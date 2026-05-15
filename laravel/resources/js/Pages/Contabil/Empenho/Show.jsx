import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';

function formatBRL(value) {
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value || 0);
}

export default function Show({ empenho, totalLiquidado, saldoDisponivel }) {
    const { flash } = usePage().props;

    function handleCancelar() {
        if (confirm('Tem certeza que deseja cancelar este empenho?')) {
            router.delete(route('contabil.empenhos.cancelar', empenho.id_empenho));
        }
    }

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Empenho {empenho.nr_empenho}</h2>}>
            <Head title="Empenho" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}
                <div className="mb-4"><Link href={route('contabil.empenhos.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">Nº Empenho</dt><dd className="mt-1 text-sm text-gray-900">{empenho.nr_empenho}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Nº Pedido</dt><dd className="mt-1 text-sm text-gray-900">
                                <Link href={route('financeiro.pedidos.show', empenho.pedido?.id_pedido)} className="text-indigo-600 hover:text-indigo-900">{empenho.pedido?.nr_pedido}</Link>
                            </dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Fornecedor</dt><dd className="mt-1 text-sm text-gray-900">{empenho.pedido?.fornecedor?.pessoa?.nm_pessoa || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Tipo</dt><dd className="mt-1 text-sm text-gray-900">{empenho.tipo_empenho?.nm_tipo_empenho || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Valor</dt><dd className="mt-1 text-sm text-gray-900">{formatBRL(empenho.vl_empenho)}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Total Liquidado</dt><dd className="mt-1 text-sm text-gray-900">{formatBRL(totalLiquidado)}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Saldo Disponível</dt><dd className="mt-1 text-sm text-gray-900">{formatBRL(saldoDisponivel)}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Data Sistema</dt><dd className="mt-1 text-sm text-gray-900">{empenho.dt_empenho_sistema || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Data SAFIRA</dt><dd className="mt-1 text-sm text-gray-900">{empenho.dt_empenho_safira || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Programa Trabalho</dt><dd className="mt-1 text-sm text-gray-900">{empenho.pedido?.programa_trabalho?.cd_programa_trabalho || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Fonte</dt><dd className="mt-1 text-sm text-gray-900">{empenho.pedido?.fonte?.nr_fonte || '-'}</dd></div>
                        </dl>
                        {empenho.ds_empenho && (
                            <div className="mt-4"><dt className="text-sm font-medium text-gray-500">Descrição</dt><dd className="mt-1 text-sm text-gray-900">{empenho.ds_empenho}</dd></div>
                        )}
                    </div>
                </div>

                <div className="mt-6 flex gap-4">
                    <Link href={route('contabil.empenhos.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Voltar</Link>
                    {empenho.sit_empenho === 1 && (
                        <button onClick={handleCancelar} className="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-red-500">Cancelar Empenho</button>
                    )}
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
