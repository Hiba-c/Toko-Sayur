<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ImageHelper;

class UserController extends Controller
{
    /**
     * Display all users
     */
    public function index()
    {
        $index = User::orderByRaw("
            CASE 
                WHEN role = 1 THEN 1   -- Superadmin
                WHEN role = 0 THEN 2   -- Admin
                WHEN role = 2 THEN 3   -- Member
            END
        ")->orderBy('nama', 'asc')->get();

        $judul = "Data Semua User";

        return view('backend.v_user.index', compact('index', 'judul'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.v_user.create', [
            'judul' => 'Tambah User',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'email' => 'required|max:255|email|unique:user',
            'hp' => 'required|min:10|max:13',
            'password' => 'required|min:4|confirmed',
            'foto' => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',
            'role' => 'required|in:0,1,2', // menerima semua role
        ], [
            'foto.image' => 'Format gambar harus jpeg, jpg, png, atau gif.',
            'foto.max' => 'Ukuran maksimal gambar adalah 1024 KB.'
        ]);

        // Set role & status
        $validatedData['role'] = $request->role;
        $validatedData['status'] = 1;

        // Upload foto jika ada
        if ($request->file('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $filename = date('YmdHis') . '_' . uniqid() . '.' . $extension;

            ImageHelper::uploadAndResize($file, 'storage/img-user/', $filename, 385, 400);

            $validatedData['foto'] = $filename;
        }

        // Validasi password kombinasi
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/';

        if (!preg_match($pattern, $request->password)) {
            return back()->withErrors([
                'password' => 'Password harus ada huruf besar, kecil, angka, dan simbol.'
            ]);
        }

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return redirect()->route('backend.user.index')
            ->with('success', 'Data berhasil tersimpan');
    }

    /**
     * Edit form
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('backend.v_user.edit', [
            'judul' => 'Ubah User',
            'edit' => $user
        ]);
    }

    /**
     * Update user
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'nama' => 'required|max:255',
            'status' => 'required',
            'hp' => 'required|min:10|max:13',
            'foto' => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',
            'password' => 'nullable|min:4|confirmed',
            'role' => 'required|in:0,1,2', // role bisa diubah
        ];

        if ($request->email != $user->email) {
            $rules['email'] = 'required|max:255|email|unique:user';
        }

        $validatedData = $request->validate($rules);

        // Set role sesuai input
        $validatedData['role'] = $request->role;

        // Upload foto baru jika ada
        if ($request->file('foto')) {

            if ($user->foto) {
                $oldImage = public_path('storage/img-user/' . $user->foto);
                if (file_exists($oldImage)) unlink($oldImage);
            }

            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $filename = date('YmdHis') . '_' . uniqid() . '.' . $extension;

            ImageHelper::uploadAndResize($file, 'storage/img-user/', $filename, 385, 400);

            $validatedData['foto'] = $filename;
        }

        // Update password jika diisi
        if ($request->filled('password')) {

            $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/';

            if (!preg_match($pattern, $request->password)) {
                return back()->withErrors([
                    'password' => 'Password harus ada huruf besar, kecil, angka, dan simbol.'
                ]);
            }

            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return redirect()->route('backend.user.index')->with('success', 'Data berhasil diperbaharui');
    }

    /**
     * Remove user
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->foto) {
            $oldImagePath = public_path('storage/img-user/') . $user->foto;
            if (file_exists($oldImagePath)) unlink($oldImagePath);
        }

        $user->delete();

        return redirect()->route('backend.user.index')->with('success', 'Data berhasil dihapus');
    }
}
