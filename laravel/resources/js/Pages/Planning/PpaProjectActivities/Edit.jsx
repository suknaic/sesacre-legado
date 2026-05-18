import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Edit({ ppaProjectActivity, strategicPlans }) {
    const { data, setData, put, processing, errors } = useForm({
        strategic_plan_id: ppaProjectActivity.strategic_plan_id || '',
        code: ppaProjectActivity.code || '',
        name: ppaProjectActivity.name || '',
        type: ppaProjectActivity.type || 'P',
        is_active: ppaProjectActivity.is_active,
    });

    function handleSubmit(e) {
        e.preventDefault();
        put(route('ppa-project-activities.update', ppaProjectActivity.id));
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Editar Projeto/Atividade</h2>
                <Link href={route('ppa-project-activities.index')} className="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-500">Voltar</Link>
            </div>
        }>
            <Head title="Editar Projeto/Atividade" />
            <div className="py-8">
                <div className="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <form onSubmit={handleSubmit} className="p-6 space-y-6">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">PPA</label>
                                <select value={data.strategic_plan_id} onChange={e => setData('strategic_plan_id', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione...</option>
                                    {strategicPlans.map(p => <option key={p.id} value={p.id}>{p.name}</option>)}
                                </select>
                                {errors.strategic_plan_id && <p className="mt-1 text-sm text-red-600">{errors.strategic_plan_id}</p>}
                            </div>
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Código</label>
                                    <input type="text" value={data.code} onChange={e => setData('code', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                    {errors.code && <p className="mt-1 text-sm text-red-600">{errors.code}</p>}
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Nome</label>
                                    <input type="text" value={data.name} onChange={e => setData('name', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                    {errors.name && <p className="mt-1 text-sm text-red-600">{errors.name}</p>}
                                </div>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2">Tipo</label>
                                <div className="flex gap-4">
                                    <label className="flex items-center gap-2">
                                        <input type="radio" checked={data.type === 'P'} onChange={() => setData('type', 'P')}
                                            className="text-indigo-600 focus:ring-indigo-500" />
                                        <span className="text-sm text-gray-700">Projeto</span>
                                    </label>
                                    <label className="flex items-center gap-2">
                                        <input type="radio" checked={data.type === 'A'} onChange={() => setData('type', 'A')}
                                            className="text-indigo-600 focus:ring-indigo-500" />
                                        <span className="text-sm text-gray-700">Atividade</span>
                                    </label>
                                </div>
                                {errors.type && <p className="mt-1 text-sm text-red-600">{errors.type}</p>}
                            </div>
                            <div className="flex items-center gap-2">
                                <input type="checkbox" checked={data.is_active} onChange={e => setData('is_active', e.target.checked)}
                                    className="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                <label className="text-sm font-medium text-gray-700">Ativo</label>
                            </div>
                            <div className="flex items-center gap-4">
                                <button type="submit" disabled={processing}
                                    className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50">Salvar</button>
                                <Link href={route('ppa-project-activities.index')} className="text-sm text-gray-600 hover:text-gray-900">Cancelar</Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
