import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';

export default function Index({ employmentContracts, filters = {} }) {
    const { flash } = usePage().props;
    const { search = '', is_active = '' } = filters;

    function handleFilterChange(key, value) {
        router.get(route('employment-contracts.index'), { ...filters, [key]: value, page: 1 }, { preserveState: true, replace: true });
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Contratos de Trabalho</h2>
                <Link href={route('employment-contracts.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Novo Contrato</Link>
            </div>
        }>
            <Head title="Contratos de Trabalho" />
            <div className="py-8"><div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}

                <div className="mb-4 flex gap-4">
                    <input type="text" value={search} onChange={e => handleFilterChange('search', e.target.value)}
                        placeholder="Buscar por matrícula ou nome..."
                        className="block w-full max-w-xs rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    <select value={is_active} onChange={e => handleFilterChange('is_active', e.target.value)}
                        className="block w-40 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Todos</option>
                        <option value="1">Ativos</option>
                        <option value="0">Inativos</option>
                    </select>
                </div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50"><tr>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Matrícula</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Funcionário</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Vínculo</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Cargo</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Admissão</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Término</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">C.H.</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                        </tr></thead>
                        <tbody className="divide-y divide-gray-200 bg-white">
                            {employmentContracts.data.length === 0 ? (
                                <tr><td colSpan="9" className="px-6 py-4 text-center text-sm text-gray-500">Nenhum contrato encontrado.</td></tr>
                            ) : employmentContracts.data.map((p) => (
                                <tr key={p.id}>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{p.registration_number || '-'}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{p.personal_info?.user?.name || '-'}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{p.employment_bond?.name || '-'}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{p.job_position?.name || '-'}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{p.admission_date || '-'}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{p.termination_date || '-'}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{p.workload ? p.workload + 'h' : '-'}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm">{p.is_active ? <span className="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold text-green-800">Sim</span> : <span className="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold text-red-800">Não</span>}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm">
                                        <Link href={route('employment-contracts.show', p.id)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                        <Link href={route('employment-contracts.edit', p.id)} className="ml-3 text-indigo-600 hover:text-indigo-900">Editar</Link>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>

                {employmentContracts.links && (
                    <div className="mt-4 flex justify-center gap-1">
                        {employmentContracts.links.map((link, i) => (
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
