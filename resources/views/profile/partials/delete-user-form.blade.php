<div class="card">
    <div class="card-header">
        {{ __('حذف اکانت') }}
    </div>
    <div class="card-body">
        <small class="text-info">
            {{ __('پس از حذف حساب شما، تمام منابع و داده های آن برای همیشه حذف می شوند. قبل از حذف حساب خود، لطفاً هر گونه داده یا اطلاعاتی را که می خواهید حفظ کنید دانلود کنید.') }}
        </small>

        <x-danger-button x-data="" class="btn btn-danger"
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('حذف اکانت') }}</x-danger-button>

        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('آیا مطمئن هستید که می خواهید حساب خود را حذف کنید؟') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __('پس از حذف حساب شما، تمام منابع و داده های آن برای همیشه حذف می شوند. لطفاً رمز عبور خود را وارد کنید تا تأیید کنید که می خواهید حساب خود را برای همیشه حذف کنید.') }}
                </p>

                <div class="mt-6">
                    <x-input-label for="password" value="{{ __('کلمه عبور') }}" class="sr-only" />

                    <x-text-input id="password" name="password" type="password" class="mt-1 form-control"
                        placeholder="{{ __('کلمه عبور') }}" />

                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('انصراف') }}
                    </x-secondary-button>

                    <x-danger-button class="ml-3">
                        {{ __('حذف اکانت') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
    </div>
</div>
