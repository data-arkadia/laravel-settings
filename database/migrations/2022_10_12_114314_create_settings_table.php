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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_category_id')->nullable()->constrained();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('data_type');
            $table->boolean('required');
            $table->timestamps();

            $table->index('name');
            $table->index('slug');
            $table->index('data_type');
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
        Schema::dropIfExists('settings');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
