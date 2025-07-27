<?php

use App\Models\MainAction;
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
        Schema::create('sub_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MainAction::class)->constrained()->cascadeOnDelete();
            $table->string('details')->nullable();
            $table->string('action_date')->nullable();
            $table->string('next_action_date')->nullable();
            $table->foreignIdFor(User::class, 'executed_by')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'added_by')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'updated_by')->constrained()->cascadeOnDelete();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_actions');
    }
};
