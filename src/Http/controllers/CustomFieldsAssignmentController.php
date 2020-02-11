<?php

namespace Customfield\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB;
use File;
use Carbon\Carbon;
use Illuminate\Container\Container;
use Customfield\Models\CustomField;
use Customfield\Models\CustomFieldAssignment;

class CustomFieldsAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $customfields_assignment = DB::table('customfields_assignments')->get();
        return view('customfield::customfield_assignment.index',compact('customfields_assignment'));
    }

    public function getdata(){
        
        return Datatables::of($customfields_assignment)
            ->addIndexColumn()
            ->addColumn('action',function($row) {
                return view('customfields::customfield_assignment.action',['row' => $row]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
       $customFields = CustomField::all();
        $appNamespace = Container::getInstance()->getNamespace();
        $modelNamespace = '';
        $models = collect(File::allFiles(app_path($modelNamespace)))->map(function ($item) use ($appNamespace, $modelNamespace) {
            $rel   = $item->getRelativePathName();
            $class = sprintf('%s%s%s', $appNamespace, $modelNamespace ? $modelNamespace . '\\' : '',
                implode('\\', explode('/', substr($rel, 0, strrpos($rel, '.')))));
            return class_exists($class) ? $class : null;
        })->filter();
        return view('customfield::customfield_assignment.create',compact('customFields', 'models'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customfield_id' => 'required',
            'model' => 'required'
        ]);
        DB::table('customfields_assignments')->insert(
            [
                'custom_field_id' => $request->customfield_id,
                'model' => $request->model,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        return redirect()->route('customfields_assignment.index')->with('success','Custom field assignment added succesfully!'); 
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $customfield_assignment = DB::table('customfields_assignments')->where('id',$id)->first();

        $customFields = CustomField::all();
        $appNamespace = Container::getInstance()->getNamespace();
        $modelNamespace = '';
        $models = collect(File::allFiles(app_path($modelNamespace)))->map(function ($item) use ($appNamespace, $modelNamespace) {
            $rel   = $item->getRelativePathName();
            $class = sprintf('%s%s%s', $appNamespace, $modelNamespace ? $modelNamespace . '\\' : '',
                implode('\\', explode('/', substr($rel, 0, strrpos($rel, '.')))));
            return class_exists($class) ? $class : null;
        })->filter();
        return view('customfield::customfield_assignment.edit', compact('customfield_assignment', 'customFields', 'models'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'customfield_id' => 'required',
            'model' => 'required'
        ]);
        DB::table('customfields_assignments')->where('id', $id)->update(
            [
                'custom_field_id' => $request->customfield_id,
                'model' => $request->model,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        return redirect()->route('customfields_assignment.index')->with('success','Custom field assignment updated succesfully!'); 
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $customfieldAssignment = CustomFieldAssignment::find($id);
        $customfieldAssignment->delete();
        return redirect()->route('customfields_assignment.index')->with('success','Custom field assignment deleted succesfully!'); 
    }
}
