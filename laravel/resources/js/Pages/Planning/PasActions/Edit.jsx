import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Edit({ pasAction, annualPlans, planActions, ppaProjectActivities }) {
    const { data, setData, put, processing, errors } = useForm({
        annual_plan_id: pasAction.annual_plan_id?.toString() || '',
        plan_action_id: pasAction.plan_action_id?.toString() || '',
        ppa_project_activity_id: pasAction.ppa_project_activity_id?.toString() || '',
        partnership_desc: pasAction.partnership_desc || '',
        programming_goal: pasAction.programming_goal || '',
        programming_indicator: pasAction.programming_indicator || '',
        is_active: pasAction.is_active,
    });

    function handleSubmit(e) {
        e.preventDefault();
        put(route('pas-actions.update', pasAction.id));
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Editar Ação do PAS</h2>
                <Link href={route('pas-actions.index')} className="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-500">Voltar</Link>
            </div>
        }>
            <Head title="Editar Ação do PAS" />
            <div className="py-8">
                <div className="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <form onSubmit={handleSubmit} className="p-6 space-y-6">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">PAS (Plano Anual)</label>
                                <select value={data.annual_plan_id} onChange={e => setData('annual_plan_id', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione...</option>
                                    {annualPlans.map((ap) => (
                                        <option key={ap.id} value={ap.id}>{ap.name}</option>
                                    ))}
                                </select>
                                {errors.annual_plan_id && <p className="mt-1 text-sm text-red-600">{errors.annual_plan_id}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Ação</label>
                                <select value={data.plan_action_id} onChange={e => setData('plan_action_id', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione...</option>
                                    {planActions.map((pa) => (
                                        <option key={pa.id} value={pa.id}>{pa.name}</option>
                                    ))}
                                </select>
                                {errors.plan_action_id && <p className="mt-1 text-sm text-red-600">{errors.plan_action_id}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">PPA Projeto/Atividade</label>
                                <select value={data.ppa_project_activity_id} onChange={e => setData('ppa_project_activity_id', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione...</option>
                                    {ppaProjectActivities.map((ppa) => (
                                        <option key={ppa.id} value={ppa.id}>{ppa.name}</option>
                                    ))}
                                </select>
                                {errors.ppa_project_activity_id && <p className="mt-1 text-sm text-red-600">{errors.ppa_project_activity_id}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Descrição Parceria</label>
                                <textarea value={data.partnership_desc} onChange={e => setData('partnership_desc', e.target.value)} rows={2} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.partnership_desc && <p className="mt-1 text-sm text-red-600">{errors.partnership_desc}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Meta da Programação</label>
                                <textarea value={data.programming_goal} onChange={e => setData('programming_goal', e.target.value)} rows={2} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.programming_goal && <p className="mt-1 text-sm text-red-600">{errors.programming_goal}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Indicador da Programação</label>
                                <textarea value={data.programming_indicator} onChange={e => setData('programming_indicator', e.target.value)} rows={2} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.programming_indicator && <p className="mt-1 text-sm text-red-600">{errors.programming_indicator}</p>}
                            </div>
                            <div className="flex items-center gap-2">
                                <input type="checkbox" checked={data.is_active} onChange={e => setData('is_active', e.target.checked)} className="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                <label className="text-sm font-medium text-gray-700">Ativo</label>
                            </div>
                            <div className="flex items-center gap-4">
                                <button type="submit" disabled={processing} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50">Salvar</button>
                                <Link href={route('pas-actions.index')} className="text-sm text-gray-600 hover:text-gray-900">Cancelar</Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
