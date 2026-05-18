import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { useState } from 'react';

export default function Edit({ role, systems, users }) {
    const initialUserIds = (role.users || []).map(u => u.id);
    const { data, setData, put, processing, errors } = useForm({
        system_id: role.system_id || '', name: role.name || '', is_active: role.is_active ?? true, user_ids: initialUserIds,
    });
    const [selectedUsers, setSelectedUsers] = useState(initialUserIds);

    function toggleUser(id) {
        setSelectedUsers(prev => prev.includes(id) ? prev.filter(u => u !== id) : [...prev, id]);
    }

    function handleSubmit(e) {
        e.preventDefault();
        setData('user_ids', selectedUsers);
        put(route('roles.update', role.id));
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Editar Perfil de Acesso</h2>
                <Link href={route('roles.index')} className="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-500">Voltar</Link>
            </div>
        }>
            <Head title="Editar Perfil de Acesso" />
            <div className="py-8"><div className="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6 space-y-6">
                        <div>
                            <label className="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" value={data.name} onChange={e => setData('name', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            {errors.name && <p className="mt-1 text-sm text-red-600">{errors.name}</p>}
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-gray-700">Sistema</label>
                            <select value={data.system_id} onChange={e => setData('system_id', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione...</option>
                                {systems.map(s => <option key={s.id} value={s.id}>{s.name}</option>)}
                            </select>
                            {errors.system_id && <p className="mt-1 text-sm text-red-600">{errors.system_id}</p>}
                        </div>
                        <div>
                            <label className="flex items-center gap-2">
                                <input type="checkbox" checked={data.is_active} onChange={e => setData('is_active', e.target.checked)}
                                    className="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                <span className="text-sm text-gray-700">Ativo</span>
                            </label>
                        </div>
                        <div>
                            <h3 className="text-sm font-medium text-gray-700 mb-2">Usuários com este perfil</h3>
                            <div className="max-h-48 overflow-y-auto border rounded-md divide-y">
                                {users.map(u => (
                                    <label key={u.id} className="flex items-center gap-2 p-2 hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" checked={selectedUsers.includes(u.id)} onChange={() => toggleUser(u.id)}
                                            className="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                        <span className="text-sm text-gray-900">{u.name}</span>
                                        <span className="text-xs text-gray-500">({u.email})</span>
                                    </label>
                                ))}
                            </div>
                            {errors.user_ids && <p className="mt-1 text-sm text-red-600">{errors.user_ids}</p>}
                        </div>
                        <div className="flex items-center gap-4">
                            <button type="submit" disabled={processing} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50">Salvar</button>
                            <Link href={route('roles.index')} className="text-sm text-gray-600 hover:text-gray-900">Cancelar</Link>
                        </div>
                    </form>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
