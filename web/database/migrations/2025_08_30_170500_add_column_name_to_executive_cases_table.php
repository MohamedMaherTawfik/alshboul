<?php

use App\Models\excutiveCasesMain;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('executive_cases', function (Blueprint $table) {
            $table->foreignIdFor(excutiveCasesMain::class, 'excutive_cases_main_id') ->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('executive_cases', function (Blueprint $table) {
            //
        });
    }
};