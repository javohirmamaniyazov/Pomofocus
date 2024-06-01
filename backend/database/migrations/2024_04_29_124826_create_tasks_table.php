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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('orderNumber')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('content');
            $table->longText('note')->nullable();
            $table->tinyInteger('isActive')->default(0)->comment('0=false, 1=true');
            $table->tinyInteger('isFinished')->default(0)->comment('0=false, 1=true');
            $table->tinyInteger('isDeleted')->default(0)->comment('0=false, 1=true');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
