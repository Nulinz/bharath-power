<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_ext', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('task_id')->nullable();
            $table->string('request_for')->nullable();
            $table->string('extend_date')->nullable();
            $table->string('c_remarks')->nullable();
            $table->string('a_remarks')->nullable();
            $table->string('status')->nullable();
            $table->string('category', 20)->nullable();
            $table->string('attach', 50)->nullable();
            $table->integer('c_by'); // NOT NULL

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_ext');
    }
};
