import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ nextNumber, tiposSolicitacao, fornecedores, fontes, programasTrabalho, despesas, despesasElemento, tiposGasto, lotacoes, portarias, convenios }) {
    const { data, setData, post, processing, errors } = useForm({
        nr_pedido: nextNumber,
        id_tipo_solicitacao: '',
        id_fornecedor: '',
        id_portatia: '',
        id_convenio: '',
        id_fonte: '',
        id_programa_trabalho: '',
        id_despesa_elemento: '',
        id_despesa: '',
        id_tipo_gasto: '',
        id_lotacao: '',
        ds_pedido: '',
        vl_pedido: '',
        dt_pedido: new Date().toISOString().split('T')[0],
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('financeiro.pedidos.store'));
    }

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Novo Pedido</h2>}>
            <Head title="Novo Pedido" />
            <div className="py-12"><div className="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('financeiro.pedidos.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Nº Pedido</label>
                            <input type="text" value={data.nr_pedido} readOnly
                                className="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 text-sm shadow-sm" />
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Tipo de Solicitação *</label>
                            <select value={data.id_tipo_solicitacao} onChange={e => setData('id_tipo_solicitacao', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione</option>
                                {tiposSolicitacao.map(t => <option key={t.id_tipo_solicitacao} value={t.id_tipo_solicitacao}>{t.nm_tipo_solicitacao}</option>)}
                            </select>
                            {errors.id_tipo_solicitacao && <p className="mt-1 text-sm text-red-600">{errors.id_tipo_solicitacao}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Data do Pedido *</label>
                            <input type="date" value={data.dt_pedido} onChange={e => setData('dt_pedido', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            {errors.dt_pedido && <p className="mt-1 text-sm text-red-600">{errors.dt_pedido}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Fornecedor</label>
                            <select value={data.id_fornecedor} onChange={e => setData('id_fornecedor', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Sem fornecedor</option>
                                {fornecedores.map(f => <option key={f.id_fornecedor} value={f.id_fornecedor}>{f.nm_pessoa}</option>)}
                            </select>
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Fonte *</label>
                            <select value={data.id_fonte} onChange={e => setData('id_fonte', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione</option>
                                {fontes.map(f => <option key={f.id_fonte} value={f.id_fonte}>{f.nr_fonte}</option>)}
                            </select>
                            {errors.id_fonte && <p className="mt-1 text-sm text-red-600">{errors.id_fonte}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Programa de Trabalho *</label>
                            <select value={data.id_programa_trabalho} onChange={e => setData('id_programa_trabalho', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione</option>
                                {programasTrabalho.map(p => <option key={p.id_programa_trabalho} value={p.id_programa_trabalho}>{p.cd_programa_trabalho} - {p.nm_programa_trabalho}</option>)}
                            </select>
                            {errors.id_programa_trabalho && <p className="mt-1 text-sm text-red-600">{errors.id_programa_trabalho}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Despesa *</label>
                            <select value={data.id_despesa} onChange={e => setData('id_despesa', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione</option>
                                {despesas.map(d => <option key={d.id_despesa} value={d.id_despesa}>{d.cd_despesa} - {d.nm_despesa}</option>)}
                            </select>
                            {errors.id_despesa && <p className="mt-1 text-sm text-red-600">{errors.id_despesa}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Elemento de Despesa *</label>
                            <select value={data.id_despesa_elemento} onChange={e => setData('id_despesa_elemento', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione</option>
                                {despesasElemento.map(e => <option key={e.id_despesa_elemento} value={e.id_despesa_elemento}>{e.cd_despesa_elemento} - {e.nm_despesa_elemento}</option>)}
                            </select>
                            {errors.id_despesa_elemento && <p className="mt-1 text-sm text-red-600">{errors.id_despesa_elemento}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Tipo de Gasto *</label>
                            <select value={data.id_tipo_gasto} onChange={e => setData('id_tipo_gasto', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione</option>
                                {tiposGasto.map(t => <option key={t.id_tipo_gasto} value={t.id_tipo_gasto}>{t.nm_tipo_gasto}</option>)}
                            </select>
                            {errors.id_tipo_gasto && <p className="mt-1 text-sm text-red-600">{errors.id_tipo_gasto}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Central (Lotação) *</label>
                            <select value={data.id_lotacao} onChange={e => setData('id_lotacao', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione</option>
                                {lotacoes.map(l => <option key={l.id_lotacao} value={l.id_lotacao}>{l.nm_lotacao}</option>)}
                            </select>
                            {errors.id_lotacao && <p className="mt-1 text-sm text-red-600">{errors.id_lotacao}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Portaria</label>
                            <select value={data.id_portatia} onChange={e => setData('id_portatia', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione</option>
                                {portarias.map(p => <option key={p.id_portaria} value={p.id_portaria}>{p.nm_portaria}</option>)}
                            </select>
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Convênio</label>
                            <select value={data.id_convenio} onChange={e => setData('id_convenio', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione</option>
                                {convenios.map(c => <option key={c.id_convenio} value={c.id_convenio}>{c.nm_convenio}</option>)}
                            </select>
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Descrição *</label>
                            <textarea value={data.ds_pedido} onChange={e => setData('ds_pedido', e.target.value)} rows={3}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            {errors.ds_pedido && <p className="mt-1 text-sm text-red-600">{errors.ds_pedido}</p>}
                        </div>

                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Valor *</label>
                            <input type="number" step="0.01" min="0" value={data.vl_pedido} onChange={e => setData('vl_pedido', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            {errors.vl_pedido && <p className="mt-1 text-sm text-red-600">{errors.vl_pedido}</p>}
                        </div>

                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('financeiro.pedidos.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
