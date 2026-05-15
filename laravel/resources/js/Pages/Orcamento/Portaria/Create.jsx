import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ redes }) {
    const { data, setData, post, processing, errors } = useForm({
        id_rede_tematica: '', nm_portaria: '', dt_portaria: '', vl_total: '', st_portaria: '1',
    });
    function handleSubmit(e) { e.preventDefault(); post(route('orcamento.portarias.store')); }
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Nova Portaria</h2>}>
            <Head title="Nova Portaria" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-6"><Link href={route('orcamento.portarias.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Rede Temática</label>
                            <select value={data.id_rede_tematica} onChange={e => setData('id_rede_tematica', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Selecione...</option>
                                {redes.map((r) => <option key={r.id_rede_tematica} value={r.id_rede_tematica}>{r.nm_rede_tematica}</option>)}
                            </select>
                            {errors.id_rede_tematica && <p className="mt-1 text-sm text-red-600">{errors.id_rede_tematica}</p>}
                        </div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Nome da Portaria</label>
                            <input type="text" value={data.nm_portaria} onChange={e => setData('nm_portaria', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.nm_portaria && <p className="mt-1 text-sm text-red-600">{errors.nm_portaria}</p>}
                        </div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Data</label>
                            <input type="date" value={data.dt_portaria} onChange={e => setData('dt_portaria', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.dt_portaria && <p className="mt-1 text-sm text-red-600">{errors.dt_portaria}</p>}
                        </div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Valor Total</label>
                            <input type="number" step="0.01" min="0" value={data.vl_total} onChange={e => setData('vl_total', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.vl_total && <p className="mt-1 text-sm text-red-600">{errors.vl_total}</p>}
                        </div>
                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Status</label>
                            <select value={data.st_portaria} onChange={e => setData('st_portaria', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="1">Rascunho</option>
                                <option value="2">Assinado</option>
                                <option value="3">Cancelado</option>
                            </select>
                            {errors.st_portaria && <p className="mt-1 text-sm text-red-600">{errors.st_portaria}</p>}
                        </div>
                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('orcamento.portarias.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
