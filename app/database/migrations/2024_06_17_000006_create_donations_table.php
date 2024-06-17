<?php

use App\Helpers\Database\Migration;
use Leaf\Schema;
use Leaf\Database;
use Illuminate\Database\Schema\Blueprint;

class CreateDonationsTable extends Database
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!static::$capsule::schema()->hasTable('donations')) {
            Schema::build("donations");

            static::$capsule::schema()->table(
                'donations',
                static function (Blueprint $blueprint): void {
                    $blueprint->foreign('employee_id')->references('id')->on('employees');
                    $blueprint->foreign('mission_id')->references('id')->on('missions');
                    $blueprint->foreign('payment_method_id')->references('id')->on('payment_methods');
                }
            );
        }

        (new Migration('2024_06_17_000006_create_donations_table'))->insert();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $migration = new Migration('2024_06_17_000006_create_donations_table');
        $migration->delete();

        static::$capsule::schema()->dropIfExists("donations");
    }
}
