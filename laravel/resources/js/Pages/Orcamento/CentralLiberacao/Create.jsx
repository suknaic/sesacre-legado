import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ qddValores }) {
    const { data, setData, post, processing, errors } = useForm({
        id_qdd_valor: '', dh_central_liberacao: '', ds_central_liberacao: '',
        tp_central_liberacao: '', id_pessoa: '', id_lotacao: '',
        st_central_liberacao: '1', vl_central_liberacao: '',
    });
    function handleSubmit(e) { e.preventDefault(); post(route('orcamento.central-liberacoes.store')); }
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Nova Liberação</h2>}>
            <Head title="Nova Liberação" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-6"><Link href={route('orcamento.central-liberacoes.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Valor QDD (Fonte / Programa / Elemento)</label>
                            <select value={data.id_qdd_valor} onChange={e => setData('id_qdd_valor', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Selecione...</option>
                                {qddValores.map((v) => (
                                    <option key={v.id_qdd_valor} value={v.id_qdd_valor}>
                                        #{v.id_qdd_valor} - {v.qdd?.aa_qdd} / {v.fonte?.nr_fonte} / {v.programaTrabalho?.cd_programa_trabalho} / {v.despesaElemento?.cd_despesa_elemento} (Saldo: {new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(v.vl_saldo || 0)})
                                    </option>
                                ))}
                            </select>
                            {errors.id_qdd_valor && <p className="mt-1 text-sm text-red-600">{errors.id_qdd_valor}</p>}
                        </div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Data/Hora</label>
                            <input type="datetime-local" value={data.dh_central_liberacao} onChange={e => setData('dh_central_liberacao', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.dh_central_liberacao && <p className="mt-1 text-sm text-red-600">{errors.dh_central_liberacao}</p>}
                        </div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Valor da Liberação</label>
                            <input type="number" step="0.01" min="0.01" value={data.vl_central_liberacao} onChange={e => setData('vl_central_liberacao', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.vl_central_liberacao && <p className="mt-1 text-sm text-red-600">{errors.vl_central_liberacao}</p>}
                        </div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea value={data.ds_central_liberacao} onChange={e => setData('ds_central_liberacao', e.target.value)} rows={3}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.ds_central_liberacao && <p className="mt-1 text-sm text-red-600">{errors.ds_central_liberacao}</p>}
                        </div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Tipo</label>
                            <input type="text" value={data.tp_central_liberacao} onChange={e => setData('tp_central_liberacao', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Status</label>
                            <select value={data.st_central_liberacao} onChange={e => setData('st_central_liberacao', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="1">Ativo</option>
                                <option value="3">Cancelado</option>
                            </select>
                        </div>
                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('orcamento.central-liberacoes.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
