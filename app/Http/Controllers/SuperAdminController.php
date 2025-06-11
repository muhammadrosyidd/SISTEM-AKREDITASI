<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class SuperAdminController extends Controller
{
    public function index()
    {
        // Get all users (you can customize the query as needed, for example, adding pagination)
        $users = UserModel::all();

        $roles = RoleModel::all();
        
        // Pass the users to the view
        return view('superadmin.index', compact('users','roles'));
    }

    public function list(Request $request)
{
    if ($request->ajax()) {
        // Ambil data user beserta relasi role
        $users = UserModel::with('role')->select('id_user', 'username', 'nama_user', 'id_role');

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('role_name', function($user) {
                return $user->role ? $user->role->role_nama : '-';
            })
            ->addColumn('aksi', function($user) {
                // Kolom aksi dihandle via render JS DataTables, jadi di sini dikosongi
                return '';
            })
            ->rawColumns(['aksi']) // supaya kolom aksi bisa berisi HTML (walaupun nanti diisi di JS)
            ->make(true);
    }

    // kalau bukan ajax, redirect balik
    return redirect()->route('superadmin.index');
}

    public function create()
{
    // Fetch all available roles for the user
    $roles = RoleModel::all();
    return view('superadmin.create', compact('roles'));
}
public function store(Request $request)
{
    $request->validate([
        'username' => 'required|unique:user|max:255',
        'nama_user' => 'required|max:255',
        'password' => 'required|min:6',
        'role_id' => 'required|exists:role,id_role',
    ]);

    UserModel::create([
        'username' => $request->username,
        'nama_user' => $request->nama_user,
        'password' => bcrypt($request->password),
        'id_role' => $request->role_id,
    ]);

    return redirect()->route('superadmin.index')->with('success', 'User created successfully!');
}

public function edit($id)
    {
        // Find the user by id
        $user = UserModel::findOrFail($id);
        $roles = RoleModel::all();  // Fetch roles to display in the dropdown
        return view('superadmin.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'username' => 'required|string|max:255|unique:user,username,'.$id.',id_user',
        'nama_user' => 'required|string|max:255',
        'password' => 'nullable|string|min:8',
        'id_role' => 'required|exists:role,id_role'
    ]);

    try {
        $user = UserModel::findOrFail($id);
        
        $updateData = $request->only(['username', 'nama_user', 'id_role']);
        
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('superadmin.index')
            ->with('success', 'User updated successfully');
            
    } catch (\Exception $e) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Error updating user: ' . $e->getMessage());
    }
}

public function destroy($id)
{
    try {
        // Cari user berdasarkan ID
        $user = UserModel::findOrFail($id);
        
        // Hapus user
        $user->delete();

        // Redirect balik ke index dengan pesan sukses
        return redirect()->route('superadmin.index')
            ->with('success', 'User deleted successfully!');
    } catch (\Exception $e) {
        // Kalau error, redirect balik dengan pesan error
        return redirect()->back()
            ->with('error', 'Error deleting user: ' . $e->getMessage());
    }
}




}
