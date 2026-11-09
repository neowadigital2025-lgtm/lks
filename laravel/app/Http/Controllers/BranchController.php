<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Branch successfully retrieved',
            'data' => $branches
        ], 200);
    }

    public function store(Request $request)
    {
        // 1. Cek Otorisasi Role Admin (Skenario 403 Forbidden)
        // Ganti 'admin' sesuai dengan struktur kolom role di tabel users Anda (misal: $request->user()->role)
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'status' => 'forbidden',
                'message' => 'Access forbidden'
            ], 403);
        }

        // 2. Validasi Input (Skenario 422)
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:branches,name',
        ], [
            'name.required' => 'The name field is required.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid field(s) in request',
                'errors' => $validator->errors()
            ], 422);
        }

        // 3. Simpan Data ke Database
        $slug = Str::slug($request->name);

        $branch = Branch::create([
            'name' => $request->name,
            'slug' => $slug
        ]);

        // 4. Respons Sukses (201 Created)
        return response()->json([
            'status' => 'success',
            'message' => 'Branch successfully added',
            'data' => [
                'name' => $branch->name,
                'slug' => $branch->slug,
                'created_at' => $branch->created_at->toISOString(),
                'updated_at' => $branch->updated_at->toISOString(),
                'id' => $branch->id
            ]
        ], 201);
    }
    public function update(Request $request, $branch_slug){
    // 1. Cek Otorisasi Role Admin (Skenario 403 Forbidden)
    if ($request->user()->role !== 'admin') {
        return response()->json([
            'status' => 'forbidden',
            'message' => 'Access forbidden'
        ], 403);
    }

    // 2. Cari data branch berdasarkan slug (Skenario 404 Not Found)
    $branch = Branch::where('slug', $branch_slug)->first();

    if (!$branch) {
        return response()->json([
            'status' => 'not_found',
            'message' => 'Resource not found.'
        ], 404);
    }

    // 3. Validasi Input Nama (Skenario 422)
    // Abaikan validasi unik untuk nama branch ini sendiri jika namanya tidak diubah
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255|unique:branches,name,' . $branch->id,
    ], [
        'name.required' => 'The name field is required.',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid field(s) in request',
            'errors' => $validator->errors()
        ], 422);
    }

    // 4. Proses Update Data
    $branch->update([
        'name' => $request->name,
        'slug' => Str::slug($request->name) // Memperbarui slug otomatis sesuai nama baru
    ]);

    // 5. Respons Sukses (200 OK)
    return response()->json([
        'status' => 'success ', // Spasi di akhir kata "success " disesuaikan dengan spesifikasi Anda
        'message' => 'Branch successfully updated.',
    ], 200);
}
}
