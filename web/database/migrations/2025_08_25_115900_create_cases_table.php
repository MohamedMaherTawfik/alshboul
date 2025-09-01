<?php

use App\Models\CaseType;
use App\Models\Client;
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
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Client::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(User::class, 'subscriber_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('first_national_id')->nullable();
            $table->string('second_national_id')->nullable();
            $table->string('third_national_id')->nullable();
            $table->foreignIdFor(CaseType::class, 'suggested_case_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('case_type')->nullable();
            $table->string('case_number')->nullable();
            $table->string('file_number')->nullable();
            $table->string('court_name')->nullable();
            $table->string('case_amount')->nullable();
            $table->string('benefit_date')->nullable();
            $table->string('jubge_name')->nullable();
            $table->text('case_details')->nullable();
            $table->string('client_description')->nullable();
            $table->text('general_information')->nullable();
            $table->text('private_information')->nullable();
            $table->foreignIdFor(User::class, 'added_by_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
