<?php

use App\Models\Settlement;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settlement_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Settlement::class)->constrained()->cascadeOnDelete();
            $table->string('action_date')->nullable();
            $table->string('type')->nullable();
            $table->string('action')->nullable();
            $table->string('notes')->nullable();
            $table->string('next_action')->nullable();
            $table->string('next_action_date')->nullable();
            $table->foreignIdFor(User::class, 'created_by')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'updated_by')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settlement_actions');
    }
};