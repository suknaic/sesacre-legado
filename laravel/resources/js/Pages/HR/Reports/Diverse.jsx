import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, usePage, router } from '@inertiajs/react';

export default function Diverse({ contracts, jobPositions, jobFunctions, employmentBonds, organizations, contractSituations, filters }) {
    const { flash } = usePage().props;
    const { search, job_position_id, job_function_id, employment_bond_id, organization_id, contract_situation_id } = filters;

    function handleFilter(key, value) {
        router.get(route('rh-reports.diverse'), { ...filters, [key]: value }, { preserveState: true, replace: true });
    }

    return (
        <AuthenticatedLayout header={
            <h2 className="text-xl font-semibold leading-tight text-gray-800">Relatórios Diversos RH</h2>
        }>
            <Head title="Relatórios RH" />
            <div className="py-8 print:py-2"><div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 print:px-0">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}

                <div className="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-3 print:hidden">
                    <input type="text" value={search || ''} onChange={e => handleFilter('search', e.target.value)} placeholder="Buscar por nome..." className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    <select value={job_position_id || ''} onChange={e => handleFilter('job_position_id', e.target.value)} className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Todos os cargos</option>
                        {jobPositions.map(p => <option key={p.id} value={p.id}>{p.name}</option>)}
                    </select>
                    <select value={employment_bond_id || ''} onChange={e => handleFilter('employment_bond_id', e.target.value)} className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Todos os vínculos</option>
                        {employmentBonds.map(b => <option key={b.id} value={b.id}>{b.name}</option>)}
                    </select>
                    <select value={organization_id || ''} onChange={e => handleFilter('organization_id', e.target.value)} className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Todas as lotações</option>
                        {organizations.map(o => <option key={o.id} value={o.id}>{o.name}</option>)}
                    </select>
                    <select value={contract_situation_id || ''} onChange={e => handleFilter('contract_situation_id', e.target.value)} className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Todas as situações</option>
                        {contractSituations.map(s => <option key={s.id} value={s.id}>{s.name}</option>)}
                    </select>
                    <div className="flex gap-2">
                        <button onClick={() => window.print()} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Imprimir PDF</button>
                        {(search || job_position_id || employment_bond_id || organization_id || contract_situation_id) && (
                            <button onClick={() => router.get(route('rh-reports.diverse'), {}, { preserveState: true, replace: true })}
                                className="rounded-md bg-gray-200 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Limpar</button>
                        )}
                    </div>
                </div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg print:shadow-none">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50 print:bg-gray-100"><tr>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Funcionário</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Cargo</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Vínculo</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Lotação</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Situação</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Admissão</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ativo</th>
                        </tr></thead>
                        <tbody className="divide-y divide-gray-200 bg-white">
                            {contracts.length === 0 ? (
                                <tr><td colSpan="7" className="px-4 py-4 text-center text-sm text-gray-500">Nenhum contrato encontrado.</td></tr>
                            ) : contracts.map((c) => (
                                <tr key={c.id}>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm font-medium text-gray-900">{c.personal_info?.user?.name || '-'}</td>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{c.job_position?.name || '-'}</td>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{c.employment_bond?.name || '-'}</td>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{c.locations?.map(l => l.organization?.name).filter(Boolean).join(', ') || '-'}</td>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{c.recruitment_history?.slice(-1)?.[0]?.contract_situation?.name || '-'}</td>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{c.admission_date || '-'}</td>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm">{c.is_active ? <span className="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold text-green-800">Sim</span> : 'Não'}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
