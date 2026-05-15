import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Index({ preOrdens, filters }) {
    const { flash } = usePage().props;
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Pré-Ordens</h2>
                <Link href={route('financeiro.pre-ordens.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Nova Pré-Ordem</Link>
            </div>
        }>
            <Head title="Pré-Ordens" />
            <div className="py-12"><div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="overflow-x-auto">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50"><tr>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">ID</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Pedido</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Fornecedor</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Qtd Itens</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Valor Total</th>
                                <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                            </tr></thead>
                            <tbody className="divide-y divide-gray-200 bg-white">
                                {preOrdens.data.length === 0 ? (
                                    <tr><td colSpan="6" className="px-6 py-4 text-center text-sm text-gray-500">Nenhuma pré-ordem encontrada.</td></tr>
                                ) : preOrdens.data.map((po) => (
                                    <tr key={po.id_pre_ordem}>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{po.id_pre_ordem}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{po.pedido?.nr_pedido || po.id_pedido}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{po.fornecedor?.id_pessoa || po.id_fornecedor}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{po.qt_itens_pre || '-'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                            {new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(po.vl_total || 0)}
                                        </td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">
                                            <Link href={route('financeiro.pre-ordens.show', po.id_pre_ordem)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                            <Link href={route('financeiro.pre-ordens.edit', po.id_pre_ordem)} className="ml-3 text-indigo-600 hover:text-indigo-900">Editar</Link>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    {preOrdens.total > preOrdens.per_page && (
                        <div className="border-t border-gray-200 px-6 py-4">
                            <div className="flex items-center justify-between">
                                <span className="text-sm text-gray-700">Mostrando {preOrdens.from} a {preOrdens.to} de {preOrdens.total}</span>
                                <div className="flex gap-2">
                                    {preOrdens.links.map((link, i) => (
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
