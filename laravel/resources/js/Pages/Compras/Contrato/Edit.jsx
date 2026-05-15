import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Edit({ contrato, fornecedores, programasTrabalho, fontes, modalidades, tiposGasto, pessoas, lotacoes }) {
    const { data, setData, put, processing, errors } = useForm({
        nr_contrato: contrato.nr_contrato || '',
        id_fornecedor: contrato.id_fornecedor || '',
        id_programa_trabalho: contrato.id_programa_trabalho || '',
        id_fonte: contrato.id_fonte || '',
        id_modalidade: contrato.id_modalidade || '',
        id_tipo_gasto: contrato.id_tipo_gasto || '',
        ds_objeto: contrato.ds_objeto || '',
        vl_contrato: contrato.vl_contrato || '',
        dt_ini_vigencia_contrato: contrato.dt_ini_vigencia_contrato || '',
        dt_fim_vigencia_contrato: contrato.dt_fim_vigencia_contrato || '',
        dt_assinatura: contrato.dt_assinatura || '',
        dt_publicacao: contrato.dt_publicacao || '',
        tp_contrato: contrato.tp_contrato || '',
        nr_prazo_entrega: contrato.nr_prazo_entrega || '',
        st_ativo: contrato.st_ativo,
        ds_obs_contrato: contrato.ds_obs_contrato || '',
        ds_area_abrangencia: contrato.ds_area_abrangencia || '',
        ds_unidade_contemplada: contrato.ds_unidade_contemplada || '',
        fl_servico_continuado: contrato.fl_servico_continuado == 1,
        fl_carona: contrato.fl_carona == 1,
        id_pessoa_gestor_titular: contrato.id_pessoa_gestor_titular || '',
        id_pessoa_gestor_substituto: contrato.id_pessoa_gestor_substituto || '',
        id_pessoa_fiscal_titular: contrato.id_pessoa_fiscal_titular || '',
        id_pessoa_fiscal_substituto: contrato.id_pessoa_fiscal_substituto || '',
        id_pessoa_sub_fiscal_titular: contrato.id_pessoa_sub_fiscal_titular || '',
        id_pessoa_sub_fiscal_substituto: contrato.id_pessoa_sub_fiscal_substituto || '',
        id_lotacao_central: contrato.id_lotacao_central || '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        put(route('compras.contratos.update', contrato.id_contrato));
    }

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Editar Contrato</h2>}>
            <Head title="Editar Contrato" />
            <div className="py-12"><div className="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('compras.contratos.show', contrato.id_contrato)} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <h3 className="mb-4 text-sm font-semibold text-gray-700">Dados Principais</h3>
                        <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Nº Contrato *</label>
                                <input type="text" value={data.nr_contrato} onChange={e => setData('nr_contrato', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.nr_contrato && <p className="mt-1 text-sm text-red-600">{errors.nr_contrato}</p>}
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
                                <label className="block text-sm font-medium text-gray-700">Programa Trabalho *</label>
                                <select value={data.id_programa_trabalho} onChange={e => setData('id_programa_trabalho', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione</option>
                                    {programasTrabalho.map(p => <option key={p.id_programa_trabalho} value={p.id_programa_trabalho}>{p.cd_programa_trabalho}</option>)}
                                </select>
                                {errors.id_programa_trabalho && <p className="mt-1 text-sm text-red-600">{errors.id_programa_trabalho}</p>}
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
                                <label className="block text-sm font-medium text-gray-700">Modalidade</label>
                                <select value={data.id_modalidade} onChange={e => setData('id_modalidade', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione</option>
                                    {modalidades.map(m => <option key={m.id_modalidade} value={m.id_modalidade}>{m.nm_modalidade || m.id_modalidade}</option>)}
                                </select>
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
                            <div className="mb-4 sm:col-span-2">
                                <label className="block text-sm font-medium text-gray-700">Objeto *</label>
                                <textarea value={data.ds_objeto} onChange={e => setData('ds_objeto', e.target.value)} rows={3}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.ds_objeto && <p className="mt-1 text-sm text-red-600">{errors.ds_objeto}</p>}
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Valor *</label>
                                <input type="number" step="0.01" min="0.01" value={data.vl_contrato} onChange={e => setData('vl_contrato', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.vl_contrato && <p className="mt-1 text-sm text-red-600">{errors.vl_contrato}</p>}
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Tipo Contrato</label>
                                <input type="text" value={data.tp_contrato} onChange={e => setData('tp_contrato', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                        </div>

                        <h3 className="mb-4 mt-6 text-sm font-semibold text-gray-700">Vigência</h3>
                        <div className="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Início Vigência *</label>
                                <input type="date" value={data.dt_ini_vigencia_contrato} onChange={e => setData('dt_ini_vigencia_contrato', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.dt_ini_vigencia_contrato && <p className="mt-1 text-sm text-red-600">{errors.dt_ini_vigencia_contrato}</p>}
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Fim Vigência *</label>
                                <input type="date" value={data.dt_fim_vigencia_contrato} onChange={e => setData('dt_fim_vigencia_contrato', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.dt_fim_vigencia_contrato && <p className="mt-1 text-sm text-red-600">{errors.dt_fim_vigencia_contrato}</p>}
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Prazo Entrega (dias)</label>
                                <input type="number" value={data.nr_prazo_entrega} onChange={e => setData('nr_prazo_entrega', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Data Assinatura</label>
                                <input type="date" value={data.dt_assinatura} onChange={e => setData('dt_assinatura', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Data Publicação</label>
                                <input type="date" value={data.dt_publicacao} onChange={e => setData('dt_publicacao', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                        </div>

                        <h3 className="mb-4 mt-6 text-sm font-semibold text-gray-700">Gestão e Fiscalização</h3>
                        <div className="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Gestor Titular</label>
                                <select value={data.id_pessoa_gestor_titular} onChange={e => setData('id_pessoa_gestor_titular', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione</option>
                                    {pessoas.map(p => <option key={p.id_pessoa} value={p.id_pessoa}>{p.nm_pessoa}</option>)}
                                </select>
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Gestor Substituto</label>
                                <select value={data.id_pessoa_gestor_substituto} onChange={e => setData('id_pessoa_gestor_substituto', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione</option>
                                    {pessoas.map(p => <option key={p.id_pessoa} value={p.id_pessoa}>{p.nm_pessoa}</option>)}
                                </select>
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Fiscal Titular</label>
                                <select value={data.id_pessoa_fiscal_titular} onChange={e => setData('id_pessoa_fiscal_titular', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione</option>
                                    {pessoas.map(p => <option key={p.id_pessoa} value={p.id_pessoa}>{p.nm_pessoa}</option>)}
                                </select>
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Fiscal Substituto</label>
                                <select value={data.id_pessoa_fiscal_substituto} onChange={e => setData('id_pessoa_fiscal_substituto', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione</option>
                                    {pessoas.map(p => <option key={p.id_pessoa} value={p.id_pessoa}>{p.nm_pessoa}</option>)}
                                </select>
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Sub-Fiscal Titular</label>
                                <select value={data.id_pessoa_sub_fiscal_titular} onChange={e => setData('id_pessoa_sub_fiscal_titular', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione</option>
                                    {pessoas.map(p => <option key={p.id_pessoa} value={p.id_pessoa}>{p.nm_pessoa}</option>)}
                                </select>
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Sub-Fiscal Substituto</label>
                                <select value={data.id_pessoa_sub_fiscal_substituto} onChange={e => setData('id_pessoa_sub_fiscal_substituto', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione</option>
                                    {pessoas.map(p => <option key={p.id_pessoa} value={p.id_pessoa}>{p.nm_pessoa}</option>)}
                                </select>
                            </div>
                        </div>

                        <h3 className="mb-4 mt-6 text-sm font-semibold text-gray-700">Informações Adicionais</h3>
                        <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Área de Abrangência</label>
                                <textarea value={data.ds_area_abrangencia} onChange={e => setData('ds_area_abrangencia', e.target.value)} rows={2}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Unidade Contemplada</label>
                                <textarea value={data.ds_unidade_contemplada} onChange={e => setData('ds_unidade_contemplada', e.target.value)} rows={2}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Observações</label>
                                <textarea value={data.ds_obs_contrato} onChange={e => setData('ds_obs_contrato', e.target.value)} rows={2}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Central</label>
                                <select value={data.id_lotacao_central} onChange={e => setData('id_lotacao_central', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione</option>
                                    {lotacoes.map(l => <option key={l.id_lotacao} value={l.id_lotacao}>{l.nm_lotacao}</option>)}
                                </select>
                            </div>
                            <div className="mb-4">
                                <label className="flex items-center gap-2">
                                    <input type="checkbox" checked={data.fl_servico_continuado} onChange={e => setData('fl_servico_continuado', e.target.checked)}
                                        className="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                    <span className="text-sm text-gray-700">Serviço Continuado</span>
                                </label>
                            </div>
                            <div className="mb-4">
                                <label className="flex items-center gap-2">
                                    <input type="checkbox" checked={data.fl_carona} onChange={e => setData('fl_carona', e.target.checked)}
                                        className="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                    <span className="text-sm text-gray-700">Carona</span>
                                </label>
                            </div>
                        </div>

                        <div className="flex items-center justify-end gap-4 mt-6">
                            <Link href={route('compras.contratos.show', contrato.id_contrato)} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
