import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ pedidos, tiposDocumento, lotacoes, fornecedores }) {
    const { data, setData, post, processing, errors } = useForm({
        id_pedido: '',
        id_tipo_documento: '',
        id_lotacao: '',
        nr_processo_administrativo: '',
        nr_documento_fiscal: '',
        dt_emissao: new Date().toISOString().split('T')[0],
        dt_vencimento: '',
        dt_atesto: new Date().toISOString().split('T')[0],
        vl_documento: '',
        competencia: `${String(new Date().getMonth() + 1).padStart(2, '0')}/${new Date().getFullYear()}`,
        fl_grp: false,
        nr_grp_numero: '',
        fl_encontro_contas: false,
        nr_encontro_dae: '',
        ds_observacao: '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('financeiro.documentos-fiscais.store'));
    }

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Novo Documento Fiscal</h2>}>
            <Head title="Novo Documento Fiscal" />
            <div className="py-12"><div className="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('financeiro.documentos-fiscais.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Pedido *</label>
                                <select value={data.id_pedido} onChange={e => setData('id_pedido', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione</option>
                                    {pedidos.map(p => <option key={p.id_pedido} value={p.id_pedido}>{p.nr_pedido}</option>)}
                                </select>
                                {errors.id_pedido && <p className="mt-1 text-sm text-red-600">{errors.id_pedido}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Tipo Documento *</label>
                                <select value={data.id_tipo_documento} onChange={e => setData('id_tipo_documento', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione</option>
                                    {tiposDocumento.map(t => <option key={t.id_tipo_documento} value={t.id_tipo_documento}>{t.nm_tipo_documento}</option>)}
                                </select>
                                {errors.id_tipo_documento && <p className="mt-1 text-sm text-red-600">{errors.id_tipo_documento}</p>}
                            </div>
                        </div>

                        <div className="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Nº Documento Fiscal *</label>
                                <input type="text" value={data.nr_documento_fiscal} onChange={e => setData('nr_documento_fiscal', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.nr_documento_fiscal && <p className="mt-1 text-sm text-red-600">{errors.nr_documento_fiscal}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Processo Administrativo *</label>
                                <input type="text" value={data.nr_processo_administrativo} onChange={e => setData('nr_processo_administrativo', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.nr_processo_administrativo && <p className="mt-1 text-sm text-red-600">{errors.nr_processo_administrativo}</p>}
                            </div>
                        </div>

                        <div className="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Data Emissão *</label>
                                <input type="date" value={data.dt_emissao} onChange={e => setData('dt_emissao', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.dt_emissao && <p className="mt-1 text-sm text-red-600">{errors.dt_emissao}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Data Vencimento</label>
                                <input type="date" value={data.dt_vencimento} onChange={e => setData('dt_vencimento', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Data Atesto *</label>
                                <input type="date" value={data.dt_atesto} onChange={e => setData('dt_atesto', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.dt_atesto && <p className="mt-1 text-sm text-red-600">{errors.dt_atesto}</p>}
                            </div>
                        </div>

                        <div className="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Valor do Documento *</label>
                                <input type="number" step="0.01" min="0.01" value={data.vl_documento} onChange={e => setData('vl_documento', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.vl_documento && <p className="mt-1 text-sm text-red-600">{errors.vl_documento}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Competência *</label>
                                <input type="text" placeholder="MM/AAAA" value={data.competencia} onChange={e => setData('competencia', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.competencia && <p className="mt-1 text-sm text-red-600">{errors.competencia}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Lotação *</label>
                                <select value={data.id_lotacao} onChange={e => setData('id_lotacao', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione</option>
                                    {lotacoes.map(l => <option key={l.id_lotacao} value={l.id_lotacao}>{l.nm_lotacao}</option>)}
                                </select>
                                {errors.id_lotacao && <p className="mt-1 text-sm text-red-600">{errors.id_lotacao}</p>}
                            </div>
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Observação</label>
                            <textarea value={data.ds_observacao} onChange={e => setData('ds_observacao', e.target.value)} rows={2}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div className="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label className="flex items-center gap-2">
                                    <input type="checkbox" checked={data.fl_grp} onChange={e => setData('fl_grp', e.target.checked)}
                                        className="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                    <span className="text-sm font-medium text-gray-700">GRP</span>
                                </label>
                                {data.fl_grp && (
                                    <input type="text" placeholder="Nº GRP" value={data.nr_grp_numero} onChange={e => setData('nr_grp_numero', e.target.value)}
                                        className="mt-2 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                )}
                            </div>
                            <div>
                                <label className="flex items-center gap-2">
                                    <input type="checkbox" checked={data.fl_encontro_contas} onChange={e => setData('fl_encontro_contas', e.target.checked)}
                                        className="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                    <span className="text-sm font-medium text-gray-700">Encontro de Contas</span>
                                </label>
                                {data.fl_encontro_contas && (
                                    <input type="text" placeholder="Nº DAE" value={data.nr_encontro_dae} onChange={e => setData('nr_encontro_dae', e.target.value)}
                                        className="mt-2 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                )}
                            </div>
                        </div>

                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('financeiro.documentos-fiscais.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
