import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ perDiemRequest }) {
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Solicitação de Diária #{perDiemRequest.id}</h2>}>
            <Head title={`Solicitação de Diária #${perDiemRequest.id}`} />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('per-diem-requests.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="border-b border-gray-200 px-6 py-4">
                        <h3 className="text-lg font-medium text-gray-900">Detalhes da Solicitação</h3>
                    </div>
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">ID</dt><dd className="mt-1 text-sm text-gray-900">{perDiemRequest.id}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Tipo de Viagem</dt><dd className="mt-1 text-sm text-gray-900">{perDiemRequest.travel_type?.name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Tipo de Transporte</dt><dd className="mt-1 text-sm text-gray-900">{perDiemRequest.transport_type?.name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Tipo de Decreto</dt><dd className="mt-1 text-sm text-gray-900">{perDiemRequest.decree_type?.name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Classe de Viagem</dt><dd className="mt-1 text-sm text-gray-900">{perDiemRequest.travel_class?.name || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Locais</dt><dd className="mt-1 text-sm text-gray-900">{perDiemRequest.locations || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Data de Criação</dt><dd className="mt-1 text-sm text-gray-900">{perDiemRequest.created_at || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Ativo</dt><dd className="mt-1 text-sm text-gray-900">{perDiemRequest.is_active ? 'Sim' : 'Não'}</dd></div>
                        </dl>
                        <div className="mt-6">
                            <dt className="text-sm font-medium text-gray-500">Descrição do Serviço</dt>
                            <dd className="mt-1 text-sm text-gray-900">{perDiemRequest.service_description || 'Sem descrição'}</dd>
                        </div>
                        <div className="mt-6">
                            <dt className="text-sm font-medium text-gray-500">Observações</dt>
                            <dd className="mt-1 text-sm text-gray-900">{perDiemRequest.notes || 'Sem observações'}</dd>
                        </div>
                    </div>
                </div>
                <div className="mt-6">
                    <Link href={route('per-diem-requests.edit', perDiemRequest.id)}
                        className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
