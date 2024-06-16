<?php

use App\Helpers\Database\Migration;
use Leaf\Schema;
use Leaf\Database;
use Illuminate\Database\Schema\Blueprint;

class CreateFundraisersTable extends Database {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!static::$capsule::schema()->hasTable('fundraisers')) {
            Schema::build("fundraisers");

            static::$capsule::schema()->table('fundraisers', function (Blueprint $table) {
                $table->foreign('employees_id')->references('id')->on('employees');
            });
        }

        (new Migration('2024_06_16_000003_create_fundraisers_table'))->insert();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        (new Migration('2024_06_16_000003_create_fundraisers_table'))->delete();

        static::$capsule::schema()->dropIfExists("fundraisers");
    }
}
