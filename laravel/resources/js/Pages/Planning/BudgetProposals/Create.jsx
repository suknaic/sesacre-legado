import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create() {
    const { data, setData, post, processing, errors } = useForm({
        year: '', situation: '', is_active: true,
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('budget-proposals.store'));
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Nova Proposta Orçamentária</h2>
                <Link href={route('budget-proposals.index')} className="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-500">Voltar</Link>
            </div>
        }>
            <Head title="Nova Proposta Orçamentária" />
            <div className="py-8">
                <div className="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <form onSubmit={handleSubmit} className="p-6 space-y-6">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Ano</label>
                                <input type="number" value={data.year} onChange={e => setData('year', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.year && <p className="mt-1 text-sm text-red-600">{errors.year}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Situação</label>
                                <select value={data.situation} onChange={e => setData('situation', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione...</option>
                                    <option value="1">Elaboração</option>
                                    <option value="2">Em Análise</option>
                                    <option value="3">Aprovada</option>
                                </select>
                                {errors.situation && <p className="mt-1 text-sm text-red-600">{errors.situation}</p>}
                            </div>
                            <div className="flex items-center gap-2">
                                <input type="checkbox" checked={data.is_active} onChange={e => setData('is_active', e.target.checked)} className="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                <label className="text-sm font-medium text-gray-700">Ativo</label>
                            </div>
                            <div className="flex items-center gap-4">
                                <button type="submit" disabled={processing} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50">Salvar</button>
                                <Link href={route('budget-proposals.index')} className="text-sm text-gray-600 hover:text-gray-900">Cancelar</Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
