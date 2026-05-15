import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ qdds, fontes, programas, elementos }) {
    const { data, setData, post, processing, errors } = useForm({
        id_qdd: '', id_fonte: '', id_programa_trabalho: '', id_despesa_elemento: '',
        vl_qdd_inical: '0', vl_qdd_suplementado: '0', vl_qdd_reduzido: '0',
        vl_empenhado: '0', vl_bloqueado: '0', vl_liberado: '0',
    });
    function handleSubmit(e) { e.preventDefault(); post(route('orcamento.qdd-valor.store')); }
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Novo Valor QDD</h2>}>
            <Head title="Novo Valor QDD" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-6"><Link href={route('orcamento.qdd-valor.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">QDD</label>
                            <select value={data.id_qdd} onChange={e => setData('id_qdd', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Selecione...</option>
                                {qdds.map((q) => <option key={q.id_qdd} value={q.id_qdd}>{q.aa_qdd}</option>)}
                            </select>
                            {errors.id_qdd && <p className="mt-1 text-sm text-red-600">{errors.id_qdd}</p>}
                        </div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Fonte</label>
                            <select value={data.id_fonte} onChange={e => setData('id_fonte', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Selecione...</option>
                                {fontes.map((f) => <option key={f.id_fonte} value={f.id_fonte}>{f.nr_fonte}</option>)}
                            </select>
                            {errors.id_fonte && <p className="mt-1 text-sm text-red-600">{errors.id_fonte}</p>}
                        </div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Programa de Trabalho</label>
                            <select value={data.id_programa_trabalho} onChange={e => setData('id_programa_trabalho', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Selecione...</option>
                                {programas.map((p) => <option key={p.id_programa_trabalho} value={p.id_programa_trabalho}>{p.cd_programa_trabalho} - {p.nm_programa_trabalho}</option>)}
                            </select>
                            {errors.id_programa_trabalho && <p className="mt-1 text-sm text-red-600">{errors.id_programa_trabalho}</p>}
                        </div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Elemento de Despesa</label>
                            <select value={data.id_despesa_elemento} onChange={e => setData('id_despesa_elemento', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Selecione...</option>
                                {elementos.map((e) => <option key={e.id_despesa_elemento} value={e.id_despesa_elemento}>{e.cd_despesa_elemento} - {e.nm_despesa_elemento}</option>)}
                            </select>
                            {errors.id_despesa_elemento && <p className="mt-1 text-sm text-red-600">{errors.id_despesa_elemento}</p>}
                        </div>
                        <div className="grid grid-cols-2 gap-4">
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Valor Inicial</label>
                                <input type="number" step="0.01" value={data.vl_qdd_inical} onChange={e => setData('vl_qdd_inical', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                {errors.vl_qdd_inical && <p className="mt-1 text-sm text-red-600">{errors.vl_qdd_inical}</p>}
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Suplementado</label>
                                <input type="number" step="0.01" value={data.vl_qdd_suplementado} onChange={e => setData('vl_qdd_suplementado', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                {errors.vl_qdd_suplementado && <p className="mt-1 text-sm text-red-600">{errors.vl_qdd_suplementado}</p>}
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Reduzido</label>
                                <input type="number" step="0.01" value={data.vl_qdd_reduzido} onChange={e => setData('vl_qdd_reduzido', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                {errors.vl_qdd_reduzido && <p className="mt-1 text-sm text-red-600">{errors.vl_qdd_reduzido}</p>}
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Empenhado</label>
                                <input type="number" step="0.01" value={data.vl_empenhado} onChange={e => setData('vl_empenhado', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                {errors.vl_empenhado && <p className="mt-1 text-sm text-red-600">{errors.vl_empenhado}</p>}
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Bloqueado</label>
                                <input type="number" step="0.01" value={data.vl_bloqueado} onChange={e => setData('vl_bloqueado', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                {errors.vl_bloqueado && <p className="mt-1 text-sm text-red-600">{errors.vl_bloqueado}</p>}
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Liberado</label>
                                <input type="number" step="0.01" value={data.vl_liberado} onChange={e => setData('vl_liberado', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                {errors.vl_liberado && <p className="mt-1 text-sm text-red-600">{errors.vl_liberado}</p>}
                            </div>
                        </div>
                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('orcamento.qdd-valor.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
