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
        Schema::create('executive_cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_number');                   // رقم القضية
            $table->string('national_id')->nullable();       // رقم الهوية الوطنية
            $table->string('plaintiff_name')->nullable();    // اسم المدعي
            $table->string('defendant_name')->nullable();    // اسم الخصم
            $table->string('file_number')->nullable();       // رقم الملف
            $table->string('execution_location')->nullable(); // جهة التنفيذ
            $table->text('notes')->nullable();               // الملاحظات

            $table->enum('execution_type', ['مالي', 'غير مالي'])->nullable(); // نوع التنفيذ
            $table->string('execution_number')->nullable();   // رقم التنفيذ
            $table->date('execution_date')->nullable();       // تاريخ التنفيذ

            $table->enum('execution_method', ['يدوي', 'الكتروني'])->nullable(); // طريقة التنفيذ

            $table->enum('execution_status', ['منفذ', 'غير منفذ'])->nullable(); // حالة التنفيذ
            $table->enum('execution_source', ['الصندوق', 'الفرع', 'مستند رسمي', 'إجراء آخر'])->nullable();

            $table->string('reference_number')->nullable();    // رقم الإحالة
            $table->date('reference_date')->nullable();        // تاريخ الإحالة
            $table->string('court_or_ruling_number')->nullable(); // رقم الحكم أو المحكمة
            $table->string('court_or_ruling_name')->nullable();   // اسم المحكمة أو الجهة
            $table->text('execution_file_copy')->nullable();      // صورة من الملف التنفيذي (رابط مثلاً)
            $table->enum('status', ['جديد', 'مؤرشف', 'ملغي'])->default('جديد');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->text('delete_reason')->nullable();
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
        Schema::dropIfExists('executive_cases');
    }
};
