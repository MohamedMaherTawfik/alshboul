<?php

use App\Models\cases;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(cases::class)->nullable()->constrained()->onDelete('cascade');
            $table->string('settlement_type')->nullable();
            $table->string('partner_name')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_status')->nullable();
            $table->string('client_national_id')->nullable();
            $table->string('opponent_name')->nullable();
            $table->string('opponent_national_id')->nullable();
            $table->string('opponent_status')->nullable();
            $table->string('opponent_phone')->nullable();
            $table->string('obligation')->nullable();
            $table->string('opponent_address')->nullable();
            $table->string('file_number')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->decimal('payment_value', 15, 2)->nullable();
            $table->string('payment_terms')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'archived', 'canceled'])->default('active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->text('delete_reason')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settlements');
    }
};