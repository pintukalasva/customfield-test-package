<?php

namespace Customfield\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Module;
use DB;
use Illuminate\Support\Str;
use Customfield\Models\CustomField;

class CustomFieldsController extends Controller
{
    public function index(){
        $customfields = DB::table('custom_fields')->get();
        return view('customfield::customfield.index',compact('customfields'));
    }
    public function getdata(){
        $customfields = DB::table('custom_fields')->get();
        return Datatables::of($customfields)
            ->addIndexColumn()
            ->addColumn('action',function($row){
                return view('customfields::custom_fields.action',['row' => $row]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }    
    public function create(Request $request){
    	$tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
    	return view('customfield::customfield.create',compact('tables'));
    }
    public function getColumnName(){
        $table = request('tablename');
        $html = '';
        $columns = DB::getSchemaBuilder()->getColumnListing($table);
        $html .='<option value="select option">select option</option>';
        foreach($columns as $column)
        {
            $html .= '<option value="'.$column.'">'.$column.'</option>';
        }
        return $html;
    }    
    public function Store(Request $request){
    	$customfield = new CustomField();
        $customfield->title = $request->field_title;
        $customfield->name = Str::slug($request->field_title, '_');
        $customfield->type = $request->field_type;
        $customfield->table_name = $request->table_name;
        $customfield->column_name = $request->column_name;
        $customfield->save();
        if($request->attribute)
        {
            for($i=0; $i < count($request->attribute); $i++)
            {
                $customfield->attributes()->create([
                    'name' => $request->attribute[$i]['attribute_name'],
                    'value' => $request->attribute[$i]['attribute_value'],
                    'customfield_id' => $customfield->id
                ]);             
            }      
        }   
        $field_types = ['select','checkbox','radio'];
        if(in_array($request->field_type, $field_types))
        {
            for($i=0; $i < count($request->option_list); $i++)
            {
                $customfield->options()->create([
                    'name' => $request->option_list[$i]['option_name'],
                    'value' => $request->option_list[$i]['option_value'],
                    'customfield_id' => $customfield->id
                ]);             
            } 
        }
        return redirect()->route('customfield.index');
    }
    public function edit($id)
    {
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
        $customfield = CustomField::find($id); 
        $columns = DB::getSchemaBuilder()->getColumnListing($customfield->table_name);     
        return view('customfield::customfield.edit', compact('customfield','tables','columns'));
    } 

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'field_title' => 'required'
        ]);
        $customfield = CustomField::find($id);
        $customfield->title = $request->field_title;
        $customfield->name = Str::slug($request->field_title, '_');
        $customfield->type = $request->field_type;
        $customfield->table_name = $request->table_name;
        $customfield->column_name = $request->column_name;
        $customfield->save();
        $customfield->attributes()->delete();
        $customfield->options()->delete();
        $field_types = ['select','checkbox','radio'];

        if($request->attribute)
        {
            for($i=0; $i < count($request->attribute); $i++)
            {
                $customfield->attributes()->create([
                    'name' => $request->attribute[$i]['attribute_name'],
                    'value' => $request->attribute[$i]['attribute_value'],
                    'customfield_id' => $customfield->id
                ]);             
            } 
        }
        if(in_array($request->field_type, $field_types))
        {
            for($i=0; $i < count($request->option_list); $i++)
            {
                 $customfield->options()->create([
                    'name' => $request->option_list[$i]['option_name'],
                    'value' => $request->option_list[$i]['option_value'],
                    'customfield_id' => $customfield->id
                ]);             
            } 
        }
        return redirect()->route('customfield.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $customfield = CustomField::find($id);
        $customfield->delete();
        return redirect()->route('customfield.index');
       
    }      
}
