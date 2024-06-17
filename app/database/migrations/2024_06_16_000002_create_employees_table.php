<?php

use App\Helpers\Database\Migration;
use Leaf\Schema;
use Leaf\Database;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeesTable extends Database
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!static::$capsule::schema()->hasTable('employees')) {
            Schema::build("employees");

            static::$capsule::schema()->table(
                'employees', function (Blueprint $table) {
                    $table->string('username')->unique(true)->change();
                    $table->string('email')->unique(true)->change();
                }
            );
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
        $migrationObj = new Migration('2024_06_16_000002_create_employees_table');
        $migrationObj->delete();
        $migrationObj->dropForeignKey('fundraisers', 'employee_id');
        $migrationObj->dropForeignKey('missions', 'employee_id');
        $migrationObj->dropForeignKey('donations', 'employee_id');
        $migrationObj->dropForeignKey('payment_methods', 'employee_id');

        static::$capsule::schema()->dropIfExists("employees");
    }
}
