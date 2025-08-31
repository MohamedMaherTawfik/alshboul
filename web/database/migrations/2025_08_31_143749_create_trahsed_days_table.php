<?php

use App\Models\cases;
use App\Models\ExecutiveCase;
use App\Models\Settlement;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trahsed_days', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(cases::class)->nullable()->constrained()->onDelete('cascade');
            $table->integer('counts')->nullable();
            $table->foreignIdFor(ExecutiveCase::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(Settlement::class)->nullable()->constrained()->onDelete('cascade');
            $table->boolean('is_seen')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trahsed_days');
    }
};