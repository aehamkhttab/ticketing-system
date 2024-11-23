<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;


class TicketController extends Controller
{

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

    //TODO: add validation for store method
    public function store(Request $request)
    {
        try{
            $data = $request->validate([
                'title' => 'required|max:30|string',
                'description' => 'required|min:35 ',
                'status' => 'required|in:pending,ongoing,finished',
                'assigned_user_id' => 'exists:users,id',
                'deadline' => 'after:now',
                'attachment' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,xlsx|max:2048'

            ],
                [
                    'title.required' => 'Title is required',
                    'title.max' => 'Title must be 30 characters',
                    'title.string' => 'Title must be string',
                    'description.required' => 'Description is required',
                    'description.min' => 'Description must be at least 35 characters',
                    'status.required' => 'Status is required',
                    'status.in' => 'Status must be one of "pending", "ongoing", "finished"',
                    'deadline.after' => 'Deadline must be after today',
                    'attachment.mimes' => 'File type must be .[jpg,jpeg,png,pdf,doc,docx,xlsx]',
                    'attachment.max' => 'File size must be equal or smaller than 2MB'

                ]
            );
            $data = $request->all();
            $ticket = new Ticket();
            $ticket->title = $data['title'];
            $ticket->description = $data['description'];
            $ticket->status = $data['status'];
            $ticket->deadline = $data['deadline'];
            $ticket->assigned_user_id = $data['assigned_user_id'];
            $ticket->user_id = $request->user('api')->id;
            $ticket->user_id = Auth::user()->id;
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

    //TODO: add validation for update method
    public function update(Request $request, string $id)
    {
       try {
           $data = $request->validate([
               'title' => 'required|max:30|string',
               'description' => 'required|min:35 ',
               'status' => 'required|in:pending,ongoing,finished',
               'assigned_user_id' => 'exists:users,id',
               'deadline' => 'after:now',
               'attachment' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,xlsx'

           ],
               [
                   'title.required' => 'Title is required',
                   'title.max' => 'Title must be 30 characters',
                   'title.string' => 'Title must be string',
                   'description.required' => 'Description is required',
                   'description.min' => 'Description must be at least 35 characters',
                   'status.required' => 'Status is required',
                   'status.in' => 'Status must be one of "pending", "ongoing", "finished"',
                   'deadline.after' => 'Deadline must be after today',

               ]
           );
            $data = $request->all();
            $ticket = Ticket::find($id);
            $ticket->title = $data['title'];
            $ticket->description = $data['description'];
            $ticket->status = $data['status'];
            $ticket->deadline = $data['deadline'];
            $ticket->assigned_user_id = $data['assigned_user_id'];
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


    public function destroy(string $id)
    {
        try {
            $ticket = Ticket::find($id);
            $ticket->delete();
            return response()->json([
                "msg" => "Ticket deleted successfully",
                "success" => true,
                "data" => $ticket
            ]);
        }catch (Exception $e){
            return response()->json([
                "msg"=>$e->getMessage(),
                "success"=>false,
                "data"=>[]
            ]);
        }
    }
    public function showTrashedTickets(){
        try {
            $tickets = Ticket::onlyTrashed()->get();
            //$tickets->restore();
            return response()->json([
                "msg" => "The deleted tickets",
                "success" => true,
                "data" => $tickets
            ]);
        }catch (Exception $e){
            return response()->json([
                "msg"=>$e->getMessage(),
                "success"=>false,
                "data"=>[]
            ]);
        }
    }
    public function restoreTrashedTickets($id){
        try {
            $tickets = Ticket::onlyTrashed()->find($id);
            $tickets->restore();
            return response()->json([
                "msg" => "The deleted ticket restored successfully",
                "success" => true,
                "data" => $tickets
            ]);
        }catch (Exception $e){
            return response()->json([
                "msg"=>$e->getMessage(),
                "success"=>false,
                "data"=>[]
            ]);
        }
    }
}
