import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, useForm } from '@inertiajs/react';

const statusColors = {
    0: 'bg-red-100 text-red-800', 1: 'bg-yellow-100 text-yellow-800', 2: 'bg-blue-100 text-blue-800',
    3: 'bg-orange-100 text-orange-800', 4: 'bg-orange-100 text-orange-800', 5: 'bg-green-100 text-green-800',
    6: 'bg-purple-100 text-purple-800', 7: 'bg-purple-100 text-purple-800', 8: 'bg-indigo-100 text-indigo-800',
    9: 'bg-green-100 text-green-800',
};

function formatBRL(value) {
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value || 0);
}

export default function Show({ ordem, lotacao, situacaoList }) {
    const { flash } = usePage().props;
    const { post, processing } = useForm({});
    const { data, setData, post: finalizarPost, processing: finalizarProcessing } = useForm({ tipo_finalizacao: '5' });

    function handleRequisitar() {
        if (confirm('Requisitar esta ordem?')) {
            post(route('financeiro.ordens.requisitar', ordem.id_ordem));
        }
    }

    function handleFinalizar(e) {
        e.preventDefault();
        finalizarPost(route('financeiro.ordens.finalizar', ordem.id_ordem), {
            data: { tipo_finalizacao: data.tipo_finalizacao }
        });
    }

    function handleCancelar() {
        if (confirm('Tem certeza que deseja cancelar esta ordem?')) {
            post(route('financeiro.ordens.cancelar', ordem.id_ordem));
        }
    }

    const finalizacoes = [
        { value: '3', label: 'Supressão do Ordenador' },
        { value: '4', label: 'Descumprimento da Contratada' },
        { value: '5', label: 'Finalização Normal' },
    ];

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Ordem {ordem.nr_ordem}/{ordem.aa_ordem}</h2>}>
            <Head title={`Ordem ${ordem.nr_ordem}`} />
            <div className="py-12"><div className="mx-auto max-w-4xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}
                <div className="mb-4"><Link href={route('financeiro.ordens.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <div className="mb-4 flex items-center justify-between">
                            <span className={`inline-flex rounded-full px-3 py-1 text-sm font-semibold ${statusColors[ordem.sit_ordem] || 'bg-gray-100 text-gray-800'}`}>
                                {ordem.status_label}
                            </span>
                            <div className="flex gap-2">
                                {ordem.pode_requisitar && (
                                    <button onClick={handleRequisitar} disabled={processing}
                                        className="rounded-md bg-blue-600 px-3 py-1 text-sm font-semibold text-white hover:bg-blue-500 disabled:opacity-50">Requisitar</button>
                                )}
                            </div>
                        </div>

                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">Nº Ordem</dt><dd className="mt-1 text-sm text-gray-900">{ordem.nr_ordem}/{ordem.aa_ordem}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Tipo</dt><dd className="mt-1 text-sm text-gray-900">{ordem.tipo_label}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Pedido</dt><dd className="mt-1 text-sm text-gray-900">{ordem.pedido?.nr_pedido || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Lotação</dt><dd className="mt-1 text-sm text-gray-900">{lotacao?.nm_lotacao || ordem.id_lotacao}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Data/Hora</dt><dd className="mt-1 text-sm text-gray-900">{ordem.dh_ordem}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Prazo</dt><dd className="mt-1 text-sm text-gray-900">{ordem.nr_prazo_ordem} dias</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Data Início</dt><dd className="mt-1 text-sm text-gray-900">{ordem.dt_ini_ordem || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Data Fim</dt><dd className="mt-1 text-sm text-gray-900">{ordem.dt_fim_ordem || '-'}</dd></div>
                        </dl>
                    </div>
                </div>

                {ordem.pode_finalizar && (
                    <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <h3 className="mb-4 text-lg font-semibold text-gray-800">Finalizar Ordem</h3>
                            <form onSubmit={handleFinalizar}>
                                <div className="mb-4">
                                    <label className="block text-sm font-medium text-gray-700">Tipo de Finalização</label>
                                    <select value={data.tipo_finalizacao} onChange={e => setData('tipo_finalizacao', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        {finalizacoes.map(f => <option key={f.value} value={f.value}>{f.label}</option>)}
                                    </select>
                                </div>
                                <button type="submit" disabled={finalizarProcessing}
                                    className="rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-green-500 disabled:opacity-50">
                                    {finalizarProcessing ? 'Finalizando...' : 'Finalizar Ordem'}</button>
                            </form>
                        </div>
                    </div>
                )}

                {ordem.pode_cancelar && (
                    <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <h3 className="mb-4 text-lg font-semibold text-red-800">Cancelar Ordem</h3>
                            <button onClick={handleCancelar} disabled={processing}
                                className="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-red-500 disabled:opacity-50">
                                {processing ? 'Cancelando...' : 'Cancelar Ordem'}</button>
                        </div>
                    </div>
                )}

                {ordem.itens?.length > 0 && (
                    <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <h3 className="mb-4 text-lg font-semibold text-gray-800">Itens da Ordem</h3>
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50"><tr>
                                    <th className="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">Item</th>
                                    <th className="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">Qtd</th>
                                    <th className="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">Valor</th>
                                </tr></thead>
                                <tbody className="divide-y divide-gray-200">
                                    {ordem.itens.map(item => (
                                        <tr key={item.id_ordem_itens}>
                                            <td className="px-4 py-2 text-sm">{item.id_pre_ordem}</td>
                                            <td className="px-4 py-2 text-sm">{item.qd_itens_pre}</td>
                                            <td className="px-4 py-2 text-sm">{formatBRL(item.vl_itens_pre)}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                )}
            </div></div>
        </AuthenticatedLayout>
    );
}
