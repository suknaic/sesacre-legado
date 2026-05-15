import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';
import { useState } from 'react';

const statusColors = {
    0: 'bg-red-100 text-red-800', 1: 'bg-yellow-100 text-yellow-800', 2: 'bg-blue-100 text-blue-800',
    3: 'bg-orange-100 text-orange-800', 4: 'bg-orange-100 text-orange-800', 5: 'bg-green-100 text-green-800',
    6: 'bg-purple-100 text-purple-800', 7: 'bg-purple-100 text-purple-800', 8: 'bg-indigo-100 text-indigo-800',
    9: 'bg-green-100 text-green-800',
};

function formatBRL(value) {
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value || 0);
}

export default function Index({ ordens, filters, situacaoList, lotacoes }) {
    const { flash } = usePage().props;
    const [params, setParams] = useState(filters || {});

    function handleFilter(e) {
        const { name, value } = e.target;
        const next = { ...params, [name]: value };
        setParams(next);
        router.get(route('financeiro.ordens.index'), next, { preserveState: true, replace: true });
    }

    function clearFilters() {
        setParams({});
        router.get(route('financeiro.ordens.index'), {}, { preserveState: true, replace: true });
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Ordens</h2>
                <Link href={route('financeiro.ordens.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Nova Ordem</Link>
            </div>
        }>
            <Head title="Ordens" />
            <div className="py-12"><div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}

                <div className="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-4">
                    <input name="search" placeholder="Buscar ordem/pedido..." value={params.search || ''} onChange={handleFilter}
                        className="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    <select name="sit_ordem" value={params.sit_ordem || ''} onChange={handleFilter}
                        className="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Todas situações</option>
                        {Object.entries(situacaoList).map(([k, v]) => <option key={k} value={k}>{v}</option>)}
                    </select>
                    <select name="id_lotacao" value={params.id_lotacao || ''} onChange={handleFilter}
                        className="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Todas lotações</option>
                        {lotacoes.map(l => <option key={l.id_lotacao} value={l.id_lotacao}>{l.nm_lotacao}</option>)}
                    </select>
                    <button onClick={clearFilters} className="rounded-md bg-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-300">Limpar</button>
                </div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="overflow-x-auto">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50"><tr>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nº Ordem</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Pedido</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tipo</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Valor</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Situação</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                            </tr></thead>
                            <tbody className="divide-y divide-gray-200 bg-white">
                                {ordens.data.length === 0 ? (
                                    <tr><td colSpan="6" className="px-6 py-4 text-center text-sm text-gray-500">Nenhuma ordem encontrada.</td></tr>
                                ) : ordens.data.map((o) => (
                                    <tr key={o.id_ordem}>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{o.nr_ordem}/{o.aa_ordem}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{o.pedido?.nr_pedido || '-'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{o.tipo_label}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{formatBRL(o.vl_ordem)}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">
                                            <span className={`inline-flex rounded-full px-2 py-1 text-xs font-semibold ${statusColors[o.sit_ordem] || 'bg-gray-100 text-gray-800'}`}>
                                                {o.status_label}
                                            </span>
                                        </td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">
                                            <Link href={route('financeiro.ordens.show', o.id_ordem)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    {ordens.total > ordens.per_page && (
                        <div className="border-t border-gray-200 px-6 py-4">
                            <div className="flex items-center justify-between">
                                <span className="text-sm text-gray-700">Mostrando {ordens.from} a {ordens.to} de {ordens.total}</span>
                                <div className="flex gap-2">
                                    {ordens.links.map((link, i) => (
                                        link.url ? (
                                            <Link key={i} href={link.url}
                                                className={`rounded px-3 py-1 text-sm ${link.active ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`}
                                                dangerouslySetInnerHTML={{ __html: link.label }} />
                                        ) : (
                                            <span key={i} className="rounded px-3 py-1 text-sm text-gray-400" dangerouslySetInnerHTML={{ __html: link.label }} />
                                        )
                                    ))}
                                </div>
                            </div>
                        </div>
                    )}
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
