import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm, usePage } from '@inertiajs/react';

export default function Edit({ employmentContract, location, organizations = [], jobFunctions = [] }) {
    const { flash } = usePage().props;
    const { data, setData, put, processing, errors } = useForm({
        organization_id: location.organization_id || '',
        job_function_id: location.job_function_id || '',
        workload: location.workload || '',
        start_date: location.start_date || '',
        end_date: location.end_date || '',
    });

    function handleSubmit(e) { e.preventDefault(); put(route('employment-contracts.locations.update', [employmentContract.id, location.id])); }

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Editar Lotação</h2>}>
            <Head title="Editar Lotação" />
            <div className="py-12"><div className="mx-auto max-w-2xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-6"><Link href={route('employment-contracts.locations.index', employmentContract.id)} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Organização *</label>
                            <select value={data.organization_id} onChange={e => setData('organization_id', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Selecione...</option>
                                {organizations.map((o) => <option key={o.id} value={o.id}>{o.name}</option>)}
                            </select>
                            {errors.organization_id && <p className="mt-1 text-sm text-red-600">{errors.organization_id}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Função</label>
                            <select value={data.job_function_id} onChange={e => setData('job_function_id', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Selecione...</option>
                                {jobFunctions.map((f) => <option key={f.id} value={f.id}>{f.name}</option>)}
                            </select>
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Carga Horária *</label>
                            <input type="number" value={data.workload} onChange={e => setData('workload', e.target.value)}
                                min="1" max="40"
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.workload && <p className="mt-1 text-sm text-red-600">{errors.workload}</p>}
                        </div>

                        <div className="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Data Início *</label>
                                <input type="date" value={data.start_date} onChange={e => setData('start_date', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                {errors.start_date && <p className="mt-1 text-sm text-red-600">{errors.start_date}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Data Fim</label>
                                <input type="date" value={data.end_date} onChange={e => setData('end_date', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                {errors.end_date && <p className="mt-1 text-sm text-red-600">{errors.end_date}</p>}
                            </div>
                        </div>

                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('employment-contracts.locations.index', employmentContract.id)}
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
