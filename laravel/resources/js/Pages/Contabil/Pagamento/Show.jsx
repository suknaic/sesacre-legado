import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';

function formatBRL(value) {
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value || 0);
}

export default function Show({ pagamento }) {
    const { flash } = usePage().props;

    function handleCancelar() {
        if (confirm('Tem certeza que deseja cancelar este pagamento?')) {
            router.delete(route('contabil.pagamentos.cancelar', pagamento.id_pagamento));
        }
    }

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Pagamento {pagamento.nr_pagamento}</h2>}>
            <Head title="Pagamento" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}
                <div className="mb-4"><Link href={route('contabil.pagamentos.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">Nº Pagamento</dt><dd className="mt-1 text-sm text-gray-900">{pagamento.nr_pagamento}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Liquidação</dt><dd className="mt-1 text-sm text-gray-900">
                                <Link href={route('contabil.liquidacoes.show', pagamento.liquidacao?.id_liquidacao)} className="text-indigo-600 hover:text-indigo-900">{pagamento.liquidacao?.nr_liquidacao}</Link>
                            </dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Empenho</dt><dd className="mt-1 text-sm text-gray-900">{pagamento.liquidacao?.empenho?.nr_empenho || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Pedido</dt><dd className="mt-1 text-sm text-gray-900">
                                <Link href={route('financeiro.pedidos.show', pagamento.liquidacao?.empenho?.pedido?.id_pedido)} className="text-indigo-600 hover:text-indigo-900">{pagamento.liquidacao?.empenho?.pedido?.nr_pedido}</Link>
                            </dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Fornecedor</dt><dd className="mt-1 text-sm text-gray-900">{pagamento.liquidacao?.empenho?.pedido?.fornecedor?.pessoa?.nm_pessoa || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Valor</dt><dd className="mt-1 text-sm text-gray-900">{formatBRL(pagamento.vl_pagamento)}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Saldo</dt><dd className="mt-1 text-sm text-gray-900">{formatBRL(pagamento.vl_pagamento_saldo)}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Data</dt><dd className="mt-1 text-sm text-gray-900">{pagamento.dt_pagamento}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Situação</dt><dd className="mt-1 text-sm">
                                <span className={`inline-flex rounded-full px-2 py-1 text-xs font-semibold ${pagamento.id_pagamento_situacao === 1 ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800'}`}>
                                    {pagamento.situacao_label}
                                </span>
                            </dd></div>
                        </dl>
                        {pagamento.ds_pagamento && (
                            <div className="mt-4"><dt className="text-sm font-medium text-gray-500">Descrição</dt><dd className="mt-1 text-sm text-gray-900">{pagamento.ds_pagamento}</dd></div>
                        )}
                    </div>
                </div>

                <div className="mt-6 flex gap-4">
                    <Link href={route('contabil.pagamentos.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Voltar</Link>
                    {pagamento.id_pagamento_situacao === 1 && (
                        <button onClick={handleCancelar} className="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-red-500">Cancelar Pagamento</button>
                    )}
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
