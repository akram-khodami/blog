<div class="card mb-1">
    <div class="card-header"> {{ __('بروزرسانی کلمه عبور') }}</div>
    <div class="card-body">

        <small class="text-info">
            {{ __('اطمینان حاصل کنید که حساب شما از یک رمز عبور طولانی و تصادفی برای حفظ امنیت استفاده می کند.') }}
        </small>

        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('put')

            <div>
                <x-input-label for="current_password" :value="__('کلمه عبور فعلی')" />
                <x-text-input id="current_password" name="current_password" type="password" class="mt-1 form-control"
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-danger" />
            </div>

            <div>
                <x-input-label for="password" :value="__('کلمه عبور جدید')" />
                <x-text-input id="password" name="password" type="password" class="mt-1 form-control"
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-danger" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('تایید کلمه عبور')" />
                <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                    class="mt-1 form-control" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-danger" />
            </div>

            <div class="flex items-center gap-4">
                <button class="btn btn-outline-success btn-sm btn-shadow mt-1">
                    <i class="fa fa-save"></i>
                </button>
                @if (session('status') === 'password-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-success">
                        {{ __('کلمه عبور با موفقیت تغییر یافت.') }}</p>
                @endif
            </div>
        </form>
    </div>
</div>
