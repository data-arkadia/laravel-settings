<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->constrained();
            $table->string('type');
            $table->text('description');
            $table->text('parameter');
            $table->timestamps();

            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('setting_rules');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
