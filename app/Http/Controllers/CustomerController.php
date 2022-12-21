<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    //
    public function index()
    {
        $Customers = Customer::all();

        if (count($Customers) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $Customers
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
            "username" => "required",
            "password" => "required",
            "name" => "required",
            "email" => "required|email"
        ]);

        if ($validate->fails()) //Untuk mengecek apakah inputan sudah sesuai dengan rule validasi
            return response(['message' => $validate->errors()], 400);

        $Customer = Customer::create($storeData);
        return response([
            'message' => 'Add Customer Success',
            'data' => $Customer
        ], 200);
    }

    public function show($id)
    {

        $Customer = Customer::find($id);
        if (!is_null($Customer)) {
            return response([
                'message' => 'Retrieve Customer Success',
                'data' => $Customer
            ], 200);
        }

        return response([
            'message' => 'Customer Not Found',
            'data' => null
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $Customer = Customer::find($id);

        if (is_null($Customer)) {
            return response([
                'message' => 'Customer Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            "username" => "required",
            "password" => "required",
            "name" => "required",
            "email" => "required|email"
        ]);

        if ($validate->fails()) //Untuk mengecek apakah inputan sudah sesuai dengan rule validasi
            return response(['message' => $validate->errors()], 400);

        $Customer->name = $updateData['name'];
        $Customer->username = $updateData['username'];
        $Customer->password = $updateData['password'];
        $Customer->email = $updateData['email'];

        if ($Customer->save()) {
            return response([
                'message' => 'Update Customer Success',
                'data' => $Customer
            ], 200);
        }

        return response([
            'message' => 'Update Customer Failed',
            'data' => null
        ], 400);
    }

    public function destroy($id)
    {
        $Customer = Customer::find($id);

        if (is_null($Customer)) {
            return response([
                'message' => 'Customer Not Found',
                'data' => null
            ], 404);
        }

        if ($Customer->delete()) {
            return response([
                'message' => 'Delete Customer Success',
                'data' => $Customer
            ], 200);
        }

        return response([
            'message' => 'Delete Customer Failed',
            'data' => null
        ], 400);
    }
}
