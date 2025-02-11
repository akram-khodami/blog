<form action="{{ url('users') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="name">نام</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="نام را وارد کنید">
    </div>
    <div class="form-group">
        <label for="email">ایمیل</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="ایمیل را وارد نمایید">
    </div>
    <div class="form-group">
        <label for="password">کلمه عبور</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="کلمه عبور">
    </div>
    <div class="form-group">
        <label for="password_confirmation">تکرار کلمه عبور</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
            placeholder="تکرار کلمه عبور">
    </div>
    <input type="submit" class="btn btn-outline-success" value="ذخیره">
</form>
