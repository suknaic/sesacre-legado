import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

const statusLabels = { ordered: 'Pendente', partially_received: 'Parcial', received: 'Recebido' };
const statusColors = { ordered: 'bg-yellow-100 text-yellow-800', partially_received: 'bg-blue-100 text-blue-800', received: 'bg-green-100 text-green-800' };

export default function Show({ order }) {
    const { data, setData, post, processing, errors } = useForm({
        quantity_received: order.quantity_ordered,
        receipt_date: new Date().toISOString().slice(0, 10),
        notes: '',
    });

    function handleReceive(e) {
        e.preventDefault();
        post(route('delivery-orders.receive', order.id));
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Detalhes da Ordem de Entrega</h2>
                <Link href={route('delivery-orders.index')} className="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-500">Voltar</Link>
            </div>
        }>
            <Head title="Detalhes da Ordem de Entrega" />
            <div className="py-8">
                <div className="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 space-y-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Material</label>
                                <p className="mt-1 text-sm text-gray-900">{order.material_description}</p>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Data do Pedido</label>
                                <p className="mt-1 text-sm text-gray-900">{order.order_date}</p>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Quantidade Pedida</label>
                                <p className="mt-1 text-sm text-gray-900">{order.quantity_ordered}</p>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Quantidade Recebida</label>
                                <p className="mt-1 text-sm text-gray-900">{order.quantity_received}</p>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Destino</label>
                                <p className="mt-1 text-sm text-gray-900">{order.organization?.name ?? '---'}</p>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Status</label>
                                <p className="mt-1">
                                    <span className={`inline-flex rounded-full px-2 text-xs font-semibold ${statusColors[order.status] || 'bg-gray-100 text-gray-800'}`}>
                                        {statusLabels[order.status] || order.status}
                                    </span>
                                </p>
                            </div>
                            {order.receipt_date && (
                                <div>
                                    <label className="block text-sm font-medium text-gray-500">Data do Recebimento</label>
                                    <p className="mt-1 text-sm text-gray-900">{order.receipt_date}</p>
                                </div>
                            )}
                            {order.notes && (
                                <div>
                                    <label className="block text-sm font-medium text-gray-500">Observações</label>
                                    <p className="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{order.notes}</p>
                                </div>
                            )}

                            {order.status !== 'received' && (
                                <div className="border-t pt-4 mt-4">
                                    <h3 className="text-lg font-medium text-gray-900 mb-4">Registrar Recebimento</h3>
                                    <form onSubmit={handleReceive} className="space-y-4">
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700">Quantidade Recebida</label>
                                            <input type="number" step="0.01" min="0" max={order.quantity_ordered} value={data.quantity_received} onChange={e => setData('quantity_received', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                            {errors.quantity_received && <p className="mt-1 text-sm text-red-600">{errors.quantity_received}</p>}
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700">Data do Recebimento</label>
                                            <input type="date" value={data.receipt_date} onChange={e => setData('receipt_date', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                            {errors.receipt_date && <p className="mt-1 text-sm text-red-600">{errors.receipt_date}</p>}
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700">Observações</label>
                                            <textarea value={data.notes} onChange={e => setData('notes', e.target.value)} rows={2} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                        </div>
                                        <button type="submit" disabled={processing} className="rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-green-500 disabled:opacity-50">Confirmar Recebimento</button>
                                    </form>
                                </div>
                            )}

                            <div className="pt-4">
                                <Link href={route('delivery-orders.edit', order.id)} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
