import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';
import { useState } from 'react';

export default function Index({ vincos, filters, lotacoes }) {
    const { flash } = usePage().props;
    const [params, setParams] = useState(filters || {});

    function handleFilter(e) {
        const { name, value } = e.target;
        const next = { ...params, [name]: value };
        setParams(next);
        router.get(route('financeiro.doc-vinc-recebimentos.index'), next, { preserveState: true, replace: true });
    }

    function handleDelete(id) {
        if (confirm('Remover este vínculo de recebimento?')) {
            router.delete(route('financeiro.doc-vinc-recebimentos.destroy', id));
        }
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Vínculos de Recebimento</h2>
                <Link href={route('financeiro.doc-vinc-recebimentos.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Novo Vínculo</Link>
            </div>
        }>
            <Head title="Vínculos de Recebimento" />
            <div className="py-12"><div className="mx-auto max-w-4xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}

                <div className="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <select name="id_lotacao" value={params.id_lotacao || ''} onChange={handleFilter}
                        className="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Todas lotações</option>
                        {lotacoes.map(l => <option key={l.id_lotacao} value={l.id_lotacao}>{l.nm_lotacao}</option>)}
                    </select>
                </div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50"><tr>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Lotação</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Pessoa</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                        </tr></thead>
                        <tbody className="divide-y divide-gray-200 bg-white">
                            {vincos.data.length === 0 ? (
                                <tr><td colSpan="3" className="px-6 py-4 text-center text-sm text-gray-500">Nenhum vínculo encontrado.</td></tr>
                            ) : vincos.data.map((v) => (
                                <tr key={v.id_doc_vinc_recebimento}>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{v.id_doc_lotacao}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{v.id_pessoa}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm">
                                        <button onClick={() => handleDelete(v.id_doc_vinc_recebimento)} className="text-red-600 hover:text-red-900">Remover</button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
