<?php

use App\Models\MainAgencies;
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
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->string(User::class)->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignIdFor(MainAgencies::class)->nullable()->constrained('main_agencies')->onDelete('cascade');
            $table->string('lawyers')->nullable();
            $table->string('letter')->nullable();
            $table->string('opponents')->nullable();
            $table->string('court')->nullable();
            $table->string('for')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agencies');
    }
};
