@extends('layouts.app1')
@section('content')
    <!-- About Us Section -->
    <section id="about" class="container relative flex gap-5 flex-col items-center py-4 px-5 mx-auto md:flex-row mt-[50px]">
        <div class="w-full md:w-2/3">
            <a href="">
                <img loading="lazy" class="w-1/2 mx-auto rounded-2xl" src="{{ asset($aboutUs->image) }}"
                    alt="الشبول للمحاماة">
            </a>
        </div>
        <div class="w-full text-center md:w-2/3 md:text-center">
            <a href="">
                <h2 id="title" class="mb-16 text-5xl font-bold h2-animate">{{ __('messages.about-us') }}</h2>
                <p class="mt-4 text-[#BC8648] text-line">
                    @if ($aboutUs)
                        @if (app()->getLocale() == 'ar')
                            {{ $aboutUs->text_ar }}
                        @else
                            {{ $aboutUs->text_en }}
                        @endif
                    @else
                        تأسس مكتبنا عام 2006 بالشراكة مع مجموعة من الزملاء المحامين لممارسة العمل في مجال المحاماة
                        والاستشارات القانونية، ثم ارتأينا بعد ذلك الاستقلال بمكتبنا الخاص المعروف باسم
                        "الشبول للمحاماة والاستشارات القانونية" لنقدم لموكلينا الخدمات القانونية بأعلى المستويات وأحدث الطرق
                        ولنرتقي بخدمة موكلينا بشكل يواكب مقتضيات العصر، واضعين في اعتبارنا تسخير كافة الوسائل الحديثة لهذه
                        الغايات وتوظيف التقدم الإلكتروني لخدمة موكلينا، مجسدين ذلك بتأسيس موقعنا الإلكتروني المخصص لخدمة
                        موكلينا
                        "الشبول للمحاماة والاستشارات القانونية" وإطلاق التطبيق الإلكترون الخاص بمكتبنا "الشبول للمحاماة"
                        لنتيح
                        من خلالهما للموكلين التعرف على آخر مستجدات القضايا الخاصة بهم بما في ذلك المواعيد الخاصة بالجلسات
                        وما تم
                        خلالها بشكل دوري وإخطارهم بجميع ما تم ويتم على الإجراءات الخاصة، وبما يمكنهم من إبداء استفساراتهم
                        وملاحظاتهم وإبداء طلباتهم مهما كان نوعها أينما وجدو وفي أي وقت، وبما يوفر لهم الوقت والجهد في الحصول
                        على
                        أفضل خدمة قانونية واستشارية.
                    @endif
                </p>
            </a>
        </div>
    </section>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const headings = document.querySelectorAll("section h2");

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("show");
                    } else {
                        entry.target.classList.remove("show");
                    }
                });
            }, {
                threshold: 0.5
            });

            headings.forEach(h2 => observer.observe(h2));
        });
    </script>
@endsection 