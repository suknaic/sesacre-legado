import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ budgetProposal }) {
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Proposta Orçamentária</h2>
                <Link href={route('budget-proposals.edit', budgetProposal.id)} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link>
            </div>
        }>
            <Head title="Proposta Orçamentária" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('budget-proposals.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">Ano</dt><dd className="mt-1 text-sm text-gray-900">{budgetProposal.year || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Situação</dt><dd className="mt-1 text-sm text-gray-900">{budgetProposal.situation || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Ativo</dt><dd className="mt-1 text-sm text-gray-900">{budgetProposal.is_active ? 'Sim' : 'Não'}</dd></div>
                        </dl>
                    </div>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
