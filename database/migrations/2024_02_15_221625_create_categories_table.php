<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('categories')) {
            return;
        }

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_screen')->index()->nullable();
            $table->foreign('id_screen')->references('id')->on('screens')->onDelete('cascade');
            $table->string('title', 255);

            $table->string('status', 63)->nullable()->default(null);
            $table->integer('created_by')->nullable()->default(null);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->integer('updated_by')->nullable()->default(null);
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->tinyInteger('active')->default(true);
        });

        // Popunite tabelu koristeći insert sa više redova
        DB::table('categories')->insert([
            [
                'id_screen' => 1,
                'title' => 'Sve',
                'status' => 'on',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'id_screen' => 2,
                'title' => 'Kafanska ljuta',
                'status' => 'on',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'id_screen' => 3,
                'title' => 'Svadba',
                'status' => 'on',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'id_screen' => 3,
                'title' => 'Rodjendan',
                'status' => 'on',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'id_screen' => 3,
                'title' => 'Ispraćaj',
                'status' => 'on',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'id_screen' => 3,
                'title' => 'Kum sam',
                'status' => 'on',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'id_screen' => 3,
                'title' => 'Random lik',
                'status' => 'on',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'id_screen' => 4,
                'title' => 'Teška dvojka',
                'status' => 'on',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'id_screen' => 4,
                'title' => 'Narodnjaci',
                'status' => 'on',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'id_screen' => 4,
                'title' => 'Rok',
                'status' => 'on',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'id_screen' => 4,
                'title' => 'EX-YU',
                'status' => 'on',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'id_screen' => 4,
                'title' => 'Balade',
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
        Schema::table('categories', function($table)
        {
            // Prvo, provjerite postoji li foreign key
            if (Schema::hasColumn('categories', 'id_screen')) {
                $table->dropForeign(['id_screen']);
            }

            // Zatim, provjerite postoji li index
            if (Schema::hasIndex('categories', 'categories_id_screen_index')) {
                $table->dropIndex('categories_id_screen_index');
            }
        });

        Schema::dropIfExists('categories');
    }
}
