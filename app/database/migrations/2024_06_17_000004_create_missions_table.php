<?php

use App\Helpers\Database\Migration;
use Leaf\Schema;
use Leaf\Database;
use Illuminate\Database\Schema\Blueprint;

class CreateMissionsTable extends Database {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!static::$capsule::schema()->hasTable('missions')) {
            Schema::build("missions");

            static::$capsule::schema()->table('missions', function (Blueprint $table) {
                $table->foreign('employee_id')->references('id')->on('employees');
                $table->foreign('fundraiser_id')->references('id')->on('fundraisers');
            });
        }

        (new Migration('2024_06_17_000004_create_missions_table'))->insert();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $migrationObj = new Migration('2024_06_17_000004_create_missions_table');
        $migrationObj->delete();
        $migrationObj->dropForeignKey('donations', 'mission_id');

        static::$capsule::schema()->dropIfExists("missions");
    }
}
