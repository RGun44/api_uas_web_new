<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    //
    public function index()
    {
        $tickets = Ticket::all();

        if (count($tickets) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $tickets
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
            'concert_id' => 'required',
            'customer_id' => 'required',
            'class' => 'required',
            'price' => 'required',
            'book_date' => 'required',
        ]);

        if ($validate->fails()) //Untuk mengecek apakah inputan sudah sesuai dengan rule validasi
            return response(['message' => $validate->errors()], 400);

        $ticket = Ticket::create($storeData);
        return response([
            'message' => 'Add ticket Success',
            'data' => $ticket
        ], 200);
    }

    public function show($id)
    {

        $ticket = Ticket::find($id);
        if (!is_null($ticket)) {
            return response([
                'message' => 'Retrieve Ticket Success',
                'data' => $ticket
            ], 200);
        }

        return response([
            'message' => 'Ticket Not Found',
            'data' => null
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::find($id);

        if (is_null($ticket)) {
            return response([
                'message' => 'ticket Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'concert_id' => 'required',
            'customer_id' => 'required',
            'class' => 'required',
            'price' => 'required',
            'book_date' => 'required',
        ]);

        if ($validate->fails()) //Untuk mengecek apakah inputan sudah sesuai dengan rule validasi
            return response(['message' => $validate->errors()], 400);

        $ticket->concert_id = $updateData['concert_id'];
        $ticket->customer_id = $updateData['customer_id'];
        $ticket->class = $updateData['class'];
        $ticket->price = $updateData['price'];
        $ticket->book_date = $updateData['book_date'];

        if ($ticket->save()) {
            return response([
                'message' => 'Update ticket Success',
                'data' => $ticket
            ], 200);
        }

        return response([
            'message' => 'Update ticket Failed',
            'data' => null
        ], 400);
    }

    public function destroy($id)
    {
        $ticket = Ticket::find($id);

        if (is_null($ticket)) {
            return response([
                'message' => 'Ticket Not Found',
                'data' => null
            ], 404);
        }

        if ($ticket->delete()) {
            return response([
                'message' => 'Delete Ticket Success',
                'data' => $ticket
            ], 200);
        }

        return response([
            'message' => 'Delete Ticket Failed',
            'data' => null
        ], 400);
    }
}
