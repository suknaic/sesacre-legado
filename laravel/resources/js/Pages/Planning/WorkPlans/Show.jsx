import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm, usePage, router } from '@inertiajs/react';
import { useState } from 'react';

const statusLabels = { draft: 'Rascunho', sent: 'Enviado', validated: 'Validado', returned: 'Devolvido' };
const statusColors = { draft: 'bg-gray-100 text-gray-800', sent: 'bg-blue-100 text-blue-800', validated: 'bg-green-100 text-green-800', returned: 'bg-yellow-100 text-yellow-800' };

export default function Show({ plan }) {
    const { flash } = usePage().props;
    const [editingItem, setEditingItem] = useState(null);
    const { data, setData, post, processing, errors } = useForm({
        material_description: '', quantity: '', unit_value: '', notes: '',
    });
    const { data: editData, setData: setEditData, put: editPut, processing: editProcessing, errors: editErrors } = useForm({
        material_description: '', quantity: '', unit_value: '', status: 'draft', notes: '',
    });

    function handleAddItem(e) {
        e.preventDefault();
        post(route('work-plans.items.store', plan.id));
    }

    function startEdit(item) {
        setEditingItem(item.id);
        setEditData({
            material_description: item.material_description,
            quantity: item.quantity?.toString(),
            unit_value: item.unit_value?.toString(),
            status: item.status,
            notes: item.notes || '',
        });
    }

    function handleEditItem(e) {
        e.preventDefault();
        editPut(route('work-plans.items.update', [plan.id, editingItem]));
    }

    function removeItem(id) {
        if (confirm('Remover este item?')) {
            router.delete(route('work-plans.items.destroy', [plan.id, id]));
        }
    }

    const totalValue = plan.items?.reduce((sum, i) => sum + Number(i.total_value), 0) || 0;

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">{plan.name}</h2>
                <Link href={route('work-plans.index')} className="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-500">Voltar</Link>
            </div>
        }>
            <Head title={plan.name} />
            <div className="py-8">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}

                    <div className="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-4">
                        <div className="rounded-lg bg-white p-4 shadow-sm">
                            <p className="text-xs text-gray-500">PAS</p>
                            <p className="text-sm font-semibold text-gray-900">{plan.annual_plan?.name ?? '---'}</p>
                        </div>
                        <div className="rounded-lg bg-white p-4 shadow-sm">
                            <p className="text-xs text-gray-500">Vigência</p>
                            <p className="text-sm font-semibold text-gray-900">{plan.start_date} até {plan.end_date}</p>
                        </div>
                        <div className="rounded-lg bg-white p-4 shadow-sm">
                            <p className="text-xs text-gray-500">Itens</p>
                            <p className="text-sm font-semibold text-gray-900">{plan.items?.length ?? 0}</p>
                        </div>
                        <div className="rounded-lg bg-white p-4 shadow-sm">
                            <p className="text-xs text-gray-500">Valor Total</p>
                            <p className="text-sm font-semibold text-gray-900">{totalValue.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}</p>
                        </div>
                    </div>

                    <div className="mb-8 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-4 border-b">
                            <h3 className="text-lg font-medium text-gray-900">Itens do PTA</h3>
                        </div>
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Material</th>
                                    <th className="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Qtd</th>
                                    <th className="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Valor Unit.</th>
                                    <th className="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Valor Total</th>
                                    <th className="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                                    <th className="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-200 bg-white">
                                {(!plan.items || plan.items.length === 0) ? (
                                    <tr><td colSpan="6" className="px-4 py-4 text-center text-sm text-gray-500">Nenhum item cadastrado.</td></tr>
                                ) : plan.items.map((item) => (
                                    editingItem === item.id ? (
                                        <tr key={item.id}>
                                            <td colSpan="6" className="px-4 py-2">
                                                <form onSubmit={handleEditItem} className="flex flex-wrap gap-2 items-end">
                                                    <div>
                                                        <label className="block text-xs text-gray-500">Material</label>
                                                        <input type="text" value={editData.material_description} onChange={e => setEditData('material_description', e.target.value)} className="w-40 rounded border-gray-300 text-sm" />
                                                    </div>
                                                    <div>
                                                        <label className="block text-xs text-gray-500">Qtd</label>
                                                        <input type="number" step="0.01" value={editData.quantity} onChange={e => setEditData('quantity', e.target.value)} className="w-20 rounded border-gray-300 text-sm" />
                                                    </div>
                                                    <div>
                                                        <label className="block text-xs text-gray-500">Valor Unit.</label>
                                                        <input type="number" step="0.01" value={editData.unit_value} onChange={e => setEditData('unit_value', e.target.value)} className="w-24 rounded border-gray-300 text-sm" />
                                                    </div>
                                                    <div>
                                                        <label className="block text-xs text-gray-500">Status</label>
                                                        <select value={editData.status} onChange={e => setEditData('status', e.target.value)} className="rounded border-gray-300 text-sm">
                                                            {Object.entries(statusLabels).map(([k, v]) => (
                                                                <option key={k} value={k}>{v}</option>
                                                            ))}
                                                        </select>
                                                    </div>
                                                    <button type="submit" disabled={editProcessing} className="rounded bg-indigo-600 px-3 py-1 text-xs text-white hover:bg-indigo-500">Salvar</button>
                                                    <button type="button" onClick={() => setEditingItem(null)} className="rounded bg-gray-400 px-3 py-1 text-xs text-white hover:bg-gray-300">Cancelar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    ) : (
                                        <tr key={item.id}>
                                            <td className="px-4 py-2 text-sm text-gray-900">{item.material_description}</td>
                                            <td className="px-4 py-2 text-sm">{item.quantity}</td>
                                            <td className="px-4 py-2 text-sm">{Number(item.unit_value).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}</td>
                                            <td className="px-4 py-2 text-sm">{Number(item.total_value).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}</td>
                                            <td className="px-4 py-2 text-sm">
                                                <span className={`inline-flex rounded-full px-2 text-xs font-semibold ${statusColors[item.status] || ''}`}>{statusLabels[item.status] || item.status}</span>
                                            </td>
                                            <td className="px-4 py-2 text-sm">
                                                <button onClick={() => startEdit(item)} className="text-indigo-600 hover:text-indigo-900 text-xs">Editar</button>
                                                <button onClick={() => removeItem(item.id)} className="ml-2 text-red-600 hover:text-red-900 text-xs">Remover</button>
                                            </td>
                                        </tr>
                                    )
                                ))}
                            </tbody>
                        </table>
                    </div>

                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-4 border-b">
                            <h3 className="text-lg font-medium text-gray-900">Adicionar Item</h3>
                        </div>
                        <form onSubmit={handleAddItem} className="p-4">
                            <div className="grid grid-cols-1 sm:grid-cols-5 gap-4">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Material</label>
                                    <input type="text" value={data.material_description} onChange={e => setData('material_description', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                    {errors.material_description && <p className="text-xs text-red-600">{errors.material_description}</p>}
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Quantidade</label>
                                    <input type="number" step="0.01" min="0" value={data.quantity} onChange={e => setData('quantity', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                    {errors.quantity && <p className="text-xs text-red-600">{errors.quantity}</p>}
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Valor Unit. (R$)</label>
                                    <input type="number" step="0.01" min="0" value={data.unit_value} onChange={e => setData('unit_value', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                    {errors.unit_value && <p className="text-xs text-red-600">{errors.unit_value}</p>}
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Observações</label>
                                    <input type="text" value={data.notes} onChange={e => setData('notes', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                </div>
                                <div className="flex items-end">
                                    <button type="submit" disabled={processing} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50">Adicionar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
