<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Country;
use App\Models\Permission;
use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['permission:browse_user']);
        // $this->middleware('permission:create_user', ['only' => ['create', 'store']]);
        // $this->middleware('permission:update_user', ['only' => ['update', 'edit']]);
        // $this->middleware('permission:delete_user', ['only' => ['destroy']]);
        // $this->middleware('permission:view_user',   ['only' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy(User::ID, 'DESC')->with('roles')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::select(Role::ID, Role::NAME)->orderBy(Role::ID)->get();
        $permissions = Permission::select(Permission::ID, Permission::NAME)->orderBy(Permission::ID)->get();
        return view('admin.users.add-edit', compact('roles','permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            // Upload profile image if present
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filePath = CommonHelper::uploadFile($image, config('constants.upload_path.users_img'));
                $request->merge(['profile_image' => $filePath]);
            }
            
            // Hash the password before saving
            $request->merge(['password' => Hash::make($request->password)]);
            
            // Create the user
            $user = User::create($request->all());
            
            // Assign role   
            if ($request->filled('role')) {
                $user->assignRole($request->role);
            }
            
            // Assign permissions if any
            if ($request->filled('permission')) {
                $user->givePermissionTo($request->permission);
            }
            return redirect()
                ->route('admin.users.index')
                ->with('success', __("User \"{$user->name}\" added successfully."));
    
        } catch (\Exception $e) {
            // Optionally log the error
            \Log::error('User creation failed: ' . $e->getMessage());
    
            return redirect()
                ->back()
                ->with('error', __("message.somethingwrong"))
                ->withInput();
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::select(Role::ID, Role::NAME)->orderBy(Role::ID)->get();

        $loggedin_user_role = Auth::User()->roles->first()->id ;
        $user_edit = Role::where(Role::NAME, $user->role)->first()->id ;

        if($loggedin_user_role == Role::ADMIN){
            $roles = Role::select(Role::ID, Role::NAME)->orderBy(Role::ID)->whereNot(Role::ID,Role::SUPER_ADMIN)->get();
        };
        if($loggedin_user_role == Role::ADMIN && $user_edit == Role::SUPER_ADMIN){
            $roles = Role::select(Role::ID, Role::NAME)->orderBy(Role::ID)->where(Role::ID,Role::SUPER_ADMIN)->get();
        }

        return view('admin.users.add-edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request,User $user)
    {
        /* Upload user image to storage. */
        if ($request->file('image')) {
            $image = $request->file('image');
            $filePath = CommonHelper::uploadFile($image, config('constants.upload_path.users_img'));
            if ($user->profile_image){
                Storage::delete($user->profile_image);
            }
            $request->merge(['profile_image' => $filePath]);
        }
        if ($request->password && $request->password_confirmation) {
            $request->merge(['password' => Hash::make($request->password)]);
            $updateData = $request->all();
        }
        else{
            $updateData = $request->except('password');
        }

        $user->roles()->detach();
        $user->assignRole($request->role);
        if ($request->permission) {
            $user->syncPermissions([$request->permission]);
        }
        else{
            $permissions = $user->getAllPermissions();
            $user->revokePermissionTo($permissions);
        }
        $userupdate = $user->update($updateData);
        if ($userupdate) {
            return redirect()->route('admin.users.index')->with('success', __("User \"$user->name\" updated successfully"));
        } else {
            return redirect()->back()->with('error', __("message.somethingwrong"))->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            Storage::delete($user->profile_image);
            return redirect()->back()->with('success', __("User \"$user->name\" deleted successfully"));
        } else {
            return redirect()->back()->with('error',__("message.somethingwrong"))->withInput();
        }
    }
}
