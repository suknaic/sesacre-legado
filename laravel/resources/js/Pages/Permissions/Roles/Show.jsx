import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ role }) {
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Perfil de Acesso</h2>
                <Link href={route('roles.edit', role.id)} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link>
            </div>
        }>
            <Head title="Perfil de Acesso" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('roles.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="border-b border-gray-200 px-6 py-4">
                        <h3 className="text-lg font-medium text-gray-900">{role.name}</h3>
                    </div>
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">Sistema</dt><dd className="mt-1 text-sm text-gray-900">{role.system?.name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Ativo</dt><dd className="mt-1 text-sm text-gray-900">{role.is_active ? 'Sim' : 'Não'}</dd></div>
                        </dl>
                        <div className="mt-6">
                            <h4 className="text-sm font-medium text-gray-500 mb-2">Usuários ({role.users?.length || 0})</h4>
                            {role.users?.length > 0 ? (
                                <ul className="divide-y divide-gray-200 border rounded-md">
                                    {role.users.map(u => (
                                        <li key={u.id} className="px-4 py-2 text-sm text-gray-900">{u.name} <span className="text-gray-500">({u.email})</span></li>
                                    ))}
                                </ul>
                            ) : <p className="text-sm text-gray-500">Nenhum usuário vinculado.</p>}
                        </div>
                    </div>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
