import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';
import { useState } from 'react';

function formatBRL(value) {
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value || 0);
}

export default function Index({ empenhos, filters, tiposEmpenho, statusEmpenho }) {
    const { flash } = usePage().props;
    const [params, setParams] = useState(filters || {});

    function handleFilter(e) {
        const { name, value } = e.target;
        const next = { ...params, [name]: value };
        setParams(next);
        router.get(route('contabil.empenhos.index'), next, { preserveState: true, replace: true });
    }

    function clearFilters() {
        setParams({});
        router.get(route('contabil.empenhos.index'), {}, { preserveState: true, replace: true });
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Empenhos</h2>
                <Link href={route('contabil.empenhos.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Novo Empenho</Link>
            </div>
        }>
            <Head title="Empenhos" />
            <div className="py-12"><div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}

                <div className="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-4">
                    <input name="nr_empenho" placeholder="Nº Empenho" value={params.nr_empenho || ''} onChange={handleFilter}
                        className="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    <select name="id_tipo_empenho" value={params.id_tipo_empenho || ''} onChange={handleFilter}
                        className="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Todos os Tipos</option>
                        {tiposEmpenho.map(t => <option key={t.id_tipo_empenho} value={t.id_tipo_empenho}>{t.nm_tipo_empenho}</option>)}
                    </select>
                    <input name="ano" type="number" placeholder="Ano" value={params.ano || ''} onChange={handleFilter}
                        className="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    <button onClick={clearFilters} className="rounded-md bg-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-300">Limpar</button>
                </div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="overflow-x-auto">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50"><tr>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nº Empenho</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Pedido</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Fornecedor</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tipo</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Valor</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Data</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                            </tr></thead>
                            <tbody className="divide-y divide-gray-200 bg-white">
                                {empenhos.data.length === 0 ? (
                                    <tr><td colSpan="7" className="px-6 py-4 text-center text-sm text-gray-500">Nenhum empenho encontrado.</td></tr>
                                ) : empenhos.data.map((e) => (
                                    <tr key={e.id_empenho}>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{e.nr_empenho}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{e.pedido?.nr_pedido || '-'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{e.pedido?.fornecedor?.pessoa?.nm_pessoa || '-'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{e.tipo_empenho?.nm_tipo_empenho || '-'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{formatBRL(e.vl_empenho)}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{e.dt_empenho_sistema || '-'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">
                                            <Link href={route('contabil.empenhos.show', e.id_empenho)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    {empenhos.total > empenhos.per_page && (
                        <div className="border-t border-gray-200 px-6 py-4">
                            <div className="flex items-center justify-between">
                                <span className="text-sm text-gray-700">Mostrando {empenhos.from} a {empenhos.to} de {empenhos.total}</span>
                                <div className="flex gap-2">
                                    {empenhos.links.map((link, i) => (
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
