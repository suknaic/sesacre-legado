import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ purchaseRequest }) {
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Pedido {purchaseRequest.number || `#${purchaseRequest.id}`}
                </h2>
            }
        >
            <Head title={`Pedido ${purchaseRequest.number || `#${purchaseRequest.id}`}`} />

            <div className="py-12">
                <div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                    <div className="mb-4">
                        <Link
                            href={route('purchase-requests.index')}
                            className="text-sm text-indigo-600 hover:text-indigo-900"
                        >
                            &larr; Voltar
                        </Link>
                    </div>

                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="border-b border-gray-200 px-6 py-4">
                            <h3 className="text-lg font-medium text-gray-900">Detalhes do Pedido</h3>
                        </div>

                        <div className="p-6">
                            <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <dt className="text-sm font-medium text-gray-500">Número</dt>
                                    <dd className="mt-1 text-sm text-gray-900">{purchaseRequest.number || '-'}</dd>
                                </div>
                                <div>
                                    <dt className="text-sm font-medium text-gray-500">Fornecedor</dt>
                                    <dd className="mt-1 text-sm text-gray-900">{purchaseRequest.supplier_id || '-'}</dd>
                                </div>
                                <div>
                                    <dt className="text-sm font-medium text-gray-500">Valor</dt>
                                    <dd className="mt-1 text-sm text-gray-900">
                                        {new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(purchaseRequest.amount || 0)}
                                    </dd>
                                </div>
                                <div>
                                    <dt className="text-sm font-medium text-gray-500">Situação</dt>
                                    <dd className="mt-1 text-sm text-gray-900">{purchaseRequest.situation?.name || '-'}</dd>
                                </div>
                                <div>
                                    <dt className="text-sm font-medium text-gray-500">Data do Pedido</dt>
                                    <dd className="mt-1 text-sm text-gray-900">{purchaseRequest.request_date || '-'}</dd>
                                </div>
                            </dl>

                            <div className="mt-6">
                                <dt className="text-sm font-medium text-gray-500">Descrição</dt>
                                <dd className="mt-1 text-sm text-gray-900">{purchaseRequest.description || 'Sem descrição'}</dd>
                            </div>
                        </div>
                    </div>

                    <div className="mt-6 flex gap-4">
                        <Link
                            href={route('purchase-requests.edit', purchaseRequest.id)}
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
