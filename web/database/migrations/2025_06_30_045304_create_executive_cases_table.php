<?php

use App\Models\Client;
use App\Models\excutiveCasesMain;
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
        Schema::create('executive_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Client::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('subscriber_name')->nullable();         // اسم المشترك
            $table->string('subscriber_number')->nullable();         // اسم المشترك
            $table->string('client_name')->nullable();             // اسم الموكل
            $table->string('client_national_id')->nullable();      // الرقم الوطني له
            $table->string('opponent_name')->nullable();           // اسم الخصم
            $table->string('opponent_national_id')->nullable();    // الرقم الوطني للخصم
            $table->string('office_file_number')->nullable();      // رقم الملف المكتبي
            $table->string('case_number')->nullable();             // رقم الدعوى
            $table->string('file_number')->nullable();             // رقم الملف
            $table->string('case_type')->nullable();               // نوع القضايا التنفيذية
            $table->string('case_status')->nullable();             // حالة القضية
            $table->string('case_value')->nullable(); // قيمة الدعوى
            $table->string('execution_court')->nullable();         // الدائرة التنفيذية
            $table->string('execution_document_type')->nullable(); // نوع السند التنفيذي
            $table->string('judged_for')->nullable();              // المحكوم له
            $table->string('judged_against')->nullable();          // المحكوم عليه
            $table->date('registration_date')->nullable();         // تاريخ التسجيل
            $table->string('execution_document_number')->nullable(); // رقم السند التنفيذي
            $table->string('judged_for_status')->nullable();       // صفة المحكوم له
            $table->string('judged_against_status')->nullable();   // صفة المحكوم عليه
            $table->date('procedural_session_date')->nullable(); // تاريخ الجلسة الإجر
            $table->softDeletes();
            // $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('executive_cases');
    }
};