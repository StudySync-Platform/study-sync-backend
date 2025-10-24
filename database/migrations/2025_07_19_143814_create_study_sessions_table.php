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
        Schema::create('study_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->foreignId('host_user_id')->constrained('users');
            $table->string('subject');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->string('status');
            $table->enum('visibility', array_map(fn($v) => $v->value, Visibility::cases()));
            $table->string('room_link')->nullable();
            $table->string('recording_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_sessions');
    }
};
