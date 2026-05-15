import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, useForm } from '@inertiajs/react';

const statusColors = {
    0: 'bg-red-100 text-red-800',
    9: 'bg-yellow-100 text-yellow-800',
    10: 'bg-orange-100 text-orange-800',
    11: 'bg-orange-100 text-orange-800',
    12: 'bg-orange-100 text-orange-800',
    13: 'bg-orange-100 text-orange-800',
    14: 'bg-orange-100 text-orange-800',
    15: 'bg-blue-100 text-blue-800',
    16: 'bg-blue-100 text-blue-800',
    17: 'bg-indigo-100 text-indigo-800',
    18: 'bg-indigo-100 text-indigo-800',
    19: 'bg-indigo-100 text-indigo-800',
    20: 'bg-indigo-100 text-indigo-800',
    21: 'bg-purple-100 text-purple-800',
    22: 'bg-purple-100 text-purple-800',
    23: 'bg-green-100 text-green-800',
    24: 'bg-yellow-100 text-yellow-800',
    25: 'bg-purple-100 text-purple-800',
    26: 'bg-purple-100 text-purple-800',
};

function formatBRL(value) {
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value || 0);
}

export default function Show({ pedido, lotacao, tipoGasto }) {
    const { flash } = usePage().props;
    const { post, processing } = useForm({});
    const { delete: destroy, processing: destroyProcessing } = useForm({});

    const niveis = [
        { st: 10, label: 'Resp. Imediato', action: 'autorizar-imediato' },
        { st: 11, label: 'Resp. Central', action: 'autorizar-central' },
        { st: 12, label: 'Orçamentário', action: 'autorizar-orcamentario' },
        { st: 13, label: 'Financeiro', action: 'autorizar-financeiro' },
        { st: 14, label: 'Ordenador', action: 'autorizar-ordenador' },
    ];

    const nivelAtual = niveis.find(n => n.st === pedido.st_pedido);

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Pedido {pedido.id_lotacao}/{pedido.nr_pedido}</h2>}>
            <Head title={`Pedido ${pedido.nr_pedido}`} />
            <div className="py-12"><div className="mx-auto max-w-4xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}
                <div className="mb-4"><Link href={route('financeiro.pedidos.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <div className="mb-4 flex items-center justify-between">
                            <span className={`inline-flex rounded-full px-3 py-1 text-sm font-semibold ${statusColors[pedido.st_pedido] || 'bg-gray-100 text-gray-800'}`}>
                                {pedido.status_label}
                            </span>
                            <div className="flex gap-2">
                                {pedido.pode_cancelar && (
                                    <Link href={route('financeiro.pedidos.edit', pedido.id_pedido)}
                                        className="rounded-md bg-indigo-600 px-3 py-1 text-sm font-semibold text-white hover:bg-indigo-500">Editar</Link>
                                )}
                            </div>
                        </div>

                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">Nº Pedido</dt><dd className="mt-1 text-sm text-gray-900">{pedido.id_lotacao}/{pedido.nr_pedido}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Tipo Solicitação</dt><dd className="mt-1 text-sm text-gray-900">{pedido.tipo_solicitacao?.nm_tipo_solicitacao || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Data</dt><dd className="mt-1 text-sm text-gray-900">{pedido.dt_pedido}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Fornecedor</dt><dd className="mt-1 text-sm text-gray-900">{pedido.fornecedor?.id_pessoa || 'Não informado'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Fonte</dt><dd className="mt-1 text-sm text-gray-900">{pedido.fonte?.nr_fonte || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Programa de Trabalho</dt><dd className="mt-1 text-sm text-gray-900">{pedido.programa_trabalho?.cd_programa_trabalho || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Despesa</dt><dd className="mt-1 text-sm text-gray-900">{pedido.despesa?.cd_despesa || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Elemento Despesa</dt><dd className="mt-1 text-sm text-gray-900">{pedido.despesa_elemento?.cd_despesa_elemento || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Tipo Gasto</dt><dd className="mt-1 text-sm text-gray-900">{tipoGasto?.nm_tipo_gasto || pedido.id_tipo_gasto}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Central</dt><dd className="mt-1 text-sm text-gray-900">{lotacao?.nm_lotacao || pedido.id_lotacao}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Valor</dt><dd className="mt-1 text-lg font-semibold text-gray-900">{formatBRL(pedido.vl_pedido)}</dd></div>
                        </dl>

                        <div className="mt-4">
                            <dt className="text-sm font-medium text-gray-500">Descrição</dt>
                            <dd className="mt-1 text-sm text-gray-900">{pedido.ds_pedido || '-'}</dd>
                        </div>
                    </div>
                </div>

                {nivelAtual && (
                    <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <h3 className="mb-4 text-lg font-semibold text-gray-800">Autorização Pendente: {nivelAtual.label}</h3>
                            <form onSubmit={e => { e.preventDefault(); post(route(`financeiro.pedidos.${nivelAtual.action}`, pedido.id_pedido)); }}>
                                <button type="submit" disabled={processing}
                                    className="rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-green-500 disabled:opacity-50">
                                    {processing ? 'Autorizando...' : `Autorizar como ${nivelAtual.label}`}</button>
                            </form>
                        </div>
                    </div>
                )}

                {pedido.pode_cancelar && (
                    <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <h3 className="mb-4 text-lg font-semibold text-red-800">Cancelar Pedido</h3>
                            <form onSubmit={e => { e.preventDefault(); if (confirm('Tem certeza que deseja cancelar este pedido?')) { destroy(route('financeiro.pedidos.destroy', pedido.id_pedido)); } }}>
                                <button type="submit" disabled={destroyProcessing}
                                    className="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-red-500 disabled:opacity-50">
                                    {destroyProcessing ? 'Cancelando...' : 'Cancelar Pedido'}</button>
                            </form>
                        </div>
                    </div>
                )}

                {pedido.anotacoes?.length > 0 && (
                    <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <h3 className="mb-4 text-lg font-semibold text-gray-800">Histórico</h3>
                            <div className="space-y-3">
                                {pedido.anotacoes.map(a => (
                                    <div key={a.id_pedido_anotacao} className="rounded-md bg-gray-50 p-3">
                                        <p className="text-sm text-gray-700">{a.ds_pedido_anotacao}</p>
                                        <p className="mt-1 text-xs text-gray-500">{a.dh_pedido_anotacao}</p>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                )}
            </div></div>
        </AuthenticatedLayout>
    );
}
