import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ annualPlans }) {
    const { data, setData, post, processing, errors } = useForm({
        annual_plan_id: '', validation_status: '1', description: '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('pas-validations.store'));
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Nova Validação do PAS</h2>
                <Link href={route('pas-validations.index')} className="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-500">Voltar</Link>
            </div>
        }>
            <Head title="Nova Validação do PAS" />
            <div className="py-8">
                <div className="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <form onSubmit={handleSubmit} className="p-6 space-y-6">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">PAS (Plano Anual)</label>
                                <select value={data.annual_plan_id} onChange={e => setData('annual_plan_id', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione...</option>
                                    {annualPlans.map((ap) => (
                                        <option key={ap.id} value={ap.id}>{ap.name}</option>
                                    ))}
                                </select>
                                {errors.annual_plan_id && <p className="mt-1 text-sm text-red-600">{errors.annual_plan_id}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Status</label>
                                <select value={data.validation_status} onChange={e => setData('validation_status', e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="1">Rascunho</option>
                                    <option value="2">Enviado</option>
                                    <option value="3">Devolvido</option>
                                    <option value="4">Autorizado</option>
                                </select>
                                {errors.validation_status && <p className="mt-1 text-sm text-red-600">{errors.validation_status}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Descrição</label>
                                <textarea value={data.description} onChange={e => setData('description', e.target.value)} rows={3} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.description && <p className="mt-1 text-sm text-red-600">{errors.description}</p>}
                            </div>
                            <div className="flex items-center gap-4">
                                <button type="submit" disabled={processing} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50">Salvar</button>
                                <Link href={route('pas-validations.index')} className="text-sm text-gray-600 hover:text-gray-900">Cancelar</Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
