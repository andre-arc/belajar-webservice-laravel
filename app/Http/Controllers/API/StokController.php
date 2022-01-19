<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Stok as ResourcesStok;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StokController extends Controller
{
    public function index()
    {
        $stok = Stok::all();
        return ResourcesStok::collection($stok);
    }

    public function store(Request $request)
    {
        $validator = $this->__validate($request);
        $stok = new Stok;
        $stok->status = $request->input('status');
        $stok->jumlah = $request->input('jumlah');
        $stok->id_barang = $request->input('id_barang');
        if ($stok->save()) {
            return new ResourcesStok($stok);
        }
    }

    public function update(Request $request,Stok $stok)
    {
        $stok->status = $request->input('status');
        $stok->jumlah = $request->input('jumlah');
        $stok->statid_barangus = $request->input('id_barang');
        if ($stok->save()) {
            return new ResourcesStok($stok);
        }
    }

    public function destroy(Stok $stok)
    {
        if ($stok->delete()) {
                return new ResourcesStok($stok);
        }
    }
    private function __validate($request)
    {
        $data = $request->all();
        $rules = [
            'status' => 'required|in:masuk,keluar',
            'jumlah' => 'required|string|max:255',
            'id_barang' => 'required|string|max:255',
        ];

        return Validator::make($data, $rules);
    }
}
