<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')) {
            return;
        }

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role');
            $table->rememberToken();

            $table->string('status', 63)->nullable()->default(null);
            $table->integer('created_by')->nullable()->default(null);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->integer('updated_by')->nullable()->default(null);
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->tinyInteger('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
