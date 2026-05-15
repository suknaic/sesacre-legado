import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm, usePage } from '@inertiajs/react';

const typeOptions = [
    { value: 'F', label: 'Férias' },
    { value: 'L', label: 'Licenças' },
    { value: 'C', label: 'Concessões' },
    { value: 'A', label: 'Afastamentos' },
    { value: 'I', label: 'Inativos' },
];

export default function Edit({ contractSituation }) {
    const { flash } = usePage().props;
    const { data, setData, put, processing, errors } = useForm({
        name: contractSituation.name || '',
        type: contractSituation.type || '',
        is_active: contractSituation.is_active ?? true,
    });

    function handleSubmit(e) { e.preventDefault(); put(route('contract-situations.update', contractSituation.id)); }

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Editar Situação Contratual</h2>}>
            <Head title="Editar Situação" />
            <div className="py-12"><div className="mx-auto max-w-2xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-6"><Link href={route('contract-situations.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Nome *</label>
                            <input type="text" value={data.name} onChange={e => setData('name', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.name && <p className="mt-1 text-sm text-red-600">{errors.name}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Tipo *</label>
                            <select value={data.type} onChange={e => setData('type', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Selecione...</option>
                                {typeOptions.map((o) => <option key={o.value} value={o.value}>{o.label}</option>)}
                            </select>
                            {errors.type && <p className="mt-1 text-sm text-red-600">{errors.type}</p>}
                        </div>

                        <div className="mb-6">
                            <label className="flex items-center gap-2">
                                <input type="checkbox" checked={data.is_active} onChange={e => setData('is_active', e.target.checked)}
                                    className="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                <span className="text-sm text-gray-700">Ativo</span>
                            </label>
                        </div>

                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('contract-situations.index')}
                                className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
