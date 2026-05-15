import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Edit({ blocoOrcamentario }) {
    const { data, setData, put, processing, errors } = useForm({
        nm_bloc_orcamentario: blocoOrcamentario.nm_bloc_orcamentario || '',
    });
    function handleSubmit(e) { e.preventDefault(); put(route('orcamento.blocos-orcamentarios.update', blocoOrcamentario.id_bloc_orcamentario)); }
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Editar {blocoOrcamentario.nm_bloc_orcamentario}</h2>}>
            <Head title="Editar Bloco Orçamentário" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-6"><Link href={route('orcamento.blocos-orcamentarios.show', blocoOrcamentario.id_bloc_orcamentario)} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Nome do Bloco Orçamentário</label>
                            <input type="text" value={data.nm_bloc_orcamentario} onChange={e => setData('nm_bloc_orcamentario', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.nm_bloc_orcamentario && <p className="mt-1 text-sm text-red-600">{errors.nm_bloc_orcamentario}</p>}
                        </div>
                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('orcamento.blocos-orcamentarios.show', blocoOrcamentario.id_bloc_orcamentario)} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
