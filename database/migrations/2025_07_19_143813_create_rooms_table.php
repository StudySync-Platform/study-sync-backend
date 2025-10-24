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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('subject');
            $table->string('level');
            $table->foreignId('host_user_id')->constrained('users');
            $table->integer('max_members');
            $table->enum('visibility', array_map(fn($v) => $v->value, Visibility::cases()));
            $table->string('thumbnail_url')->nullable();
            $table->string('status');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
