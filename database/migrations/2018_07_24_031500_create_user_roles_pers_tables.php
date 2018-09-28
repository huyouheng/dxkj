<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRolesPersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('roles', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('description');
			$table->string('display_name');
			$table->timestamps();
		});

		Schema::create('permissions', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('description');
			$table->string('display_name');
			$table->timestamps();
		});


		Schema::create('user_roles', function (Blueprint $table) {
			$table->integer('user_id');
			$table->integer('role_id');

			$table->foreign('user_id')->references('id')->on('users')
				  ->onUpdate('cascade')->onDelete('cascade');

			$table->foreign('role_id')->references('id')->on('roles')
				   ->onUpdate('cascade')->onDelete('cascade');

			$table->primary(['user_id', 'role_id']);

		});

		Schema::create('role_permissions', function (Blueprint $table) {
			$table->integer('role_id');
			$table->integer('permission_id');

			$table->foreign('role_id')->references('id')->on('roles')
				->onUpdate('cascade')->onDelete('cascade');

			$table->foreign('permission_id')->references('id')->on('permissions')
				->onUpdate('cascade')->onDelete('cascade');

			$table->primary(['permission_id', 'role_id']);

		});

		Schema::create('user_permissions', function (Blueprint $table) {
			$table->integer('user_id');
			$table->integer('permission_id');

			$table->foreign('user_id')->references('id')->on('users')
				->onUpdate('cascade')->onDelete('cascade');

			$table->foreign('permission_id')->references('id')->on('permissions')
				->onUpdate('cascade')->onDelete('cascade');

			$table->primary(['user_id', 'permission_id']);

		});




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
