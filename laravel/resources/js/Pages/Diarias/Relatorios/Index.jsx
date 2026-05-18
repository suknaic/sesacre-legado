import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm, usePage } from '@inertiajs/react';

export default function Index({ results, filters, travelTypes, decreeTypes }) {
    const { flash } = usePage().props;
    const { data, setData, get, processing } = useForm({
        date_from: filters?.date_from || '',
        date_to: filters?.date_to || '',
        travel_type_id: filters?.travel_type_id || '',
        decree_type_id: filters?.decree_type_id || '',
        stage: filters?.stage ?? '',
        is_active: filters?.is_active ?? '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        get(route('diarias-relatorios.gerar'));
    }

    function stageLabel(stage) {
        const labels = { '-1': 'Rejeitada', '1': 'Etapa 1', '2': 'Etapa 2', '3': 'Etapa 3', '4': 'Etapa 4', '5': 'Aprovada' };
        return labels[stage] ?? `Etapa ${stage}`;
    }

    return (
        <AuthenticatedLayout header={
            <h2 className="text-xl font-semibold leading-tight text-gray-800">Relatórios de Diárias</h2>
        }>
            <Head title="Relatórios de Diárias" />
            <div className="py-8">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                    <div className="mb-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <form onSubmit={handleSubmit} className="p-6">
                            <div className="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Data Início</label>
                                    <input type="date" value={data.date_from} onChange={e => setData('date_from', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Data Fim</label>
                                    <input type="date" value={data.date_to} onChange={e => setData('date_to', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Tipo de Viagem</label>
                                    <select value={data.travel_type_id} onChange={e => setData('travel_type_id', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">Todos</option>
                                        {travelTypes.map(t => <option key={t.id} value={t.id}>{t.name}</option>)}
                                    </select>
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Tipo de Decreto</label>
                                    <select value={data.decree_type_id} onChange={e => setData('decree_type_id', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">Todos</option>
                                        {decreeTypes.map(t => <option key={t.id} value={t.id}>{t.name}</option>)}
                                    </select>
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Etapa</label>
                                    <select value={data.stage} onChange={e => setData('stage', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">Todas</option>
                                        <option value="-1">Rejeitada</option>
                                        <option value="1">Etapa 1</option>
                                        <option value="2">Etapa 2</option>
                                        <option value="3">Etapa 3</option>
                                        <option value="4">Etapa 4</option>
                                        <option value="5">Aprovada</option>
                                    </select>
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Ativo</label>
                                    <select value={data.is_active} onChange={e => setData('is_active', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">Todos</option>
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select>
                                </div>
                            </div>
                            <div className="mt-4">
                                <button type="submit" disabled={processing}
                                    className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50">
                                    {processing ? 'Gerando...' : 'Gerar Relatório'}
                                </button>
                            </div>
                        </form>
                    </div>

                    {results && results.length > 0 && (
                        <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                            <div className="border-b border-gray-200 px-6 py-4">
                                <h3 className="text-lg font-medium text-gray-900">Resultados ({results.length} registros)</h3>
                            </div>
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">ID</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Serviço</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tipo Viagem</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Etapa</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Data</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-200 bg-white">
                                    {results.map((req) => (
                                        <tr key={req.id}>
                                            <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{req.id}</td>
                                            <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{req.service_description || '-'}</td>
                                            <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{req.travel_type?.name || '-'}</td>
                                            <td className="whitespace-nowrap px-6 py-4 text-sm">{stageLabel(req.stage)}</td>
                                            <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{req.created_at}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    )}
                    {results && results.length === 0 && filters && (
                        <div className="rounded-md bg-gray-50 p-6 text-center text-sm text-gray-500">Nenhum resultado encontrado para os filtros selecionados.</div>
                    )}
                    {!filters && (
                        <div className="rounded-md bg-gray-50 p-6 text-center text-sm text-gray-500">Selecione os filtros e clique em "Gerar Relatório".</div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
