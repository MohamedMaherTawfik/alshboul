  @php
      $links = \App\Models\SocialLink::first();
  @endphp
  <header class="bg-[#011627] text-white">
      <div class="container flex flex-wrap items-center justify-between px-4 py-2 mx-auto md:flex-nowrap">
          <!-- Left: Logo -->
          <div class="flex items-center gap-3">
              <img src="{{ asset('assets/admin/imgs/logoFull.png') }}" alt="الشبول" class="h-12">
              <div class="text-sm font-bold leading-4 text-gold">
                  <p class="text-xl text-[#D4AF37]">{{ __('messages.logo_title') }}</p>
                  <p class="text-xs text-white">{{ __('messages.logo_subtitle') }} </p>
              </div>
          </div>

          <!-- Middle: Lawyer Name & Time -->
          <div class="hidden mt-2 text-center md:mt-0 md:block">
              <p class="text-xs text-gray-300">{{ __('messages.working_hours_label') }}</p>
              <p class="text-sm font-bold text-[#D4AF37]">6:00 - 9:00</p>
              <p class="mt-1 text-sm text-white">{{ __('messages.lawyer_title') }} </p>
              <p class="text-lg font-bold text-[#D4AF37]">{{ __('messages.lawyer_name') }} </p>
              <a href="{{ route('login1') }}"
                  class="mt-1 px-4 py-1 bg-[#D4AF37] hover:bg-yellow-600 inline-block text-black font-semibold rounded-md">{{ __('messages.client_login') }}
              </a>
          </div>

          <!-- Right: Nav + Button -->
          <div class="flex items-center gap-3 mt-4 ml-auto md:mt-0">
              <button id="menu-toggle" class="text-2xl text-[#D4AF37] md:hidden focus:outline-none">
                  <span id="menu-icon">☰</span>
              </button>

              <nav id="main-menu" class="items-center hidden gap-6 font-semibold text-l md:flex">
                  <a href="{{ route('home') }}" class="text-[#D4AF37]">{{ __('messages.home') }}</a>
                  <a href="{{ route('about-us') }}">{{ __('messages.about-us') }} </a>
                  <a href="{{ route('services') }}">{{ __('messages.services') }} </a>
                  <a href="{{ route('apply-careers.create') }}">{{ __('messages.jobs') }} </a>
                  <a href="{{ $links->whatsapp }}" class="flex items-center gap-1 text-green-400">
                      <i class="fab fa-whatsapp"></i>
                  </a>
                  <a href="{{ App::getLocale() == 'en' ? route('change.language', 'ar') : route('change.language', 'en') }}"
                      class="flex items-center">
                      <img src="{{ App::getLocale() == 'en' ? 'https://flagcdn.com/w40/jo.png' : 'https://flagcdn.com/w40/gb.png' }}"
                          class="h-4 ml-1" alt="English"> {{ App::getLocale() == 'en' ? 'AR' : 'EN' }}
                  </a>
              </nav>
          </div>
      </div>

      <!-- Responsive Mobile Menu -->
      <div id="mobile-menu" class="md:hidden hidden bg-[#021b30] px-4 pb-4">
          <nav class="flex flex-col gap-2 text-sm font-semibold">
              <a href="{{ route('home') }}" class="text-[#D4AF37]">{{ __('messages.home') }}</a>
              <a href="{{ route('about-us') }}">{{ __('messages.about-us') }} </a>
              <a href="{{ route('services') }}">{{ __('messages.services') }} </a>
              <a href="{{ route('apply-careers.create') }}">{{ __('messages.jobs') }} </a>
              <a href="{{ $links->whatsapp }}" class="flex items-center gap-1 text-green-400">
                  <i class="fab fa-whatsapp"></i>
              </a>
              <a href="{{ route('login1') }}">{{ __('messages.client_login') }} </a>
              <a href="{{ App::getLocale() == 'en' ? route('change.language', 'ar') : route('change.language', 'en') }}"
                  class="flex items-center">
                  <img src=" {{ App::getLocale() == 'en' ? 'https://flagcdn.com/w40/jo.png' : 'https://flagcdn.com/w40/gb.png' }}"
                      class="h-4 ml-1" alt="English"> {{ App::getLocale() == 'en' ? 'AR' : 'EN' }}
              </a>
          </nav>
      </div>
  </header>


  <div id="notificationModal"
      class="fixed inset-0 z-50 items-center justify-center hidden bg-black bg-opacity-50 top-20">
      <div class="relative max-w-full p-4 bg-white rounded-lg shadow-lg w-96">
          <!-- زر إغلاق -->
          <button onclick="toggleNotifications()" class="absolute text-gray-500 top-2 right-2 hover:text-gray-800">
              <i class="text-xl fa-solid fa-xmark"></i>
          </button>

          <h3 class="mb-4 text-lg font-bold text-gray-700">{{ __('messages.notfiys') }}</h3>

          <ul class="space-y-2 overflow-y-auto max-h-60">
              @if (isset($notifications) && !empty($notifications) && count($notifications) > 0)
                  <a href="{{ route('notifications.markAllRead') }}"
                      class="text-[#BC8648] hover:text-black transition">
                      {{ __('messages.make_all_ready') }}
                  </a>
                  @foreach ($notifications as $item)
                      <li class="flex items-center w-full p-2 bg-gray-100 rounded">

                          <div class="flex flex-col flex-1">
                              <a href="{{ $item->data['link'] ?? '#' }}">
                                  <p>{{ $item->data['title'] }}</p>
                              </a>
                              <span class="text-xs text-gray-500">{{ $item->created_at }}</span>
                          </div>


                          <form action="{{ route('notifications.read', $item->id) }}" method="POST" class="ml-4">
                              @csrf
                              <button type="submit"
                                  class="px-2 py-1 rounded-full text-white bg-[#BC8648] hover:bg-[#a43d48] transition">
                                  <i class="fa-solid fa-eye"></i>
                              </button>
                          </form>
                      </li>
                  @endforeach
              @else
                  <li class="text-center text-gray-500">{{ __('messages.no_data') }}</li>
              @endif
          </ul>
      </div>
  </div>
