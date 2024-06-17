<?php

use App\Helpers\Database\Migration;
use Leaf\Schema;
use Leaf\Database;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentMethodsTable extends Database
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!static::$capsule::schema()->hasTable('payment_methods')) {
            Schema::build("payment_methods");

            static::$capsule::schema()->table(
                'payment_methods',
                static function (Blueprint $blueprint): void {
                    $blueprint->foreign('employee_id')->references('id')->on('employees');
                }
            );
        }

        (new Migration('2024_06_17_000006_create_payment_methods_table'))->insert();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $migration = new Migration('2024_06_17_000005_create_payment_methods_table');
        $migration->delete();
        $migration->dropForeignKey('donations', 'payment_method_id');

        static::$capsule::schema()->dropIfExists("payment_methods");
    }
}
