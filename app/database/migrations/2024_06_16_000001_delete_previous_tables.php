<?php

use App\Helpers\Database\Migration;
use Leaf\Database;

class DeletePreviousTables extends Database
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        static::$capsule::schema()->dropIfExists('password_resets');
        static::$capsule::schema()->dropIfExists('users');

        (new Migration('2024_06_16_000001_delete_previous_tables'))->insert();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        (new Migration('2024_06_16_000001_delete_previous_tables'))->delete();
    }
}
