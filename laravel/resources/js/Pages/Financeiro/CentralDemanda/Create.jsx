import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ lotacoes }) {
    const { data, setData, post, processing, errors } = useForm({
        id_lotacao: '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('financeiro.centrais-demanda.store'));
    }

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Nova Central de Demanda</h2>}>
            <Head title="Nova Central de Demanda" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('financeiro.centrais-demanda.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Lotação *</label>
                            <select value={data.id_lotacao} onChange={e => setData('id_lotacao', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione</option>
                                {lotacoes.map(l => <option key={l.id_lotacao} value={l.id_lotacao}>{l.nm_lotacao}</option>)}
                            </select>
                            {errors.id_lotacao && <p className="mt-1 text-sm text-red-600">{errors.id_lotacao}</p>}
                        </div>

                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('financeiro.centrais-demanda.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
