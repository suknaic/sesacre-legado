import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Edit({ centralLiberacao, qddValores }) {
    const { data, setData, put, processing, errors } = useForm({
        id_qdd_valor: String(centralLiberacao.id_qdd_valor || ''),
        dh_central_liberacao: centralLiberacao.dh_central_liberacao || '',
        ds_central_liberacao: centralLiberacao.ds_central_liberacao || '',
        tp_central_liberacao: centralLiberacao.tp_central_liberacao || '',
        id_pessoa: String(centralLiberacao.id_pessoa || ''),
        id_lotacao: String(centralLiberacao.id_lotacao || ''),
        st_central_liberacao: String(centralLiberacao.st_central_liberacao || '1'),
        vl_central_liberacao: String(centralLiberacao.vl_central_liberacao || ''),
    });
    function handleSubmit(e) { e.preventDefault(); put(route('orcamento.central-liberacoes.update', centralLiberacao.id_central_liberacao)); }
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Editar Liberação #{centralLiberacao.id_central_liberacao}</h2>}>
            <Head title="Editar Liberação" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-6"><Link href={route('orcamento.central-liberacoes.show', centralLiberacao.id_central_liberacao)} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Valor QDD</label>
                            <select value={data.id_qdd_valor} onChange={e => setData('id_qdd_valor', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Selecione...</option>
                                {qddValores.map((v) => (
                                    <option key={v.id_qdd_valor} value={v.id_qdd_valor}>
                                        #{v.id_qdd_valor} - {v.qdd?.aa_qdd} / {v.fonte?.nr_fonte} / {v.programaTrabalho?.cd_programa_trabalho}
                                    </option>
                                ))}
                            </select>
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
                            <Link href={route('orcamento.central-liberacoes.show', centralLiberacao.id_central_liberacao)} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
