<?php

use App\Helpers\Database\Migration;
use Leaf\Schema;
use Leaf\Database;
use Illuminate\Database\Schema\Blueprint;

class CreateFundraisersTable extends Database
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!static::$capsule::schema()->hasTable('fundraisers')) {
            Schema::build("fundraisers");

            static::$capsule::schema()->table(
                'fundraisers',
                static function (Blueprint $blueprint): void {
                    $blueprint->foreign('employee_id')->references('id')->on('employees');
                }
            );
        }

        (new Migration('2024_06_16_000003_create_fundraisers_table'))->insert();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $migration = new Migration('2024_06_16_000003_create_fundraisers_table');
        $migration->delete();
        $migration->dropForeignKey('missions', 'fundraiser_id');

        static::$capsule::schema()->dropIfExists("fundraisers");
    }
}
