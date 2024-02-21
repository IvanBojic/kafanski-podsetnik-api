<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateScreensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('screens')) {
            return;
        }

        Schema::create('screens', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);

            $table->string('status', 63)->nullable()->default(null);
            $table->integer('created_by')->nullable()->default(null);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->integer('updated_by')->nullable()->default(null);
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->tinyInteger('active')->default(true);
        });

        // Popunite tabelu koristeći insert sa više redova
        DB::table('screens')->insert([
            [
                'id' => 1,
                'title' => 'Pevač',
                'status' => 'on',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'id' => 2,
                'title' => 'Zaboravni boem',
                'status' => 'on',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'id' => 3,
                'title' => 'Veselje pa da naručim',
                'status' => 'on',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'id' => 4,
                'title' => 'Žanrovi',
                'status' => 'on',
                'created_by' => 1,
                'updated_by' => 1,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('screens');

        Schema::enableForeignKeyConstraints();
    }
}
