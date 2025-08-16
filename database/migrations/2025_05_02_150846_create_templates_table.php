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
        Schema::create('templates', function (Blueprint $table) {
            // its for saving website templates that user can download such as tempalte_file_name.zip
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique(); // slug for the template
            $table->string('image')->nullable(); // image of the template
            $table->string('description')->nullable();
            $table->string('file_name')->unique();
            $table->string('file_url')->unique();
            $table->string('file_size')->nullable(); // size in bytes
            $table->string('demo_url')->nullable(); // type of the file such as zip, pdf, etc
            $table->integer('downloads')->default(0); // number of downloads+
            $table->integer('price')->default(0); // price of the file
            $table->integer('status')->default(1); // 0 = inactive, 1 = active
            $table->integer('discount')->default(0); // 0 = not featured, 1 = featured
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('category_id');

            // foreign keys

            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
