<?php

use App\Models\subrocedural;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('client_procedural_files', function (Blueprint $table) {
            $table->foreignIdFor(subrocedural::class)->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_procedural_files', function (Blueprint $table) {
            //
        });
    }
};
