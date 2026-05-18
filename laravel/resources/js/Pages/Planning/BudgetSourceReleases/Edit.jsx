import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Edit({ release, fontes }) {
    const { data, setData, put, processing, errors } = useForm({
        fonte_id: release.fonte_id?.toString() || '',
        year: release.year?.toString() || '',
        total_amount: release.total_amount || '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        put(route('budget-source-releases.update', release.id));
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Editar Liberação de Fonte</h2>
                <Link href={route('budget-source-releases.index')} className="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-500">Voltar</Link>
            </div>
        }>
            <Head title="Editar Liberação de Fonte" />
            <div className="py-8">
                <div className="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <form onSubmit={handleSubmit} className="p-6 space-y-6">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Fonte</label>
                                <select value={data.fonte_id} onChange={e => setData('fonte_id', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione...</option>
                                    {fontes.map((f) => (
                                        <option key={f.id_fonte} value={f.id_fonte}>{f.nr_fonte}</option>
                                    ))}
                                </select>
                                {errors.fonte_id && <p className="mt-1 text-sm text-red-600">{errors.fonte_id}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Ano</label>
                                <input type="number" value={data.year} onChange={e => setData('year', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.year && <p className="mt-1 text-sm text-red-600">{errors.year}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Valor Total (R$)</label>
                                <input type="number" step="0.01" min="0" value={data.total_amount} onChange={e => setData('total_amount', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.total_amount && <p className="mt-1 text-sm text-red-600">{errors.total_amount}</p>}
                            </div>
                            <div className="flex items-center gap-4">
                                <button type="submit" disabled={processing} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50">Salvar</button>
                                <Link href={route('budget-source-releases.index')} className="text-sm text-gray-600 hover:text-gray-900">Cancelar</Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
