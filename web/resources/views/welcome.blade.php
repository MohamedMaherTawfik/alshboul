@extends('layouts.app1')
@section('content')
    @if ($moveBar)
        <marquee direction="right" loop="20"
            style="font-size:22px;direction: ltr !important; color:#343030;z-index:50;background:linear-gradient(45deg, #ba7534, #fdbd83bf, #af7532);">
            {{ $moveBar->text }}
        </marquee>
    @endif

    <section class="relative">
        <div class="relative mb-5 swiper mySwiper">
            <div class="swiper-wrapper">
                @if (isset($sliders) && !empty($sliders) && count($sliders) > 0)
                    @foreach ($sliders as $slider)
                        <div class="swiper-slide">
                            <img src="{{ asset($slider->image) }}" alt="{{ $slider->title }}"
                                class="w-full h-[450px] cover md:object-cover block">

                        </div>
                    @endforeach
                @else
                    <div class="swiper-slide">
                        <img src="{{ asset('assets/admin/imgs/bg.jpg') }}" alt="صورة 1"
                            class="w-full h-[450px] object-cover">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('assets/admin/imgs/logoFull.png') }}" alt="صورة 2"
                            class="w-full h-[450px] object-cover">
                    </div>
                @endif
            </div>
            <div class="swiper-pagination absolute translate-y-[-50%]"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>

    <div class="w-full">
        <video controls class="w-full rounded-lg shadow-lg" autoplay controls playsinline muted>
            <source src="{{ asset('assets/img/test1.mp4') }}" type="video/mp4">
        </video>
    </div>

    <!-- About Us Section -->
    <section id="about"
        class="container relative flex gap-5 flex-col items-center py-4 px-5 mx-auto md:flex-row mt-[50px]">
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

    <!-- Services Section -->
    <section class="container px-5 py-16 mx-auto overflow-hidden text-center">
        <h2 class="text-3xl font-bold text-[#BC8648] h2-animate">{{ __('messages.services') }}</h2>
        <p class="my-2">{{ __('messages.our-services') }}</p>
        <div class="grid grid-cols-1 gap-6 mt-6 md:grid-cols-3">
            @if (isset($caseTypes) && !empty($caseTypes) && count($caseTypes) > 0)
                @foreach ($caseTypes as $caseType)
                    <div
                        class="p-6 bg-gray-200 rounded-lg card-animate shadow-lg hover:scale-[1.01] sm:hover:scale-[1.03] lg:hover:scale-[1.05] hover:shadow-xl">
                        <img loading="lazy" src="{{ asset($caseType->image) }}"
                            alt="{{ app()->getLocale() == 'ar' ? $caseType->name_ar : $caseType->name_en }}"
                            class="block mx-auto">
                        <h3 class="mt-4 text-xl font-bold">
                            {{ app()->getLocale() == 'ar' ? $caseType->name_ar : $caseType->name_en }}
                        </h3>
                        <a href="#"
                            class="mt-1 px-4 py-1 bg-[#D4AF37] hover:bg-yellow-600 text-black font-semibold rounded-md inline-block">{{ __('messages.details') }}</a>
                    </div>
                @endforeach
            @else
                <div
                    class="p-6 bg-gray-200 rounded-lg card-animate shadow-lg hover:scale-[1.01] sm:hover:scale-[1.03] lg:hover:scale-[1.05] hover:shadow-xl">
                    <img loading="lazy" src="{{ asset('assets/img/Lawshar31.png') }}" alt="قضايا شرعية"
                        class="block mx-auto">
                    <h3 class="mt-4 text-xl font-bold">قضايا شرعية</h3>
                    <p>مزيد</p>
                </div>

                <div
                    class="p-6 bg-gray-200 rounded-lg card-animate shadow-lg hover:scale-[1.01] sm:hover:scale-[1.03] lg:hover:scale-[1.05] hover:shadow-xl">
                    <img loading="lazy" src="{{ asset('assets/img/LawJazai1.png') }}" alt="قضايا جزائية"
                        class="block mx-auto">
                    <h3 class="mt-4 text-xl font-bold">قضايا جزائية</h3>
                    <p>مزيد</p>
                </div>

                <div
                    class="p-6 bg-gray-200 rounded-lg card-animate shadow-lg hover:scale-[1.01] sm:hover:scale-[1.03] lg:hover:scale-[1.05] hover:shadow-xl">
                    <img loading="lazy" src="{{ asset('assets/img/MadaniLaw1.png') }}" alt="قضايا مدنية"
                        class="block mx-auto">
                    <h3 class="mt-4 text-xl font-bold">قضايا مدنية</h3>
                    <p>مزيد</p>
                </div>
            @endif
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

        document.addEventListener("DOMContentLoaded", function() {
            const cards = document.querySelectorAll(".card-animate");

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("show");
                    } else {
                        entry.target.classList.remove("show");
                    }
                });
            }, {
                threshold: 0.3
            });

            cards.forEach(card => observer.observe(card));
        });
    </script>
@endsection
