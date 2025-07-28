@extends('layouts.app1')
@section('content')
    <div class="min-h-screen flex items-center justify-center bg-[#011627] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-[#D4AF37]">
                    {{ __('messages.login') }}
                </h2>
            </div>
            <form class="mt-8 space-y-6" action="{{ route('loginclient') }}" method="POST">
                @csrf
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="email" class="sr-only">{{ __('messages.email') }}</label>
                        <input id="email" name="email" type="text" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:z-10 sm:text-sm"
                            placeholder="{{ __('messages.email') }}">
                    </div>
                    <div>
                        <label for="password" class="sr-only">{{ __('messages.password') }}</label>
                        <input id="password" name="password" type="password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:z-10 sm:text-sm"
                            placeholder="{{ __('messages.password') }}">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox"
                            class="h-4 w-4 text-[#D4AF37] focus:ring-[#D4AF37] border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                            {{ __('messages.remember_me') }}
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-[#D4AF37] hover:text-[#011627]">
                            {{ __('messages.forgot_password') }}
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#D4AF37] hover:bg-[#011627] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#D4AF37]">
                        {{ __('messages.login') }}
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <p class="text-sm text-gray-600">
                    {{ __('messages.dont_have_account') }}
                    <a href="{{ route('register') }}" class="font-medium text-[#D4AF37] hover:text-[#011627]">
                        {{ __('messages.create_account') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
