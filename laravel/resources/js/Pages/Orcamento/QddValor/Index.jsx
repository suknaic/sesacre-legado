import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Index({ valores, qdds, filters }) {
    const { flash } = usePage().props;
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Valores QDD</h2>
                <Link href={route('orcamento.qdd-valor.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Novo Valor</Link>
            </div>
        }>
            <Head title="Valores QDD" />
            <div className="py-12"><div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                        <h3 className="text-lg font-medium text-gray-900">Lista de Valores</h3>
                    </div>
                    <div className="overflow-x-auto">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50"><tr>
                                <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">QDD</th>
                                <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Fonte</th>
                                <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Programa</th>
                                <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Elemento</th>
                                <th className="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Inicial</th>
                                <th className="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Saldo</th>
                                <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                            </tr></thead>
                            <tbody className="divide-y divide-gray-200 bg-white">
                                {valores.data.length === 0 ? (
                                    <tr><td colSpan="7" className="px-6 py-4 text-center text-sm text-gray-500">Nenhum valor encontrado.</td></tr>
                                ) : valores.data.map((v) => (
                                    <tr key={v.id_qdd_valor}>
                                        <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-900">{v.qdd?.aa_qdd || '-'}</td>
                                        <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-900">{v.fonte?.nr_fonte || '-'}</td>
                                        <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-900">{v.programaTrabalho?.cd_programa_trabalho || '-'}</td>
                                        <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-900">{v.despesaElemento?.cd_despesa_elemento || '-'}</td>
                                        <td className="whitespace-nowrap px-4 py-3 text-sm text-right text-gray-900">{new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(v.vl_qdd_inical || 0)}</td>
                                        <td className="whitespace-nowrap px-4 py-3 text-sm text-right text-gray-900">{new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(v.vl_saldo || 0)}</td>
                                        <td className="whitespace-nowrap px-4 py-3 text-sm">
                                            <Link href={route('orcamento.qdd-valor.show', v.id_qdd_valor)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                            <Link href={route('orcamento.qdd-valor.edit', v.id_qdd_valor)} className="ml-3 text-indigo-600 hover:text-indigo-900">Editar</Link>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    {valores.total > valores.per_page && (
                        <div className="border-t border-gray-200 px-6 py-4">
                            <div className="flex items-center justify-between">
                                <span className="text-sm text-gray-700">Mostrando {valores.from} a {valores.to} de {valores.total}</span>
                                <div className="flex gap-2">
                                    {valores.links.map((link, i) => (
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
