<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PembeliResource;
use App\Models\Pembeli;
use App\Models\Products;
use Illuminate\Http\Request;

class PembeliController extends Controller
{

    // TODO GET ALL
    public function index()
    {
        $pembelis = Pembeli::all();
        return response()->json($pembelis);
    }

    // TODO : POST
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:pembelis',
            'password' => 'required|min:6',
        ]);

        $pembeli = Pembeli::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return new PembeliResource($pembeli);
    }

    // TODO : GET BY ID
    public function show($id)
    {
        $pembeli = Pembeli::with('products')->find($id);
        if (!$pembeli) {
            return response()->json(['message' => 'Pembeli tidak ditemukan'], 404);
        }
        return new PembeliResource($pembeli);
    }

    // Todo : PUT
    public function update(Request $request, $id)
    {
        $pembeli = Pembeli::find($id);

        if (!$pembeli) {
            return response()->json(['message' => 'Pembeli tidak ditemukan'], 404);
        }

        $request->validate([
            'nama' => 'sometimes|required',
            'email' => 'sometimes|required|email|unique:pembelis,email,' . $id,
            'password' => 'sometimes|required|min:6',
        ]);

        if ($request->has('password')) {
            $request->merge(['password' => bcrypt($request->password)]);
        }

        $pembeli->update($request->all());

        return response()->json(['message' => 'Pembeli berhasil diperbarui', 'data' => $pembeli], 200);
    }

    // TODO : DELETE
    public function destroy($id)
    {
        $pembeli = Pembeli::find($id);

        if (!$pembeli) {
            return response()->json(['message' => 'Pembeli tidak ditemukan'], 404);
        }

        $pembeli->delete();

        return response()->json(['message' => 'Pembeli berhasil dihapus'], 200);
    }
}
