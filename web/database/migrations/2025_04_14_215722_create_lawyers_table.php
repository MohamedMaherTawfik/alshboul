<?php

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
        Schema::create('lawyers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->string('name'); // الاسم
            $table->string('license_number')->unique(); // رقم الرخصة
            $table->date('dob')->nullable(); // تاريخ الميلاد
            $table->string('bar_association'); // النقابة / الفرع المنتسب إليه
            $table->string('specialization')->nullable(); // التخصص مثل جنائي، مدني...
            $table->date('license_issue_date')->nullable(); // تاريخ إصدار الرخصة
            $table->string('address')->nullable(); // عنوان المكتب
            $table->string('phone')->nullable(); // رقم الهاتف
            $table->string('id_number')->nullable(); // الرقم القومي أو رقم الهوية
            $table->string('nationality')->nullable(); // الجنسية
            $table->string('cv_file')->nullable(); // رابط للسيرة الذاتية إن وجد
            $table->integer('added_by')->nullable(); // المستخدم الذي أضاف العميل
            $table->integer('updated_by')->nullable(); // المستخدم الذي قام بتحديث العميل
            $table->softDeletes();
            $table->text('delete_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyers');
    }
};
