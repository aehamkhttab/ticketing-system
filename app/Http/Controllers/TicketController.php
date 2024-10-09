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
        return view('tickets.index' , ['tickets' => $tickets]);
    }
    public function create()
    {
        $users =  User::all();
        return view('tickets.create', ['users' => $users]);
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $ticket = new Ticket();
        $ticket->title = $data['title'];
        $ticket->description = $data['description'];
        $ticket->status = $data['status'];
        $ticket->deadline = $data['deadline'];
        $ticket->assigned_user_id = $data['assigned_user_id'];
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
