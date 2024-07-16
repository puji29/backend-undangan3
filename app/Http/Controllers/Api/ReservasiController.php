<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Resepsi;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function index()
    {

        $reservasi = Resepsi::latest()->paginate(5);

        return new PostResource(true, 'Data reservasi found', $reservasi);
    }

    public function store(Request $request)
    {

        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'status' => 'required|string|max:255',
        ]);

        try {
            // Buat data reservasi
            $reservasi = Resepsi::create([
                'name' => $request->name,
                'jumlah' => $request->jumlah,
                'status' => $request->status
            ]);
    
            // Kembalikan respon sukses
            return new PostResource(true, 'Data successfully inserted', $reservasi);
        } catch (\Exception $e) {
            // Tangani kesalahan
            return response()->json([
                'success' => false,
                'message' => 'Failed to insert data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
