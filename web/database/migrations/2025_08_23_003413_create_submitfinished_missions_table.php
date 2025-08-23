<?php

use App\Models\Lawyer;
use App\Models\Missions;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('submitfinished_missions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Lawyer::class, 'first_lawyer_id')->nullable()->constrained('lawyers')->nullOnDelete();
            $table->foreignIdFor(Lawyer::class, 'second_lawyer_id')->nullable()->constrained('lawyers')->nullOnDelete();
            $table->foreignIdFor(Missions::class, 'mission_id')->constrained('missions')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submitfinished_missions');
    }
};
