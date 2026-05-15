import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ personalInfo }) {
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">{personalInfo.user?.name || 'Funcionário'}</h2>}>
            <Head title={personalInfo.user?.name || 'Funcionário'} />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('personal-info.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">Usuário</dt><dd className="mt-1 text-sm text-gray-900">{personalInfo.user?.name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">CPF</dt><dd className="mt-1 text-sm text-gray-900">{personalInfo.user?.cpf || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Gênero</dt><dd className="mt-1 text-sm text-gray-900">{personalInfo.gender || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">RG</dt><dd className="mt-1 text-sm text-gray-900">{personalInfo.rg || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Órgão Expedidor</dt><dd className="mt-1 text-sm text-gray-900">{personalInfo.issuing_agency || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">UF do Órgão Expedidor</dt><dd className="mt-1 text-sm text-gray-900">{personalInfo.issuing_state?.name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Estado Civil</dt><dd className="mt-1 text-sm text-gray-900">{personalInfo.marital_status?.name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Formação</dt><dd className="mt-1 text-sm text-gray-900">{personalInfo.education_formation?.name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Nome do Pai</dt><dd className="mt-1 text-sm text-gray-900">{personalInfo.father_name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Nome da Mãe</dt><dd className="mt-1 text-sm text-gray-900">{personalInfo.mother_name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Data de Nascimento</dt><dd className="mt-1 text-sm text-gray-900">{personalInfo.birth_date || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">CNS</dt><dd className="mt-1 text-sm text-gray-900">{personalInfo.cns_number || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Habilidades</dt><dd className="mt-1 text-sm text-gray-900">{personalInfo.skills || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Ativo</dt><dd className="mt-1 text-sm text-gray-900">{personalInfo.is_active ? 'Sim' : 'Não'}</dd></div>
                        </dl>
                    </div>
                </div>
                <div className="mt-6"><Link href={route('personal-info.edit', personalInfo.id)}
                    className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link></div>
            </div></div>
        </AuthenticatedLayout>
    );
}
