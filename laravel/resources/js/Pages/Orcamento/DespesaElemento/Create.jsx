import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ despesas }) {
    const { data, setData, post, processing, errors } = useForm({
        cd_despesa_elemento: '', nm_despesa_elemento: '', id_despesa: '', st_ativo: '1',
    });
    function handleSubmit(e) { e.preventDefault(); post(route('orcamento.despesa-elementos.store')); }
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Novo Elemento de Despesa</h2>}>
            <Head title="Novo Elemento de Despesa" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-6"><Link href={route('orcamento.despesa-elementos.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Código</label>
                            <input type="text" value={data.cd_despesa_elemento} onChange={e => setData('cd_despesa_elemento', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.cd_despesa_elemento && <p className="mt-1 text-sm text-red-600">{errors.cd_despesa_elemento}</p>}
                        </div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" value={data.nm_despesa_elemento} onChange={e => setData('nm_despesa_elemento', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.nm_despesa_elemento && <p className="mt-1 text-sm text-red-600">{errors.nm_despesa_elemento}</p>}
                        </div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Despesa</label>
                            <select value={data.id_despesa} onChange={e => setData('id_despesa', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Selecione...</option>
                                {despesas.map((d) => <option key={d.id_despesa} value={d.id_despesa}>{d.cd_despesa} - {d.nm_despesa}</option>)}
                            </select>
                            {errors.id_despesa && <p className="mt-1 text-sm text-red-600">{errors.id_despesa}</p>}
                        </div>
                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Ativo</label>
                            <select value={data.st_ativo} onChange={e => setData('st_ativo', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="1">Sim</option><option value="0">Não</option>
                            </select>
                        </div>
                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('orcamento.despesa-elementos.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
