import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, router, usePage } from '@inertiajs/react';

export default function Index({ items, strategicPlans, filters }) {
    const { flash } = usePage().props;

    function handleFilter(strategic_plan_id) {
        router.get(route('ppa-project-activities.index'), { strategic_plan_id }, { preserveState: true, replace: true });
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Projetos/Atividades do PPA</h2>
                <Link href={route('ppa-project-activities.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Novo</Link>
            </div>
        }>
            <Head title="Projetos/Atividades do PPA" />
            <div className="py-8">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                    <div className="mb-4">
                        <select value={filters.strategic_plan_id || ''} onChange={e => handleFilter(e.target.value)}
                            className="block w-full max-w-xs rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Todos os PPAs</option>
                            {strategicPlans.map(p => <option key={p.id} value={p.id}>{p.name}</option>)}
                        </select>
                    </div>
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Código</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nome</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">PPA</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tipo</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ativo</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-200 bg-white">
                                {items.data.length === 0 ? (
                                    <tr><td colSpan="6" className="px-6 py-4 text-center text-sm text-gray-500">Nenhum registro encontrado.</td></tr>
                                ) : items.data.map((item) => (
                                    <tr key={item.id}>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{item.code}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{item.name}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{item.strategic_plan?.name}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">{item.type === 'P' ? 'Projeto' : 'Atividade'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">{item.is_active ? <span className="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold text-green-800">Sim</span> : 'Não'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">
                                            <Link href={route('ppa-project-activities.show', item.id)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                            <Link href={route('ppa-project-activities.edit', item.id)} className="ml-3 text-indigo-600 hover:text-indigo-900">Editar</Link>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
