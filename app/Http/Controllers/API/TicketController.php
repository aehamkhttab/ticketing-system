<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Ticket;


class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tickets = Ticket::all();
            return response()->json([
                "msg"=>"All tickets found",
                "success"=>true,
                "data"=>$tickets
            ],200);
        }catch (Exception $e){
            return response()->json([
                "msg"=>$e->getMessage(),
                "success"=>false,
                "data"=>[]
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $data = $request->all();
            $ticket = new Ticket();
            $ticket->title = $data['title'];
            $ticket->description = $data['description'];
            $ticket->status = $data['status'];
            $ticket->deadline = $data['deadline'];
            $ticket->assigned_user = $data['assigned_user'];
            $ticket->save();
            return response()->json([
                "msg" => "Ticket created successfully",
                "success" => true,
                "data" => $ticket
            ], 201);
        }catch (Exception $e){
            return response()->json([
                "msg"=>$e->getMessage(),
                "success"=>false,
                "data"=>[]
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $ticket = Ticket::find($id);
            return response()->json([
                "msg"=>"Ticket found",
                "success"=>true,
                "data"=>$ticket
            ]);
        }catch (Exception $e){
            return response()->json([
                "msg"=>$e->getMessage(),
                "success"=>false,
                "data"=>[]
            ],500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       try {
            $data = $request->all();
            $ticket = Ticket::find($id);
            $ticket->title = $data['title'];
            $ticket->description = $data['description'];
            $ticket->status = $data['status'];
            $ticket->deadline = $data['deadline'];
            $ticket->assigned_user = $data['assigned_user'];
            $ticket->save();
            return response()->json([
                "msg" => "Ticket updated successfully",
                "success" => true,
                "data" => $ticket
            ]);
        }catch (Exception $e){
           return response()->json([
               "msg"=>$e->getMessage(),
               "success"=>false,
               "data"=>[]
           ],500);
       }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
