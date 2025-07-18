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
        Schema::create('task', function (Blueprint $table) {
            $table->id();
            $table->string('enq_no');
            $table->string('product_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('remakrs')->nullable();
            $table->string('lead_cycle')->nullable();
            $table->string('callback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task');
    }
};
