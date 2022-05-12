<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->string('name');
            $table->unsignedBigInteger('balance')
                ->nullable()
                ->default(0)
                ->comment('Total balance came through this method');
            $table->unsignedBigInteger('expense')
                ->nullable()
                ->default(0)
                ->comment('Total expense through this method');
            $table->timestamps();

            $table->unique(['user_id', 'name'], 'unique_user_method');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('methods');
    }
};
