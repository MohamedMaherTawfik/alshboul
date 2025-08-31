<?php

use App\Models\ExecutiveCase;
use App\Models\SettlementMain;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settlements', function (Blueprint $table) {
            $table->foreignIdFor(ExecutiveCase::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(SettlementMain::class)->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settlements', function (Blueprint $table) {
            //
        });
    }
};
