<?php

use App\Models\Client;
use App\Models\Lawyer;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Client::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Lawyer::class, 'first_lawyer_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Lawyer::class, 'second_lawyer_id')->nullable()->constrained()->cascadeOnDelete();
            $table->boolean('is_done')->default(false);
            $table->string('deadline')->nullable();
            $table->text('description')->nullable();
            $table->string('file')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignIdFor(User::class, 'added_by_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missions');
    }
};