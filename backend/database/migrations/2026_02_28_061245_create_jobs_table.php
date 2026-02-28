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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // user delete হলে job থাকবে, user_id null হবে

            $table->string('title', 150);
            $table->string('company', 150);
            $table->string('location', 120);
            $table->foreignId('category_id')->nullable()->constrained('categories')->restrictOnDelete();
            $table->longText('description');
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // helpful indexes for search/filter
            $table->index('title');
            $table->index('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
