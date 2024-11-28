<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['active'] = 'roles';
        $data['title'] = 'نقش ها';
        $data['roles'] = Role::paginate(10);

        return view('admin.role.all', $data);
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
     * @param  \App\Http\Requests\StoreRoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        $role = new Role;
        $role->name = $request->name;
        $role->save();

        return redirect()->back()->with('success_message', 'نقش با موفقیت ثبت شد.');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $data['title'] = 'مشاهده نقش ' . $role->name;
        $data['active'] = 'roles';
        $data['role'] = $role;
        $data['permissions'] = Permission::all();
        $data['role_permissions'] = $role->permissions()->pluck('permissions.id')->toArray();


        // dd($data['role_permissions']);

        return view('admin.role.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $data['role'] = $role;
        $data['active'] = 'roles';
        $data['title'] = 'ویرایش نقش ' . $role->name;
        $data['roles'] = Role::paginate(10);

        return view('admin.role.all', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoleRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->name = $request->name;
        $role->save();

        return redirect('roles')->with('success_message', 'نقش با موفقیت ویرایش شد');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->users()->detach();

        $role->delete();

    }


    function addPermission()
    {
        $is_checked = Request('is_checked');

        $role_id = Request('role');

        $permission_id = Request('permission');

        $role = Role::findOrfail($role_id);

        if ($is_checked == 'true') {

            $role->permissions()->attach($permission_id);

        } else {

            $role->permissions()->detach([$permission_id]);

        }

    }
}
