import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';

const statusLabels = { 1: 'Rascunho', 2: 'Assinado', 3: 'Cancelado' };
const statusColors = { 1: 'text-yellow-600', 2: 'text-green-600', 3: 'text-red-600' };

export default function Index({ portarias, filters }) {
    const { flash } = usePage().props;
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Portarias</h2>
                <Link href={route('orcamento.portarias.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Nova Portaria</Link>
            </div>
        }>
            <Head title="Portarias" />
            <div className="py-12"><div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="overflow-x-auto">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50"><tr>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Portaria</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Rede Temática</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Data</th>
                                <th className="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Valor Total</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                            </tr></thead>
                            <tbody className="divide-y divide-gray-200 bg-white">
                                {portarias.data.length === 0 ? (
                                    <tr><td colSpan="6" className="px-6 py-4 text-center text-sm text-gray-500">Nenhuma portaria encontrada.</td></tr>
                                ) : portarias.data.map((p) => (
                                    <tr key={p.id_portaria}>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{p.nm_portaria}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{p.rede_tematica?.nm_rede_tematica || '-'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{p.dt_portaria || '-'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-right text-gray-900">{new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(p.vl_total || 0)}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm"><span className={statusColors[p.st_portaria] || ''}>{statusLabels[p.st_portaria] || '-'}</span></td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">
                                            <Link href={route('orcamento.portarias.show', p.id_portaria)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                            <Link href={route('orcamento.portarias.edit', p.id_portaria)} className="ml-3 text-indigo-600 hover:text-indigo-900">Editar</Link>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    {portarias.total > portarias.per_page && (
                        <div className="border-t border-gray-200 px-6 py-4">
                            <div className="flex items-center justify-between">
                                <span className="text-sm text-gray-700">Mostrando {portarias.from} a {portarias.to} de {portarias.total}</span>
                                <div className="flex gap-2">
                                    {portarias.links.map((link, i) => (
                                        link.url ? (
                                            <Link key={i} href={link.url}
                                                className={`rounded px-3 py-1 text-sm ${link.active ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`}
                                                dangerouslySetInnerHTML={{ __html: link.label }} />
                                        ) : (
                                            <span key={i} className="rounded px-3 py-1 text-sm text-gray-400" dangerouslySetInnerHTML={{ __html: link.label }} />
                                        )
                                    ))}
                                </div>
                            </div>
                        </div>
                    )}
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
