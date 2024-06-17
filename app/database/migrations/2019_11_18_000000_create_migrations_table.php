<?php

use App\Helpers\Database\Migration;
use Leaf\Database;
use Illuminate\Database\Schema\Blueprint;

class CreateMigrationsTable extends Database
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!static::$capsule::schema()->hasTable('migrations')) {
            // Create the migrations table.
            static::$capsule::schema()->create(
                'migrations',
                static function (Blueprint $blueprint): void {
                    $blueprint->increments('id');
                    $blueprint->string('migration')->unique();
                }
            );

            (new Migration('2019_11_18_000000_create_migrations_table'))->insert();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        (new Migration('2019_11_18_000000_create_migrations_table'))->delete();

        static::$capsule::schema()->dropIfExists('migrations');
    }
}
