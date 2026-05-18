import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { useState } from 'react';

export default function Create({ systems }) {
    const { data, setData, post, processing, errors } = useForm({
        system_id: '', name: '', is_active: true, user_ids: [],
    });
    const [selectedUsers, setSelectedUsers] = useState([]);

    function toggleUser(id) {
        setSelectedUsers(prev => prev.includes(id) ? prev.filter(u => u !== id) : [...prev, id]);
    }

    function handleSubmit(e) {
        e.preventDefault();
        setData('user_ids', selectedUsers);
        post(route('roles.store'));
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Novo Perfil de Acesso</h2>
                <Link href={route('roles.index')} className="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-500">Voltar</Link>
            </div>
        }>
            <Head title="Novo Perfil de Acesso" />
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
