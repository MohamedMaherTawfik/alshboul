<?php

use App\Models\Client;
use App\Models\TransactionsMain;
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
        Schema::create('trans_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(TransactionsMain::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(Client::class)->nullable()->constrained()->onDelete('cascade');
            $table->string('file_number')->nullable();
            $table->boolean('is_active')->default(1);
            $table->string('client_name')->nullable();
            $table->text('description')->nullable();
            $table->string('area_name')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_actions');
    }
};
