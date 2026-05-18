import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';
import { useState } from 'react';

export default function Index({ materials, filters }) {
    const { flash } = usePage().props;
    const [search, setSearch] = useState(filters?.search ?? '');

    function applyFilters() {
        router.get(route('materials.index'), { search: search || undefined }, { preserveState: true, replace: true });
    }

    function clearFilters() {
        setSearch('');
        router.get(route('materials.index'), {}, { preserveState: true, replace: true });
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Materiais</h2>
                <Link href={route('materials.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                    Novo Material
                </Link>
            </div>
        }>
            <Head title="Materiais" />
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
                                placeholder="Nome, patrimônio ou serial..."
                                className="mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                            />
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
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nome</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Patrimônio</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Marca</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Modelo</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Estado</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-200 bg-white">
                                    {materials.data.length === 0 ? (
                                        <tr><td colSpan="6" className="px-6 py-4 text-center text-sm text-gray-500">Nenhum material encontrado.</td></tr>
                                    ) : (
                                        materials.data.map((m) => (
                                            <tr key={m.id}>
                                                <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{m.name}</td>
                                                <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{m.patrimony_number || '-'}</td>
                                                <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{m.brand || '-'}</td>
                                                <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{m.model || '-'}</td>
                                                <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{m.state || '-'}</td>
                                                <td className="whitespace-nowrap px-6 py-4 text-sm">
                                                    <Link href={route('materials.show', m.id)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                                    <Link href={route('materials.edit', m.id)} className="ml-3 text-indigo-600 hover:text-indigo-900">Editar</Link>
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
