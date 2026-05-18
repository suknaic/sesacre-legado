import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, useForm } from '@inertiajs/react';

export default function Create({ employmentContracts, contractSituations, organizations, jobFunctions }) {
    const { flash } = usePage().props;
    const { data, setData, post, processing, errors } = useForm({
        employment_contract_id: '', contract_situation_id: '',
        organization_id: '', job_function_id: '',
        history_date: '', start_date: '', end_date: '', observation: '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('ferias-licencas.store'));
    }

    return (
        <AuthenticatedLayout header={
            <h2 className="text-xl font-semibold leading-tight text-gray-800">Novo Registro de Férias/Licenças</h2>
        }>
            <Head title="Novo Registro" />
            <div className="py-8"><div className="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg"><div className="p-6">
                    <form onSubmit={handleSubmit} className="space-y-6">
                        <div><label className="block text-sm font-medium text-gray-700">Contrato *</label>
                            <select value={data.employment_contract_id} onChange={e => setData('employment_contract_id', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione...</option>
                                {employmentContracts.map(c => <option key={c.id} value={c.id}>{c.name}</option>)}
                            </select>
                            {errors.employment_contract_id && <p className="mt-1 text-sm text-red-600">{errors.employment_contract_id}</p>}
                        </div>
                        <div className="grid grid-cols-2 gap-4">
                            <div><label className="block text-sm font-medium text-gray-700">Situação</label>
                                <select value={data.contract_situation_id} onChange={e => setData('contract_situation_id', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione...</option>
                                    {contractSituations.map(s => <option key={s.id} value={s.id}>{s.name}</option>)}
                                </select>
                            </div>
                            <div><label className="block text-sm font-medium text-gray-700">Data do Histórico *</label>
                                <input type="date" value={data.history_date} onChange={e => setData('history_date', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.history_date && <p className="mt-1 text-sm text-red-600">{errors.history_date}</p>}
                            </div>
                        </div>
                        <div className="grid grid-cols-2 gap-4">
                            <div><label className="block text-sm font-medium text-gray-700">Organização</label>
                                <select value={data.organization_id} onChange={e => setData('organization_id', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione...</option>
                                    {organizations.map(o => <option key={o.id} value={o.id}>{o.name}</option>)}
                                </select>
                            </div>
                            <div><label className="block text-sm font-medium text-gray-700">Função</label>
                                <select value={data.job_function_id} onChange={e => setData('job_function_id', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione...</option>
                                    {jobFunctions.map(f => <option key={f.id} value={f.id}>{f.name}</option>)}
                                </select>
                            </div>
                        </div>
                        <div className="grid grid-cols-2 gap-4">
                            <div><label className="block text-sm font-medium text-gray-700">Data Início</label>
                                <input type="date" value={data.start_date} onChange={e => setData('start_date', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div><label className="block text-sm font-medium text-gray-700">Data Fim</label>
                                <input type="date" value={data.end_date} onChange={e => setData('end_date', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.end_date && <p className="mt-1 text-sm text-red-600">{errors.end_date}</p>}
                            </div>
                        </div>
                        <div><label className="block text-sm font-medium text-gray-700">Observação</label>
                            <textarea value={data.observation} onChange={e => setData('observation', e.target.value)} rows="3"
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>
                        <div className="flex items-center gap-4">
                            <button type="submit" disabled={processing} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Salvar</button>
                            <Link href={route('ferias-licencas.index')} className="text-sm text-gray-600 hover:text-gray-900">Cancelar</Link>
                        </div>
                    </form>
                </div></div>
            </div></div>
        </AuthenticatedLayout>
    );
}
