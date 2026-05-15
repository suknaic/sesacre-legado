import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';

function formatBRL(value) {
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value || 0);
}

export default function Show({ liquidacao, totalPago }) {
    const { flash } = usePage().props;

    function handleAssinar() {
        if (confirm('Assinar esta liquidação?')) {
            router.post(route('contabil.liquidacoes.assinar', liquidacao.id_liquidacao));
        }
    }

    function handleFinalizarPagamento() {
        if (confirm('Finalizar pagamento desta liquidação?')) {
            router.post(route('contabil.liquidacoes.finalizar-pagamento', liquidacao.id_liquidacao));
        }
    }

    function handleCancelar() {
        if (confirm('Tem certeza que deseja cancelar esta liquidação?')) {
            router.delete(route('contabil.liquidacoes.cancelar', liquidacao.id_liquidacao));
        }
    }

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Liquidação {liquidacao.nr_liquidacao}</h2>}>
            <Head title="Liquidação" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}
                <div className="mb-4"><Link href={route('contabil.liquidacoes.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">Nº Liquidação</dt><dd className="mt-1 text-sm text-gray-900">{liquidacao.nr_liquidacao}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Empenho</dt><dd className="mt-1 text-sm text-gray-900">{liquidacao.empenho?.nr_empenho || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Pedido</dt><dd className="mt-1 text-sm text-gray-900">
                                <Link href={route('financeiro.pedidos.show', liquidacao.empenho?.pedido?.id_pedido)} className="text-indigo-600 hover:text-indigo-900">{liquidacao.empenho?.pedido?.nr_pedido}</Link>
                            </dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Fornecedor</dt><dd className="mt-1 text-sm text-gray-900">{liquidacao.empenho?.pedido?.fornecedor?.pessoa?.nm_pessoa || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Valor</dt><dd className="mt-1 text-sm text-gray-900">{formatBRL(liquidacao.vl_liquidacao)}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Saldo</dt><dd className="mt-1 text-sm text-gray-900">{formatBRL(liquidacao.vl_liquidacao_saldo)}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Total Pago</dt><dd className="mt-1 text-sm text-gray-900">{formatBRL(totalPago)}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Data</dt><dd className="mt-1 text-sm text-gray-900">{liquidacao.dt_liquidacao}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Situação</dt><dd className="mt-1 text-sm">
                                <span className={`inline-flex rounded-full px-2 py-1 text-xs font-semibold ${liquidacao.situacao_color}`}>{liquidacao.situacao_label}</span>
                            </dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Status</dt><dd className="mt-1 text-sm text-gray-900">{liquidacao.status_label}</dd></div>
                        </dl>
                        {liquidacao.ds_liquidacao && (
                            <div className="mt-4"><dt className="text-sm font-medium text-gray-500">Descrição</dt><dd className="mt-1 text-sm text-gray-900">{liquidacao.ds_liquidacao}</dd></div>
                        )}
                    </div>
                </div>

                {liquidacao.documentos && liquidacao.documentos.length > 0 && (
                    <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <h3 className="text-sm font-medium text-gray-700 mb-4">Documentos Vinculados</h3>
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50"><tr>
                                    <th className="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">Documento</th>
                                    <th className="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">Valor</th>
                                </tr></thead>
                                <tbody className="divide-y divide-gray-200">
                                    {liquidacao.documentos.map(doc => (
                                        <tr key={doc.id_liquidacao_doc}>
                                            <td className="px-4 py-2 text-sm">{doc.documento_fiscal?.nr_documento_fiscal || '-'}</td>
                                            <td className="px-4 py-2 text-sm">{formatBRL(doc.vl_liquidacao_doc)}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                )}

                <div className="mt-6 flex gap-4">
                    <Link href={route('contabil.liquidacoes.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Voltar</Link>
                    {liquidacao.id_liquidacao_situacao === 1 && (
                        <button onClick={handleAssinar} className="rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-green-500">Assinar Liquidação</button>
                    )}
                    {liquidacao.id_liquidacao_status === 2 && (
                        <button onClick={handleFinalizarPagamento} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Finalizar Pagamento</button>
                    )}
                    {liquidacao.id_liquidacao_situacao !== 3 && liquidacao.id_liquidacao_situacao !== 4 && (
                        <button onClick={handleCancelar} className="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-red-500">Cancelar</button>
                    )}
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
