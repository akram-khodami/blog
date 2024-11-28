<div class="card mb-1">
    <h5 class="card-header"> {{ __('اطلاعات پروفایل') }}</h5>
    <div class="card-body">

        <small class="text-info">
            {{ __('اطلاعات نمایه و آدرس ایمیل حساب خود را به روز کنید.') }}
        </small>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')

            <div>
                <x-input-label for="name" :value="__('نام')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 form-control " :value="old('name', $user->name)"
                    required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('ایمیل')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 form-control" :value="old('email', $user->email)"
                    required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800">
                            {{ __('آدرس ایمیل شما تایید نشده است.') }}

                            <button form="send-verification"
                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('برای ارسال مجدد ایمیل تایید اینجا را کلیک کنید.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('یک لینک تأیید جدید به آدرس ایمیل شما ارسال شده است.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center">

                <button class="btn btn-outline-success btn-sm btn-shadow mt-1">
                    <i class="fa fa-save"></i>
                </button>

                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-success">
                        {{ __('با موفقیت ذخیره شد.') }}</p>
                @endif
            </div>
        </form>

    </div>
</div>
