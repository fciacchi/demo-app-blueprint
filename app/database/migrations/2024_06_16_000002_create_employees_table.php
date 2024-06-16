<?php

use App\Helpers\Database\Migration;
use Leaf\Schema;
use Leaf\Database;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeesTable extends Database {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!static::$capsule::schema()->hasTable('employees')) {
            Schema::build("employees");

            static::$capsule::schema()->table('employees', function (Blueprint $table) {
                $table->string('username')->unique(true)->change();
                $table->string('email')->unique(true)->change();
            });
        }

        (new Migration('2024_06_16_000002_create_employees_table'))->insert();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        (new Migration('2024_06_16_000002_create_employees_table'))->delete();

        static::$capsule::schema()->dropIfExists("employees");
    }
}
