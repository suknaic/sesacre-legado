import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';
import { useState } from 'react';

export default function Index({ tickets, filters, statuses, priorities }) {
    const { flash } = usePage().props;

    const [search, setSearch] = useState(filters?.search ?? '');
    const [statusFilter, setStatusFilter] = useState(filters?.ticket_status_id ?? '');
    const [priorityFilter, setPriorityFilter] = useState(filters?.ticket_priority_id ?? '');

    function applyFilters() {
        router.get(route('tickets.index'), {
            search: search || undefined,
            ticket_status_id: statusFilter || undefined,
            ticket_priority_id: priorityFilter || undefined,
        }, { preserveState: true, replace: true });
    }

    function clearFilters() {
        setSearch('');
        setStatusFilter('');
        setPriorityFilter('');
        router.get(route('tickets.index'), {}, { preserveState: true, replace: true });
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Chamados</h2>
                <Link href={route('tickets.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                    Novo Chamado
                </Link>
            </div>
        }>
            <Head title="Chamados" />
            <div className="py-8">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}

                    <div className="mb-4 flex flex-wrap gap-3 items-end">
                        <div>
                            <label className="block text-xs font-medium text-gray-600">Buscar</label>
                            <input
                                type="text"
                                value={search}
                                onChange={(e) => setSearch(e.target.value)}
                                onKeyDown={(e) => e.key === 'Enter' && applyFilters()}
                                placeholder="Descrição ou ID..."
                                className="mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                            />
                        </div>
                        <div>
                            <label className="block text-xs font-medium text-gray-600">Status</label>
                            <select
                                value={statusFilter}
                                onChange={(e) => setStatusFilter(e.target.value)}
                                className="mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                            >
                                <option value="">Todos</option>
                                {statuses?.map((s) => (
                                    <option key={s.id} value={s.id}>{s.name}</option>
                                ))}
                            </select>
                        </div>
                        <div>
                            <label className="block text-xs font-medium text-gray-600">Prioridade</label>
                            <select
                                value={priorityFilter}
                                onChange={(e) => setPriorityFilter(e.target.value)}
                                className="mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                            >
                                <option value="">Todas</option>
                                {priorities?.map((p) => (
                                    <option key={p.id} value={p.id}>{p.name}</option>
                                ))}
                            </select>
                        </div>
                        <button onClick={applyFilters} className="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                            Filtrar
                        </button>
                        <button onClick={clearFilters} className="rounded-md bg-gray-200 px-3 py-2 text-sm font-semibold text-gray-700 shadow hover:bg-gray-300">
                            Limpar
                        </button>
                    </div>

                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="overflow-x-auto">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">ID</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Descrição</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Prioridade</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Data</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-200 bg-white">
                                    {tickets.data.length === 0 ? (
                                        <tr><td colSpan="6" className="px-6 py-4 text-center text-sm text-gray-500">Nenhum chamado encontrado.</td></tr>
                                    ) : (
                                        tickets.data.map((t) => (
                                            <tr key={t.id}>
                                                <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">#{t.id}</td>
                                                <td className="max-w-xs truncate px-6 py-4 text-sm text-gray-500">{t.description || '-'}</td>
                                                <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{t.status?.name || '-'}</td>
                                                <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{t.priority?.name || '-'}</td>
                                                <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{t.created_at?.split('T')[0] || '-'}</td>
                                                <td className="whitespace-nowrap px-6 py-4 text-sm">
                                                    <Link href={route('tickets.show', t.id)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                                    <Link href={route('tickets.edit', t.id)} className="ml-3 text-indigo-600 hover:text-indigo-900">Editar</Link>
                                                </td>
                                            </tr>
                                        ))
                                    )}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
