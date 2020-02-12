<?php
	
	$namespace = "Customfield\Http\Controllers";
	use Illuminate\Http\Request;
	Route::group(['namespace' => $namespace, 'prefix' => 'customfields' , 'as' => 'customfields.'], function(){
		Route::get('index' , "CustomFieldsController@index")->name('index');
		Route::get('getdata' , "CustomFieldsController@getdata")->name('getdata');
		Route::get('create' , "CustomFieldsController@create")->name('create');
		Route::post('store' , "CustomFieldsController@store")->name('store');
		Route::get('getcolumnname','CustomFieldsController@getColumnName')->name('getcolumnname');
		Route::get('edit/{id}' , "CustomFieldsController@edit")->name('edit');
		Route::put('update/{id}','CustomFieldsController@update')->name('update');
    	Route::delete('delete/{id}','CustomFieldsController@destroy')->name('destroy');		
	});
	Route::group(['namespace' => $namespace, 'prefix' => 'customfields_assignment' , 'as' => 'customfields_assignment.'], function(){
		Route::get('index' , "CustomFieldsAssignmentController@index")->name('index');	
		Route::get('getData','CustomFieldsAssignmentController@getData')->name('getdata');
		Route::get('create','CustomFieldsAssignmentController@create')->name('create');
		Route::post('store','CustomFieldsAssignmentController@store')->name('store');
	    Route::get('edit/{id}','CustomFieldsAssignmentController@edit')->name('edit');
	    Route::put('update/{id}','CustomFieldsAssignmentController@update')->name('update');
	    Route::delete('delete/{id}','CustomFieldsAssignmentController@destroy')->name('destroy');		
	});	
?>