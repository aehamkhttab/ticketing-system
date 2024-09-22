<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
   public function index()
    {
        $tickets = Ticket::all();
        return view('tickets.index' , ['tickets' => $tickets]);
    }
    public function create()
    {
        return view('tickets.create');
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $ticket = new Ticket();
        $ticket->title = $data['title'];
        $ticket->description = $data['description'];
        $ticket->status = $data['status'];
        $ticket->deadline = $data['deadline'];
        $ticket->assigned_user = $data['assigned_user'];
        $ticket->save();

        return redirect('/tickets');
    }
    public function show(string $id)
    {
        $ticket = Ticket::find($id);
        return view('tickets.details' , ['ticket' => $ticket]);
    }
    public function edit(string $id)
    {
        $ticket = Ticket::find($id);
        return view('tickets.edit' , ['ticket' => $ticket]);
    }
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $ticket = Ticket::find($id);
        $ticket->title = $data['title'];
        $ticket->description = $data['description'];
        $ticket->status = $data['status'];
        $ticket->deadline = $data['deadline'];
        $ticket->assigned_user = $data['assigned_user'];
        $ticket->save();
        return redirect('/tickets');
    }
    public function destroy(string $id)
    {
        $ticket = Ticket::find($id);
        $ticket->delete();
        return redirect('/tickets');
    }

}
