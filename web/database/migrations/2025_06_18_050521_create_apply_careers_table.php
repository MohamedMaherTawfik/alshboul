<?php

use App\Models\Career;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('apply_careers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->date('brith_date');
            $table->foreignIdFor(Career::class)->nullable()->constrained()->nullOnDelete();
            $table->string('phone');
            $table->string('cv_file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apply_careers');
    }
};
