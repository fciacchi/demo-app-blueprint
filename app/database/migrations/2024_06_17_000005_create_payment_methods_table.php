<?php

use App\Helpers\Database\Migration;
use Leaf\Schema;
use Leaf\Database;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentMethodsTable extends Database
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!static::$capsule::schema()->hasTable('payment_methods')) {
            Schema::build("payment_methods");

            static::$capsule::schema()->table(
                'payment_methods', function (Blueprint $table) {
                    $table->foreign('employee_id')->references('id')->on('employees');
                }
            );
        }

        (new Migration('2024_06_17_000006_create_payment_methods_table'))->insert();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $migrationObj = new Migration('2024_06_17_000005_create_payment_methods_table');
        $migrationObj->delete();
        $migrationObj->dropForeignKey('donations', 'payment_method_id');

        static::$capsule::schema()->dropIfExists("payment_methods");
    }
}
