import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';
import { useState } from 'react';

const statusColors = {
    0: 'bg-red-100 text-red-800',
    9: 'bg-yellow-100 text-yellow-800',
    10: 'bg-orange-100 text-orange-800',
    11: 'bg-orange-100 text-orange-800',
    12: 'bg-orange-100 text-orange-800',
    13: 'bg-orange-100 text-orange-800',
    14: 'bg-orange-100 text-orange-800',
    15: 'bg-blue-100 text-blue-800',
    16: 'bg-blue-100 text-blue-800',
    17: 'bg-indigo-100 text-indigo-800',
    18: 'bg-indigo-100 text-indigo-800',
    19: 'bg-indigo-100 text-indigo-800',
    20: 'bg-indigo-100 text-indigo-800',
    21: 'bg-purple-100 text-purple-800',
    22: 'bg-purple-100 text-purple-800',
    23: 'bg-green-100 text-green-800',
    24: 'bg-yellow-100 text-yellow-800',
    25: 'bg-purple-100 text-purple-800',
    26: 'bg-purple-100 text-purple-800',
};

function formatBRL(value) {
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value || 0);
}

export default function Index({ pedidos, filters, statusList, lotacoes, tiposGasto, fornecedores }) {
    const { flash } = usePage().props;
    const [params, setParams] = useState(filters || {});

    function handleFilter(e) {
        const { name, value } = e.target;
        const next = { ...params, [name]: value };
        setParams(next);
        router.get(route('financeiro.pedidos.index'), next, { preserveState: true, replace: true });
    }

    function clearFilters() {
        setParams({});
        router.get(route('financeiro.pedidos.index'), {}, { preserveState: true, replace: true });
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Solicitações Central</h2>
                <Link href={route('financeiro.pedidos.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Novo Pedido</Link>
            </div>
        }>
            <Head title="Solicitações Central" />
            <div className="py-12"><div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}

                <div className="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-3 lg:grid-cols-6">
                    <input name="nr_pedido" placeholder="Nº Pedido" value={params.nr_pedido || ''} onChange={handleFilter}
                        className="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    <select name="id_lotacao" value={params.id_lotacao || ''} onChange={handleFilter}
                        className="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Todas Centrais</option>
                        {lotacoes.map(l => <option key={l.id_lotacao} value={l.id_lotacao}>{l.nm_lotacao}</option>)}
                    </select>
                    <select name="id_tipo_gasto" value={params.id_tipo_gasto || ''} onChange={handleFilter}
                        className="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Todos Gastos</option>
                        {tiposGasto.map(t => <option key={t.id_tipo_gasto} value={t.id_tipo_gasto}>{t.nm_tipo_gasto}</option>)}
                    </select>
                    <select name="id_fornecedor" value={params.id_fornecedor || ''} onChange={handleFilter}
                        className="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Todos Fornecedores</option>
                        {fornecedores.map(f => <option key={f.id_fornecedor} value={f.id_fornecedor}>{f.nm_pessoa}</option>)}
                    </select>
                    <input name="ano" type="number" placeholder="Ano" value={params.ano || ''} onChange={handleFilter}
                        className="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    <button onClick={clearFilters} className="rounded-md bg-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-300">Limpar</button>
                </div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="overflow-x-auto">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50"><tr>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nº Pedido</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tipo</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Programa Trabalho</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Fonte</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Desp. Elemento</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tipo Gasto</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Central</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Descrição</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Valor</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                            </tr></thead>
                            <tbody className="divide-y divide-gray-200 bg-white">
                                {pedidos.data.length === 0 ? (
                                    <tr><td colSpan="11" className="px-6 py-4 text-center text-sm text-gray-500">Nenhum pedido encontrado.</td></tr>
                                ) : pedidos.data.map((p) => (
                                    <tr key={p.id_pedido}>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{p.id_lotacao}/{p.nr_pedido}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{p.tipo_solicitacao?.nm_tipo_solicitacao || '-'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{p.programa_trabalho?.cd_programa_trabalho || '-'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{p.fonte?.nr_fonte || '-'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{p.despesa_elemento?.cd_despesa_elemento || '-'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{p.id_tipo_gasto || '-'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{p.id_lotacao || '-'}</td>
                                        <td className="max-w-xs truncate px-6 py-4 text-sm text-gray-500">{p.ds_pedido || '-'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{formatBRL(p.vl_pedido)}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">
                                            <span className={`inline-flex rounded-full px-2 py-1 text-xs font-semibold ${statusColors[p.st_pedido] || 'bg-gray-100 text-gray-800'}`}>
                                                {statusList[p.st_pedido] || p.st_pedido}
                                            </span>
                                        </td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">
                                            <Link href={route('financeiro.pedidos.show', p.id_pedido)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                            {p.pode_cancelar && (
                                                <Link href={route('financeiro.pedidos.edit', p.id_pedido)} className="ml-3 text-indigo-600 hover:text-indigo-900">Editar</Link>
                                            )}
                                            {p.st_pedido === 15 && (
                                                <span className="ml-3 text-green-600">Empenhar</span>
                                            )}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    {pedidos.total > pedidos.per_page && (
                        <div className="border-t border-gray-200 px-6 py-4">
                            <div className="flex items-center justify-between">
                                <span className="text-sm text-gray-700">Mostrando {pedidos.from} a {pedidos.to} de {pedidos.total}</span>
                                <div className="flex gap-2">
                                    {pedidos.links.map((link, i) => (
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
