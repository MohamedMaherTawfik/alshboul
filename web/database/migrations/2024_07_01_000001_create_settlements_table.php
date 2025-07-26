<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->id();
            $table->string('settlement_type');
            $table->string('partner_name');
            $table->string('client_name');
            $table->string('client_national_id');
            $table->string('opponent_name');
            $table->string('opponent_national_id')->nullable();
            $table->string('opponent_status')->nullable();
            $table->string('obligation')->nullable();
            $table->string('file_number')->nullable();
            $table->string('opponent_address')->nullable();
            $table->string('opponent_phone')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('payment_terms')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'archived', 'canceled'])->default('active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->text('delete_reason')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settlements');
    }
}; 