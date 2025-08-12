<section>
    <header>
        <h2 class="font-medium text-gray-900 text-lg">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-gray-600 text-sm">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6 mt-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="block mt-1 w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="block mt-1 w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="gender" :value="__('Gender')" />
            <select name="gender" id="gender" class="block mt-1 w-full">
                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
        </div>

        <div>
            <x-input-label for="contact_no" :value="__('Contact No')" />
            <x-text-input id="contact_no" name="contact_no" type="text" class="block mt-1 w-full" :value="old('contact_no', $user->contact_no)" required autocomplete="contact_no" />
            <x-input-error class="mt-2" :messages="$errors->get('contact_no')" />
        </div>

        <div>
            <x-input-label for="address" :value="__('Address')" />
            <x-text-input id="address" name="address" type="text" class="block mt-1 w-full" :value="old('address', $user->address)" required autocomplete="address" />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div>
            <x-input-label for="dob" :value="__('Date of Birth')" />
            <x-text-input id="dob" name="dob" type="date" class="block mt-1 w-full" :value="old('dob', $user->dob)" required autocomplete="dob" />
            <x-input-error class="mt-2" :messages="$errors->get('dob')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-gray-600 text-sm"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
