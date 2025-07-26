<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('case_types', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->text('description_ar');
            $table->text('description_en');
            $table->string('image')->nullable();
            $table->timestamps();
        });
        DB::table('case_types')->insert([
            'name_ar' => 'قضايا مدنية',
            'name_en' => 'Penal Cases',
            'description_ar' => 'يضم مكتبنا كادرا مختصا بالدعاوى المدنية والحقوقية وجميع الدعاوى المتفرعة عن القانون المدني والتشريعات المرتبطة به ونسعى من خلال الجهود المتظافرة لفريق العمل إلى حماية كافة الحقوق المدنية لموكلينا في القضايا التي تندرج تحت مظلة هذا القانون والتشريعات المرتبطة به بما في ذلك الدعاوى المتعلقة بالعقود سواء المطالبة بتنفيذ الالتزامات عينا أو التعويض الناشئ عن عدم تنفيذ العقود والمسؤولية العقدية أو الدعاوى الخاصة بفسخ العقود أو دعاوى بطلان العقود، بالإضافة إلى الدعاوى الخاصة بالتعويض عن المسؤولية التقصيرية، والتعويض عن الأضرار الجسدية، وكافة الدعاوى الموضوعية الأخرى بما في ذلك دعوى عدم نفاذ التصرف، ودعوى دفع غير المستحق، ونتولى بمناسبة هذه الدعاوى تمثيل موكلينا قانونيا أمام المحاكم النظامية على اختلاف أنواعها ودرجاتها واختصاصاتها والترافع أمامها وتقديم جميع الطعون الخاصة بالقرارات الصادرة عنها بشكل احترافي لنلبي طموح موكلينا ونحافظ على حقوقهم بما يتوافق مع أحكام القانون.',
            'description_en' => 'Our firm includes a cadre specialized in civil and legal cases as well as all cases branching out of civil law and legislation related to it. In fact, we seek, through the concerted efforts of the work team, to protect all civil and commercial rights of our clients in cases that fall under the umbrella of this law and legislation related to it, including cases related to contracts, whether claiming implementation, obligations in kind or compensation arising from non-implementation of contracts, contractual liability, lawsuits for avoiding contracts or lawsuits for invalidity of contracts in addition to lawsuits for compensation for tort liability, compensation for bodily damages and all other substantive lawsuits including a lawsuit for non-enforceability of disposition and a lawsuit for non-payment of the receivables in addition to commercial lawsuits including financial claims according to the account statement or according to checks or lawsuits resulting from commercial contracts. Yet, and on the occasion of these lawsuits, we represent our clients legally before the justice courts of all types, degrees and specialties, plead before them and submit all appeals related to the decisions issued by them in a professional manner to meet the expectations of our clients and preserve their rights in accordance with the provisions of the law.'
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
