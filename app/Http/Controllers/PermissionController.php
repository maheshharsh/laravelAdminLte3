<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $selectCol = 'permissions.' . Permission::ID . ',' . 'permissions.' . Permission::NAME . ' as code_name';
        $permission = Permission::selectRaw($selectCol)->orderBy(Permission::ID);
        
        $canView = Gate::allows(Permission::VIEW_PERMISSION);
        $canUpdate = Gate::allows(Permission::UPDATE_PERMISSION);
        $canDelete = Gate::allows(Permission::DELETE_PERMISSION);

        if ($request->ajax()) {

            return Datatables::of($permission)
                ->filterColumn('name', function ($query, $keyword) {
                    $sql = "permissions.name like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('code_name', function ($query, $keyword) {
                    $sql = "permissions.name like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->addColumn('name', function (Permission $permission) {
                    return ucwords(str_replace('_', ' ', $permission->code_name)) ?? config('constants.empty_value');
                })
                ->editColumn('action', function ($permission) use ($canView, $canUpdate, $canDelete) {
                    $action = '';
                    // if ($canUpdate) {
                        $action .= '<a href="' . route('admin.permissions.edit', $permission->id) . '"> <i class="fa fa-edit"></i> </a>';
                    // }
                    // if ($canDelete) {
                        $action .= "<a href='#' class='delete' title='Delete' data-id='$permission->id'> <i class='fa fa-trash'></i> </a>";
                    // }

                    return $action;
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permissions.add-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        $permission = Permission::create($request->validated());

        if ($permission) {
            return redirect()->route('admin.permissions.index')
                ->with('success', "Permissions \"$permission->name\" added successfully");
        }

        return redirect()->back()
            ->withErrors(__('somethingwrong'))
            ->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.add-edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
        $permissionUpdate = $permission->update($request->validated());

        if ($permissionUpdate) {
            return redirect()->route('admin.permissions.index')->with('success', "Permissions \"$permission->name\" updated successfully");;
        } else {
            return redirect()->back()->withErrors(__('somethingwrong'))->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $isDeleted = $permission->delete();
        if ($isDeleted) {
            return redirect()->route('admin.permissions.index')->with('success', "Permissions \"$permission->name\" deleted successfully");
        } else {
            return redirect()->back()->withErrors(__('somethingwrong'))->withInput();
        }
    }

    public function getRolePermission(Request $request)
    {
        $role = Role::find($request->roleId);
        if ($role->name == Role::SUPER_ADMIN) {
            return response()->json($role->name);
        }
        $permissions = Permission::whereNotIn('id', $role->permissions->pluck(Permission::ID))->get();

        return response()->json($permissions);
    }
}
