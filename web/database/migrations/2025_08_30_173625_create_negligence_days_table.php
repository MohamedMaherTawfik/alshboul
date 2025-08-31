<?php

use App\Models\CaseType;
use App\Models\excutiveCasesMain;
use App\Models\SettlementMain;
use App\Models\TransactionsMain;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('negligence_days', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CaseType::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(excutiveCasesMain::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(SettlementMain::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(TransactionsMain::class)->nullable()->constrained()->nullOnDelete();
            $table->integer('days')->nullable();
            $table->string('column_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('negligence_days');
    }
};