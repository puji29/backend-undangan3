<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Resepsi;
use Dotenv\Validator;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function index()
    {

        $reservasi = Resepsi::latest()->paginate(10);

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

    public function show( $id) {
        $reservasi = Resepsi::find($id);

        return new PostResource(true, 'Id found', $reservasi);
    }

    public function update(Request $request,$id)  {

        $validator = Validator($request->all(),[
            'name' => 'required',
            'jumlah' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        
        $reservasi = Resepsi::find($id);

        $reservasi->update([
            'name' => $request->name,
            'jumlah' => $request->jumlah,
            'status' => $request->status,
        ]);

        return new PostResource(true, 'Data update succesfully',$reservasi);
    }

    public function destroy($id) {

        $reservasi = Resepsi::find($id);

        $reservasi->delete();

        return new PostResource(true, "Data succesfully delete", null);
    }
}
