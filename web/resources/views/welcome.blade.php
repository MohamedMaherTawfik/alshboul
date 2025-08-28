<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>مكتب المحاماة - مميزاتنا</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
    </style>
</head>


<body class="bg-gray-50
        text-gray-800">

    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="container mx-auto px-4 py-3 flex flex-col md:flex-row items-center justify-between">
            <!-- Left: Search + Language -->
            <div class="flex items-center gap-2 w-full md:w-auto mb-3 md:mb-0 order-2 md:order-1">
                <!-- Search -->
                <div class="relative w-full md:w-56">
                    <input type="text" placeholder="بحث"
                        class="w-full px-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-yellow-400" />
                    <button class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <!-- Language Switch -->
                <button class="flex items-center gap-1 border rounded-md px-3 py-2 text-sm font-medium">
                    En
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </button>
            </div>

            <!-- Logo (Center) -->
            <div class="order-1 md:order-2 mb-3 md:mb-0">
                <img src="{{ asset('images/logoFull.png') }}" alt="Logo" class="h-12 mx-auto" />
            </div>

            <!-- Navigation + Button (Right) -->
            <div class="order-3">
                <nav class="flex gap-6 items-center">
                    <a href="#" class="bg-yellow-600 text-white px-3 py-2 rounded-md">الرئيسية</a>
                    <a href="#" class="hover:text-yellow-600">من نحن</a>
                    <a href="#" class="hover:text-yellow-600">الخدمات</a>
                    <a href="#" class="hover:text-yellow-600">الوظائف</a>
                    <a href="#" class="hover:text-yellow-600">المدونة</a>
                    <a href="#" class="hover:text-yellow-600">المزيد</a>
                    <a href="#" class="hover:text-yellow-600">الخريطة</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Sub Header + Hero Section -->
    <div class="container mx-auto px-4">
        <!-- Sub Header Title -->
        <div class="text-center text-4xl font-bold py-3 border-b">
            مكتب الشبول يرحب بكم - أهلا وسهلا
        </div>

        <!-- Hero Section -->
        <section class="relative mt-4">
            <img src="{{ asset('images/hero.png') }}" alt="Office"
                class="w-full h-[600px] object-cover rounded-lg shadow-md" />
        </section>

        <div class="flex justify-center gap-4 mt-6">
            <!-- LinkedIn -->
            <a href="#" target="_blank"
                class="text-blue-700 hover:bg-blue-700 hover:text-white border border-blue-700 rounded-full p-3 transition flex items-center justify-center w-10 h-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 448 512">
                    <path
                        d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8 0 24.1 24.09-.5 53.79-.5c29.5 0 53.6 24.6 53.6 54.3 0 29.7-24.1 53.8-53.6 53.8zM447.9 448h-92.4V302.4c0-34.7-12.4-58.4-43.6-58.4-23.8 0-38 16-44.3 31.4-2.3 5.6-2.9 13.3-2.9 21.1V448h-92.5s1.2-269.5 0-297.1h92.5v42.1c12.3-19 34.4-46.1 83.7-46.1 61.2 0 107.2 39.9 107.2 125.6V448z" />
                </svg>
            </a>

            <!-- YouTube -->
            <a href="#" target="_blank"
                class="text-red-600 hover:bg-red-600 hover:text-white border border-red-600 rounded-full p-3 transition flex items-center justify-center w-10 h-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 576 512">
                    <path
                        d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.5-48.6C458.4 64 288 64 288 64s-170.4 0-213.2 11.5c-23.7 6.3-42.2 24.9-48.5 48.6C16 166.9 16 256 16 256s0 89.1 10.3 131.9c6.3 23.7 24.8 42.3 48.5 48.6C117.6 448 288 448 288 448s170.4 0 213.2-11.5c23.7-6.3 42.2-24.9 48.5-48.6C560 345.1 560 256 560 256s0-89.1-10.3-131.9zM232 334.6V177.4l142.7 78.6L232 334.6z" />
                </svg>
            </a>

            <!-- Twitter/X -->
            <a href="#" target="_blank"
                class="text-black hover:bg-black hover:text-white border border-black rounded-full p-3 transition flex items-center justify-center w-10 h-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 512 512">
                    <path
                        d="M459.4 151.7c.3 4.5.3 9 .3 13.6 0 138.7-105.6 298.7-298.7 298.7-59.5 0-114.7-17.2-161.1-47 8.4 1 16.8 1.6 25.6 1.6 49.3 0 94.6-16.8 130.5-45.5-46.2-1-85-31.2-98.4-72.8 6.4 1 12.8 1.6 19.2 1.6 9.4 0 18.7-1.3 27.5-3.6-48.4-9.7-84.7-52.3-84.7-103.6v-1.3c14.1 7.8 30.5 12.8 47.8 13.6-28.8-19.2-47.5-52.1-47.5-89.5 0-19.7 5.2-38.4 14.1-54.2 51.2 63 128.3 104.2 214.4 108.9-1.9-7.8-2.9-15.9-2.9-24 0-57.8 47.2-105 105-105 30.2 0 57.5 12.8 76.7 33.5 23.7-4.5 46.5-13.3 66.7-25.6-7.8 24.5-24.5 45.2-46.2 58.1 21.1-2.3 41.8-8.1 60.8-16.2-14.4 20.8-32.6 39.1-53.7 53.7z" />
                </svg>
            </a>

            <!-- Facebook -->
            <a href="#" target="_blank"
                class="text-blue-600 hover:bg-blue-600 hover:text-white border border-blue-600 rounded-full p-3 transition flex items-center justify-center w-10 h-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 320 512">
                    <path
                        d="M279.14 288l14.22-92.66h-88.91V134.12c0-25.35 12.42-50.06 52.24-50.06H293V6.26S259.5 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72V195.3H22.89V288h81.39v224h100.17V288z" />
                </svg>
            </a>

            <!-- Instagram with Font Awesome -->
            <a href="https://www.instagram.com" target="_blank"
                class="block text-red-500 hover:bg-red-500 hover:text-white border border-red-500 rounded-full p-3 transition flex items-center justify-center w-10 h-10">
                <i class="fab fa-instagram fa-sm"></i>
            </a>
        </div>

    </div>

    <section class="flex flex-col items-center justify-center py-6 px-4 bg-gray-50 min-h-40">
        <div class="flex space-x-8 space-x-reverse">
            <a href=""
                class="px-12 py-3 bg-amber-400 text-gray-800 font-bold text-lg rounded-lg hover:bg-amber-500 transition-colors duration-200 shadow-sm min-w-48">
                بوابه الموكلين
            </a>
            <a href="{{ route('apply-careers.index') }}"
                class="px-12 py-3 bg-amber-400 text-gray-800 font-bold text-lg rounded-lg hover:bg-amber-500 transition-colors duration-200 shadow-sm min-w-48">
                بوابه المحاميين
            </a>
        </div>
    </section>
    <!-- Service Cards -->
    <section class="container mx-auto px-4 py-12">
        <h2 class="text-3xl font-bold text-center mb-10">خدماتنا</h2>
        <div class="grid grid-cols-3 gap-4 mt-8">
            <!-- Card 1 -->
            <div
                class="relative group overflow-hidden rounded-lg shadow-md transition-transform duration-300 hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-b from-gray-300 to-gray-300 opacity-80"></div>
                <img src="{{ asset('images/hammer.png') }}" alt="مطرقة قاضٍ" class="w-full h-60 object-cover" />
                <div class="absolute top-0 left-0 right-0 p-3 bg-gray-700 text-white text-center font-bold text-sm">
                    تنظيم العقود
                </div>
            </div>

            <!-- Card 2 -->
            <div
                class="relative group overflow-hidden rounded-lg shadow-md transition-transform duration-300 hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-b from-gray-400 to-gray-400 opacity-80"></div>
                <img src="{{ asset('images/hammer.png') }}" alt="مطرقة قاضٍ" class="w-full h-60 object-cover" />
                <div class="absolute top-0 left-0 right-0 p-3 bg-gray-700 text-white text-center font-bold text-sm">
                    تنظيم العقود
                </div>
            </div>

            <!-- Card 3 -->
            <div
                class="relative group overflow-hidden rounded-lg shadow-md transition-transform duration-300 hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-b from-gray-500 to-gray-500 opacity-80"></div>
                <img src="{{ asset('images/hammer.png') }}" alt="مطرقة قاضٍ" class="w-full h-60 object-cover" />
                <div class="absolute top-0 left-0 right-0 p-3 bg-gray-700 text-white text-center font-bold text-sm">
                    تنظيم العقود
                </div>
            </div>

            <!-- Card 4 -->
            <div
                class="relative group overflow-hidden rounded-lg shadow-md transition-transform duration-300 hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-b from-gray-600 to-gray-600 opacity-80"></div>
                <img src="{{ asset('images/hammer.png') }}" alt="مطرقة قاضٍ" class="w-full h-60 object-cover" />
                <div class="absolute top-0 left-0 right-0 p-3 bg-gray-700 text-white text-center font-bold text-sm">
                    تنظيم العقود
                </div>
            </div>

            <!-- Card 5 -->
            <div
                class="relative group overflow-hidden rounded-lg shadow-md transition-transform duration-300 hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-b from-gray-700 to-gray-700 opacity-80"></div>
                <img src="{{ asset('images/hammer.png') }}" alt="مطرقة قاضٍ" class="w-full h-60 object-cover" />
                <div class="absolute top-0 left-0 right-0 p-3 bg-gray-700 text-white text-center font-bold text-sm">
                    تنظيم العقود
                </div>
            </div>

            <!-- Card 6 -->
            <div
                class="relative group overflow-hidden rounded-lg shadow-md transition-transform duration-300 hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-b from-gray-800 to-gray-800 opacity-80"></div>
                <img src="{{ asset('images/hammer.png') }}" alt="مطرقة قاضٍ" class="w-full h-60 object-cover" />
                <div class="absolute top-0 left-0 right-0 p-3 bg-gray-700 text-white text-center font-bold text-sm">
                    تنظيم العقود
                </div>
            </div>

            <!-- Card 7 -->
            <div
                class="relative group overflow-hidden rounded-lg shadow-md transition-transform duration-300 hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-b from-gray-800 to-gray-900 opacity-80"></div>
                <img src="{{ asset('images/hammer.png') }}" alt="مطرقة قاضٍ" class="w-full h-60 object-cover" />
                <div class="absolute top-0 left-0 right-0 p-3 bg-gray-700 text-white text-center font-bold text-sm">
                    تنظيم العقود
                </div>
            </div>

            <!-- Card 8 -->
            <div
                class="relative group overflow-hidden rounded-lg shadow-md transition-transform duration-300 hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-b from-gray-900 to-gray-1000 opacity-80"></div>
                <img src="{{ asset('images/hammer.png') }}" alt="مطرقة قاضٍ" class="w-full h-60 object-cover" />
                <div class="absolute top-0 left-0 right-0 p-3 bg-gray-700 text-white text-center font-bold text-sm">
                    تنظيم العقود
                </div>
            </div>

            <!-- Card 9 -->
            <div
                class="relative group overflow-hidden rounded-lg shadow-md transition-transform duration-300 hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-b from-black to-gray-1100 opacity-80"></div>
                <img src="{{ asset('images/hammer.png') }}" alt="مطرقة قاضٍ" class="w-full h-60 object-cover" />
                <div class="absolute top-0 left-0 right-0 p-3 bg-gray-700 text-white text-center font-bold text-sm">
                    تنظيم العقود
                </div>
            </div>
        </div>
    </section>

    <!-- About Us -->
    <section class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center gap-10">
                <!-- Text -->
                <div class="md:w-1/2">
                    <h2 class="text-3xl font-bold mb-4">من نحن</h2>
                    <p class="text-gray-700 mb-6">
                        مكتب الشريعة للمحاماة - دكتور عمر السبولي<br>
                        متخصص في القضايا المدنية والجنائية، نقدم خدمات قانونية شاملة للعملاء.
                    </p>
                    <p class="text-gray-700 mb-6">
                        لدينا أكثر من 15 سنة خبرة في المجال القانوني، ونحن نؤمن بالعدالة والنزاهة.
                    </p>
                    <div class="flex space-x-4">
                        <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg ml-2">تواصل
                            معنا</button>
                        <button class="border border-gray-300 hover:border-yellow-500 px-6 py-2 rounded-lg">احجز
                            موعد</button>
                    </div>
                </div>
                <!-- Image -->
                <div class="md:w-1/2">
                    <img src="{{ asset('images/omar.svg') }}" alt="المحامي" class="rounded-lg shadow-lg" />
                </div>
            </div>
        </div>
    </section>

    <!-- Features with Hover & Popup using Alpine.js -->
    <section class="py-16 bg-gray-50">
        <!-- Alpine.js (ضعه مرة واحدة في الصفحة، يفضل قبل </body>) -->

        <div class="container mx-auto px-4">
            <div x-data="{ openModal: false }" class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- Card 1: ملف بين يديك -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-2xl hover:scale-105 transition-all duration-300 transform
            flex flex-col justify-center items-center text-center"
                    style="height: 350px;">
                    <div class="text-yellow-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold">ملف بين يديك</h3>
                </div>

                <!-- Card 2: الليكسن حاص -->
                <div class="bg-yellow-500 p-6 rounded-lg shadow-md hover:shadow-2xl hover:scale-105 transition-all duration-300 transform
            flex flex-col justify-center items-center text-center text-white cursor-default"
                    style="height: 350px;">
                    <div class="text-white mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 18h.01M8 21h8a2 2 0 002-2V7.414A2 2 0 0018 5.414V4a2 2 0 00-2-2H8a2 2 0 00-2 2v1.414A2 2 0 006 7.414V16a2 2 0 002 2h.01M12 18V9" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold">الليكسن حاص</h3>
                    <p class="text-base mt-2">للموكلين</p>
                </div>

                <!-- Card 3: موقع الكتروني -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-2xl hover:scale-105 transition-all duration-300 transform
            flex flex-col justify-center items-center text-center"
                    style="height: 350px;">
                    <div class="text-yellow-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.336 0" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold">موقع الكتروني</h3>
                    <p class="text-base mt-2">خاص للموكلين</p>
                </div>


            </div>


        </div>
    </section>

    <div class="max-w-md mx-auto mt-10">
        <div
            class="border-2 border-yellow-500 rounded-lg mb-5 bg-white px-6 py-3 shadow-sm flex items-center justify-center">
            <p class="text-gray-700 font-medium text-sm">"رؤيتنا هي أن نخدم موكِلينا ومجتمعينا"</p>
        </div>
    </div>
    <div class="mb-10"></div>

    <!-- Hero Section -->
    <section class="relative mt-4 mb-4">
        <div class="container mx-auto px-4">
            <div class="relative w-full h-[600px] rounded-lg shadow-md overflow-hidden">
                <!-- الصورة كـ Background -->
                <img src="{{ asset('images/news.png') }}" alt="Office"
                    class="absolute inset-0 w-full h-full object-cover" />

                <!-- Overlay -->
                <div class="absolute inset-0 bg-black/40"></div>

                <!-- النص + صورة العميل -->
                <div
                    class="absolute inset-0 flex flex-col md:flex-row items-center justify-center text-white px-6 gap-8">

                    <!-- النص -->
                    <div class="flex-1 text-center md:text-left">
                        <h1 class="text-4xl md:text-5xl font-bold mb-4">مرحبا بك في موقعنا</h1>
                        <p class="text-lg md:text-xl max-w-xl">
                            هنا تقدر تكتب أي وصف أو جملة قصيرة تظهر فوق الصورة في نص الصفحة
                        </p>
                    </div>

                    <!-- صورة عميل -->
                    <div class="flex-1 flex justify-center md:justify-end">
                        <img src="{{ asset('images/client.png') }}" alt="Client"
                            class="w-64 h-64 object-cover rounded-full border-4 border-white shadow-lg" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Form -->
                <div class="md:w-1/3">
                    <h3 class="text-xl font-semibold mb-4">كلّي اتصال</h3>
                    <form>
                        <input type="email" placeholder="بريدك الإلكتروني"
                            class="w-full p-3 rounded-md bg-gray-800 border border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4" />
                        <button type="submit"
                            class="w-full bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold py-3 rounded-md transition">اتصل
                            الآن</button>
                    </form>
                </div>

                <!-- Contact Info -->
                <div class="md:w-2/3">
                    <div class="flex flex-col md:flex-row justify-between">
                        <div class="mb-6 md:mb-0">
                            <p class="text-gray-300 text-sm">
                                مكتبنا تم تأسيسه عام 2006، وقد حصل على شهادة التميز في مجال القانون والتشريعات.
                            </p>
                            <p class="text-gray-300 text-sm mt-2">
                                كما أننا نقدم خدمات قانونية شاملة لجميع القضايا والإجراءات القانونية.
                            </p>
                            <p class="text-gray-300 text-sm mt-2">
                                - خدمة مجانية للتواصل عبر الهاتف أو البريد الإلكتروني.
                            </p>
                        </div>
                        <div class="flex items-center">
                            <img src="{{ asset('images/logoFull.png') }}" alt="شعار المكتب" class="h-16" />
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-400">
                        <div>
                            <p class="font-semibold">تواصل معنا</p>
                            <p>+971 2012 4523</p>
                            <p>+971 3012 4523</p>
                        </div>
                        <div>
                            <p class="font-semibold">موقعنا</p>
                            <p>3821 New Farms, St. Dubai, UAE</p>
                            <p>info@lawoffice.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Font Awesome Icons (for social media) -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>

</html>
