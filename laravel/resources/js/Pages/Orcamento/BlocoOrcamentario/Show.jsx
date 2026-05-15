import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ blocoOrcamentario }) {
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">{blocoOrcamentario.nm_bloc_orcamentario}</h2>}>
            <Head title={blocoOrcamentario.nm_bloc_orcamentario} />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('orcamento.blocos-orcamentarios.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">Nome</dt><dd className="mt-1 text-sm text-gray-900">{blocoOrcamentario.nm_bloc_orcamentario}</dd></div>
                        </dl>
                    </div>
                </div>
                {blocoOrcamentario.redes_tematicas?.length > 0 && (
                    <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="border-b border-gray-200 px-6 py-4">
                            <h3 className="text-lg font-medium text-gray-900">Redes Temáticas</h3>
                        </div>
                        <div className="overflow-x-auto">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50"><tr>
                                    <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nome</th>
                                </tr></thead>
                                <tbody className="divide-y divide-gray-200 bg-white">
                                    {blocoOrcamentario.redes_tematicas.map((r) => (
                                        <tr key={r.id_rede_tematica}>
                                            <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-900">{r.nm_rede_tematica}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                )}
                <div className="mt-6"><Link href={route('orcamento.blocos-orcamentarios.edit', blocoOrcamentario.id_bloc_orcamentario)}
                    className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link></div>
            </div></div>
        </AuthenticatedLayout>
    );
}
