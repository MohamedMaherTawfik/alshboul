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
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->text('text_ar');
            $table->text('text_en');
            $table->timestamps();
        });
        DB::table('about_us')->insert([
            'text_ar' => ' تأسس مكتبنا عام 2006 بالشراكة مع مجموعة من الزملاء المحامين لممارسة العمل في مجال المحاماة والاستشارات القانونية، ثم ارتأينا بعد ذلك الاستقلال بمكتبنا الخاص المعروف باسم الشبول للمحاماة والاستشارات القانونية لنقدم لموكلينا الخدمات القانونية بأعلى المستويات وأحدث الطرق ولنرتقي بخدمة موكلينا بشكل يواكب مقتضيات العصر، واضعين في اعتبارنا تسخير كافة الوسائل الحديثة لهذه الغايات وتوظيف التقدم الإلكتروني لخدمة موكلينا، مجسدين ذلك بتأسيس موقعنا الإلكتروني المخصص لخدمة موكلينا "الشبول للمحاماة والاستشارات القانونية" وإطلاق التطبيق الإلكترون الخاص بمكتبنا "الشبول للمحاماة" لنتيح من خلالهما للموكلين التعرف على آخر مستجدات القضايا الخاصة بهم بما في ذلك المواعيد الخاصة بالجلسات وما تم خلالها بشكل دوري وإخطارهم بجميع ما تم ويتم على الإجراءات الخاصة، وبما يمكنهم من إبداء استفساراتهم وملاحظاتهم وإبداء طلباتهم مهما كان نوعها أينما وجدو وفي أي وقت، وبما يوفر لهم الوقت والجهد في الحصول على أفضل خدمة قانونية واستشارية.',
            'text_en' => 'Our firm was established in 2006 in partnership with a group of associate lawyers to practice work in the field of law and legal advice after which we decided to become independent in our own firm known as "Al Shboul Advocates and Legal Consultants to provide our clients with legal services at the highest levels and the latest methods as well as to improve the service of our clients in a way that keeps pace with the modern requirements. In fact, we have taken into account harnessing all modern means for these purposes and employing electronic progress to serve our clients embodying this by establishing our website dedicated to serving our clients “Al Shboul Law Firm and Legal Consultation” and launching the electronic application of our firm “Al Shboul Law Firm” to allow clients, and through the same, to learn about the latest developments in their cases, including the dates of the sessions and the progress of them periodically and notifying them of all that was done and is being done according to the special procedures so that they can express their inquiries and observations as well as expressing their requests of any kind wherever at any time in a way that saves them time and effort in obtaining the best legal and advisory service.'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
