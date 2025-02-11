<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\AuthorizationsTrait;
use App\Models\Permission;
use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Auth;
use Illuminate\Support\Facades\Gate;
use Request;

class RoleController extends Controller
{
    use AuthorizationsTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('manageRoles', Role::class);
        
        $data['active'] = 'roles';
        $data['title'] = 'نقش ها';
        $data['roles'] = Role::paginate(10);
        $data['manuAuthorizations'] = $this->getMenuAuthorizations(Auth::user());

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
        Gate::authorize('create', Role::class);

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
        $data['permissions'] = Permission::orderBy("ability", "asc")->get();
        $data['role_permissions'] = $role->permissions()->pluck('permissions.id')->toArray();
        $data['manuAuthorizations'] = $this->getMenuAuthorizations(Auth::user());

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
        $data['manuAuthorizations'] = $this->getMenuAuthorizations(Auth::user());

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
        Gate::authorize('update', $role);

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
        Gate::authorize('delete', $role);

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
