<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concert;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ConcertController extends Controller
{
    //
    public function index()
    {
        $concerts = Concert::all();

        if (count($concerts) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $concerts
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
            'date' => 'required',
            'start_time' => 'required',
            'band_id' => 'required',
        ]);

        if ($validate->fails()) //Untuk mengecek apakah inputan sudah sesuai dengan rule validasi
            return response(['message' => $validate->errors()], 400);

        $concert = Concert::create($storeData);
        return response([
            'message' => 'Add concert Success',
            'data' => $concert
        ], 200);
    }

    public function show($id)
    {

        $concert = Concert::find($id);
        if (!is_null($concert)) {
            return response([
                'message' => 'Retrieve Concert Success',
                'data' => $concert
            ], 200);
        }

        return response([
            'message' => 'Concert Not Found',
            'data' => null
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $concert = Concert::find($id);

        if (is_null($concert)) {
            return response([
                'message' => 'concert Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'name' => 'required',
            'date' => 'required',
            'start_time' => 'required',
            'band_id' => 'required',
        ]);

        if ($validate->fails()) //Untuk mengecek apakah inputan sudah sesuai dengan rule validasi
            return response(['message' => $validate->errors()], 400);

        $concert->name = $updateData['name'];
        $concert->date = $updateData['date'];
        $concert->start_time = $updateData['start_time'];
        $concert->band_id = $updateData['band_id'];

        if ($concert->save()) {
            return response([
                'message' => 'Update concert Success',
                'data' => $concert
            ], 200);
        }

        return response([
            'message' => 'Update concert Failed',
            'data' => null
        ], 400);
    }

    public function destroy($id)
    {
        $concert = Concert::find($id);

        if (is_null($concert)) {
            return response([
                'message' => 'Concert Not Found',
                'data' => null
            ], 404);
        }

        if ($concert->delete()) {
            return response([
                'message' => 'Delete Concert Success',
                'data' => $concert
            ], 200);
        }

        return response([
            'message' => 'Delete Concert Failed',
            'data' => null
        ], 400);
    }
}
