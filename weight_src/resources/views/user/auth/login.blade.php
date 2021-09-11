<x-myapp.guest title='ログインしよう！' skipName='ログイン'>

<div class="sm:min-h-screen  flex sm:justify-center items-center sm:pt-0 bg-green-600">
    <div class="w-full sm:max-w-md bg-white shadow-md overflow-hidden sm:rounded-lg">

        <a href="{!!url('/')!!}">
        <div class="flex justify-center items-center">
            <img class="w-6/12" src="{!!url('/')!!}/img/kenkoushindan03_taijuu_boy.png">
        </div>
        </a>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

<div class ="bg-green-500 p-4">

        <form method="POST" action="{{ route('user.login') }}">
            @honeypot
                        
            @csrf
            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <div class="flex items-center justify-center m-4">
                <x-button class="ml-3">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
</div>


    </div>
</div>


  

</x-myapp.guest>



