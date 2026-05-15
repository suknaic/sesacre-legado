import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';

export default function Index({ employmentContract, locations }) {
    const { flash } = usePage().props;
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Lotações - {employmentContract.personal_info?.user?.name}</h2>
                <Link href={route('employment-contracts.locations.create', employmentContract.id)}
                    className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Nova Lotação</Link>
            </div>
        }>
            <Head title="Lotações" />
            <div className="py-8"><div className="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}
                <div className="mb-4"><Link href={route('employment-contracts.show', employmentContract.id)} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar ao Contrato</Link></div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50"><tr>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Organização</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Função</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">C.H.</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Início</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Fim</th>
                            <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                        </tr></thead>
                        <tbody className="divide-y divide-gray-200 bg-white">
                            {locations.length === 0 ? (
                                <tr><td colSpan="6" className="px-4 py-4 text-center text-sm text-gray-500">Nenhuma lotação encontrada.</td></tr>
                            ) : locations.map((loc) => (
                                <tr key={loc.id}>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-900">{loc.organization?.name || '-'}</td>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{loc.job_function?.name || '-'}</td>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{loc.workload ? loc.workload + 'h' : '-'}</td>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{loc.start_date || '-'}</td>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{loc.end_date || '-'}</td>
                                    <td className="whitespace-nowrap px-4 py-3 text-sm">
                                        <Link href={route('employment-contracts.locations.edit', [employmentContract.id, loc.id])}
                                            className="text-indigo-600 hover:text-indigo-900">Editar</Link>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
