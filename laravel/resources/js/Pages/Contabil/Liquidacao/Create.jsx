import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { useState } from 'react';

export default function Create({ nextNumber, empenhos, documentosFiscais }) {
    const { data, setData, post, processing, errors } = useForm({
        id_empenho: '',
        vl_liquidacao: '',
        dt_liquidacao: '',
        ds_liquidacao: '',
        documentos: [],
    });

    const [selectedDocs, setSelectedDocs] = useState([]);

    function handleSubmit(e) {
        e.preventDefault();
        post(route('contabil.liquidacoes.store'));
    }

    function addDocumento() {
        setSelectedDocs([...selectedDocs, { id_documento_fiscal: '', vl_liquidacao_doc: '' }]);
        setData('documentos', [...data.documentos, { id_documento_fiscal: '', vl_liquidacao_doc: '' }]);
    }

    function removeDocumento(index) {
        const newDocs = selectedDocs.filter((_, i) => i !== index);
        setSelectedDocs(newDocs);
        setData('documentos', newDocs);
    }

    function updateDocumento(index, field, value) {
        const newDocs = [...selectedDocs];
        newDocs[index] = { ...newDocs[index], [field]: value };
        setSelectedDocs(newDocs);
        setData('documentos', newDocs);
    }

    const selectedEmpenho = empenhos.find(e => e.id_empenho == data.id_empenho);

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Nova Liquidação</h2>}>
            <Head title="Nova Liquidação" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('contabil.liquidacoes.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-4">
                            <p className="text-sm text-gray-500">Nº Liquidação: <strong>{nextNumber}</strong></p>
                        </div>

                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Empenho *</label>
                            <select value={data.id_empenho} onChange={e => setData('id_empenho', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione um empenho</option>
                                {empenhos.map(e => (
                                    <option key={e.id_empenho} value={e.id_empenho}>{e.label}</option>
                                ))}
                            </select>
                            {errors.id_empenho && <p className="mt-1 text-sm text-red-600">{errors.id_empenho}</p>}
                        </div>

                        {selectedEmpenho && (
                            <div className="mb-6 rounded-md bg-gray-50 p-4">
                                <h4 className="text-sm font-medium text-gray-700">Detalhes do Empenho</h4>
                                <dl className="mt-2 grid grid-cols-2 gap-2 text-sm">
                                    <dt className="text-gray-500">Fornecedor:</dt>
                                    <dd>{selectedEmpenho.pedido?.fornecedor?.pessoa?.nm_pessoa || '-'}</dd>
                                    <dt className="text-gray-500">Valor Empenho:</dt>
                                    <dd>R$ {Number(selectedEmpenho.vl_empenho).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</dd>
                                    <dt className="text-gray-500">Saldo:</dt>
                                    <dd>R$ {Number(selectedEmpenho.vl_saldo).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</dd>
                                </dl>
                            </div>
                        )}

                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Valor da Liquidação *</label>
                            <input type="number" step="0.01" min="0.01" value={data.vl_liquidacao} onChange={e => setData('vl_liquidacao', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            {errors.vl_liquidacao && <p className="mt-1 text-sm text-red-600">{errors.vl_liquidacao}</p>}
                        </div>

                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Data da Liquidação *</label>
                            <input type="date" value={data.dt_liquidacao} onChange={e => setData('dt_liquidacao', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            {errors.dt_liquidacao && <p className="mt-1 text-sm text-red-600">{errors.dt_liquidacao}</p>}
                        </div>

                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea value={data.ds_liquidacao} onChange={e => setData('ds_liquidacao', e.target.value)} rows={2}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div className="mb-6">
                            <div className="flex items-center justify-between">
                                <label className="block text-sm font-medium text-gray-700">Documentos Fiscais</label>
                                <button type="button" onClick={addDocumento} className="text-sm text-indigo-600 hover:text-indigo-900">+ Adicionar Documento</button>
                            </div>
                            {errors.documentos && <p className="mt-1 text-sm text-red-600">{errors.documentos}</p>}
                            {selectedDocs.map((doc, idx) => (
                                <div key={idx} className="mt-2 flex items-end gap-2 rounded-md bg-gray-50 p-3">
                                    <div className="flex-1">
                                        <label className="block text-xs text-gray-500">Documento</label>
                                        <select value={doc.id_documento_fiscal} onChange={e => updateDocumento(idx, 'id_documento_fiscal', e.target.value)}
                                            className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Selecione</option>
                                            {documentosFiscais.map(df => (
                                                <option key={df.id_documento_fiscal} value={df.id_documento_fiscal}>{df.label}</option>
                                            ))}
                                        </select>
                                    </div>
                                    <div className="w-48">
                                        <label className="block text-xs text-gray-500">Valor (R$)</label>
                                        <input type="number" step="0.01" min="0.01" value={doc.vl_liquidacao_doc} onChange={e => updateDocumento(idx, 'vl_liquidacao_doc', e.target.value)}
                                            className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                    </div>
                                    <button type="button" onClick={() => removeDocumento(idx)} className="rounded-md bg-red-100 p-2 text-red-600 hover:bg-red-200">Remover</button>
                                </div>
                            ))}
                            {selectedDocs.length === 0 && (
                                <p className="mt-1 text-xs text-gray-400">Nenhum documento vinculado.</p>
                            )}
                        </div>

                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('contabil.liquidacoes.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
