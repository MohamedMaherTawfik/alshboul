@extends('layouts.app1')
@section('content')
    <div class="min-h-screen flex items-center justify-center bg-[#011627] py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md p-8 space-y-8 bg-white rounded-lg shadow-lg">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-[#D4AF37]">
                    {{ __('messages.register') }}
                </h2>
            </div>
            <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
                @csrf
                <div class="-space-y-px rounded-md shadow-sm">
                    <div>
                        <label for="name" class="sr-only">{{ __('messages.name') }}</label>
                        <input id="name" name="name" type="text" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:z-10 sm:text-sm"
                            placeholder="{{ __('messages.name') }}">
                    </div>
                    <div>
                        <label for="username" class="sr-only">{{ __('messages.username') }}</label>
                        <input id="username" name="username" type="text" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:z-10 sm:text-sm"
                            placeholder="{{ __('messages.username') }}">
                    </div>
                    <div>
                        <label for="email" class="sr-only">{{ __('messages.email') }}</label>
                        <input id="email" name="email" type="email" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:z-10 sm:text-sm"
                            placeholder="{{ __('messages.email') }}">
                    </div>
                    <div>
                        <label for="phone" class="sr-only">{{ __('messages.phone') }}</label>
                        <input id="phone" name="phone" type="tel" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:z-10 sm:text-sm"
                            placeholder="{{ __('messages.phone') }}">
                    </div>
                    <div>
                        <label for="address" class="sr-only">{{ __('messages.address') }}</label>
                        <input id="address" name="address" type="text" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:z-10 sm:text-sm"
                            placeholder="{{ __('messages.address') }}">
                    </div>
                    <div>
                        <label for="password" class="sr-only">{{ __('messages.password') }}</label>
                        <input id="password" name="password" type="password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:z-10 sm:text-sm"
                            placeholder="{{ __('messages.password') }}">
                    </div>
                    <div>
                        <label for="password_confirmation" class="sr-only">{{ __('messages.confirm_password') }}</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:z-10 sm:text-sm"
                            placeholder="{{ __('messages.confirm_password') }}">
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#D4AF37] hover:bg-[#011627] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#D4AF37]">
                        {{ __('messages.register') }}
                    </button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">
                    {{ __('messages.already_have_account') }}
                    <a href="{{ route('login1') }}" class="font-medium text-[#D4AF37] hover:text-[#011627]">
                        {{ __('messages.login_here') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
