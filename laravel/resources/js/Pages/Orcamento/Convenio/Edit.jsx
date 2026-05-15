import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Edit({ convenio, fontes }) {
    const { data, setData, put, processing, errors } = useForm({
        id_fonte: String(convenio.id_fonte || ''),
        nm_convenio: convenio.nm_convenio || '',
        vl_total: String(convenio.vl_total || ''),
    });
    function handleSubmit(e) { e.preventDefault(); put(route('orcamento.convenios.update', convenio.id_convenio)); }
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Editar {convenio.nm_convenio}</h2>}>
            <Head title="Editar Convênio" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-6"><Link href={route('orcamento.convenios.show', convenio.id_convenio)} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
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
                            <label className="block text-sm font-medium text-gray-700">Nome do Convênio</label>
                            <input type="text" value={data.nm_convenio} onChange={e => setData('nm_convenio', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.nm_convenio && <p className="mt-1 text-sm text-red-600">{errors.nm_convenio}</p>}
                        </div>
                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Valor Total</label>
                            <input type="number" step="0.01" min="0" value={data.vl_total} onChange={e => setData('vl_total', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.vl_total && <p className="mt-1 text-sm text-red-600">{errors.vl_total}</p>}
                        </div>
                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('orcamento.convenios.show', convenio.id_convenio)} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
