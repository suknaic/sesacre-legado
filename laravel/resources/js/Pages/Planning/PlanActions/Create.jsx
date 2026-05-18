import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ objectives }) {
    const { data, setData, post, processing, errors } = useForm({
        plan_objective_id: '', name: '', indicator: '', goal: '', registration_type: '', is_active: true,
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('plan-actions.store'));
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Nova Ação</h2>
                <Link href={route('plan-actions.index')} className="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-500">Voltar</Link>
            </div>
        }>
            <Head title="Nova Ação" />
            <div className="py-8">
                <div className="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <form onSubmit={handleSubmit} className="p-6 space-y-6">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Objetivo</label>
                                <select value={data.plan_objective_id} onChange={e => setData('plan_objective_id', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione...</option>
                                    {objectives.map(o => <option key={o.id} value={o.id}>{o.name}</option>)}
                                </select>
                                {errors.plan_objective_id && <p className="mt-1 text-sm text-red-600">{errors.plan_objective_id}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Nome</label>
                                <input type="text" value={data.name} onChange={e => setData('name', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.name && <p className="mt-1 text-sm text-red-600">{errors.name}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Indicador</label>
                                <input type="text" value={data.indicator} onChange={e => setData('indicator', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.indicator && <p className="mt-1 text-sm text-red-600">{errors.indicator}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Meta</label>
                                <textarea value={data.goal} onChange={e => setData('goal', e.target.value)} rows={3} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.goal && <p className="mt-1 text-sm text-red-600">{errors.goal}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Tipo de Cadastro</label>
                                <select value={data.registration_type} onChange={e => setData('registration_type', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione...</option>
                                    <option value="PPA">PPA</option>
                                    <option value="PES">PES</option>
                                    <option value="PAS">PAS</option>
                                </select>
                                {errors.registration_type && <p className="mt-1 text-sm text-red-600">{errors.registration_type}</p>}
                            </div>
                            <div className="flex items-center gap-2">
                                <input type="checkbox" checked={data.is_active} onChange={e => setData('is_active', e.target.checked)} className="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                <label className="text-sm font-medium text-gray-700">Ativo</label>
                            </div>
                            <div className="flex items-center gap-4">
                                <button type="submit" disabled={processing} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50">Salvar</button>
                                <Link href={route('plan-actions.index')} className="text-sm text-gray-600 hover:text-gray-900">Cancelar</Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
