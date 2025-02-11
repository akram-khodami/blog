<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\AuthorizationsTrait;
use App\Models\Permission;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Auth;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    use AuthorizationsTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('managePermissions', Permission::class);

        $data['active'] = 'permissions';
        $data['title'] = 'اجازه ها';
        $data['permissions'] = Permission::orderBy("ability", "asc")->paginate(10);
        $data['manuAuthorizations'] = $this->getMenuAuthorizations(Auth::user());

        return view('admin.permission.all', $data);
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
     * @param  \App\Http\Requests\StorePermissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        Gate::authorize('create', Permission::class);

        $permission = new Permission;

        $permission->name = $request->name;
        $permission->ability = $request->ability;
        $permission->description = $request->description;

        $permission->save();

        return redirect()->back()->with('success_message', 'اجازه با موفقیت ثبت شد.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        $data['permission'] = $permission;
        $data['active'] = 'permissions';
        $data['title'] = 'ویرایش اجازه ' . $permission->name;
        $data['permissions'] = Permission::paginate(10);
        $data['manuAuthorizations'] = $this->getMenuAuthorizations(Auth::user());

        return view('admin.permission.all', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePermissionRequest  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        Gate::authorize('update', $permission);

        $permission->name = $request->name;
        $permission->ability = $request->ability;
        $permission->description = $request->description;
        $permission->save();

        return redirect('permissions')->with('success_message', 'اجازه با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        Gate::authorize('delete', $permission);

        $permission->roles()->detach();

        $permission->delete();

    }
}
