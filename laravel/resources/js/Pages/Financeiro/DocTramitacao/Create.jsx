import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ documentos, situacoes, lotacoes, tpTramitacao }) {
    const { data, setData, post, processing, errors } = useForm({
        id_documento_fiscal: '',
        id_doc_origem: '',
        id_doc_destino: '',
        id_tipo_tramitacao: '',
        ds_doc_tramitacao: '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('financeiro.doc-tramitacoes.store'));
    }

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Nova Tramitação</h2>}>
            <Head title="Nova Tramitação" />
            <div className="py-12"><div className="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('financeiro.doc-tramitacoes.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Documento Fiscal *</label>
                            <select value={data.id_documento_fiscal} onChange={e => setData('id_documento_fiscal', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione</option>
                                {documentos.map(d => <option key={d.id_documento_fiscal} value={d.id_documento_fiscal}>{d.nr_documento_fiscal}</option>)}
                            </select>
                            {errors.id_documento_fiscal && <p className="mt-1 text-sm text-red-600">{errors.id_documento_fiscal}</p>}
                        </div>

                        <div className="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Origem (Lotação)</label>
                                <select value={data.id_doc_origem} onChange={e => setData('id_doc_origem', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione</option>
                                    {lotacoes.map(l => <option key={l.id_lotacao} value={l.id_lotacao}>{l.nm_lotacao}</option>)}
                                </select>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Destino (Lotação)</label>
                                <select value={data.id_doc_destino} onChange={e => setData('id_doc_destino', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione</option>
                                    {lotacoes.map(l => <option key={l.id_lotacao} value={l.id_lotacao}>{l.nm_lotacao}</option>)}
                                </select>
                            </div>
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Tipo de Tramitação *</label>
                            <select value={data.id_tipo_tramitacao} onChange={e => setData('id_tipo_tramitacao', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione</option>
                                {Object.entries(tpTramitacao).map(([k, v]) => <option key={k} value={k}>{v}</option>)}
                            </select>
                            {errors.id_tipo_tramitacao && <p className="mt-1 text-sm text-red-600">{errors.id_tipo_tramitacao}</p>}
                        </div>

                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea value={data.ds_doc_tramitacao} onChange={e => setData('ds_doc_tramitacao', e.target.value)} rows={3}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('financeiro.doc-tramitacoes.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
