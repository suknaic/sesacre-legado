import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create() {
    const { data, setData, post, processing, errors } = useForm({
        name: '', year: '', note_code: '', indicator_type: '', goal: '', unit: '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('health-indicators.store'));
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Novo Indicador de Saúde</h2>
                <Link href={route('health-indicators.index')} className="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-500">Voltar</Link>
            </div>
        }>
            <Head title="Novo Indicador de Saúde" />
            <div className="py-8">
                <div className="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <form onSubmit={handleSubmit} className="p-6 space-y-6">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Nome</label>
                                <input type="text" value={data.name} onChange={e => setData('name', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.name && <p className="mt-1 text-sm text-red-600">{errors.name}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Ano</label>
                                <input type="number" value={data.year} onChange={e => setData('year', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.year && <p className="mt-1 text-sm text-red-600">{errors.year}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Código Nota</label>
                                <input type="text" value={data.note_code} onChange={e => setData('note_code', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.note_code && <p className="mt-1 text-sm text-red-600">{errors.note_code}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Tipo</label>
                                <input type="text" value={data.indicator_type} onChange={e => setData('indicator_type', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.indicator_type && <p className="mt-1 text-sm text-red-600">{errors.indicator_type}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Meta</label>
                                <textarea value={data.goal} onChange={e => setData('goal', e.target.value)} rows={2} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.goal && <p className="mt-1 text-sm text-red-600">{errors.goal}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Unidade</label>
                                <input type="text" value={data.unit} onChange={e => setData('unit', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.unit && <p className="mt-1 text-sm text-red-600">{errors.unit}</p>}
                            </div>
                            <div className="flex items-center gap-4">
                                <button type="submit" disabled={processing} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50">Salvar</button>
                                <Link href={route('health-indicators.index')} className="text-sm text-gray-600 hover:text-gray-900">Cancelar</Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
