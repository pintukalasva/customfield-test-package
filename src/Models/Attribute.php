<?php

namespace Customfield\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
	protected $table = 'attributes';
    protected $fillable = ['name','value','customfield_id'];
    
	public function customfield(){
    	return $this->belongsTo('Customfield\Models\Customfield');
    }
}
