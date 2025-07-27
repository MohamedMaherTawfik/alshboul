<?php

use App\Models\ExecutiveCase;
use App\Models\Lawyer;
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
        Schema::create('procedural_redords', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ExecutiveCase::class)->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->string('action');
            $table->foreignIdFor(Lawyer::class)->constrained()->cascadeOnDelete();
            $table->string('next_action');
            $table->string('next_action_date');
            $table->foreignIdFor(User::class, 'created_by')->nullable();
            $table->foreignIdFor(User::class, 'updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedural_redords');
    }
};