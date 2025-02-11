<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Traits\AuthorizationsTrait;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    use AuthorizationsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('manageUsers', User::class);

        $data['active'] = 'users';
        $data['title'] = 'کاربران';
        $data['users'] = User::with('roles')->paginate(10);
        $data['roles'] = Role::all();
        $data['manuAuthorizations'] = $this->getMenuAuthorizations(Auth::user());

        return view('admin.user.all', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('create', User::class);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],//???
            'password' => ['required', 'confirmed', Rules\password::defaults()],//???
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success_message', 'کاربر با موفقیت ثبت شد.');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        Gate::authorize('update', $user);

        $data['active'] = 'users';
        $data['title'] = 'کاربران';
        $data['users'] = User::with('roles')->paginate(10);
        $data['roles'] = Role::all();
        $data['manuAuthorizations'] = $this->getMenuAuthorizations(Auth::user());

        return view('admin.user.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        Gate::authorize('update', $user);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],//???
            'password' => ['required', 'confirmed', Rules\password::defaults()],//???
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {

            $user->password = Hash::make($request->password);

        }

        $user->save();

        return redirect()->back()->with('success_message', 'کاربر با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);

        DB::transaction(function () use ($user) {

            DB::table('post_tag')->join('posts', 'posts.id', '=', 'post_tag.post_id')->where('user_id', '=', $user->id)->delete();

            DB::table('category_post')->join('posts', 'posts.id', '=', 'category_post.post_id')->where('user_id', '=', $user->id)->delete();

            DB::table('posts')->where('user_id', '=', $user->id)->delete();

            DB::table('role_user')->where('user_id', '=', $user->id)->delete();

            $user->delete();

        }, 5);

    }


    function activeUser(Request $request)
    {
        Gate::authorize('manageUsers', User::class);

        $user_id = $request->id;

        $user = User::find($user_id);

        if ($user->active != 1) {

            $user->active = 1;

            $user->save();

        }


    }

    function inActiveUser(Request $request)
    {
        Gate::authorize('manageUsers', User::class);

        $user_id = $request->id;

        $user = User::find($user_id);

        if ($user->active != 0) {

            $user->active = 0;

            $user->save();

        }

    }

    function addUserRole(Request $request)
    {

        Gate::authorize('addUserRole', User::class);

        $user_id = $request->user_id;
        $roles = $request->roles;

        $user = User::find($user_id);//type=model

        $user->roles()->sync($roles, ['status' => 1]);

        return redirect()->back()->with('success_message', 'نقش ها با موفقیت به کاربر اعطا شدند.');

    }


    function deleteUserRole()
    {
        Gate::authorize('deleteUserRole', User::class);

        $role_id_array = request('role');
        $user_id = request('user');

        $user = User::findOrfail($user_id);

        $user->roles()->detach($role_id_array);

    }
}
