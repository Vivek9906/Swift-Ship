<?php

namespace App\Http\Controllers;

use App\Models\ContactLead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactLeadController extends Controller
{
    /** POST /contact-leads — public form submission */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email'],
            'company' => ['required', 'string', 'max:150'],
            'phone' => ['required', 'string'],
            'business_type' => ['required', 'string'],
            'monthly_volume' => ['required', 'string'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        $lead = ContactLead::create(array_merge($validated, ['status' => 'new']));

        // Auto-reply to user
        try {
            Mail::to($validated['email'])->send(new \App\Mail\ContactAutoReplyMail($lead));
            // Alert to ops team
            Mail::to(config('mail.ops_address', 'ops@swiftship.in'))
                ->send(new \App\Mail\ContactAlertMail($lead));
        } catch (\Throwable) {
        }

        return response()->json(['success' => true, 'message' => "Thanks! Our team will reach out within 24 hours."]);
    }

    /** Admin: list leads */
    public function index(Request $request)
    {
        $leads = ContactLead::when($request->status, fn($q, $s) => $q->where('status', $s))
            ->when($request->search, fn($q, $s) => $q->where('name', 'like', "%$s%")->orWhere('email', 'like', "%$s%"))
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.leads.index', compact('leads'));
    }

    /** Admin: update lead status inline */
    public function updateStatus(Request $request, ContactLead $lead)
    {
        $request->validate(['status' => ['required', 'in:new,contacted,qualified,closed']]);
        $lead->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }
}
