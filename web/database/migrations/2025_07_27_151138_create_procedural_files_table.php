<?php

use App\Models\ProceduralRecord;
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
        Schema::create('procedural_files', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProceduralRecord::class)->constrained()->cascadeOnDelete();
            $table->string('file_path')->nullable();
            $table->foreignIdFor(User::class, 'created_by')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'updated_by')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedural_files');
    }
};
