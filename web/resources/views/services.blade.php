@extends('layouts.app1')
@section('content')
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
                        <p>مزيد</p>
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
