import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create() {
    const { data, setData, post, processing, errors } = useForm({
        nm_tipo_documento: '',
        ds_tipo_documento: '',
        st_tipo_documento: true,
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('financeiro.tipos-documento.store'));
    }

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Novo Tipo de Documento</h2>}>
            <Head title="Novo Tipo de Documento" />
            <div className="py-12"><div className="mx-auto max-w-2xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('financeiro.tipos-documento.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Nome *</label>
                            <input type="text" value={data.nm_tipo_documento} onChange={e => setData('nm_tipo_documento', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            {errors.nm_tipo_documento && <p className="mt-1 text-sm text-red-600">{errors.nm_tipo_documento}</p>}
                        </div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea value={data.ds_tipo_documento} onChange={e => setData('ds_tipo_documento', e.target.value)} rows={3}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>
                        <div className="mb-6">
                            <label className="flex items-center gap-2">
                                <input type="checkbox" checked={data.st_tipo_documento} onChange={e => setData('st_tipo_documento', e.target.checked)}
                                    className="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                <span className="text-sm font-medium text-gray-700">Ativo</span>
                            </label>
                        </div>
                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('financeiro.tipos-documento.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
