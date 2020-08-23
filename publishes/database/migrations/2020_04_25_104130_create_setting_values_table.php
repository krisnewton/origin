<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_values', function (Blueprint $table) {
            $table->id();
            $table->integer('setting_id');
            $table->string('code');
            $table->string('form_name');
            $table->string('name');
            $table->text('value');
            $table->integer('position');
            $table->text('extra')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_values');
    }
}
