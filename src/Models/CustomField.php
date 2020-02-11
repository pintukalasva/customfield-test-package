<?php

namespace Customfield\Models;

use Illuminate\Database\Eloquent\Model;
use Customfield\Models\Option;
use Customfield\Models\Attribute;


class CustomField extends Model
{
    protected $fillable = ['name', 'type'];
	public function options() 
    {
    	return $this->hasMany(Option::class,'customfield_id');
    }
    public function attributes() 
    {
        return $this->hasMany(Attribute::class,'customfield_id');
    }    

    public function assets()
    {
        return $this->morphedByMany('App\Asset', 'customfieldable');
    }

    public function licenses()
    {
        return $this->morphedByMany('App\License', 'customfieldable');
    } 
       

    public function assignements()
    {
    	return $this->hasMany(CustomFieldAssignment::class);
    }   	


}
