import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';

const typeColors = {
    F: 'bg-green-100 text-green-800',
    L: 'bg-blue-100 text-blue-800',
    C: 'bg-purple-100 text-purple-800',
    A: 'bg-yellow-100 text-yellow-800',
    I: 'bg-red-100 text-red-800',
};

export default function Index({ history, contractSituations = [], filters = {} }) {
    const { flash } = usePage().props;
    const { search = '', contract_situation_id = '', date_start = '', date_end = '', employment_contract_id = '' } = filters;

    function handleFilterChange(key, value) {
        router.get(route('ferias-licencas.index'), { ...filters, [key]: value, page: 1 }, { preserveState: true, replace: true });
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Férias, Licenças e Concessões</h2>
            </div>
        }>
            <Head title="Férias, Licenças e Concessões" />
            <div className="py-8"><div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}

                <div className="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-4">
                    <input type="text" value={search} onChange={e => handleFilterChange('search', e.target.value)}
                        placeholder="Buscar por funcionário..."
                        className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    <select value={contract_situation_id} onChange={e => handleFilterChange('contract_situation_id', e.target.value)}
                        className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Todas as situações</option>
                        {contractSituations.map((s) => <option key={s.id} value={s.id}>{s.name}</option>)}
                    </select>
                    <input type="date" value={date_start} onChange={e => handleFilterChange('date_start', e.target.value)}
                        placeholder="Data início"
                        className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    <input type="date" value={date_end} onChange={e => handleFilterChange('date_end', e.target.value)}
                        placeholder="Data fim"
                        className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                </div>
                {(search || contract_situation_id || date_start || date_end) && (
                    <div className="mb-4">
                        <button onClick={() => router.get(route('ferias-licencas.index'), {}, { preserveState: true, replace: true })}
                            className="rounded-md bg-gray-200 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">
                            Limpar Filtros
                        </button>
                    </div>
                )}

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50"><tr>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Funcionário</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Situação</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Organização</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Função</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Início</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Fim</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Observação</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                        </tr></thead>
                        <tbody className="divide-y divide-gray-200 bg-white">
                            {history.data.length === 0 ? (
                                <tr><td colSpan="8" className="px-4 py-4 text-center text-sm text-gray-500">Nenhum registro encontrado.</td></tr>
                            ) : history.data.map((h) => (
                                <tr key={h.id}>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm font-medium text-gray-900">{h.employment_contract?.personal_info?.user?.name || '-'}</td>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm">
                                        {h.contract_situation ? (
                                            <span className={`inline-flex rounded-full px-2 text-xs font-semibold ${typeColors[h.contract_situation.type] || 'bg-gray-100 text-gray-800'}`}>
                                                {h.contract_situation.name}
                                            </span>
                                        ) : '-'}
                                    </td>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{h.organization?.name || '-'}</td>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{h.job_function?.name || '-'}</td>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{h.start_date || '-'}</td>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{h.end_date || '-'}</td>
                                    <td className="max-w-xs truncate px-4 py-3 text-sm text-gray-500">{h.observation || '-'}</td>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm">
                                        <Link href={route('ferias-licencas.show', h.id)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>

                {history.links && (
                    <div className="mt-4 flex justify-center gap-1">
                        {history.links.map((link, i) => (
                            <button key={i} onClick={() => {
                                if (link.url) router.get(link.url, {}, { preserveState: true, replace: true });
                            }} disabled={!link.url}
                                className={`rounded px-3 py-1 text-sm ${link.active ? 'bg-indigo-600 text-white' : link.url ? 'bg-white text-gray-700 hover:bg-gray-100' : 'bg-gray-100 text-gray-400'}`}
                                dangerouslySetInnerHTML={{ __html: link.label }} />
                        ))}
                    </div>
                )}
            </div></div>
        </AuthenticatedLayout>
    );
}
