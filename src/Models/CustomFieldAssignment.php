<?php

namespace Customfield\Models;

use Illuminate\Database\Eloquent\Model;

class CustomFieldAssignment extends Model
{
    protected $fillable = [];

    protected $table = 'customfields_assignments';

    public function custom_field(){
    	return $this->belongsTo(CustomField::class);
    }
}
