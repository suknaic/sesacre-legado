import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Edit({ preOrdem, pedidos, fornecedores }) {
    const { data, setData, put, processing, errors } = useForm({
        id_pedido: preOrdem.id_pedido || '',
        id_fornecedor: preOrdem.id_fornecedor || '',
        qt_itens_pre: preOrdem.qt_itens_pre || '',
        vl_itens_pre: preOrdem.vl_itens_pre || '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        put(route('financeiro.pre-ordens.update', preOrdem.id_pre_ordem));
    }

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Editar Pré-Ordem #{preOrdem.id_pre_ordem}</h2>}>
            <Head title="Editar Pré-Ordem" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('financeiro.pre-ordens.show', preOrdem.id_pre_ordem)} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Pedido *</label>
                            <select value={data.id_pedido} onChange={e => setData('id_pedido', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione</option>
                                {pedidos.map(p => <option key={p.id_pedido} value={p.id_pedido}>{p.nr_pedido}</option>)}
                            </select>
                            {errors.id_pedido && <p className="mt-1 text-sm text-red-600">{errors.id_pedido}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Fornecedor *</label>
                            <select value={data.id_fornecedor} onChange={e => setData('id_fornecedor', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione</option>
                                {fornecedores.map(f => <option key={f.id_fornecedor} value={f.id_fornecedor}>{f.nm_pessoa}</option>)}
                            </select>
                            {errors.id_fornecedor && <p className="mt-1 text-sm text-red-600">{errors.id_fornecedor}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Quantidade de Itens</label>
                            <input type="number" min="1" value={data.qt_itens_pre} onChange={e => setData('qt_itens_pre', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Valor dos Itens</label>
                            <input type="number" step="0.01" min="0" value={data.vl_itens_pre} onChange={e => setData('vl_itens_pre', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('financeiro.pre-ordens.show', preOrdem.id_pre_ordem)} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
