import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Index({ perDiemRequests }) {
    const { flash } = usePage().props;
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Diárias - Proposta e Concessão</h2>
                <Link href={route('per-diem-requests.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Nova Solicitação</Link>
            </div>
        }>
            <Head title="Diárias - Proposta e Concessão" />
            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="overflow-x-auto">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">ID</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Serviço</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tipo Viagem</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Local</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Data</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ativo</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-200 bg-white">
                                    {perDiemRequests.data.length === 0 ? (
                                        <tr><td colSpan="7" className="px-6 py-4 text-center text-sm text-gray-500">Nenhuma solicitação encontrada.</td></tr>
                                    ) : perDiemRequests.data.map((req) => (
                                        <tr key={req.id}>
                                            <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{req.id}</td>
                                            <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{req.service_description || '-'}</td>
                                            <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{req.travel_type?.name || '-'}</td>
                                            <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{req.locations || '-'}</td>
                                            <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{req.created_at || '-'}</td>
                                            <td className="whitespace-nowrap px-6 py-4 text-sm">{req.is_active ? <span className="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold text-green-800">Sim</span> : 'Não'}</td>
                                            <td className="whitespace-nowrap px-6 py-4 text-sm">
                                                <Link href={route('per-diem-requests.show', req.id)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                                <Link href={route('per-diem-requests.edit', req.id)} className="ml-3 text-indigo-600 hover:text-indigo-900">Editar</Link>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                        {perDiemRequests.total > perDiemRequests.per_page && (
                            <div className="border-t border-gray-200 px-6 py-4">
                                <div className="flex items-center justify-between">
                                    <span className="text-sm text-gray-700">Mostrando {perDiemRequests.from} a {perDiemRequests.to} de {perDiemRequests.total}</span>
                                    <div className="flex gap-2">
                                        {perDiemRequests.links.map((link, i) => (
                                            link.url ? (
                                                <Link key={i} href={link.url}
                                                    className={`rounded px-3 py-1 text-sm ${link.active ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`}
                                                    dangerouslySetInnerHTML={{ __html: link.label }} />
                                            ) : (
                                                <span key={i} className="rounded px-3 py-1 text-sm text-gray-400"
                                                    dangerouslySetInnerHTML={{ __html: link.label }} />
                                            )
                                        ))}
                                    </div>
                                </div>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
