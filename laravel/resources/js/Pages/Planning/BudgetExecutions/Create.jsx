import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ budgetProposals, planActions }) {
    const { data, setData, post, processing, errors } = useForm({
        budget_proposal_id: '',
        plan_action_id: '',
        status: 'not_started',
        executed_amount: '',
        execution_date: '',
        notes: '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('budget-execution.store'));
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Nova Execução Orçamentária</h2>
                <Link href={route('budget-execution.index')} className="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-500">Voltar</Link>
            </div>
        }>
            <Head title="Nova Execução Orçamentária" />
            <div className="py-8">
                <div className="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <form onSubmit={handleSubmit} className="p-6 space-y-6">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Proposta Orçamentária</label>
                                <select value={data.budget_proposal_id} onChange={e => setData('budget_proposal_id', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione...</option>
                                    {budgetProposals.map((bp) => (
                                        <option key={bp.id} value={bp.id}>{bp.year} - {bp.situation || 'Sem situação'}</option>
                                    ))}
                                </select>
                                {errors.budget_proposal_id && <p className="mt-1 text-sm text-red-600">{errors.budget_proposal_id}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Ação (opcional)</label>
                                <select value={data.plan_action_id} onChange={e => setData('plan_action_id', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione...</option>
                                    {planActions.map((pa) => (
                                        <option key={pa.id} value={pa.id}>{pa.name}</option>
                                    ))}
                                </select>
                                {errors.plan_action_id && <p className="mt-1 text-sm text-red-600">{errors.plan_action_id}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Status</label>
                                <select value={data.status} onChange={e => setData('status', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="not_started">Não Iniciado</option>
                                    <option value="in_progress">Em Execução</option>
                                    <option value="partially_completed">Parcialmente Executado</option>
                                    <option value="completed">Executado</option>
                                </select>
                                {errors.status && <p className="mt-1 text-sm text-red-600">{errors.status}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Valor Executado (R$)</label>
                                <input type="number" step="0.01" min="0" value={data.executed_amount} onChange={e => setData('executed_amount', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.executed_amount && <p className="mt-1 text-sm text-red-600">{errors.executed_amount}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Data da Execução</label>
                                <input type="date" value={data.execution_date} onChange={e => setData('execution_date', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.execution_date && <p className="mt-1 text-sm text-red-600">{errors.execution_date}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Observações</label>
                                <textarea value={data.notes} onChange={e => setData('notes', e.target.value)} rows={3} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.notes && <p className="mt-1 text-sm text-red-600">{errors.notes}</p>}
                            </div>
                            <div className="flex items-center gap-4">
                                <button type="submit" disabled={processing} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50">Salvar</button>
                                <Link href={route('budget-execution.index')} className="text-sm text-gray-600 hover:text-gray-900">Cancelar</Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
