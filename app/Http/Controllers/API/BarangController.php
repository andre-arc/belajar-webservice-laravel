<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index(){
        $barangs = Barang::all();

        if($barangs->count() < 1){
            return response(
                [
                    "status" => "error",
                    "message" => "Data Barang Kosong"
                ], 400);
        }

        return response()->json($barangs, 200);
    }

    public function store(Request $request){
        $validator = $this->__validate($request);

        if($validator->fails()){
            return response()->json([
                "status" => "error",
                "message" => "Error Validation",
                "validation" => $validator->errors()
            ], 400);
        }

        Barang::create([
            "nama" => $request->nama
        ]);

        return response()->json([
            "status" => "success",
            "message" => "Data Berhasil di tambah"
        ], 200);
    }

    public function update(Request $request, Barang $barang){
        $validator = $this->__validate($request);

        if($validator->fails()){
            return response()->json([
                "status" => "error",
                "message" => "Error Validation",
                "validation" => $validator->errors()
            ], 400);
        }

        $barang->update([
            "nama" => $request->nama
        ]);

        return response()->json([
            "status" => "success",
            "message" => "Data Berhasil di edit"
        ], 200);
    }

    public function destroy(Barang $barang){
        $barang->delete();

        return response()->json([
            "status" => "success",
            "message" => "Data Berhasil di hapus"
        ], 200);
    }

    private function __validate($request){
        $data = $request->all();
        $rules = [
            'nama' => 'required|string|max:255',
        ];

        return Validator::make($data, $rules);
    }
}
