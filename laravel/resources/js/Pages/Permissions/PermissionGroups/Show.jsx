import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ group }) {
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Grupo de Recursos</h2>
                <Link href={route('permission-groups.edit', group.id)} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link>
            </div>
        }>
            <Head title="Grupo de Recursos" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('permission-groups.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="border-b border-gray-200 px-6 py-4">
                        <h3 className="text-lg font-medium text-gray-900">{group.name}</h3>
                    </div>
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">Ativo</dt><dd className="mt-1 text-sm text-gray-900">{group.is_active ? 'Sim' : 'Não'}</dd></div>
                        </dl>
                        <div className="mt-6">
                            <h4 className="text-sm font-medium text-gray-500 mb-2">Recursos ({group.resources?.length || 0})</h4>
                            {group.resources?.length > 0 ? (
                                <table className="min-w-full divide-y divide-gray-200">
                                    <thead className="bg-gray-50">
                                        <tr>
                                            <th className="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">Recurso</th>
                                            <th className="px-4 py-2 text-center text-xs font-medium uppercase text-gray-500">Criar</th>
                                            <th className="px-4 py-2 text-center text-xs font-medium uppercase text-gray-500">Editar</th>
                                            <th className="px-4 py-2 text-center text-xs font-medium uppercase text-gray-500">Excluir</th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y divide-gray-200">
                                        {group.resources.map(r => (
                                            <tr key={r.id}>
                                                <td className="px-4 py-2 text-sm text-gray-900">{r.name}</td>
                                                <td className="px-4 py-2 text-center text-sm">{r.pivot?.can_create ? '✅' : '❌'}</td>
                                                <td className="px-4 py-2 text-center text-sm">{r.pivot?.can_edit ? '✅' : '❌'}</td>
                                                <td className="px-4 py-2 text-center text-sm">{r.pivot?.can_delete ? '✅' : '❌'}</td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            ) : <p className="text-sm text-gray-500">Nenhum recurso vinculado.</p>}
                        </div>
                    </div>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
