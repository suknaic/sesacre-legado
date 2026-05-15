import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ nextNumber, liquidacoes }) {
    const { data, setData, post, processing, errors } = useForm({
        id_liquidacao: '',
        vl_pagamento: '',
        dt_pagamento: '',
        ds_pagamento: '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('contabil.pagamentos.store'));
    }

    const selectedLiquidacao = liquidacoes.find(l => l.id_liquidacao == data.id_liquidacao);

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Novo Pagamento</h2>}>
            <Head title="Novo Pagamento" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('contabil.pagamentos.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-4">
                            <p className="text-sm text-gray-500">Nº Pagamento: <strong>{nextNumber}</strong></p>
                        </div>

                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Liquidação *</label>
                            <select value={data.id_liquidacao} onChange={e => setData('id_liquidacao', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione uma liquidação</option>
                                {liquidacoes.map(l => (
                                    <option key={l.id_liquidacao} value={l.id_liquidacao}>{l.label}</option>
                                ))}
                            </select>
                            {errors.id_liquidacao && <p className="mt-1 text-sm text-red-600">{errors.id_liquidacao}</p>}
                        </div>

                        {selectedLiquidacao && (
                            <div className="mb-6 rounded-md bg-gray-50 p-4">
                                <h4 className="text-sm font-medium text-gray-700">Detalhes da Liquidação</h4>
                                <dl className="mt-2 grid grid-cols-2 gap-2 text-sm">
                                    <dt className="text-gray-500">Fornecedor:</dt>
                                    <dd>{selectedLiquidacao.empenho?.pedido?.fornecedor?.pessoa?.nm_pessoa || '-'}</dd>
                                    <dt className="text-gray-500">Valor Original:</dt>
                                    <dd>R$ {Number(selectedLiquidacao.vl_liquidacao).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</dd>
                                    <dt className="text-gray-500">Saldo Disponível:</dt>
                                    <dd>R$ {Number(selectedLiquidacao.vl_saldo).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</dd>
                                </dl>
                            </div>
                        )}

                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Valor do Pagamento *</label>
                            <input type="number" step="0.01" min="0.01" value={data.vl_pagamento} onChange={e => setData('vl_pagamento', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            {errors.vl_pagamento && <p className="mt-1 text-sm text-red-600">{errors.vl_pagamento}</p>}
                        </div>

                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Data do Pagamento *</label>
                            <input type="date" value={data.dt_pagamento} onChange={e => setData('dt_pagamento', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            {errors.dt_pagamento && <p className="mt-1 text-sm text-red-600">{errors.dt_pagamento}</p>}
                        </div>

                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea value={data.ds_pagamento} onChange={e => setData('ds_pagamento', e.target.value)} rows={2}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('contabil.pagamentos.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
                            <button type="submit" disabled={processing}
                                className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50">
                                {processing ? 'Salvando...' : 'Salvar'}</button>
                        </div>
                    </form>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
