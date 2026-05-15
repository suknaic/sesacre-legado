import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Edit({ autorizacao, tipos, pedidos }) {
    const { data, setData, put, processing, errors } = useForm({
        st_nivel: autorizacao.st_nivel || '',
        id_pedido: autorizacao.id_pedido || '',
        ds_autorizacao: autorizacao.ds_autorizacao || '',
        dt_autorizacao: autorizacao.dt_autorizacao || '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        put(route('financeiro.autorizacoes.update', autorizacao.id_autorizacao));
    }

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Editar Autorização</h2>}>
            <Head title="Editar Autorização" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('financeiro.autorizacoes.show', autorizacao.id_autorizacao)} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Nível de Autorização *</label>
                            <select value={data.st_nivel} onChange={e => setData('st_nivel', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione</option>
                                {Object.entries(tipos).map(([k, v]) => (
                                    <option key={k} value={k}>{v.label}</option>
                                ))}
                            </select>
                            {errors.st_nivel && <p className="mt-1 text-sm text-red-600">{errors.st_nivel}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Pedido *</label>
                            <select value={data.id_pedido} onChange={e => setData('id_pedido', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione</option>
                                {pedidos.map(p => <option key={p.id_pedido} value={p.id_pedido}>{p.nr_pedido}</option>)}
                            </select>
                            {errors.id_pedido && <p className="mt-1 text-sm text-red-600">{errors.id_pedido}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Data da Autorização *</label>
                            <input type="date" value={data.dt_autorizacao} onChange={e => setData('dt_autorizacao', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            {errors.dt_autorizacao && <p className="mt-1 text-sm text-red-600">{errors.dt_autorizacao}</p>}
                        </div>

                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea value={data.ds_autorizacao} onChange={e => setData('ds_autorizacao', e.target.value)} rows={3}
                                className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('financeiro.autorizacoes.show', autorizacao.id_autorizacao)} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
