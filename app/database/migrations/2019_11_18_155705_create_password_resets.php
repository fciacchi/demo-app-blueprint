<?php

use App\Helpers\Database\Migration;
use Leaf\Database;
use Illuminate\Database\Schema\Blueprint;

class CreatePasswordResets extends Database
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!static::$capsule::schema()->hasTable('password_resets')) :
            static::$capsule::schema()->create(
                'password_resets', function (Blueprint $table) {
                    $table->id();
                    $table->string('email')->index();
                    $table->string('token');
                    $table->timestamp('created_at')->nullable();
                }
            );
        endif;

        (new Migration('2019_11_18_155705_create_password_resets'))->insert();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        (new Migration('2019_11_18_155705_create_password_resets'))->delete();

        static::$capsule::schema()->dropIfExists('password_resets');
    }
}
