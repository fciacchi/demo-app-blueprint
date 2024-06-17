<?php

use App\Helpers\Database\Migration;
use Leaf\Database;
use Illuminate\Database\Schema\Blueprint;

class CreatePasswordResets extends Database
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!static::$capsule::schema()->hasTable('password_resets')) :
            static::$capsule::schema()->create(
                'password_resets',
                static function (Blueprint $blueprint): void {
                    $blueprint->id();
                    $blueprint->string('email')->index();
                    $blueprint->string('token');
                    $blueprint->timestamp('created_at')->nullable();
                }
            );
        endif;

        (new Migration('2019_11_18_155705_create_password_resets'))->insert();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        (new Migration('2019_11_18_155705_create_password_resets'))->delete();

        static::$capsule::schema()->dropIfExists('password_resets');
    }
}
