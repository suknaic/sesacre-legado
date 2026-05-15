import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';
import { useState } from 'react';

export default function Index({ tramitacoes, filters, tpTramitacao }) {
    const { flash } = usePage().props;
    const [params, setParams] = useState(filters || {});

    function handleFilter(e) {
        const { name, value } = e.target;
        const next = { ...params, [name]: value };
        setParams(next);
        router.get(route('financeiro.doc-tramitacoes.index'), next, { preserveState: true, replace: true });
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Tramitações</h2>
                <Link href={route('financeiro.doc-tramitacoes.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Nova Tramitação</Link>
            </div>
        }>
            <Head title="Tramitações" />
            <div className="py-12"><div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}

                <div className="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <input name="search" placeholder="Buscar por documento..." value={params.search || ''} onChange={handleFilter}
                        className="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    <select name="id_tipo_tramitacao" value={params.id_tipo_tramitacao || ''} onChange={handleFilter}
                        className="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Todos tipos</option>
                        {Object.entries(tpTramitacao).map(([k, v]) => <option key={k} value={k}>{v}</option>)}
                    </select>
                </div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50"><tr>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Documento</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tipo</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Data/Hora</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Descrição</th>
                        </tr></thead>
                        <tbody className="divide-y divide-gray-200 bg-white">
                            {tramitacoes.data.length === 0 ? (
                                <tr><td colSpan="4" className="px-6 py-4 text-center text-sm text-gray-500">Nenhuma tramitação encontrada.</td></tr>
                            ) : tramitacoes.data.map((t) => (
                                <tr key={t.id_doc_tramitacao}>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{t.documento_fiscal?.nr_documento_fiscal || '-'}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{t.tipo_label}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{t.dh_doc_tramitacao}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{t.ds_doc_tramitacao || '-'}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
