<?php

use App\Helpers\Database\Migration;
use Leaf\Schema;
use Leaf\Database;
use Illuminate\Database\Schema\Blueprint;

class CreateMissionsTable extends Database
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!static::$capsule::schema()->hasTable('missions')) {
            Schema::build("missions");

            static::$capsule::schema()->table(
                'missions',
                static function (Blueprint $blueprint): void {
                    $blueprint->foreign('employee_id')->references('id')->on('employees');
                    $blueprint->foreign('fundraiser_id')->references('id')->on('fundraisers');
                }
            );
        }

        (new Migration('2024_06_17_000004_create_missions_table'))->insert();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $migration = new Migration('2024_06_17_000004_create_missions_table');
        $migration->delete();
        $migration->dropForeignKey('donations', 'mission_id');

        static::$capsule::schema()->dropIfExists("missions");
    }
}
