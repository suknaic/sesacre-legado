import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Edit({ fonte }) {
    const { data, setData, put, processing, errors } = useForm({
        nr_fonte: fonte.nr_fonte || '',
        st_fonte: String(fonte.st_fonte ?? '1'),
    });
    function handleSubmit(e) { e.preventDefault(); put(route('orcamento.fontes.update', fonte.id_fonte)); }
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Editar Fonte {fonte.nr_fonte}</h2>}>
            <Head title="Editar Fonte" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-6"><Link href={route('orcamento.fontes.show', fonte.id_fonte)} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Número da Fonte</label>
                            <input type="text" value={data.nr_fonte} onChange={e => setData('nr_fonte', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.nr_fonte && <p className="mt-1 text-sm text-red-600">{errors.nr_fonte}</p>}
                        </div>
                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Ativo</label>
                            <select value={data.st_fonte} onChange={e => setData('st_fonte', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('orcamento.fontes.show', fonte.id_fonte)} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
