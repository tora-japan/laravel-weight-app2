<x-myapp.guest title='ユーザーを登録しよう！' skipName='登録'>

<div class="sm:min-h-screen  flex sm:justify-center items-center sm:pt-0 bg-green-600">
    <div class="w-full sm:max-w-md bg-white  overflow-hidden sm:rounded">
        <div class="mt-4"></div>
        <div class="p-4">
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('user.register') }}">
            @honeypot

            @csrf
            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>
            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>
            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />
                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>
            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>
            <div class="mt-4">
                <x-label for="height" value="身長(cm) bmiの計算で使います" />
                <x-input id="height" class="block mt-1 w-full"
                                type="number"
                                value="150"
                                name="height" required />
            </div>

            <div class="flex items-center justify-center mt-4">
                <x-button>
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>

        <div class="flex justify-center items-center mt-4">
            <img class="w-2/12 sm:w-3/12" src="{!!url('/')!!}/img/kenkoushindan01_shinchou_girl_kakato.png">
        </div>

      </div>

    </div>
</div>



</x-myapp.guest>

