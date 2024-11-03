<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dotenv\Store\File\Paths;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function __construct()
    {
        $this->middleware(['permission:users_read'])->only(methods: 'index');
        $this->middleware(['permission:users_create'])->only(methods: 'create');
        $this->middleware(['permission:users_update'])->only(methods: 'edit');
        $this->middleware(['permission:users_delete'])->only(methods: 'destroy');
    }




    public function index(Request $request)
    {




        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->where(function ($q) use ($request) {
            $q->where('first_name', 'like', '%' . $request->search . '%')
                ->orWhere('last_name', 'like', '%' . $request->search . '%');
        })->latest()->paginate(10);


        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'image' => 'image',
            'password' => 'required|confirmed',
            'permissions' => 'required|min:1',

        ]);


        $request_data = $request->except(['password', 'password_confirmation', 'permissions', 'image']);
        $request_data['password'] = bcrypt($request->password);


        if ($request->image) {
            Image::make($request->image)->resize(300, null, function ($constraint) {

                $constraint->aspectRatio();
            })->save(public_path('uploads/users_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();
        } //end of if

        $user = user::create($request_data);

        $user->addRole('admin');

        $permissions = $request->permissions ?? [];
        $user->syncPermissions($permissions);

        session()->flash('success', __(key: 'site.added_successfully'));

        return redirect()->route('dashboard.user.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', Rule::unique('users')->ignore($user->id),],
            'image' => 'image',
            'permissions' => 'required|min:1',
        ]);

        $request_data = $request->except(['permissions', 'image']);

        if ( $request->image) {

            if ($user->image != 'default.jpg') {
                Storage::disk('public_uploads')->delete('users_images/' . $user->image);

            }
            // dd($request->image);
                Image::make($request->image)->resize(300, null, function ($constraint) {

                    $constraint->aspectRatio();
                })->save(public_path('uploads/users_images/' . $request->image->hashName()));

                $request_data['image'] = $request->image->hashName();

        } //end of if

        $user->update($request_data);

        $permissions = $request->permissions ?? [];
        $user->syncPermissions($permissions);

        session()->flash('success', __(key: 'site.updated_successfully'));

        return redirect()->route('dashboard.user.index');
    }


    /**
     * Remove the specified resource from storage.
     */


    public function destroy(User $user)
    {
        if ($user->image != 'default.jpg') {

            Storage::disk('public_uploads')->delete('users_images/' . $user->image);
        }

        $user->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.user.index');
    }
}
