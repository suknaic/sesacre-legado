import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create() {
    const { data, setData, post, processing, errors } = useForm({
        code: '', name: '', description_code: '', description_name: '',
        group_code: '', group_name: '', subgroup_code: '', subgroup_name: '',
        material_type: '', expense_element_code: '', expense_type_id: '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('plan-materials.store'));
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Novo Material</h2>
                <Link href={route('plan-materials.index')} className="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-500">Voltar</Link>
            </div>
        }>
            <Head title="Novo Material" />
            <div className="py-8">
                <div className="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <form onSubmit={handleSubmit} className="p-6 space-y-6">
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Código</label>
                                    <input type="text" value={data.code} onChange={e => setData('code', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                    {errors.code && <p className="mt-1 text-sm text-red-600">{errors.code}</p>}
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Nome</label>
                                    <input type="text" value={data.name} onChange={e => setData('name', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                    {errors.name && <p className="mt-1 text-sm text-red-600">{errors.name}</p>}
                                </div>
                            </div>
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Código Descrição</label>
                                    <input type="text" value={data.description_code} onChange={e => setData('description_code', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Nome Descrição</label>
                                    <input type="text" value={data.description_name} onChange={e => setData('description_name', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                </div>
                            </div>
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Código Grupo</label>
                                    <input type="text" value={data.group_code} onChange={e => setData('group_code', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Nome Grupo</label>
                                    <input type="text" value={data.group_name} onChange={e => setData('group_name', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                </div>
                            </div>
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Código Subgrupo</label>
                                    <input type="text" value={data.subgroup_code} onChange={e => setData('subgroup_code', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Nome Subgrupo</label>
                                    <input type="text" value={data.subgroup_name} onChange={e => setData('subgroup_name', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                </div>
                            </div>
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Tipo de Material</label>
                                    <select value={data.material_type} onChange={e => setData('material_type', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Selecione...</option>
                                        <option value="Consumo">Consumo</option>
                                        <option value="Permanente">Permanente</option>
                                        <option value="Serviço">Serviço</option>
                                    </select>
                                    {errors.material_type && <p className="mt-1 text-sm text-red-600">{errors.material_type}</p>}
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Código Elemento Despesa</label>
                                    <input type="text" value={data.expense_element_code} onChange={e => setData('expense_element_code', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                </div>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Tipo de Despesa (ID)</label>
                                <input type="number" value={data.expense_type_id} onChange={e => setData('expense_type_id', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div className="flex items-center gap-4">
                                <button type="submit" disabled={processing} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50">Salvar</button>
                                <Link href={route('plan-materials.index')} className="text-sm text-gray-600 hover:text-gray-900">Cancelar</Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
