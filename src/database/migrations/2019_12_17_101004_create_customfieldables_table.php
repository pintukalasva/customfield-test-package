<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomfieldablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customfieldables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('custom_field_id');
            $table->integer('customfieldable_id');
            $table->string('customfieldable_type');
            $table->string('field_name');
            $table->string('field_value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customfieldables');
    }
}
