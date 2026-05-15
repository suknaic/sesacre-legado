import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Edit({ redeTematica, blocos }) {
    const { data, setData, put, processing, errors } = useForm({
        nm_rede_tematica: redeTematica.nm_rede_tematica || '',
        id_bloc_orcamentario: String(redeTematica.id_bloc_orcamentario || ''),
    });
    function handleSubmit(e) { e.preventDefault(); put(route('orcamento.redes-tematicas.update', redeTematica.id_rede_tematica)); }
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Editar {redeTematica.nm_rede_tematica}</h2>}>
            <Head title="Editar Rede Temática" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-6"><Link href={route('orcamento.redes-tematicas.show', redeTematica.id_rede_tematica)} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Nome da Rede Temática</label>
                            <input type="text" value={data.nm_rede_tematica} onChange={e => setData('nm_rede_tematica', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.nm_rede_tematica && <p className="mt-1 text-sm text-red-600">{errors.nm_rede_tematica}</p>}
                        </div>
                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Bloco Orçamentário</label>
                            <select value={data.id_bloc_orcamentario} onChange={e => setData('id_bloc_orcamentario', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Selecione...</option>
                                {blocos.map((b) => <option key={b.id_bloc_orcamentario} value={b.id_bloc_orcamentario}>{b.nm_bloc_orcamentario}</option>)}
                            </select>
                            {errors.id_bloc_orcamentario && <p className="mt-1 text-sm text-red-600">{errors.id_bloc_orcamentario}</p>}
                        </div>
                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('orcamento.redes-tematicas.show', redeTematica.id_rede_tematica)} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
