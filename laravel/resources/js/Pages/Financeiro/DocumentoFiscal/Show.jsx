import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, useForm } from '@inertiajs/react';

const statusColors = {
    1: 'bg-yellow-100 text-yellow-800', 2: 'bg-blue-100 text-blue-800', 3: 'bg-purple-100 text-purple-800',
    4: 'bg-indigo-100 text-indigo-800', 5: 'bg-orange-100 text-orange-800', 6: 'bg-green-100 text-green-800',
    7: 'bg-red-100 text-red-800',
};

function formatBRL(value) {
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value || 0);
}

export default function Show({ documento, tramitacoes, situacaoList, tpTramitacao }) {
    const { flash } = usePage().props;
    const { post, processing } = useForm({});
    const { data, setData, post: formPost, processing: formProcessing, errors } = useForm({
        id_doc_destino: '',
        ds_doc_tramitacao: '',
        ds_observacao: '',
    });

    function handleEncaminhar(e) {
        e.preventDefault();
        formPost(route('financeiro.documentos-fiscais.encaminhar', documento.id_documento_fiscal), {
            data: { id_doc_destino: data.id_doc_destino, ds_doc_tramitacao: data.ds_doc_tramitacao }
        });
    }

    function handleReceber() {
        if (confirm('Receber este documento?')) {
            post(route('financeiro.documentos-fiscais.receber', documento.id_documento_fiscal));
        }
    }

    function handleLiquidar() {
        if (confirm('Liquidar este documento?')) {
            post(route('financeiro.documentos-fiscais.liquidar', documento.id_documento_fiscal));
        }
    }

    function handlePagar() {
        if (confirm('Registrar pagamento deste documento?')) {
            post(route('financeiro.documentos-fiscais.pagar', documento.id_documento_fiscal));
        }
    }

    function handleCancelar(e) {
        e.preventDefault();
        if (confirm('Tem certeza que deseja cancelar este documento?')) {
            formPost(route('financeiro.documentos-fiscais.cancelar', documento.id_documento_fiscal), {
                data: { ds_observacao: data.ds_observacao }
            });
        }
    }

    const podeEncaminhar = documento.id_documento_situacao === 1 || documento.id_documento_situacao === 2;
    const podeReceber = documento.id_documento_situacao === 1 || documento.id_documento_situacao === 2;
    const podeLiquidar = documento.id_documento_situacao === 2;
    const podePagar = [3, 4, 5].includes(documento.id_documento_situacao);
    const podeCancelar = documento.id_documento_situacao === 1;

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Documento Fiscal {documento.nr_documento_fiscal}</h2>}>
            <Head title={`Documento ${documento.nr_documento_fiscal}`} />
            <div className="py-12"><div className="mx-auto max-w-4xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}
                <div className="mb-4"><Link href={route('financeiro.documentos-fiscais.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <div className="mb-4 flex items-center justify-between">
                            <span className={`inline-flex rounded-full px-3 py-1 text-sm font-semibold ${statusColors[documento.id_documento_situacao] || 'bg-gray-100 text-gray-800'}`}>
                                {documento.situacao_label}
                            </span>
                            <div className="flex gap-2">
                                {podeCancelar && (
                                    <Link href={route('financeiro.documentos-fiscais.edit', documento.id_documento_fiscal)}
                                        className="rounded-md bg-indigo-600 px-3 py-1 text-sm font-semibold text-white hover:bg-indigo-500">Editar</Link>
                                )}
                            </div>
                        </div>

                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">Nº Documento</dt><dd className="mt-1 text-sm text-gray-900">{documento.nr_documento_fiscal}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Processo Adm.</dt><dd className="mt-1 text-sm text-gray-900">{documento.nr_processo_administrativo}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Tipo</dt><dd className="mt-1 text-sm text-gray-900">{documento.tipo_documento?.nm_tipo_documento || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Pedido</dt><dd className="mt-1 text-sm text-gray-900">{documento.pedido?.nr_pedido || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Data Emissão</dt><dd className="mt-1 text-sm text-gray-900">{documento.dt_emissao}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Data Vencimento</dt><dd className="mt-1 text-sm text-gray-900">{documento.dt_vencimento || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Data Atesto</dt><dd className="mt-1 text-sm text-gray-900">{documento.dt_atesto}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Competência</dt><dd className="mt-1 text-sm text-gray-900">{documento.mm_competencia}/{documento.aa_competencia}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Valor</dt><dd className="mt-1 text-lg font-semibold text-gray-900">{formatBRL(documento.vl_documento)}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Saldo</dt><dd className="mt-1 text-lg font-semibold text-gray-900">{formatBRL(documento.vl_documento_saldo)}</dd></div>
                        </dl>

                        {documento.ds_observacao && (
                            <div className="mt-4">
                                <dt className="text-sm font-medium text-gray-500">Observação</dt>
                                <dd className="mt-1 text-sm text-gray-900">{documento.ds_observacao}</dd>
                            </div>
                        )}

                        {(documento.fl_grp || documento.fl_encontro_contas) && (
                            <div className="mt-4 flex gap-4">
                                {documento.fl_grp && <span className="inline-flex rounded-full bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800">GRP: {documento.nr_grp_numero || 'N/I'}</span>}
                                {documento.fl_encontro_contas && <span className="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">Encontro Contas DAE: {documento.nr_encontro_dae || 'N/I'}</span>}
                            </div>
                        )}
                    </div>
                </div>

                {podeEncaminhar && (
                    <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <h3 className="mb-4 text-lg font-semibold text-gray-800">Encaminhar Documento</h3>
                            <form onSubmit={handleEncaminhar}>
                                <div className="mb-4">
                                    <label className="block text-sm font-medium text-gray-700">Destino (ID Lotação)</label>
                                    <input type="number" value={data.id_doc_destino} onChange={e => setData('id_doc_destino', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                    {errors.id_doc_destino && <p className="mt-1 text-sm text-red-600">{errors.id_doc_destino}</p>}
                                </div>
                                <div className="mb-4">
                                    <label className="block text-sm font-medium text-gray-700">Observação</label>
                                    <textarea value={data.ds_doc_tramitacao} onChange={e => setData('ds_doc_tramitacao', e.target.value)} rows={2}
                                        className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                </div>
                                <button type="submit" disabled={formProcessing}
                                    className="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-500 disabled:opacity-50">Encaminhar</button>
                            </form>
                        </div>
                    </div>
                )}

                {podeReceber && (
                    <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <h3 className="mb-4 text-lg font-semibold text-gray-800">Receber Documento</h3>
                            <button onClick={handleReceber} disabled={processing}
                                className="rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-teal-500 disabled:opacity-50">Receber Documento</button>
                        </div>
                    </div>
                )}

                {podeLiquidar && (
                    <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <h3 className="mb-4 text-lg font-semibold text-gray-800">Liquidar Documento</h3>
                            <button onClick={handleLiquidar} disabled={processing}
                                className="rounded-md bg-purple-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-purple-500 disabled:opacity-50">Liquidar Documento</button>
                        </div>
                    </div>
                )}

                {podePagar && (
                    <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <h3 className="mb-4 text-lg font-semibold text-gray-800">Pagamento</h3>
                            <button onClick={handlePagar} disabled={processing}
                                className="rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-green-500 disabled:opacity-50">Registrar Pagamento</button>
                        </div>
                    </div>
                )}

                {podeCancelar && (
                    <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <h3 className="mb-4 text-lg font-semibold text-red-800">Cancelar Documento</h3>
                            <form onSubmit={handleCancelar}>
                                <div className="mb-4">
                                    <label className="block text-sm font-medium text-gray-700">Justificativa *</label>
                                    <textarea value={data.ds_observacao} onChange={e => setData('ds_observacao', e.target.value)} rows={2}
                                        className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                    {errors.ds_observacao && <p className="mt-1 text-sm text-red-600">{errors.ds_observacao}</p>}
                                </div>
                                <button type="submit" disabled={formProcessing}
                                    className="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-red-500 disabled:opacity-50">Cancelar Documento</button>
                            </form>
                        </div>
                    </div>
                )}

                {tramitacoes.length > 0 && (
                    <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <h3 className="mb-4 text-lg font-semibold text-gray-800">Histórico de Tramitação</h3>
                            <div className="space-y-3">
                                {tramitacoes.map(t => (
                                    <div key={t.id_doc_tramitacao} className="rounded-md bg-gray-50 p-3">
                                        <div className="flex items-center justify-between">
                                            <span className="inline-flex rounded-full bg-gray-200 px-2 py-0.5 text-xs font-semibold text-gray-700">{t.tipo_label}</span>
                                            <span className="text-xs text-gray-500">{t.dh_doc_tramitacao}</span>
                                        </div>
                                        <p className="mt-1 text-sm text-gray-700">{t.ds_doc_tramitacao || 'Sem descrição'}</p>
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
