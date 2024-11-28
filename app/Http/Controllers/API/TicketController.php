<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class TicketController extends Controller
{

    public function index(Request $request)
    {
        try {
            $sortOrder = $request->get('sort', 'asc');
            $pendingTickets = Ticket::where('status', 'pending')
                ->orderBy('deadline', $sortOrder)
                ->paginate(5, ['*'], 'pending_page');
            $ongoingTickets = Ticket::where('status', 'ongoing')
                ->orderBy('deadline', $sortOrder)
                ->paginate(5, ['*'], 'ongoing_page');
            $finishedTickets = Ticket::where('status', 'finished')
                ->orderBy('deadline', $sortOrder)
                ->paginate(5, ['*'], 'finished_page');
            return response()->json([
                "msg" => "All tickets are founded",
                "success" => true,
                "data" => ["Pending" => $pendingTickets,"Ongoing" => $ongoingTickets, "Finished" => $finishedTickets]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "success" => false,
                "data" => []
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
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
            $ticket->user_id = Auth::id();
            $ticket->save();

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $path = $file->store('attachments', 'public');

                $ticket->attachments()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'mime_type' => $file->getClientMimeType(),
                    'file_extension' => $file->getClientOriginalExtension(),
                ]);
            }

            return response()->json([
                "msg" => "Ticket created successfully",
                "success" => true,
                "data" => $ticket->load('attachments')
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "success" => false,
                "data" => []
            ], 500);
        }
    }


    public function show(string $id)
    {
        try {
            $ticket = Ticket::with('attachments')->findOrFail($id);
            return response()->json([
                "msg" => "Ticket found",
                "success" => true,
                "data" => $ticket
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "success" => false,
                "data" => []
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
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
            $ticket = Ticket::with('attachments')->findOrFail($id);
            $ticket->title = $data['title'];
            $ticket->description = $data['description'];
            $ticket->status = $data['status'];
            $ticket->deadline = $data['deadline'];
            $ticket->assigned_user_id = $data['assigned_user_id'];
            $ticket->save();

            if ($request->hasFile('attachment')) {
                if ($ticket->attachments()->exists()) {
                    $oldAttachment = $ticket->attachments->first();
                    Storage::disk('public')->delete($oldAttachment->file_path);
                    $oldAttachment->delete();
                }
                $file = $request->file('attachment');
                $path = $file->store('attachments', 'public');

                $ticket->attachments()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'mime_type' => $file->getClientMimeType(),
                    'file_extension' => $file->getClientOriginalExtension(),
                ]);
            }
            return response()->json([
                "msg" => "Ticket updated successfully",
                "success" => true,
                "data" => $ticket->load('attachments')
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "success" => false,
                "data" => []
            ], 500);
        }
    }


    public function destroy(string $id)
    {
        try {
            $ticket = Ticket::with('attachments')->findOrFail($id);
            foreach ($ticket->attachments as $attachment) {
                Storage::disk('public')->delete($attachment->file_path);
                $attachment->delete();
            }
            $ticket->delete();
            return response()->json([
                "msg" => "Ticket deleted successfully",
                "success" => true
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "success" => false,
                "data" => []
            ]);
        }
    }
    public function showTrashedTickets()
    {
        try {
            $tickets = Ticket::onlyTrashed()->with('attachments')->get();
            return response()->json([
                "msg" => "The deleted tickets",
                "success" => true,
                "data" => $tickets
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "success" => false,
                "data" => []
            ]);
        }
    }
    public function restoreTrashedTickets($id)
    {
        try {
            $ticket = Ticket::onlyTrashed()->with('attachments')->findOrFail($id);
            $ticket->restore();

            return response()->json([
                "msg" => "The deleted ticket restored successfully",
                "success" => true,
                "data" => $ticket
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "success" => false,
                "data" => []
            ]);
        }
    }
}
