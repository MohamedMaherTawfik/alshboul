<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('case_types', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class, 'added_by')->nullable();
            $table->string('name');
            $table->text('description');
            $table->string('image')->nullable();
            $table->timestamps();
        });
        DB::table('case_types')->insert([
            'name' => 'قضايا مدنية',
            'description' => 'يضم مكتبنا كادرا مختصا بالدعاوى المدنية والحقوقية وجميع الدعاوى المتفرعة عن القانون المدني والتشريعات المرتبطة به ونسعى من خلال الجهود المتظافرة لفريق العمل إلى حماية كافة الحقوق المدنية لموكلينا في القضايا التي تندرج تحت مظلة هذا القانون والتشريعات المرتبطة به بما في ذلك الدعاوى المتعلقة بالعقود سواء المطالبة بتنفيذ الالتزامات عينا أو التعويض الناشئ عن عدم تنفيذ العقود والمسؤولية العقدية أو الدعاوى الخاصة بفسخ العقود أو دعاوى بطلان العقود، بالإضافة إلى الدعاوى الخاصة بالتعويض عن المسؤولية التقصيرية، والتعويض عن الأضرار الجسدية، وكافة الدعاوى الموضوعية الأخرى بما في ذلك دعوى عدم نفاذ التصرف، ودعوى دفع غير المستحق، ونتولى بمناسبة هذه الدعاوى تمثيل موكلينا قانونيا أمام المحاكم النظامية على اختلاف أنواعها ودرجاتها واختصاصاتها والترافع أمامها وتقديم جميع الطعون الخاصة بالقرارات الصادرة عنها بشكل احترافي لنلبي طموح موكلينا ونحافظ على حقوقهم بما يتوافق مع أحكام القانون.',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_types');
    }
};