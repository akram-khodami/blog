<form action="{{ url('users/' . $user->id) }}" method="post">
    @csrf
    @method('put')
    <input type="hidden" name="id" value="{{ $user->id }}">
    <div class="form-group">
        <label for="name">نام</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="نام را وارد کنید"
            value="{{ $user->name }}" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="email">ایمیل</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="ایمیل را وارد نمایید"
            value="{{ $user->email }}" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="password">کلمه عبور</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="کلمه عبور"
            autocomplete="off">
    </div>
    <div class="form-group">
        <label for="password_confirmation">تکرار کلمه عبور</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
            placeholder="تکرار کلمه عبور" autocomplete="off">
    </div>
    <input type="submit" class="btn btn-outline-success btn-sm" value="ذخیره">
</form>
