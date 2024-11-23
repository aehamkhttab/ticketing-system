<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $ticket = new Ticket();
        $ticket->title = $data['title'];
        $ticket->description = $data['description'];
        $ticket->status = $data['status'];
        $ticket->deadline = $data['deadline'];
        $ticket->assigned_user_id = $data['assigned_user_id'];
        $ticket->user_id = $request->user()->id;
        $ticket->save();;

        if($request->hasFile('attachment')){
            $file = $request->file('attachment');
            $path = $file->store('attachment' , 'public');

            $ticket->attachments()->create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'mime_type' => $file->getClientMimeType(),
                'file_extension' => $file->getClientOriginalExtension(),
            ]);
        }
        return redirect('/tickets');
    }
    /*public function show(string $id)
    {
        $ticket = Ticket::where('id', $id)->with('user','assigned_user')->first();
        return view('tickets.details',['ticket'=>$ticket]);
    }*/
    public function show(string $id)
    {
        $ticket = Ticket::where('id', $id)
            ->with(['user', 'assigned_user', 'attachments'])
            ->first();

        return view('tickets.details', ['ticket' => $ticket]);
    }
    public function downloadAttachment($attachmentId)
    {

        $attachment = Attachment::findOrFail($attachmentId);
        $filePath = storage_path('app/public/attachments/'
            . $attachment->file_name);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            abort(404, 'File not found');
        }
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
        $ticket = Ticket::find($id);
        $ticket->update($data);

        if ($request-> hasFile('attachment'))
        {
            $ticket->attachments()->delete();
            $file = $request->file('attachment');
            $path = $file->store('attachment' , 'public');
            $ticket->attachments()->create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'mime_type' => $file->getClientMimeType(),
                'file_extension' => $file->getClientOriginalExtension(),
            ]);
        }

        return redirect()->route('tickets.show', $ticket->id)->with('message' , 'Ticket has been updated');
    }
    public function destroy(string $id)
    {
        $ticket = Ticket::find($id);
        $ticket->delete();
        return redirect('/tickets');
    }

    public function deleteAttachment($attachmentId)
    {
        $attachment = Attachment::findOrFail($attachmentId);
        Storage::disk('public')->delete($attachment->file_path);
        $attachment->delete();

        return back()->with('message', 'Attachment deleted successfully.');
    }
}
