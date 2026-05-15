import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';

function formatBRL(value) {
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value || 0);
}

export default function Show({ anulacao }) {
    const { flash } = usePage().props;

    function handleAssinar(deferido) {
        if (confirm(deferido ? 'Deferir esta anulação?' : 'Indeferir esta anulação?')) {
            router.post(route('contabil.empenhos-anulacao.assinar', anulacao.id_empenho_anulacao), { deferido: deferido ? 1 : 0 });
        }
    }

    function handleCancelar() {
        if (confirm('Tem certeza que deseja cancelar esta anulação?')) {
            router.delete(route('contabil.empenhos-anulacao.cancelar', anulacao.id_empenho_anulacao));
        }
    }

    const podeAssinar = anulacao.id_empenho_anulacao_situacao === 1;
    const podeCancelar = anulacao.id_empenho_anulacao_situacao === 1;

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Anulação {anulacao.nr_empenho_anulacao}</h2>}>
            <Head title="Anulação de Empenho" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}
                <div className="mb-4"><Link href={route('contabil.empenhos-anulacao.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">Nº Anulação</dt><dd className="mt-1 text-sm text-gray-900">{anulacao.nr_empenho_anulacao}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Empenho</dt><dd className="mt-1 text-sm text-gray-900">{anulacao.nr_empenho || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Pedido</dt><dd className="mt-1 text-sm text-gray-900">
                                <Link href={route('financeiro.pedidos.show', anulacao.pedido?.id_pedido)} className="text-indigo-600 hover:text-indigo-900">{anulacao.pedido?.nr_pedido}</Link>
                            </dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Fornecedor</dt><dd className="mt-1 text-sm text-gray-900">{anulacao.pedido?.fornecedor?.pessoa?.nm_pessoa || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Valor Anulado</dt><dd className="mt-1 text-sm text-gray-900">{formatBRL(anulacao.vl_empenho_anulacao)}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Saldo Resultante</dt><dd className="mt-1 text-sm text-gray-900">{formatBRL(anulacao.vl_empenho_saldo)}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Data</dt><dd className="mt-1 text-sm text-gray-900">{anulacao.dt_empenho_anulacao}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Situação</dt><dd className="mt-1 text-sm">
                                <span className={`inline-flex rounded-full px-2 py-1 text-xs font-semibold ${anulacao.id_empenho_anulacao_situacao === 2 ? 'bg-green-100 text-green-800' : anulacao.id_empenho_anulacao_situacao === 3 ? 'bg-red-100 text-red-800' : anulacao.id_empenho_anulacao_situacao === 4 ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800'}`}>
                                    {anulacao.situacao_label}
                                </span>
                            </dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Status</dt><dd className="mt-1 text-sm text-gray-900">{anulacao.status_label}</dd></div>
                        </dl>
                    </div>
                </div>

                <div className="mt-6 flex gap-4">
                    <Link href={route('contabil.empenhos-anulacao.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Voltar</Link>
                    {podeAssinar && (
                        <>
                            <button onClick={() => handleAssinar(true)} className="rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-green-500">Deferir</button>
                            <button onClick={() => handleAssinar(false)} className="rounded-md bg-yellow-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-yellow-500">Indeferir</button>
                        </>
                    )}
                    {podeCancelar && (
                        <button onClick={handleCancelar} className="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-red-500">Cancelar</button>
                    )}
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
