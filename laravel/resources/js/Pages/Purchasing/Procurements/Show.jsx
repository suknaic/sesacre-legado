import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ procurement }) {
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Processo {procurement.ada_code || `#${procurement.id}`}
                </h2>
            }
        >
            <Head title={`Processo ${procurement.ada_code || `#${procurement.id}`}`} />

            <div className="py-12">
                <div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                    <div className="mb-4">
                        <Link
                            href={route('procurements.index')}
                            className="text-sm text-indigo-600 hover:text-indigo-900"
                        >
                            &larr; Voltar
                        </Link>
                    </div>

                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="border-b border-gray-200 px-6 py-4">
                            <h3 className="text-lg font-medium text-gray-900">Detalhes do Processo</h3>
                        </div>

                        <div className="p-6">
                            <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <dt className="text-sm font-medium text-gray-500">Código ADA</dt>
                                    <dd className="mt-1 text-sm text-gray-900">{procurement.ada_code || '-'}</dd>
                                </div>
                                <div>
                                    <dt className="text-sm font-medium text-gray-500">Código Leilão</dt>
                                    <dd className="mt-1 text-sm text-gray-900">{procurement.auction_code || '-'}</dd>
                                </div>
                                <div>
                                    <dt className="text-sm font-medium text-gray-500">Modalidade</dt>
                                    <dd className="mt-1 text-sm text-gray-900">{procurement.modality?.name || '-'}</dd>
                                </div>
                                <div>
                                    <dt className="text-sm font-medium text-gray-500">Objeto</dt>
                                    <dd className="mt-1 text-sm text-gray-900">{procurement.object?.name || '-'}</dd>
                                </div>
                                <div>
                                    <dt className="text-sm font-medium text-gray-500">Situação</dt>
                                    <dd className="mt-1 text-sm text-gray-900">{procurement.situation?.name || '-'}</dd>
                                </div>
                                <div>
                                    <dt className="text-sm font-medium text-gray-500">Ano</dt>
                                    <dd className="mt-1 text-sm text-gray-900">{procurement.year || '-'}</dd>
                                </div>
                                <div>
                                    <dt className="text-sm font-medium text-gray-500">Gestor Técnico</dt>
                                    <dd className="mt-1 text-sm text-gray-900">{procurement.technical_manager || '-'}</dd>
                                </div>
                                <div>
                                    <dt className="text-sm font-medium text-gray-500">Valor Estimado</dt>
                                    <dd className="mt-1 text-sm text-gray-900">
                                        {new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(procurement.estimated_total || 0)}
                                    </dd>
                                </div>
                                <div>
                                    <dt className="text-sm font-medium text-gray-500">Valor Adjudicado</dt>
                                    <dd className="mt-1 text-sm text-gray-900">
                                        {new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(procurement.adjudicated_total || 0)}
                                    </dd>
                                </div>
                                <div>
                                    <dt className="text-sm font-medium text-gray-500">Data do Processo</dt>
                                    <dd className="mt-1 text-sm text-gray-900">{procurement.process_date || '-'}</dd>
                                </div>
                                <div>
                                    <dt className="text-sm font-medium text-gray-500">Ativo</dt>
                                    <dd className="mt-1 text-sm">
                                        {procurement.is_active ? (
                                            <span className="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">Sim</span>
                                        ) : (
                                            <span className="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">Não</span>
                                        )}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div className="mt-6 flex gap-4">
                        <Link
                            href={route('procurements.edit', procurement.id)}
                            className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500"
                        >
                            Editar
                        </Link>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
