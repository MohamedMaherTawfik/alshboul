  @php
      $links = \App\Models\SocialLink::first();
  @endphp
  <footer class="bg-[#031424] text-white text-center pt-10 pb-2 mt-16">
      <div class="container grid grid-cols-1 gap-6 mx-auto md:grid-cols-3">
          <div class="px-5">
              <ul class="flex flex-col items-center mt-4 space-y-2 text-center">
                  <li><img loading="lazy" src=" {{ asset('assets/admin/imgs/logoFull.png') }}" class="h-20 w-28"
                          alt="banat app"></li>
                  <li class="text-lg font-semibold text-white"></li>

              </ul>
          </div>

          <div class="px-5">
              <ul class="flex flex-col mt-4 space-y-2 {{ __('messages.text-align') }}">
                  <li><a href="{{ route('home') }}"
                          class="transition hover:text-yellow-600">{{ __('messages.home') }}</a>
                  </li>
                  <li><a href="{{ route('about-us') }}"
                          class="transition hover:text-yellow-600">{{ __('messages.about-us') }} </a></li>

                  <li><a href="{{ route('services') }}"
                          class="transition hover:text-yellow-600">{{ __('messages.services') }} </a></li>
                  <li><a href="{{ route('apply-careers.create') }}"
                          class="transition hover:text-yellow-600">{{ __('messages.jobs') }} </a></li>
                  <li><a href="#" class="transition hover:text-yellow-600">{{ __('messages.contact-us') }}
                      </a></li>


              </ul>
          </div>
          <div class="px-5">
              <ul class="flex flex-col mt-4 space-y-2 {{ __('messages.text-align') }}">
                  {{-- <li><a href="{{ $links->sale ?? '#' }}" class="transition hover:text-black">{{ __('messages.sale') }}
                    </a></li> --}}
                  <li><a href="#" class="transition hover:text-yellow-600">{{ __('messages.contact_us') }} </a>
                  </li>
                  <li>
                      <a href="{{ $links->facebook ?? '#' }}" class="ml-3">
                          <i class="fab fa-facebook-f"></i>
                      </a>
                      <a href="{{ $links->x ?? '#' }}" class="ml-3">
                          <i class="fab fa-twitter"></i>
                      </a>
                      <a href="{{ $links->whatsapp ?? '#' }}" class="ml-3">
                          <i class="fab fa-whatsapp"></i>
                      </a>
                      <a href="{{ $links->instagram ?? '#' }}" class="ml-3">
                          <i class="fab fa-instagram"></i>
                      </a>
                  </li>
                  <li><i class="fas fa-phone"></i> ({{ __('messages.office_number') }})
                      : {{ $links->phone }}</li>
                  <li><i class="fas fa-phone"></i> ({{ __('messages.private_number') }}) : {{ $links->phone_spical }}
                  </li>
                  <li>
                      <i class="fas fa-fax"></i> ({{ __('messages.fax_number') }}) : {{ $links->fax }}
                  </li>
                  </li>
              </ul>
          </div>

      </div>
      <div class="px-2 pt-8 text-center">
          {{ __('messages.copy') }} &copy; {{ __('messages.title') }}
      </div>
  </footer>
