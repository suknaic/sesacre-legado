import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ employmentContract }) {
    const c = employmentContract;
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Contrato: {c.registration_number || '#' + c.id}</h2>
                <div className="flex gap-2">
                    <Link href={route('employment-contracts.edit', c.id)}
                        className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link>
                    <Link href={route('employment-contracts.locations.index', c.id)}
                        className="rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-green-500">Lotações</Link>
                    <Link href={route('employment-contracts.recruitment-history.index', c.id)}
                        className="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-500">Histórico</Link>
                </div>
            </div>
        }>
            <Head title={`Contrato ${c.registration_number || '#' + c.id}`} />
            <div className="py-12"><div className="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('employment-contracts.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">Matrícula</dt><dd className="mt-1 text-sm text-gray-900">{c.registration_number || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Funcionário</dt><dd className="mt-1 text-sm text-gray-900">{c.personal_info?.user?.name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">CPF</dt><dd className="mt-1 text-sm text-gray-900">{c.personal_info?.user?.cpf || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Vínculo</dt><dd className="mt-1 text-sm text-gray-900">{c.employment_bond?.name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Cargo</dt><dd className="mt-1 text-sm text-gray-900">{c.job_position?.name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Pessoa Jurídica</dt><dd className="mt-1 text-sm text-gray-900">{c.legal_entity?.name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Data de Admissão</dt><dd className="mt-1 text-sm text-gray-900">{c.admission_date || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Data de Término</dt><dd className="mt-1 text-sm text-gray-900">{c.termination_date || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Carga Horária</dt><dd className="mt-1 text-sm text-gray-900">{c.workload ? c.workload + 'h' : '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Ativo</dt><dd className="mt-1 text-sm text-gray-900">{c.is_active ? 'Sim' : 'Não'}</dd></div>
                            <div className="sm:col-span-2"><dt className="text-sm font-medium text-gray-500">Observações</dt><dd className="mt-1 text-sm text-gray-900">{c.notes || '-'}</dd></div>
                        </dl>
                    </div>
                </div>

                {c.locations && c.locations.length > 0 && (
                    <div className="mt-8">
                        <h3 className="mb-4 text-lg font-medium text-gray-900">Lotações</h3>
                        <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50"><tr>
                                    <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Organização</th>
                                    <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Função</th>
                                    <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">C.H.</th>
                                    <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Início</th>
                                    <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Fim</th>
                                </tr></thead>
                                <tbody className="divide-y divide-gray-200 bg-white">
                                    {c.locations.map((loc) => (
                                        <tr key={loc.id}>
                                            <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-900">{loc.organization?.name || '-'}</td>
                                            <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{loc.job_function?.name || '-'}</td>
                                            <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{loc.workload ? loc.workload + 'h' : '-'}</td>
                                            <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{loc.start_date || '-'}</td>
                                            <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{loc.end_date || '-'}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                )}

                {c.recruitment_history && c.recruitment_history.length > 0 && (
                    <div className="mt-8">
                        <h3 className="mb-4 text-lg font-medium text-gray-900">Histórico / Situações</h3>
                        <div className="space-y-4">
                            {c.recruitment_history.map((h) => (
                                <div key={h.id} className="rounded-lg border border-gray-200 bg-white p-4">
                                    <div className="flex items-center justify-between">
                                        <div>
                                            <span className="text-sm font-medium text-gray-900">{h.contract_situation?.name || 'Registro'}</span>
                                            <span className="ml-2 text-xs text-gray-500">{new Date(h.history_date).toLocaleString('pt-BR')}</span>
                                        </div>
                                    </div>
                                    <div className="mt-2 grid grid-cols-3 gap-2 text-xs text-gray-600">
                                        {h.organization && <div>Organização: {h.organization.name}</div>}
                                        {h.job_function && <div>Função: {h.job_function.name}</div>}
                                        {h.start_date && <div>Início: {h.start_date}</div>}
                                        {h.end_date && <div>Fim: {h.end_date}</div>}
                                    </div>
                                    {h.observation && <p className="mt-1 text-xs text-gray-500">{h.observation}</p>}
                                </div>
                            ))}
                        </div>
                    </div>
                )}
            </div></div>
        </AuthenticatedLayout>
    );
}
