import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';
import { useState } from 'react';

function formatBRL(value) {
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value || 0);
}

export default function Index({ contratos, filters, fornecedores }) {
    const { flash } = usePage().props;
    const [params, setParams] = useState(filters || {});

    function handleFilter(e) {
        const { name, value } = e.target;
        const next = { ...params, [name]: value };
        setParams(next);
        router.get(route('compras.contratos.index'), next, { preserveState: true, replace: true });
    }

    function clearFilters() {
        setParams({});
        router.get(route('compras.contratos.index'), {}, { preserveState: true, replace: true });
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Contratos</h2>
                <Link href={route('compras.contratos.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Novo Contrato</Link>
            </div>
        }>
            <Head title="Contratos" />
            <div className="py-12"><div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}

                <div className="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-4">
                    <input name="search" placeholder="Buscar contrato ou objeto" value={params.search || ''} onChange={handleFilter}
                        className="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    <select name="st_ativo" value={params.st_ativo || ''} onChange={handleFilter}
                        className="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Todos</option>
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                    <select name="id_fornecedor" value={params.id_fornecedor || ''} onChange={handleFilter}
                        className="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Todos Fornecedores</option>
                        {fornecedores.map(f => <option key={f.id_fornecedor} value={f.id_fornecedor}>{f.nm_pessoa}</option>)}
                    </select>
                    <button onClick={clearFilters} className="rounded-md bg-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-300">Limpar</button>
                </div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="overflow-x-auto">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50"><tr>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nº Contrato</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Fornecedor</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Objeto</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Valor</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Vigência</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ativo</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                            </tr></thead>
                            <tbody className="divide-y divide-gray-200 bg-white">
                                {contratos.data.length === 0 ? (
                                    <tr><td colSpan="7" className="px-6 py-4 text-center text-sm text-gray-500">Nenhum contrato encontrado.</td></tr>
                                ) : contratos.data.map((c) => (
                                    <tr key={c.id_contrato}>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{c.nr_contrato}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{c.fornecedor_nome}</td>
                                        <td className="max-w-xs truncate px-6 py-4 text-sm text-gray-500">{c.ds_objeto}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{formatBRL(c.vl_contrato)}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{c.dt_ini_vigencia_contrato} a {c.dt_fim_vigencia_contrato}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">
                                            <span className={`inline-flex rounded-full px-2 py-1 text-xs font-semibold ${c.st_ativo == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`}>
                                                {c.ativo_label}
                                            </span>
                                        </td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">
                                            <Link href={route('compras.contratos.show', c.id_contrato)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                            <Link href={route('compras.contratos.edit', c.id_contrato)} className="ml-3 text-indigo-600 hover:text-indigo-900">Editar</Link>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    {contratos.total > contratos.per_page && (
                        <div className="border-t border-gray-200 px-6 py-4">
                            <div className="flex items-center justify-between">
                                <span className="text-sm text-gray-700">Mostrando {contratos.from} a {contratos.to} de {contratos.total}</span>
                                <div className="flex gap-2">
                                    {contratos.links.map((link, i) => (
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
