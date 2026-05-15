<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketPriority;
use App\Models\TicketStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TicketController extends Controller
{
    public function index(): Response
    {
        $tickets = Ticket::with(['status', 'priority', 'secondaryCategory'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Helpdesk/Tickets/Index', [
            'tickets' => $tickets,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Helpdesk/Tickets/Create', [
            'statuses' => TicketStatus::where('is_active', true)->get(),
            'priorities' => TicketPriority::where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'description' => 'nullable|string',
            'requester_phone' => 'nullable|string|max:255',
            'ticket_status_id' => 'nullable|exists:ticket_statuses,id',
            'ticket_priority_id' => 'nullable|exists:ticket_priorities,id',
            'deadline' => 'nullable|date',
        ]);

        Ticket::create($validated);

        return redirect()->route('tickets.index')
            ->with('success', 'Chamado criado com sucesso.');
    }

    public function show(Ticket $ticket): Response
    {
        $ticket->load(['status', 'priority', 'secondaryCategory', 'services', 'notes', 'attachments']);

        return Inertia::render('Helpdesk/Tickets/Show', [
            'ticket' => $ticket,
        ]);
    }

    public function edit(Ticket $ticket): Response
    {
        return Inertia::render('Helpdesk/Tickets/Edit', [
            'ticket' => $ticket,
            'statuses' => TicketStatus::where('is_active', true)->get(),
            'priorities' => TicketPriority::where('is_active', true)->get(),
        ]);
    }

    public function update(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'description' => 'nullable|string',
            'resolution' => 'nullable|string',
            'ticket_status_id' => 'nullable|exists:ticket_statuses,id',
            'ticket_priority_id' => 'nullable|exists:ticket_priorities,id',
            'deadline' => 'nullable|date',
        ]);

        $ticket->update($validated);

        return redirect()->route('tickets.index')
            ->with('success', 'Chamado atualizado com sucesso.');
    }

    public function destroy(Ticket $ticket): RedirectResponse
    {
        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Chamado removido com sucesso.');
    }
}
