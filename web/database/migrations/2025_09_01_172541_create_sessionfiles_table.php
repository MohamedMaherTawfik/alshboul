<?php

use App\Models\court_session_date;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sessionfiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(court_session_date::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessionfiles');
    }
};
