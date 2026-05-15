import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ nextNumber, pedidos, tiposOrdem, lotacoes, fornecedores }) {
    const { data, setData, post, processing, errors } = useForm({
        id_pedido: '',
        id_lotacao: '',
        tp_ordem: '1',
        nr_prazo_ordem: '30',
        dt_ini_ordem: '',
        dt_fim_ordem: '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('financeiro.ordens.store'));
    }

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Nova Ordem</h2>}>
            <Head title="Nova Ordem" />
            <div className="py-12"><div className="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('financeiro.ordens.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Nº Ordem (automático)</label>
                            <input type="text" value={`${nextNumber}/${new Date().getFullYear()}`} readOnly
                                className="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 text-sm shadow-sm" />
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Pedido * (status: Aguardando Ordem)</label>
                            <select value={data.id_pedido} onChange={e => setData('id_pedido', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione um pedido</option>
                                {pedidos.map(p => <option key={p.id_pedido} value={p.id_pedido}>{p.nr_pedido} - {p.ds_pedido}</option>)}
                            </select>
                            {errors.id_pedido && <p className="mt-1 text-sm text-red-600">{errors.id_pedido}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Tipo de Ordem *</label>
                            <select value={data.tp_ordem} onChange={e => setData('tp_ordem', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                {Object.entries(tiposOrdem).map(([k, v]) => <option key={k} value={k}>{v}</option>)}
                            </select>
                            {errors.tp_ordem && <p className="mt-1 text-sm text-red-600">{errors.tp_ordem}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Lotação (Execução) *</label>
                            <select value={data.id_lotacao} onChange={e => setData('id_lotacao', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione</option>
                                {lotacoes.map(l => <option key={l.id_lotacao} value={l.id_lotacao}>{l.nm_lotacao}</option>)}
                            </select>
                            {errors.id_lotacao && <p className="mt-1 text-sm text-red-600">{errors.id_lotacao}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Prazo (dias)</label>
                            <input type="number" min="1" value={data.nr_prazo_ordem} onChange={e => setData('nr_prazo_ordem', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div className="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Data Início Vigência</label>
                                <input type="date" value={data.dt_ini_ordem} onChange={e => setData('dt_ini_ordem', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Data Fim Vigência</label>
                                <input type="date" value={data.dt_fim_ordem} onChange={e => setData('dt_fim_ordem', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                        </div>

                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('financeiro.ordens.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
