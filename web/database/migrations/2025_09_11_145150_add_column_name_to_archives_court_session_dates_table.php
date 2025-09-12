<?php

use App\Models\ExecutiveCase;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('court_session_dates', function (Blueprint $table) {
            $table->foreignIdFor(ExecutiveCase::class)->nullable()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('court_session_dates', function (Blueprint $table) {
            //
        });
    }
};