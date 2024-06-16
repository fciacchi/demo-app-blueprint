<?php

use App\Helpers\Database\Migration;
use Leaf\Database;

class DeletePreviousTables extends Database
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        static::$capsule::schema()->dropIfExists('password_resets');
        static::$capsule::schema()->dropIfExists('users');

        (new Migration('2024_06_16_000001_delete_previous_tables'))->insert();
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        (new Migration('2024_06_16_000001_delete_previous_tables'))->delete();
    }
}
