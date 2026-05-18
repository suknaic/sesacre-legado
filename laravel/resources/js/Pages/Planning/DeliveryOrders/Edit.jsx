import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

const statusOptions = [
    { value: 'ordered', label: 'Pendente' },
    { value: 'partially_received', label: 'Parcialmente Recebido' },
    { value: 'received', label: 'Recebido' },
];

export default function Edit({ order, organizations }) {
    const { data, setData, put, processing, errors } = useForm({
        order_date: order.order_date || '',
        material_description: order.material_description || '',
        quantity_ordered: order.quantity_ordered?.toString() || '',
        quantity_received: order.quantity_received?.toString() || '0',
        organization_id: order.organization_id?.toString() || '',
        status: order.status || 'ordered',
        receipt_date: order.receipt_date || '',
        notes: order.notes || '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        put(route('delivery-orders.update', order.id));
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Editar Ordem de Entrega</h2>
                <Link href={route('delivery-orders.index')} className="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-500">Voltar</Link>
            </div>
        }>
            <Head title="Editar Ordem de Entrega" />
            <div className="py-8">
                <div className="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <form onSubmit={handleSubmit} className="p-6 space-y-6">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Data do Pedido</label>
                                <input type="date" value={data.order_date} onChange={e => setData('order_date', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.order_date && <p className="mt-1 text-sm text-red-600">{errors.order_date}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Descrição do Material</label>
                                <input type="text" value={data.material_description} onChange={e => setData('material_description', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.material_description && <p className="mt-1 text-sm text-red-600">{errors.material_description}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Quantidade Pedida</label>
                                <input type="number" step="0.01" min="0" value={data.quantity_ordered} onChange={e => setData('quantity_ordered', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.quantity_ordered && <p className="mt-1 text-sm text-red-600">{errors.quantity_ordered}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Quantidade Recebida</label>
                                <input type="number" step="0.01" min="0" value={data.quantity_received} onChange={e => setData('quantity_received', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.quantity_received && <p className="mt-1 text-sm text-red-600">{errors.quantity_received}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Destino (Lotação)</label>
                                <select value={data.organization_id} onChange={e => setData('organization_id', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione...</option>
                                    {organizations.map((o) => (
                                        <option key={o.id} value={o.id}>{o.name}</option>
                                    ))}
                                </select>
                                {errors.organization_id && <p className="mt-1 text-sm text-red-600">{errors.organization_id}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Status</label>
                                <select value={data.status} onChange={e => setData('status', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    {statusOptions.map((opt) => (
                                        <option key={opt.value} value={opt.value}>{opt.label}</option>
                                    ))}
                                </select>
                                {errors.status && <p className="mt-1 text-sm text-red-600">{errors.status}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Data do Recebimento</label>
                                <input type="date" value={data.receipt_date} onChange={e => setData('receipt_date', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.receipt_date && <p className="mt-1 text-sm text-red-600">{errors.receipt_date}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Observações</label>
                                <textarea value={data.notes} onChange={e => setData('notes', e.target.value)} rows={3} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.notes && <p className="mt-1 text-sm text-red-600">{errors.notes}</p>}
                            </div>
                            <div className="flex items-center gap-4">
                                <button type="submit" disabled={processing} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50">Salvar</button>
                                <Link href={route('delivery-orders.index')} className="text-sm text-gray-600 hover:text-gray-900">Cancelar</Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
