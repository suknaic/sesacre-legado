import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

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

export default function Show({ execution }) {
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Detalhes da Execução Orçamentária</h2>
                <Link href={route('budget-execution.index')} className="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-500">Voltar</Link>
            </div>
        }>
            <Head title="Detalhes da Execução Orçamentária" />
            <div className="py-8">
                <div className="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 space-y-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Proposta Orçamentária</label>
                                <p className="mt-1 text-sm text-gray-900">{execution.budget_proposal?.year ?? '---'}</p>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Ação</label>
                                <p className="mt-1 text-sm text-gray-900">{execution.plan_action?.name ?? '---'}</p>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Status</label>
                                <p className="mt-1">
                                    <span className={`inline-flex rounded-full px-2 text-xs font-semibold ${statusColors[execution.status] || 'bg-gray-100 text-gray-800'}`}>
                                        {statusLabels[execution.status] || execution.status}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Valor Executado</label>
                                <p className="mt-1 text-sm text-gray-900">{Number(execution.executed_amount).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}</p>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Data da Execução</label>
                                <p className="mt-1 text-sm text-gray-900">{execution.execution_date}</p>
                            </div>
                            {execution.notes && (
                                <div>
                                    <label className="block text-sm font-medium text-gray-500">Observações</label>
                                    <p className="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{execution.notes}</p>
                                </div>
                            )}
                            <div className="pt-4">
                                <Link href={route('budget-execution.edit', execution.id)} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
