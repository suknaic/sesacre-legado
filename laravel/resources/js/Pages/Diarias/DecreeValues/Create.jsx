import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ decreeTypes, travelClasses }) {
    const { data, setData, post, processing, errors } = useForm({
        decree_type_id: '',
        travel_class_id: '',
        value: '',
        is_active: true,
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('decree-values.store'));
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Novo Valor de Diária</h2>
                <Link href={route('decree-values.index')} className="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-500">Voltar</Link>
            </div>
        }>
            <Head title="Novo Valor de Diária" />
            <div className="py-8">
                <div className="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <form onSubmit={handleSubmit} className="p-6 space-y-6">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Tipo de Decreto</label>
                                <select value={data.decree_type_id} onChange={e => setData('decree_type_id', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione...</option>
                                    {decreeTypes.map(t => <option key={t.id} value={t.id}>{t.name}</option>)}
                                </select>
                                {errors.decree_type_id && <p className="mt-1 text-sm text-red-600">{errors.decree_type_id}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Classe de Viagem</label>
                                <select value={data.travel_class_id} onChange={e => setData('travel_class_id', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione...</option>
                                    {travelClasses.map(t => <option key={t.id} value={t.id}>{t.name}</option>)}
                                </select>
                                {errors.travel_class_id && <p className="mt-1 text-sm text-red-600">{errors.travel_class_id}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Valor (R$)</label>
                                <input type="number" step="0.01" min="0" value={data.value} onChange={e => setData('value', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.value && <p className="mt-1 text-sm text-red-600">{errors.value}</p>}
                            </div>
                            <div>
                                <label className="flex items-center gap-2">
                                    <input type="checkbox" checked={data.is_active} onChange={e => setData('is_active', e.target.checked)}
                                        className="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                    <span className="text-sm text-gray-700">Ativo</span>
                                </label>
                            </div>
                            <div className="flex items-center gap-4">
                                <button type="submit" disabled={processing} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50">Salvar</button>
                                <Link href={route('decree-values.index')} className="text-sm text-gray-600 hover:text-gray-900">Cancelar</Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
