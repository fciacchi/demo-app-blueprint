<?php

use App\Helpers\Database\Migration;
use Leaf\Schema;
use Leaf\Database;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeesTable extends Database
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!static::$capsule::schema()->hasTable('employees')) {
            Schema::build("employees");

            static::$capsule::schema()->table(
                'employees',
                static function (Blueprint $blueprint): void {
                    $blueprint->string('username')->unique()->change();
                    $blueprint->string('email')->unique()->change();
                }
            );
        }

        (new Migration('2024_06_16_000002_create_employees_table'))->insert();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $migration = new Migration('2024_06_16_000002_create_employees_table');
        $migration->delete();
        $migration->dropForeignKey('fundraisers', 'employee_id');
        $migration->dropForeignKey('missions', 'employee_id');
        $migration->dropForeignKey('donations', 'employee_id');
        $migration->dropForeignKey('payment_methods', 'employee_id');

        static::$capsule::schema()->dropIfExists("employees");
    }
}
