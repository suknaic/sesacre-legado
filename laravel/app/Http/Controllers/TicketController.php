<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketPriority;
use App\Models\TicketSecondaryCategory;
use App\Models\TicketService;
use App\Models\TicketServiceMaterial;
use App\Models\TicketStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TicketController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Ticket::with(['status', 'priority', 'secondaryCategory']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('id', $search);
            });
        }

        if ($request->filled('ticket_status_id')) {
            $query->where('ticket_status_id', $request->ticket_status_id);
        }

        if ($request->filled('ticket_priority_id')) {
            $query->where('ticket_priority_id', $request->ticket_priority_id);
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(15);

        return Inertia::render('Helpdesk/Tickets/Index', [
            'tickets' => $tickets,
            'filters' => $request->only(['search', 'ticket_status_id', 'ticket_priority_id']),
            'statuses' => TicketStatus::where('is_active', true)->get(),
            'priorities' => TicketPriority::where('is_active', true)->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Helpdesk/Tickets/Create', [
            'statuses' => TicketStatus::where('is_active', true)->get(),
            'priorities' => TicketPriority::where('is_active', true)->get(),
            'categories' => TicketCategory::with(['categoryTypes.primaryCategories.secondaryCategories'])->where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'description' => 'nullable|string',
            'requester_phone' => 'nullable|string|max:255',
            'ticket_status_id' => 'nullable|exists:ticket_statuses,id',
            'ticket_priority_id' => 'nullable|exists:ticket_priorities,id',
            'ticket_secondary_category_id' => 'nullable|exists:ticket_secondary_categories,id',
            'deadline' => 'nullable|date',
        ]);

        Ticket::create($validated);

        return redirect()->route('tickets.index')
            ->with('success', 'Chamado criado com sucesso.');
    }

    public function show(Ticket $ticket): Response
    {
        $ticket->load([
            'status',
            'priority',
            'secondaryCategory.primaryCategory.categoryType.category',
            'services.materials.material',
            'notes',
            'attachments',
        ]);

        return Inertia::render('Helpdesk/Tickets/Show', [
            'ticket' => $ticket,
            'statuses' => TicketStatus::where('is_active', true)->get(),
            'priorities' => TicketPriority::where('is_active', true)->get(),
            'categories' => TicketCategory::with(['categoryTypes.primaryCategories.secondaryCategories'])->where('is_active', true)->get(),
            'materials' => Material::orderBy('name')->get(['id', 'name', 'patrimony_number']),
        ]);
    }

    public function addService(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'service_description' => 'required|string',
            'quantity' => 'nullable|integer|min:1',
            'service_value' => 'nullable|numeric|min:0',
            'total_value' => 'nullable|numeric|min:0',
        ]);

        $ticket->services()->create($validated);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Serviço adicionado ao chamado.');
    }

    public function updateService(Request $request, Ticket $ticket, TicketService $service): RedirectResponse
    {
        $validated = $request->validate([
            'service_description' => 'required|string',
            'quantity' => 'nullable|integer|min:1',
            'service_value' => 'nullable|numeric|min:0',
            'total_value' => 'nullable|numeric|min:0',
        ]);

        $service->update($validated);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Serviço atualizado.');
    }

    public function removeService(Ticket $ticket, TicketService $service): RedirectResponse
    {
        $service->delete();

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Serviço removido do chamado.');
    }

    public function addMaterial(Request $request, TicketService $service): RedirectResponse
    {
        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'quantity' => 'nullable|integer|min:1',
            'value' => 'nullable|numeric|min:0',
        ]);

        $service->materials()->create($validated);

        return redirect()->route('tickets.show', $service->ticket_id)
            ->with('success', 'Material vinculado ao serviço.');
    }

    public function removeMaterial(TicketService $service, TicketServiceMaterial $material): RedirectResponse
    {
        $material->delete();

        return redirect()->route('tickets.show', $service->ticket_id)
            ->with('success', 'Material removido do serviço.');
    }

    public function edit(Ticket $ticket): Response
    {
        $ticket->load(['secondaryCategory.primaryCategory.categoryType.category']);

        return Inertia::render('Helpdesk/Tickets/Edit', [
            'ticket' => $ticket,
            'statuses' => TicketStatus::where('is_active', true)->get(),
            'priorities' => TicketPriority::where('is_active', true)->get(),
            'categories' => TicketCategory::with(['categoryTypes.primaryCategories.secondaryCategories'])->where('is_active', true)->get(),
        ]);
    }

    public function update(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'description' => 'nullable|string',
            'resolution' => 'nullable|string',
            'ticket_status_id' => 'nullable|exists:ticket_statuses,id',
            'ticket_priority_id' => 'nullable|exists:ticket_priorities,id',
            'ticket_secondary_category_id' => 'nullable|exists:ticket_secondary_categories,id',
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
