<?php

namespace Customfield\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['name','value','customfield_id'];

    public function customfield(){
    	return $this->belongsTo('Customfield\Models\CustomField');
    }
}
