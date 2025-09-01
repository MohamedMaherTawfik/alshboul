<?php

use App\Models\ProceduralRecord;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subrocedurals', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProceduralRecord::class)->nullable()->constrained()->onDelete('cascade');
            $table->string('action')->nullable();
            $table->string('note')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subrocedurals');
    }
};