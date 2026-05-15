import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Edit({ purchaseRequest, suppliers, situations }) {
    const { data, setData, put, processing, errors } = useForm({
        number: purchaseRequest.number || '',
        supplier_id: purchaseRequest.supplier_id || '',
        purchase_request_situation_id: purchaseRequest.purchase_request_situation_id || '',
        description: purchaseRequest.description || '',
        amount: purchaseRequest.amount || '',
        request_date: purchaseRequest.request_date || '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        put(route('purchase-requests.update', purchaseRequest.id));
    }

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Editar Pedido {purchaseRequest.number || `#${purchaseRequest.id}`}
                </h2>
            }
        >
            <Head title="Editar Pedido" />

            <div className="py-12">
                <div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <form onSubmit={handleSubmit} className="p-6">
                            <div className="mb-6">
                                <Link
                                    href={route('purchase-requests.show', purchaseRequest.id)}
                                    className="text-sm text-indigo-600 hover:text-indigo-900"
                                >
                                    &larr; Voltar
                                </Link>
                            </div>

                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700" htmlFor="number">
                                    Número
                                </label>
                                <input id="number" type="text" value={data.number} onChange={(e) => setData('number', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                {errors.number && <p className="mt-1 text-sm text-red-600">{errors.number}</p>}
                            </div>

                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700" htmlFor="supplier_id">Fornecedor</label>
                                <select id="supplier_id" value={data.supplier_id} onChange={(e) => setData('supplier_id', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Selecione...</option>
                                    {suppliers.map((s) => <option key={s.id} value={s.id}>Fornecedor #{s.id}</option>)}
                                </select>
                                {errors.supplier_id && <p className="mt-1 text-sm text-red-600">{errors.supplier_id}</p>}
                            </div>

                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700" htmlFor="purchase_request_situation_id">Situação</label>
                                <select id="purchase_request_situation_id" value={data.purchase_request_situation_id} onChange={(e) => setData('purchase_request_situation_id', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Selecione...</option>
                                    {situations.map((s) => <option key={s.id} value={s.id}>{s.name}</option>)}
                                </select>
                                {errors.purchase_request_situation_id && <p className="mt-1 text-sm text-red-600">{errors.purchase_request_situation_id}</p>}
                            </div>

                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700" htmlFor="amount">Valor</label>
                                <input id="amount" type="number" step="0.01" min="0" value={data.amount} onChange={(e) => setData('amount', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                {errors.amount && <p className="mt-1 text-sm text-red-600">{errors.amount}</p>}
                            </div>

                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700" htmlFor="request_date">Data do Pedido</label>
                                <input id="request_date" type="date" value={data.request_date} onChange={(e) => setData('request_date', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                {errors.request_date && <p className="mt-1 text-sm text-red-600">{errors.request_date}</p>}
                            </div>

                            <div className="mb-6">
                                <label className="block text-sm font-medium text-gray-700" htmlFor="description">Descrição</label>
                                <textarea id="description" rows={4} value={data.description} onChange={(e) => setData('description', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                {errors.description && <p className="mt-1 text-sm text-red-600">{errors.description}</p>}
                            </div>

                            <div className="flex items-center justify-end gap-4">
                                <Link href={route('purchase-requests.show', purchaseRequest.id)}
                                    className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
                                <button type="submit" disabled={processing}
                                    className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50">
                                    {processing ? 'Salvando...' : 'Salvar'}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
