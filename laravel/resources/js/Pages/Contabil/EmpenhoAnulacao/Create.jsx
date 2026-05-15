import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ nextNumber, pedidos }) {
    const { data, setData, post, processing, errors } = useForm({
        id_pedido: '',
        vl_empenho_anulacao: '',
        dt_empenho_anulacao: '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('contabil.empenhos-anulacao.store'));
    }

    const selectedPedido = pedidos.find(p => p.id_pedido == data.id_pedido);

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Nova Anulação de Empenho</h2>}>
            <Head title="Nova Anulação de Empenho" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('contabil.empenhos-anulacao.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-4">
                            <p className="text-sm text-gray-500">Nº Anulação: <strong>{nextNumber}</strong></p>
                        </div>

                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Pedido com Empenho *</label>
                            <select value={data.id_pedido} onChange={e => setData('id_pedido', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione um pedido</option>
                                {pedidos.map(p => (
                                    <option key={p.id_pedido} value={p.id_pedido}>{p.label}</option>
                                ))}
                            </select>
                            {errors.id_pedido && <p className="mt-1 text-sm text-red-600">{errors.id_pedido}</p>}
                        </div>

                        {selectedPedido && (
                            <div className="mb-6 rounded-md bg-gray-50 p-4">
                                <h4 className="text-sm font-medium text-gray-700">Detalhes do Empenho</h4>
                                <dl className="mt-2 grid grid-cols-2 gap-2 text-sm">
                                    <dt className="text-gray-500">Empenho Ativo:</dt>
                                    <dd>{selectedPedido.nr_empenho_ativo}</dd>
                                    <dt className="text-gray-500">Saldo Disponível:</dt>
                                    <dd>R$ {Number(selectedPedido.vl_saldo_empenho).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</dd>
                                    <dt className="text-gray-500">Fornecedor:</dt>
                                    <dd>{selectedPedido.fornecedor?.pessoa?.nm_pessoa || '-'}</dd>
                                </dl>
                            </div>
                        )}

                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Valor da Anulação *</label>
                            <input type="number" step="0.01" min="0.01" value={data.vl_empenho_anulacao} onChange={e => setData('vl_empenho_anulacao', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            {errors.vl_empenho_anulacao && <p className="mt-1 text-sm text-red-600">{errors.vl_empenho_anulacao}</p>}
                        </div>

                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Data da Anulação *</label>
                            <input type="date" value={data.dt_empenho_anulacao} onChange={e => setData('dt_empenho_anulacao', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            {errors.dt_empenho_anulacao && <p className="mt-1 text-sm text-red-600">{errors.dt_empenho_anulacao}</p>}
                        </div>

                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('contabil.empenhos-anulacao.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
