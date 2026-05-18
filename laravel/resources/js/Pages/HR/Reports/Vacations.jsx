import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, usePage, router } from '@inertiajs/react';

export default function Vacations({ history, contractSituations, filters }) {
    const { flash } = usePage().props;
    const { search, contract_situation_id, date_start, date_end } = filters;

    function handleFilter(key, value) {
        router.get(route('rh-reports.vacations'), { ...filters, [key]: value }, { preserveState: true, replace: true });
    }

    return (
        <AuthenticatedLayout header={
            <h2 className="text-xl font-semibold leading-tight text-gray-800">Relatórios de Férias, Licenças e Concessões</h2>
        }>
            <Head title="Relatórios de Férias" />
            <div className="py-8 print:py-2"><div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 print:px-0">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}

                <div className="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-4 print:hidden">
                    <input type="text" value={search || ''} onChange={e => handleFilter('search', e.target.value)} placeholder="Buscar por nome..." className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    <select value={contract_situation_id || ''} onChange={e => handleFilter('contract_situation_id', e.target.value)} className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Todas as situações</option>
                        {contractSituations.map(s => <option key={s.id} value={s.id}>{s.name}</option>)}
                    </select>
                    <input type="date" value={date_start || ''} onChange={e => handleFilter('date_start', e.target.value)} className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    <div className="flex gap-2">
                        <input type="date" value={date_end || ''} onChange={e => handleFilter('date_end', e.target.value)} className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        <button onClick={() => window.print()} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">PDF</button>
                    </div>
                </div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg print:shadow-none">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50 print:bg-gray-100"><tr>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Funcionário</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Situação</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Organização</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Início</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Fim</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Observação</th>
                        </tr></thead>
                        <tbody className="divide-y divide-gray-200 bg-white">
                            {history.length === 0 ? (
                                <tr><td colSpan="6" className="px-4 py-4 text-center text-sm text-gray-500">Nenhum registro encontrado.</td></tr>
                            ) : history.map((h) => (
                                <tr key={h.id}>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm font-medium text-gray-900">{h.employment_contract?.personal_info?.user?.name || '-'}</td>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{h.contract_situation?.name || '-'}</td>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{h.organization?.name || '-'}</td>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{h.start_date || '-'}</td>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{h.end_date || '-'}</td>
                                    <td className="max-w-xs truncate px-4 py-3 text-sm text-gray-500">{h.observation || '-'}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
