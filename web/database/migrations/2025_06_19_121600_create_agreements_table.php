<?php

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
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->string('agreement_number')->unique();
            $table->string('first_party');
            $table->string('second_party');
            $table->date('agreement_date');
            $table->text('subject')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('represented_by')->nullable();
            $table->text('delete_reason')->nullable();
            $table->enum('agreement_type', ['public', 'private'])->nullable();
            $table->unsignedInteger('installments_count')->default(1);
            $table->unsignedInteger('installment_interval_months')->default(1);
            $table->date('first_installment_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreements');
    }
};
