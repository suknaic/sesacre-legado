import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Index({ employmentContract, history }) {
    const { flash } = usePage().props;
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Histórico - {employmentContract.personal_info?.user?.name}</h2>
                <Link href={route('employment-contracts.recruitment-history.create', employmentContract.id)}
                    className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Novo Registro</Link>
            </div>
        }>
            <Head title="Histórico" />
            <div className="py-8"><div className="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}
                <div className="mb-4"><Link href={route('employment-contracts.show', employmentContract.id)} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar ao Contrato</Link></div>

                <div className="space-y-4">
                    {history.length === 0 ? (
                        <div className="rounded-lg bg-white p-6 text-center text-sm text-gray-500 shadow-sm">Nenhum registro histórico encontrado.</div>
                    ) : history.map((h) => (
                        <div key={h.id} className="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                            <div className="flex items-center justify-between">
                                <div className="flex items-center gap-3">
                                    <div className="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-indigo-700">
                                        <span className="text-sm font-bold">{h.contract_situation?.name?.charAt(0) || 'R'}</span>
                                    </div>
                                    <div>
                                        <span className="text-sm font-medium text-gray-900">{h.contract_situation?.name || 'Registro'}</span>
                                        <span className="ml-2 text-xs text-gray-500">{new Date(h.history_date).toLocaleString('pt-BR')}</span>
                                    </div>
                                </div>
                                <div className="flex gap-2">
                                    <Link href={route('employment-contracts.recruitment-history.edit', [employmentContract.id, h.id])}
                                        className="text-xs text-indigo-600 hover:text-indigo-900">Editar</Link>
                                </div>
                            </div>
                            <div className="mt-3 grid grid-cols-3 gap-2 text-xs text-gray-600">
                                {h.organization && <div><span className="font-medium">Organização:</span> {h.organization.name}</div>}
                                {h.job_function && <div><span className="font-medium">Função:</span> {h.job_function.name}</div>}
                                {h.start_date && <div><span className="font-medium">Início:</span> {h.start_date}</div>}
                                {h.end_date && <div><span className="font-medium">Fim:</span> {h.end_date}</div>}
                            </div>
                            {h.observation && <p className="mt-2 text-xs text-gray-500 italic">{h.observation}</p>}
                        </div>
                    ))}
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
