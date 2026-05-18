import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Index({ groups }) {
    const { flash } = usePage().props;
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Grupos de Recursos</h2>
                <Link href={route('permission-groups.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Novo Grupo</Link>
            </div>
        }>
            <Head title="Grupos de Recursos" />
            <div className="py-8"><div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50">
                            <tr>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nome</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Recursos</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Usuários</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ativo</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-gray-200 bg-white">
                            {groups.data.length === 0 ? (
                                <tr><td colSpan="5" className="px-6 py-4 text-center text-sm text-gray-500">Nenhum grupo encontrado.</td></tr>
                            ) : groups.data.map((g) => (
                                <tr key={g.id}>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{g.name}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{g.resources_count ?? 0}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{g.users_count ?? 0}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm">{g.is_active ? <span className="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold text-green-800">Sim</span> : 'Não'}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm">
                                        <Link href={route('permission-groups.show', g.id)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                        <Link href={route('permission-groups.edit', g.id)} className="ml-3 text-indigo-600 hover:text-indigo-900">Editar</Link>
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
