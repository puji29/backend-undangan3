<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Ucapan;
use Illuminate\Http\Request;

class UcapanController extends Controller
{
    public function index()
    {
        $ucapan = Ucapan::latest()->paginate(5);

        return new PostResource(true, "Data Ucapan found", $ucapan);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'ucapan' => 'required|string|max:255',
        ]);

        try {
            $ucapan = Ucapan::create([
                'name' => $request->name,
                'ucapan' => $request->ucapan,
            ]);

            return new PostResource(true, "Ucapan insert succesfully", $ucapan);
        } catch (\Exception $e) {
            // \Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed insert data',
                'error' => $e->getMessage(),
                
            ], 500);
        }
    }
}
