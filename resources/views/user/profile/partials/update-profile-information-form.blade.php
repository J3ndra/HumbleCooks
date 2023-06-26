<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label-user for="avatar" :value="__('Avatar')" />
            <input id="avatar" name="avatar" type="file" accept="image/*" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <!-- Preview Avatar -->
        <div id="avatar-preview" class="mt-4">
            @if ($user->avatar)
                <img src="{{ Storage::disk('avatars')->url($user->avatar) }}" alt="Avatar"
                    class="w-60 h-60 rounded-full" />
            @else
                <div class="w-60 h-60 bg-gray-200 rounded-full object-cover"></div>
            @endif
        </div>
        <!-- End Preview Avatar -->

        <div>
            <x-input-label-user for="name" :value="__('Name')" />
            <x-text-input-user id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label-user for="email" :value="__('Email')" />
            <x-text-input-user id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <script>
        // Avatar preview handling
        const avatarInput = document.getElementById('avatar');
        const avatarPreview = document.getElementById('avatar-preview');

        avatarInput.addEventListener('change', () => {
            const file = avatarInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = () => {
                    const img = document.createElement('img');
                    img.src = reader.result;
                    img.alt = 'Avatar';
                    img.classList.add('w-60', 'h-60', 'rounded-full');

                    while (avatarPreview.firstChild) {
                        avatarPreview.firstChild.remove();
                    }

                    avatarPreview.appendChild(img);
                };
                reader.readAsDataURL(file);
            } else {
                while (avatarPreview.firstChild) {
                    avatarPreview.firstChild.remove();
                }
                avatarPreview.innerHTML = '<div class="w-60 h-60 bg-gray-200 rounded-full"></div>';
            }
        });
    </script>
</section>
