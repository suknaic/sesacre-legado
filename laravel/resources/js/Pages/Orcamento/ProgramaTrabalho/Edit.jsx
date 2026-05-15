import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Edit({ programaTrabalho, funcoes, subfuncoes, programasList }) {
    const { data, setData, put, processing, errors } = useForm({
        cd_programa_trabalho: programaTrabalho.cd_programa_trabalho || '',
        nm_programa_trabalho: programaTrabalho.nm_programa_trabalho || '',
        st_ativo: String(programaTrabalho.st_ativo ?? '1'),
    });
    function handleSubmit(e) { e.preventDefault(); put(route('orcamento.programa-trabalho.update', programaTrabalho.id_programa_trabalho)); }
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Editar {programaTrabalho.nm_programa_trabalho}</h2>}>
            <Head title="Editar Programa de Trabalho" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-6"><Link href={route('orcamento.programa-trabalho.show', programaTrabalho.id_programa_trabalho)} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Código (8 caracteres - XX.XXX.XXXX)</label>
                            <input type="text" value={data.cd_programa_trabalho} onChange={e => setData('cd_programa_trabalho', e.target.value)} maxLength={8}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.cd_programa_trabalho && <p className="mt-1 text-sm text-red-600">{errors.cd_programa_trabalho}</p>}
                        </div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" value={data.nm_programa_trabalho} onChange={e => setData('nm_programa_trabalho', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.nm_programa_trabalho && <p className="mt-1 text-sm text-red-600">{errors.nm_programa_trabalho}</p>}
                        </div>
                        <div className="mb-6">
                            <label className="block text-sm font-medium text-gray-700">Ativo</label>
                            <select value={data.st_ativo} onChange={e => setData('st_ativo', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('orcamento.programa-trabalho.show', programaTrabalho.id_programa_trabalho)} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
