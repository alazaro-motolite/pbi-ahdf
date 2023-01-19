<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('profile_no', 100)->unique();
            $table->string('last_name', 255);
            $table->string('first_name', 255);
            $table->string('middle_name', 255);
            $table->string('birth_date', 100);
            $table->text('address');
            $table->string('mobile_no', 255);
            $table->string('company_name', 255);
            $table->string('profile_group', 100);
            $table->tinyInteger('is_active');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->tinyInteger('encrypted')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_info');
    }
}
