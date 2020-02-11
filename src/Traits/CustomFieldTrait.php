<?php

namespace Customfield\Traits;
use Customfield\Models\CustomField;
use Illuminate\Database\Eloquent\Builder;
trait CustomFieldTrait {
		
	public function customFieldCreate($modelName) {
 		$custom_fields = CustomField::whereHas('assignements', function (Builder $query) use ($modelName) {
        	$query->where('model', '=', $modelName);
    	})->get();
    	return $custom_fields;
    }

    public function customFieldStore($request, $storeModel , $modelName) {
		$custom_fields = CustomField::whereHas('assignements', function (Builder $query) use ($modelName) {
            $query->where('model', '=', $modelName);
        })->get();
        foreach($custom_fields as $custom_field) {
            if($custom_field->type == 'checkbox'){
                if(is_array($request->{$custom_field->name})) {
                    $storeModel->customfields()->save($custom_field,['field_name' => $custom_field->name, 'field_value' => implode(',', $request->{$custom_field->name})]);    
                } else {
                    $storeModel->customfields()->save($custom_field,['field_name' => $custom_field->name, 'field_value' => $request->{$custom_field->name}]);
                }
            } else {
                $storeModel->customfields()->save($custom_field,['field_name' => $custom_field->name, 'field_value' => $request->{$custom_field->name}]);
            }
        }	    	
    }

    public function customFieldEdit($editModel,$modelName) {
		$stored_custom_field = $editModel->customfields;
        $stored = $stored_custom_field->pluck('id')->toArray();
        $remain_custom_fields = CustomField::whereHas('assignements', function (Builder $query) use ($modelName,$stored) {
             $query->where('model', '=', $modelName)->whereNotIn('custom_field_id',$stored);
        })->get(); 
      
        $custom_fields = $stored_custom_field->merge($remain_custom_fields);	
        return $custom_fields;    	
    }

    public function customFieldUpdate($request,$updateModel,$modelName) {
    	$custom_fields = CustomField::whereHas('assignements', function (Builder $query) use ($modelName) {
            $query->where('model', '=', $modelName);
        })->get();
        foreach($custom_fields as $custom_field) {
            $is_exist = $updateModel->customfields;
           
            if($custom_field->type == 'checkbox') {
                if(is_array($request->{$custom_field->name})) {
                    if($is_exist->contains($custom_field->id)) { 

                        $updateModel->customfields()->updateExistingPivot($custom_field,['field_name' => $custom_field->name, 'field_value' => implode(',', $request->{$custom_field->name})]);
                    
                    } else {

                        $updateModel->customfields()->save($custom_field,['field_name' => $custom_field->name, 'field_value' => implode(',', $request->{$custom_field->name})]);
                    }
                } else {
                    if($is_exist->contains($custom_field->id)) {

                        $updateModel->customfields()->updateExistingPivot($custom_field,['field_name' => $custom_field->name, 'field_value' => $request->{$custom_field->name}]);
                    }
                    else
                    {
                        $updateModel->customfields()->save($custom_field,['field_name' => $custom_field->name, 'field_value' => $request->{$custom_field->name}]);
                    }
                }
            } else {
                if($is_exist->contains($custom_field->id)) {

                    $updateModel->customfields()->updateExistingPivot($custom_field,['field_name' => $custom_field->name, 'field_value' => $request->{$custom_field->name}]);
                }
                else {
                    $updateModel->customfields()->save($custom_field,['field_name' => $custom_field->name, 'field_value' => $request->{$custom_field->name}]);
                }
            }
        } 
    }

    public function customFieldShow($showModel) {
        return $showModel->customfields; 
    }

    public function customFieldDelete($deleteModel) {
    	$deleteModel->customfields()->detach();
    }

}
 
?>
