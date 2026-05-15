<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Models\ForServico;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ServicoController extends Controller
{
    public function index(Request $request): Response
    {
        $query = ForServico::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nm_servico', 'ilike', "%{$search}%");
        }

        $servicos = $query->orderBy('nm_servico')->paginate(15);

        return Inertia::render('Compras/Servico/Index', [
            'servicos' => $servicos,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Compras/Servico/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nm_servico' => 'required|string|max:255|unique:for_servico,nm_servico',
        ], [
            'nm_servico.required' => 'O nome do serviço é obrigatório.',
            'nm_servico.unique' => 'Este serviço já está cadastrado.',
        ]);

        ForServico::create($validated);

        return redirect()->route('compras.servicos.index')
            ->with('success', 'Serviço cadastrado com sucesso.');
    }
}
