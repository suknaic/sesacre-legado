import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ employmentContract, recruitmentHistory }) {
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Registro Histórico - {employmentContract.personal_info?.user?.name}</h2>
                <Link href={route('employment-contracts.recruitment-history.edit', [employmentContract.id, recruitmentHistory.id])} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link>
            </div>
        }>
            <Head title="Registro Histórico" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('employment-contracts.recruitment-history.index', employmentContract.id)} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">Situação</dt><dd className="mt-1 text-sm text-gray-900">{recruitmentHistory.contract_situation?.name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Organização</dt><dd className="mt-1 text-sm text-gray-900">{recruitmentHistory.organization?.name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Função</dt><dd className="mt-1 text-sm text-gray-900">{recruitmentHistory.job_function?.name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Data do Histórico</dt><dd className="mt-1 text-sm text-gray-900">{recruitmentHistory.history_date ? new Date(recruitmentHistory.history_date).toLocaleString('pt-BR') : '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Início</dt><dd className="mt-1 text-sm text-gray-900">{recruitmentHistory.start_date || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Fim</dt><dd className="mt-1 text-sm text-gray-900">{recruitmentHistory.end_date || '-'}</dd></div>
                            <div className="sm:col-span-2"><dt className="text-sm font-medium text-gray-500">Observação</dt><dd className="mt-1 text-sm text-gray-900">{recruitmentHistory.observation || '-'}</dd></div>
                        </dl>
                    </div>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
