import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';
import { useState } from 'react';

function formatBRL(value) {
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value || 0);
}

export default function Index({ liquidacoes, filters, situacoes, statusList }) {
    const { flash } = usePage().props;
    const [params, setParams] = useState(filters || {});

    function handleFilter(e) {
        const { name, value } = e.target;
        const next = { ...params, [name]: value };
        setParams(next);
        router.get(route('contabil.liquidacoes.index'), next, { preserveState: true, replace: true });
    }

    function clearFilters() {
        setParams({});
        router.get(route('contabil.liquidacoes.index'), {}, { preserveState: true, replace: true });
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Liquidações</h2>
                <Link href={route('contabil.liquidacoes.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Nova Liquidação</Link>
            </div>
        }>
            <Head title="Liquidações" />
            <div className="py-12"><div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}

                <div className="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-4">
                    <input name="search" placeholder="Nº Liquidação" value={params.search || ''} onChange={handleFilter}
                        className="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    <select name="id_liquidacao_situacao" value={params.id_liquidacao_situacao || ''} onChange={handleFilter}
                        className="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Todas Situações</option>
                        {situacoes.map(s => <option key={s.id_liquidacao_situacao} value={s.id_liquidacao_situacao}>{s.nm_liquidacao_situacao}</option>)}
                    </select>
                    <select name="id_liquidacao_status" value={params.id_liquidacao_status || ''} onChange={handleFilter}
                        className="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Todos Status</option>
                        {statusList.map(s => <option key={s.id_liquidacao_status} value={s.id_liquidacao_status}>{s.nm_liquidacao_status}</option>)}
                    </select>
                    <button onClick={clearFilters} className="rounded-md bg-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-300">Limpar</button>
                </div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="overflow-x-auto">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50"><tr>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nº Liquidação</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Empenho</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Fornecedor</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Valor</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Situação</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Data</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                            </tr></thead>
                            <tbody className="divide-y divide-gray-200 bg-white">
                                {liquidacoes.data.length === 0 ? (
                                    <tr><td colSpan="8" className="px-6 py-4 text-center text-sm text-gray-500">Nenhuma liquidação encontrada.</td></tr>
                                ) : liquidacoes.data.map((l) => (
                                    <tr key={l.id_liquidacao}>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{l.nr_liquidacao}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{l.empenho?.nr_empenho || '-'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{l.empenho?.pedido?.fornecedor?.pessoa?.nm_pessoa || '-'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{formatBRL(l.vl_liquidacao)}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">
                                            <span className={`inline-flex rounded-full px-2 py-1 text-xs font-semibold ${l.situacao_color}`}>{l.situacao_label}</span>
                                        </td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{l.status_label}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{l.dt_liquidacao}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">
                                            <Link href={route('contabil.liquidacoes.show', l.id_liquidacao)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    {liquidacoes.total > liquidacoes.per_page && (
                        <div className="border-t border-gray-200 px-6 py-4">
                            <div className="flex items-center justify-between">
                                <span className="text-sm text-gray-700">Mostrando {liquidacoes.from} a {liquidacoes.to} de {liquidacoes.total}</span>
                                <div className="flex gap-2">
                                    {liquidacoes.links.map((link, i) => (
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
