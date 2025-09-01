<?php

use App\Models\cases;
use App\Models\ExecutiveCase;
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
        Schema::create('case_opponents', function (Blueprint $table) {
            $table->id();
            $table->string('case_opponent_name');
            $table->string('case_opponent_national_number');
            $table->string('case_opponent_description');
            $table->foreignIdFor(cases::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(ExecutiveCase::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_opponents');
    }
};
