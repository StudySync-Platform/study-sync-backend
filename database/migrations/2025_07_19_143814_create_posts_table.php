<?php

use App\Enums\Visibility;
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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users');
            $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->text('content');
            $table->json('media_urls')->nullable();
            $table->enum('visibility', array_map(fn($v) => $v->value, Visibility::cases()));
            $table->string('type'); // text, image, poll, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
