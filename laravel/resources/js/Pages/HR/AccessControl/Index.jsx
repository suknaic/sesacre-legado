import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, usePage, router } from '@inertiajs/react';

export default function Index({ users, rhRoles }) {
    const { flash } = usePage().props;

    function toggleAccess(user, roleId, grant) {
        router.put(route('rh-access.update', user.id), { role_id: roleId, grant }, {
            preserveScroll: true, preserveState: true,
        });
    }

    return (
        <AuthenticatedLayout header={
            <h2 className="text-xl font-semibold leading-tight text-gray-800">Controle de Acesso RH</h2>
        }>
            <Head title="Controle de Acesso RH" />
            <div className="py-8"><div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50"><tr>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nome</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Email</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">CPF</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ativo</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Acesso RH</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                        </tr></thead>
                        <tbody className="divide-y divide-gray-200 bg-white">
                            {users.data.length === 0 ? (
                                <tr><td colSpan="6" className="px-6 py-4 text-center text-sm text-gray-500">Nenhum usuário encontrado.</td></tr>
                            ) : users.data.map((u) => (
                                <tr key={u.id}>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{u.name}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{u.email}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{u.cpf || '-'}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm">{u.is_active ? <span className="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold text-green-800">Sim</span> : 'Não'}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm">{u.has_rh_access ? <span className="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold text-green-800">Sim</span> : <span className="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold text-red-800">Não</span>}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm">
                                        {rhRoles.map(role => (
                                            <button key={role.id} onClick={() => toggleAccess(u, role.id, !u.has_rh_access)}
                                                className={`mr-2 rounded-md px-3 py-1 text-xs font-semibold ${u.has_rh_access ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-100 text-green-700 hover:bg-green-200'}`}>
                                                {u.has_rh_access ? 'Remover' : 'Conceder'} {role.name}
                                            </button>
                                        ))}
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
