import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';

const statusLabels = {
    not_started: 'Não Iniciado',
    in_progress: 'Em Execução',
    partially_completed: 'Parcialmente Executado',
    completed: 'Executado',
};

const statusColors = {
    not_started: 'bg-gray-100 text-gray-800',
    in_progress: 'bg-blue-100 text-blue-800',
    partially_completed: 'bg-yellow-100 text-yellow-800',
    completed: 'bg-green-100 text-green-800',
};

export default function Index({ executions, summary, budgetProposals, planActions }) {
    const { flash } = usePage().props;
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Execução Orçamentária</h2>
                <Link href={route('budget-execution.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Nova Execução</Link>
            </div>
        }>
            <Head title="Execução Orçamentária" />
            <div className="py-8">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}

                    <div className="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
                        <div className="rounded-lg bg-white p-4 shadow-sm">
                            <p className="text-sm text-gray-500">Total de Registros</p>
                            <p className="text-2xl font-bold text-gray-900">{summary.total}</p>
                        </div>
                        <div className="rounded-lg bg-white p-4 shadow-sm">
                            <p className="text-sm text-gray-500">Valor Total Executado</p>
                            <p className="text-2xl font-bold text-gray-900">{Number(summary.total_executed).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}</p>
                        </div>
                        <div className="rounded-lg bg-white p-4 shadow-sm">
                            <p className="text-sm text-gray-500">Não Iniciado</p>
                            <p className="text-2xl font-bold text-gray-700">{summary.by_status.not_started}</p>
                        </div>
                        <div className="rounded-lg bg-white p-4 shadow-sm">
                            <p className="text-sm text-gray-500">Em Execução</p>
                            <p className="text-2xl font-bold text-blue-700">{summary.by_status.in_progress}</p>
                        </div>
                        <div className="rounded-lg bg-white p-4 shadow-sm">
                            <p className="text-sm text-gray-500">Concluído</p>
                            <p className="text-2xl font-bold text-green-700">{summary.by_status.completed}</p>
                        </div>
                    </div>

                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Proposta</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ação</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Valor Executado</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Data</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-200 bg-white">
                                {executions.data.length === 0 ? (
                                    <tr><td colSpan="6" className="px-6 py-4 text-center text-sm text-gray-500">Nenhum registro de execução encontrado.</td></tr>
                                ) : executions.data.map((e) => (
                                    <tr key={e.id}>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{e.budget_proposal?.year ?? '---'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{e.plan_action?.name ?? '---'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">
                                            <span className={`inline-flex rounded-full px-2 text-xs font-semibold ${statusColors[e.status] || 'bg-gray-100 text-gray-800'}`}>
                                                {statusLabels[e.status] || e.status}
                                            </span>
                                        </td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{Number(e.executed_amount).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{e.execution_date}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">
                                            <Link href={route('budget-execution.show', e.id)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                            <Link href={route('budget-execution.edit', e.id)} className="ml-3 text-indigo-600 hover:text-indigo-900">Editar</Link>
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
