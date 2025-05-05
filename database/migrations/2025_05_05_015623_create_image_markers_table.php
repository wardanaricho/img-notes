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
        Schema::create('image_markers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lokalis_id')->constrained('lokalis')->onDelete('cascade');
            $table->string('image_path')->nullable();
            $table->integer('number')->nullable();
            $table->float('x');
            $table->float('y');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_markers');
    }
};
