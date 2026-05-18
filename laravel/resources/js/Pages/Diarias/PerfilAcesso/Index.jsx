import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, usePage, router } from '@inertiajs/react';

export default function Index({ users }) {
    const { flash } = usePage().props;

    function handleToggle(userId, currentValue) {
        router.put(route('diarias-perfil-acesso.update', userId), {
            can_access_diarias: !currentValue,
        });
    }

    return (
        <AuthenticatedLayout header={
            <h2 className="text-xl font-semibold leading-tight text-gray-800">Perfil de Acesso - Diárias</h2>
        }>
            <Head title="Perfil de Acesso - Diárias" />
            <div className="py-8">
                <div className="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                    {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Usuário</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Email</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Acesso Diárias</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-200 bg-white">
                                {users.data.length === 0 ? (
                                    <tr><td colSpan="3" className="px-6 py-4 text-center text-sm text-gray-500">Nenhum usuário encontrado.</td></tr>
                                ) : users.data.map((u) => (
                                    <tr key={u.id}>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{u.name}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{u.email}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">
                                            <button onClick={() => handleToggle(u.id, u.can_access_diarias)}
                                                className={`rounded-md px-3 py-1 text-xs font-semibold text-white ${u.can_access_diarias ? 'bg-green-600 hover:bg-green-500' : 'bg-gray-400 hover:bg-gray-500'}`}>
                                                {u.can_access_diarias ? 'Liberado' : 'Bloqueado'}
                                            </button>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
