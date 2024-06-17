<?php

use App\Helpers\Database\Migration;
use Leaf\Schema;
use Leaf\Database;

class CreateUsers extends Database
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::build('users');

        (new Migration('2019_11_18_133625_create_users'))->insert();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        (new Migration('2019_11_18_133625_create_users'))->delete();

        static::$capsule::schema()->dropIfExists('users');
    }
}
