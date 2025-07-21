<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['permission:browse_role']);
        // $this->middleware('permission:create_role', ['only' => ['create', 'store']]);
        // $this->middleware('permission:update_role', ['only' => ['update', 'edit']]);
        // $this->middleware('permission:delete_role', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (!Auth::check()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $selectCol = 'roles.'.Role::ID.','.'roles.'.Role::NAME.','.'roles.'.Role::GUARD_NAME;

            $role = Role::selectRaw($selectCol)
            ->orderBy(Role::ID);

            $canView = Gate::allows(Role::VIEW_ROLE);
            $canUpdate = Gate::allows(Role::UPDATE_ROLE);
            $canDelete = Gate::allows(Role::DELETE_ROLE);

            return Datatables::of($role)
                ->editColumn('action', function ($role) use ($canView, $canUpdate, $canDelete) {
                    $action = '';
                    // if ($canUpdate) {
                        $action .= '<a href="'.route('admin.roles.edit', $role->id).'"> <i class="fa fa-edit"> </i></a>';
                    // }
                    // if ($canDelete) {
                        $action .= "<a href='#' class='delete' title='Delete' data-id='$role->id'> <i class='fa fa-trash'></i> </a>";
                    // }

                    return $action;
                })

                ->addIndexColumn()
                ->make(true);
            }
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->middleware(['permission:create_role']);
        $permissions = Permission::all();

        return view('admin.roles.add-edit', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        // $this->middleware(['permission:create_role']);
        
        $role = new Role();
        DB::transaction(function () use ($request, &$role) {
            $role = $role->create($request->validated());

            if ($request->has('permissions')) {
                $role->permissions()->sync($request->permissions);
            }
        });
        /* $role = Role::firstOrCreate(['name' => $request->name]); */

        if ($role) {
            return redirect()->route('admin.roles.index')->with('success',"Role \"$role->name\" added successfully");
        }
        else {
            return redirect()->back()->withErrors(__('message.somethingwrong'))->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        // $this->middleware(['permission:update_role']);
        $permissions = Permission::all();

        return view('admin.roles.add-edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        // $this->middleware(['permission:update_role']);

        DB::transaction(function () use ($request, $role) {
            $role->update($request->all());
            if ($request->has('permissions')) {
                $role->permissions()->sync($request->permissions);
            }
            else {
                $role->permissions()->sync([]);
            }
        });

        if ($role) {
            return redirect()->route('admin.roles.index')->with('success',"Role \"$role->name\" updated successfully");;
        }
        else {
            return redirect()->back()->withErrors(__('message.somethingwrong'))->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        // $this->middleware(['permission:delete_role']);
        $isDeleted = $role->delete();

        if ($isDeleted) {
            return redirect()->route('admin.roles.index')->with('success',"Role \"$role->name\" deleted successfully");;
        }
        else {
            return redirect()->back()->withErrors(__('message.somethingwrong'))->withInput();
        }
    }
}
