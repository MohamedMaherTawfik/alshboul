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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('cascade');
            $table->string('name'); // اسم الشخص
            $table->string('company_name')->nullable(); // اسم الشركة (اختياري)
            $table->string('company_national_number')->nullable(); // الرقم الوطني للشركة (اختياري)
            $table->string('national_id'); // الرقم القومي
            $table->string('nationality'); // الجنسية
            $table->string('phone'); // رقم الهاتف
            $table->string('address'); // العنوان
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
        Schema::dropIfExists('clients');
    }
};
