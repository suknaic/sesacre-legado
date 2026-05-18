import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';

const statusLabels = { ordered: 'Pendente', partially_received: 'Parcial', received: 'Recebido' };
const statusColors = { ordered: 'bg-yellow-100 text-yellow-800', partially_received: 'bg-blue-100 text-blue-800', received: 'bg-green-100 text-green-800' };

export default function Index({ orders }) {
    const { flash } = usePage().props;
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Ordens de Entrega</h2>
                <Link href={route('delivery-orders.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Nova Ordem</Link>
            </div>
        }>
            <Head title="Ordens de Entrega" />
            <div className="py-8">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Material</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Qtd Pedida</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Qtd Recebida</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Destino</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-200 bg-white">
                                {orders.data.length === 0 ? (
                                    <tr><td colSpan="6" className="px-6 py-4 text-center text-sm text-gray-500">Nenhuma ordem encontrada.</td></tr>
                                ) : orders.data.map((o) => (
                                    <tr key={o.id}>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{o.material_description}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{o.quantity_ordered}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{o.quantity_received}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{o.organization?.name ?? '---'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">
                                            <span className={`inline-flex rounded-full px-2 text-xs font-semibold ${statusColors[o.status] || 'bg-gray-100 text-gray-800'}`}>
                                                {statusLabels[o.status] || o.status}
                                            </span>
                                        </td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">
                                            <Link href={route('delivery-orders.show', o.id)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                            <Link href={route('delivery-orders.edit', o.id)} className="ml-3 text-indigo-600 hover:text-indigo-900">Editar</Link>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
