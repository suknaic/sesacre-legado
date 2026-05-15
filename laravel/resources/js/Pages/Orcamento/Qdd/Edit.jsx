import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Edit({ qdd }) {
    const { data, setData, put, processing, errors } = useForm({
        aa_qdd: String(qdd.aa_qdd),
    });
    function handleSubmit(e) { e.preventDefault(); put(route('orcamento.qdd.update', qdd.id_qdd)); }
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Editar QDD {qdd.aa_qdd}</h2>}>
            <Head title="Editar QDD" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-6"><Link href={route('orcamento.qdd.show', qdd.id_qdd)} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Ano (4 dígitos)</label>
                            <input type="number" value={data.aa_qdd} onChange={e => setData('aa_qdd', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.aa_qdd && <p className="mt-1 text-sm text-red-600">{errors.aa_qdd}</p>}
                        </div>
                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('orcamento.qdd.show', qdd.id_qdd)} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
