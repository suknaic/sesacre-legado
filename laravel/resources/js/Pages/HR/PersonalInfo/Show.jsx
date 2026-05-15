import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ personalInfo, contracts = [] }) {
    function formatCpf(cpf) {
        if (!cpf) return '-';
        const c = cpf.replace(/\D/g, '');
        if (c.length !== 11) return cpf;
        return c.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
    }

    function formatRg(rg) {
        if (!rg) return '-';
        const r = rg.replace(/\D/g, '');
        if (r.length !== 9) return rg;
        return r.replace(/(\d{2})(\d{3})(\d{3})(\d{1})/, '$1.$2.$3-$4');
    }

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">{personalInfo.user?.name || 'Funcionário'}</h2>}>
            <Head title={personalInfo.user?.name || 'Funcionário'} />
            <div className="py-12"><div className="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('personal-info.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <div className="mb-4 flex items-center justify-between">
                            <h3 className="text-lg font-medium text-gray-900">Dados do Funcionário</h3>
                            <Link href={route('personal-info.edit', personalInfo.id)}
                                className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link>
                        </div>

                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <div>
                                <dt className="text-sm font-medium text-gray-500">Nome</dt>
                                <dd className="mt-1 text-sm text-gray-900">{personalInfo.user?.name || '-'}</dd>
                            </div>
                            <div>
                                <dt className="text-sm font-medium text-gray-500">CPF</dt>
                                <dd className="mt-1 text-sm text-gray-900">{formatCpf(personalInfo.user?.cpf)}</dd>
                            </div>
                            <div>
                                <dt className="text-sm font-medium text-gray-500">E-mail</dt>
                                <dd className="mt-1 text-sm text-gray-900">{personalInfo.user?.email || '-'}</dd>
                            </div>
                            <div>
                                <dt className="text-sm font-medium text-gray-500">Telefone</dt>
                                <dd className="mt-1 text-sm text-gray-900">{personalInfo.user?.phone || '-'}</dd>
                            </div>
                            <div>
                                <dt className="text-sm font-medium text-gray-500">Celular</dt>
                                <dd className="mt-1 text-sm text-gray-900">{personalInfo.user?.mobile || '-'}</dd>
                            </div>
                            <div>
                                <dt className="text-sm font-medium text-gray-500">Endereço</dt>
                                <dd className="mt-1 text-sm text-gray-900">{personalInfo.user?.address || '-'}</dd>
                            </div>
                            <div>
                                <dt className="text-sm font-medium text-gray-500">Bairro</dt>
                                <dd className="mt-1 text-sm text-gray-900">{personalInfo.user?.neighborhood || '-'}</dd>
                            </div>
                            <div>
                                <dt className="text-sm font-medium text-gray-500">CEP</dt>
                                <dd className="mt-1 text-sm text-gray-900">{personalInfo.user?.zip_code || '-'}</dd>
                            </div>
                            <div>
                                <dt className="text-sm font-medium text-gray-500">Cidade</dt>
                                <dd className="mt-1 text-sm text-gray-900">{personalInfo.user?.city?.name || '-'}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <h3 className="mb-4 text-lg font-medium text-gray-900">Dados Pessoais</h3>
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <div>
                                <dt className="text-sm font-medium text-gray-500">Sexo</dt>
                                <dd className="mt-1 text-sm text-gray-900">{personalInfo.gender || '-'}</dd>
                            </div>
                            <div>
                                <dt className="text-sm font-medium text-gray-500">RG</dt>
                                <dd className="mt-1 text-sm text-gray-900">{formatRg(personalInfo.rg)}</dd>
                            </div>
                            <div>
                                <dt className="text-sm font-medium text-gray-500">Órgão Expedidor</dt>
                                <dd className="mt-1 text-sm text-gray-900">{personalInfo.issuing_agency || '-'}</dd>
                            </div>
                            <div>
                                <dt className="text-sm font-medium text-gray-500">UF do Órgão</dt>
                                <dd className="mt-1 text-sm text-gray-900">{personalInfo.issuing_state?.name || '-'}</dd>
                            </div>
                            <div>
                                <dt className="text-sm font-medium text-gray-500">Estado Civil</dt>
                                <dd className="mt-1 text-sm text-gray-900">{personalInfo.marital_status?.name || '-'}</dd>
                            </div>
                            <div>
                                <dt className="text-sm font-medium text-gray-500">Formação</dt>
                                <dd className="mt-1 text-sm text-gray-900">{personalInfo.education_formation?.name || '-'}</dd>
                            </div>
                            <div>
                                <dt className="text-sm font-medium text-gray-500">Data de Nascimento</dt>
                                <dd className="mt-1 text-sm text-gray-900">{personalInfo.birth_date || '-'}</dd>
                            </div>
                            <div>
                                <dt className="text-sm font-medium text-gray-500">Nome do Pai</dt>
                                <dd className="mt-1 text-sm text-gray-900">{personalInfo.father_name || '-'}</dd>
                            </div>
                            <div>
                                <dt className="text-sm font-medium text-gray-500">Nome da Mãe</dt>
                                <dd className="mt-1 text-sm text-gray-900">{personalInfo.mother_name || '-'}</dd>
                            </div>
                            <div>
                                <dt className="text-sm font-medium text-gray-500">CNS</dt>
                                <dd className="mt-1 text-sm text-gray-900">{personalInfo.cns_number || '-'}</dd>
                            </div>
                            <div>
                                <dt className="text-sm font-medium text-gray-500">Ativo</dt>
                                <dd className="mt-1 text-sm">{personalInfo.is_active ? <span className="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold text-green-800">Sim</span> : <span className="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold text-red-800">Não</span>}</dd>
                            </div>
                        </dl>
                        {personalInfo.skills && (
                            <div className="mt-4">
                                <dt className="text-sm font-medium text-gray-500">Habilidades</dt>
                                <dd className="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{personalInfo.skills}</dd>
                            </div>
                        )}
                    </div>
                </div>

                {contracts.length > 0 && (
                    <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <h3 className="mb-4 text-lg font-medium text-gray-900">Contratos</h3>
                            <div className="overflow-x-auto">
                                <table className="min-w-full divide-y divide-gray-200">
                                    <thead className="bg-gray-50"><tr>
                                        <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Matrícula</th>
                                        <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Vínculo</th>
                                        <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Cargo</th>
                                        <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Admissão</th>
                                        <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Término</th>
                                        <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">C.H.</th>
                                        <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ativo</th>
                                        <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                                    </tr></thead>
                                    <tbody className="divide-y divide-gray-200 bg-white">
                                        {contracts.map((c) => (
                                            <tr key={c.id}>
                                                <td className="whitespace-nowrap px-4 py-3 text-sm font-medium text-gray-900">{c.registration_number || '-'}</td>
                                                <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{c.employment_bond?.name || '-'}</td>
                                                <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{c.job_position?.name || '-'}</td>
                                                <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{c.admission_date || '-'}</td>
                                                <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{c.termination_date || '-'}</td>
                                                <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{c.workload ? `${c.workload}h` : '-'}</td>
                                                <td className="whitespace-nowrap px-4 py-3 text-sm">{c.is_active ? <span className="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold text-green-800">Sim</span> : <span className="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold text-red-800">Não</span>}</td>
                                                <td className="whitespace-nowrap px-4 py-3 text-sm">
                                                    <Link href={route('employment-contracts.show', c.id)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                )}
            </div></div>
        </AuthenticatedLayout>
    );
}
