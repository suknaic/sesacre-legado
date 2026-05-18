import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { useState } from 'react';

export default function Edit({ group, resources }) {
    const initialSelected = (group.resources || []).map(r => ({
        id: r.id,
        can_create: r.pivot?.can_create ?? false,
        can_edit: r.pivot?.can_edit ?? false,
        can_delete: r.pivot?.can_delete ?? false,
    }));

    const { data, setData, put, processing, errors } = useForm({
        name: group.name || '',
        is_active: group.is_active ?? true,
        resources: initialSelected,
    });
    const [selectedResources, setSelectedResources] = useState(initialSelected);

    function toggleResource(id) {
        setSelectedResources(prev => {
            const exists = prev.find(r => r.id === id);
            if (exists) return prev.filter(r => r.id !== id);
            return [...prev, { id, can_create: false, can_edit: false, can_delete: false }];
        });
    }

    function setResourcePerm(id, field, value) {
        setSelectedResources(prev => prev.map(r => r.id === id ? { ...r, [field]: value } : r));
    }

    function handleSubmit(e) {
        e.preventDefault();
        setData('resources', selectedResources);
        put(route('permission-groups.update', group.id));
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Editar Grupo de Recursos</h2>
                <Link href={route('permission-groups.index')} className="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-500">Voltar</Link>
            </div>
        }>
            <Head title="Editar Grupo de Recursos" />
            <div className="py-8"><div className="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6 space-y-6">
                        <div>
                            <label className="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" value={data.name} onChange={e => setData('name', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            {errors.name && <p className="mt-1 text-sm text-red-600">{errors.name}</p>}
                        </div>
                        <div>
                            <label className="flex items-center gap-2">
                                <input type="checkbox" checked={data.is_active} onChange={e => setData('is_active', e.target.checked)}
                                    className="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                <span className="text-sm text-gray-700">Ativo</span>
                            </label>
                        </div>
                        <div>
                            <h3 className="text-sm font-medium text-gray-700 mb-2">Recursos e Permissões</h3>
                            <div className="max-h-64 overflow-y-auto border rounded-md divide-y">
                                {resources.map(r => {
                                    const sel = selectedResources.find(sr => sr.id === r.id);
                                    return (
                                        <div key={r.id} className="p-3 flex items-center gap-4">
                                            <label className="flex items-center gap-2 w-40">
                                                <input type="checkbox" checked={!!sel}
                                                    onChange={() => toggleResource(r.id)}
                                                    className="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                                <span className="text-sm text-gray-900">{r.name}</span>
                                            </label>
                                            {sel && (
                                                <div className="flex gap-4">
                                                    <label className="flex items-center gap-1 text-xs text-gray-600">
                                                        <input type="checkbox" checked={sel.can_create} onChange={e => setResourcePerm(r.id, 'can_create', e.target.checked)}
                                                            className="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />Criar
                                                    </label>
                                                    <label className="flex items-center gap-1 text-xs text-gray-600">
                                                        <input type="checkbox" checked={sel.can_edit} onChange={e => setResourcePerm(r.id, 'can_edit', e.target.checked)}
                                                            className="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />Editar
                                                    </label>
                                                    <label className="flex items-center gap-1 text-xs text-gray-600">
                                                        <input type="checkbox" checked={sel.can_delete} onChange={e => setResourcePerm(r.id, 'can_delete', e.target.checked)}
                                                            className="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />Excluir
                                                    </label>
                                                </div>
                                            )}
                                        </div>
                                    );
                                })}
                            </div>
                        </div>
                        <div className="flex items-center gap-4">
                            <button type="submit" disabled={processing} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50">Salvar</button>
                            <Link href={route('permission-groups.index')} className="text-sm text-gray-600 hover:text-gray-900">Cancelar</Link>
                        </div>
                    </form>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
