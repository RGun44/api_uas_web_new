<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Band;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class BandController extends Controller
{
    //
    public function index()
    {
        $bands = Band::all();

        if (count($bands) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $bands
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'name' => 'required',
            'genre' => 'required',
        ]);

        if ($validate->fails()) //Untuk mengecek apakah inputan sudah sesuai dengan rule validasi
            return response(['message' => $validate->errors()], 400);

        $band = Band::create($storeData);
        return response([
            'message' => 'Add band Success',
            'data' => $band
        ], 200);
    }

    public function show($id)
    {

        $band = Band::find($id);
        if (!is_null($band)) {
            return response([
                'message' => 'Retrieve Band Success',
                'data' => $band
            ], 200);
        }

        return response([
            'message' => 'Band Not Found',
            'data' => null
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $band = Band::find($id);

        if (is_null($band)) {
            return response([
                'message' => 'band Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'name' => 'required',
            'genre' => 'required',
        ]);

        if ($validate->fails()) //Untuk mengecek apakah inputan sudah sesuai dengan rule validasi
            return response(['message' => $validate->errors()], 400);

        $band->name = $updateData['name'];
        $band->genre = $updateData['genre'];

        if ($band->save()) {
            return response([
                'message' => 'Update band Success',
                'data' => $band
            ], 200);
        }

        return response([
            'message' => 'Update band Failed',
            'data' => null
        ], 400);
    }

    public function destroy($id)
    {
        $band = Band::find($id);

        if (is_null($band)) {
            return response([
                'message' => 'Band Not Found',
                'data' => null
            ], 404);
        }

        if ($band->delete()) {
            return response([
                'message' => 'Delete Band Success',
                'data' => $band
            ], 200);
        }

        return response([
            'message' => 'Delete Band Failed',
            'data' => null
        ], 400);
    }
}
