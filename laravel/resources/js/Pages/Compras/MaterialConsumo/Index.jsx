import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';
import { useState } from 'react';

export default function Index({ materiais, filters }) {
    const { flash } = usePage().props;
    const [params, setParams] = useState(filters || {});

    function handleFilter(e) {
        const { name, value } = e.target;
        const next = { ...params, [name]: value };
        setParams(next);
        router.get(route('compras.materiais-consumo.index'), next, { preserveState: true, replace: true });
    }

    function clearFilters() {
        setParams({});
        router.get(route('compras.materiais-consumo.index'), {}, { preserveState: true, replace: true });
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Materiais de Consumo</h2>
                <Link href={route('compras.materiais-consumo.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Novo Material</Link>
            </div>
        }>
            <Head title="Materiais de Consumo" />
            <div className="py-12"><div className="mx-auto max-w-4xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                <div className="mb-4 flex gap-4">
                    <input name="search" placeholder="Buscar material" value={params.search || ''} onChange={handleFilter}
                        className="flex-1 rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    <button onClick={clearFilters} className="rounded-md bg-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-300">Limpar</button>
                </div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50"><tr>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">ID</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nome</th>
                        </tr></thead>
                        <tbody className="divide-y divide-gray-200 bg-white">
                            {materiais.data.length === 0 ? (
                                <tr><td colSpan="2" className="px-6 py-4 text-center text-sm text-gray-500">Nenhum material encontrado.</td></tr>
                            ) : materiais.data.map((m) => (
                                <tr key={m.id_material_consumo}>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{m.id_material_consumo}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{m.nm_material_consumo}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                    {materiais.total > materiais.per_page && (
                        <div className="border-t border-gray-200 px-6 py-4">
                            <div className="flex items-center justify-between">
                                <span className="text-sm text-gray-700">Mostrando {materiais.from} a {materiais.to} de {materiais.total}</span>
                                <div className="flex gap-2">
                                    {materiais.links.map((link, i) => (
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
