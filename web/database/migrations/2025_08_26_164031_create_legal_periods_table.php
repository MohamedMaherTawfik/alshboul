<?php

use App\Models\cases;
use App\Models\Client;
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
        Schema::create('legal_periods', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(cases::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('period_start')->nullable();
            $table->string('period_end')->nullable();
            $table->string('notes')->nullable();
            $table->string('period_facts')->nullable();
            $table->boolean('is_done')->default(false);
            $table->foreignIdFor(User::class, 'first_submitter_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(User::class, 'second_submitter_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_periods');
    }
};
