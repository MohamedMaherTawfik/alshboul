<?php

use App\Models\MainNav;
use App\Models\subNav;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('negligence_days', function (Blueprint $table) {
            $table->foreignIdFor(subNav::class)->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('negligence_days', function (Blueprint $table) {
            //
        });
    }
};
