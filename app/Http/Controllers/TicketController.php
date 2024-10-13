<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
   public function index()
    {
        $tickets = Ticket::with('assigned_user')->get();
        $sorted=$tickets->sortBy('deadline');
        return view('tickets.index' , ['tickets' => $sorted]);
    }
    public function create()
    {
        $users =  User::all();
        return view('tickets.create', ['users' => $users]);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:30|string',
            'description' => 'required|min:35 ',
            'status' => 'required|in:pending,ongoing,finished',
            'assigned_user_id' => 'exists:users,id',
            'deadline' => 'after:now',

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
        $ticket = new Ticket();
        $ticket->title = $data['title'];
        $ticket->description = $data['description'];
        $ticket->status = $data['status'];
        $ticket->deadline = $data['deadline'];
        $ticket->assigned_user_id = $data['assigned_user_id'];
        //$ticket->user_id = $request->user()->id->equals(2);
        $ticket->user_id = $request->user()->id;
        $ticket->save();


        return redirect('/tickets');
    }
    public function show(string $id)
    {
        $ticket = Ticket::where('id', $id)->with('user','assigned_user')->first();
        return view('tickets.details',['ticket'=>$ticket]);
    }
    public function edit(string $id)
    {
        $users = User::all();
        $ticket = Ticket::where('id', $id)->with('assigned_user')->first();
        return view('tickets.edit' , ['ticket' => $ticket,'users' => $users]);
    }

    //TODO: add validation for update method then edit on view to show it
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $ticket = Ticket::find($id);
        $ticket->title = $data['title'];
        $ticket->description = $data['description'];
        $ticket->status = $data['status'];
        $ticket->deadline = $data['deadline'];
        $ticket->assigned_user_id = $data['assigned_user_id'];
        $ticket->save();
        return redirect()->route('tickets.show', $ticket->id)->with('message' , 'Ticket has been updated');
    }
    public function destroy(string $id)
    {
        $ticket = Ticket::find($id);
        $ticket->delete();
        return redirect('/tickets');
    }

}
