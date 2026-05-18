import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, useForm } from '@inertiajs/react';

export default function Create({ parents, categories, cities, managers }) {
    const { flash } = usePage().props;
    const { data, setData, post, processing, errors } = useForm({
        parent_id: '', category_id: '', name: '', cnpj: '',
        city_id: '', address: '', neighborhood: '', zip_code: '',
        email: '', phone: '', latitude: '', longitude: '',
        manager_id: '', is_principal: false, is_active: true,
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('organization-details.store'));
    }

    return (
        <AuthenticatedLayout header={
            <h2 className="text-xl font-semibold leading-tight text-gray-800">Novo Detalhe de Organização</h2>
        }>
            <Head title="Novo Detalhe de Organização" />
            <div className="py-8"><div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg"><div className="p-6">
                    <form onSubmit={handleSubmit} className="space-y-6">
                        <div><label className="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" value={data.name} onChange={e => setData('name', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            {errors.name && <p className="mt-1 text-sm text-red-600">{errors.name}</p>}
                        </div>
                        <div><label className="block text-sm font-medium text-gray-700">Categoria</label>
                            <select value={data.category_id} onChange={e => setData('category_id', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione...</option>
                                {categories.map(c => <option key={c.id} value={c.id}>{c.name}</option>)}
                            </select>
                        </div>
                        <div><label className="block text-sm font-medium text-gray-700">CNPJ</label>
                            <input type="text" value={data.cnpj} onChange={e => setData('cnpj', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>
                        <div><label className="block text-sm font-medium text-gray-700">Cidade</label>
                            <select value={data.city_id} onChange={e => setData('city_id', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione...</option>
                                {cities.map(c => <option key={c.id} value={c.id}>{c.name}</option>)}
                            </select>
                        </div>
                        <div><label className="block text-sm font-medium text-gray-700">Endereço</label>
                            <input type="text" value={data.address} onChange={e => setData('address', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>
                        <div className="grid grid-cols-3 gap-4">
                            <div><label className="block text-sm font-medium text-gray-700">Bairro</label>
                                <input type="text" value={data.neighborhood} onChange={e => setData('neighborhood', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div><label className="block text-sm font-medium text-gray-700">CEP</label>
                                <input type="text" value={data.zip_code} onChange={e => setData('zip_code', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div><label className="block text-sm font-medium text-gray-700">Telefone</label>
                                <input type="text" value={data.phone} onChange={e => setData('phone', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                        </div>
                        <div className="grid grid-cols-3 gap-4">
                            <div><label className="block text-sm font-medium text-gray-700">Latitude</label>
                                <input type="text" value={data.latitude} onChange={e => setData('latitude', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div><label className="block text-sm font-medium text-gray-700">Longitude</label>
                                <input type="text" value={data.longitude} onChange={e => setData('longitude', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div><label className="block text-sm font-medium text-gray-700">Gestor</label>
                                <select value={data.manager_id} onChange={e => setData('manager_id', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione...</option>
                                    {managers.map(m => <option key={m.id} value={m.id}>{m.name}</option>)}
                                </select>
                            </div>
                        </div>
                        <div className="flex items-center gap-6">
                            <label className="flex items-center gap-2"><input type="checkbox" checked={data.is_principal} onChange={e => setData('is_principal', e.target.checked)} className="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" /> Principal</label>
                            <label className="flex items-center gap-2"><input type="checkbox" checked={data.is_active} onChange={e => setData('is_active', e.target.checked)} className="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" /> Ativo</label>
                        </div>
                        <div className="flex items-center gap-4">
                            <button type="submit" disabled={processing} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Salvar</button>
                            <Link href={route('organization-details.index')} className="text-sm text-gray-600 hover:text-gray-900">Cancelar</Link>
                        </div>
                    </form>
                </div></div>
            </div></div>
        </AuthenticatedLayout>
    );
}
