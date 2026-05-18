import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Edit({ resource, systems }) {
    const { data, setData, put, processing, errors } = useForm({
        system_id: resource.system_id || '',
        name: resource.name || '',
        route: resource.route || '',
        description: resource.description || '',
        is_active: resource.is_active ?? true,
    });

    function handleSubmit(e) {
        e.preventDefault();
        put(route('resources.update', resource.id));
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Editar Recurso</h2>
                <Link href={route('resources.index')} className="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-500">Voltar</Link>
            </div>
        }>
            <Head title="Editar Recurso" />
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
                            <label className="block text-sm font-medium text-gray-700">Rota</label>
                            <input type="text" value={data.route} onChange={e => setData('route', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            {errors.route && <p className="mt-1 text-sm text-red-600">{errors.route}</p>}
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea rows={3} value={data.description} onChange={e => setData('description', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            {errors.description && <p className="mt-1 text-sm text-red-600">{errors.description}</p>}
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
                            <Link href={route('resources.index')} className="text-sm text-gray-600 hover:text-gray-900">Cancelar</Link>
                        </div>
                    </form>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
