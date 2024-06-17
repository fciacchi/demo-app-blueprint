<?php

use App\Helpers\Database\Migration;
use Leaf\Schema;
use Leaf\Database;
use Illuminate\Database\Schema\Blueprint;

class CreateDonationsTable extends Database {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!static::$capsule::schema()->hasTable('donations')) {
            Schema::build("donations");

            static::$capsule::schema()->table('donations', function (Blueprint $table) {
                $table->foreign('employee_id')->references('id')->on('employees');
                $table->foreign('mission_id')->references('id')->on('missions');
                $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            });
        }

        (new Migration('2024_06_17_000006_create_donations_table'))->insert();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $migrationObj = new Migration('2024_06_17_000006_create_donations_table');
        $migrationObj->delete();

        static::$capsule::schema()->dropIfExists("donations");
    }
}
