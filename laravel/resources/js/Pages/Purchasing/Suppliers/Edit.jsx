import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Edit({ supplier, legalEntities = [] }) {
    const { data, setData, put, processing, errors } = useForm({
        legal_entity_id: supplier.legal_entity_id || '',
        situation: supplier.situation || '',
    });
    function handleSubmit(e) { e.preventDefault(); put(route('suppliers.update', supplier.id)); }
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Editar {supplier.legal_entity?.name || 'Fornecedor'}</h2>}>
            <Head title="Editar Fornecedor" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-6"><Link href={route('suppliers.show', supplier.id)} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Pessoa Jurídica</label>
                            <select value={data.legal_entity_id} onChange={e => setData('legal_entity_id', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Selecione...</option>
                                {(legalEntities || []).map((e) => <option key={e.id} value={e.id}>{e.name}</option>)}
                            </select>
                            {errors.legal_entity_id && <p className="mt-1 text-sm text-red-600">{errors.legal_entity_id}</p>}
                        </div>
                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Situação</label>
                            <input type="text" value={data.situation} onChange={e => setData('situation', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.situation && <p className="mt-1 text-sm text-red-600">{errors.situation}</p>}
                        </div>
                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('suppliers.show', supplier.id)} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
                            <button type="submit" disabled={processing}
                                className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50">
                                {processing ? 'Salvando...' : 'Salvar'}</button>
                        </div>
                    </form>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
