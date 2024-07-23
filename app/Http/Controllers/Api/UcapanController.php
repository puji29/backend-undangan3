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

    public function show( $id) {
        $ucapan = Ucapan::find($id);

        return new PostResource(true, 'Id found', $ucapan);
    }

    public function update(Request $request,$id)  {

        $validator = Validator($request->all(),[
            'name' => 'required',
            'ucapan' => 'required',
            
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        
        $ucapan = Ucapan::find($id);

        $ucapan->update([
            'name' => $request->name,
            'ucapan' => $request->ucapan,
            
        ]);

        return new PostResource(true, 'Data update succesfully',$ucapan);
    }

    public function destroy($id) {

        $ucapan = Ucapan::find($id);

        $ucapan->delete();

        return new PostResource(true, "Data succesfully delete", null);
    }
}
