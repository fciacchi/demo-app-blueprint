<?php

use App\Helpers\Database\Migration;
use Leaf\Database;
use Illuminate\Database\Schema\Blueprint;

class CreateMigrationsTable extends Database
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!static::$capsule::schema()->hasTable('migrations')) {
            // Create the migrations table
            static::$capsule::schema()->create(
                'migrations', function (Blueprint $table) {
                    $table->increments('id');
                    $table->string('migration')->unique();
                }
            );

            (new Migration('2019_11_18_000000_create_migrations_table'))->insert();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        (new Migration('2019_11_18_000000_create_migrations_table'))->delete();

        static::$capsule::schema()->dropIfExists('migrations');
    }
}
