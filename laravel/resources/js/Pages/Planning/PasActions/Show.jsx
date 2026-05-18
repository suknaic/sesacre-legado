import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ pasAction }) {
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Detalhes da Ação do PAS</h2>
                <Link href={route('pas-actions.index')} className="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-500">Voltar</Link>
            </div>
        }>
            <Head title="Detalhes da Ação do PAS" />
            <div className="py-8">
                <div className="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 space-y-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-500">PAS</label>
                                <p className="mt-1 text-sm text-gray-900">{pasAction.annual_plan?.name ?? '---'}</p>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Ação</label>
                                <p className="mt-1 text-sm text-gray-900">{pasAction.plan_action?.name ?? '---'}</p>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-500">PPA Projeto/Atividade</label>
                                <p className="mt-1 text-sm text-gray-900">{pasAction.ppa_project_activity?.name ?? '---'}</p>
                            </div>
                            {pasAction.partnership_desc && (
                                <div>
                                    <label className="block text-sm font-medium text-gray-500">Descrição Parceria</label>
                                    <p className="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{pasAction.partnership_desc}</p>
                                </div>
                            )}
                            {pasAction.programming_goal && (
                                <div>
                                    <label className="block text-sm font-medium text-gray-500">Meta da Programação</label>
                                    <p className="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{pasAction.programming_goal}</p>
                                </div>
                            )}
                            {pasAction.programming_indicator && (
                                <div>
                                    <label className="block text-sm font-medium text-gray-500">Indicador da Programação</label>
                                    <p className="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{pasAction.programming_indicator}</p>
                                </div>
                            )}
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Ativo</label>
                                <p className="mt-1 text-sm">{pasAction.is_active ? <span className="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold text-green-800">Sim</span> : 'Não'}</p>
                            </div>
                            <div className="pt-4">
                                <Link href={route('pas-actions.edit', pasAction.id)} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
