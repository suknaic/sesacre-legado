import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ funcoes, subfuncoes, programasList }) {
    const { data, setData, post, processing, errors } = useForm({
        cd_programa_trabalho: '',
        nm_programa_trabalho: '',
        st_ativo: '1',
    });
    function handleSubmit(e) { e.preventDefault(); post(route('orcamento.programa-trabalho.store')); }
    function montarCodigo() {
        const funcao = document.getElementById('funcao')?.value || '';
        const subfuncao = document.getElementById('subfuncao')?.value || '';
        const prog = document.getElementById('programa')?.value || '';
        if (funcao && subfuncao && prog) {
            setData('cd_programa_trabalho', `${funcao}.${subfuncao}.${prog}`);
        }
    }
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Novo Programa de Trabalho</h2>}>
            <Head title="Novo Programa de Trabalho" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-6"><Link href={route('orcamento.programa-trabalho.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Código (formato XX.XXX.XXXX)</label>
                            <input type="text" value={data.cd_programa_trabalho} onChange={e => setData('cd_programa_trabalho', e.target.value)} maxLength={8}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Ex: 10.302.2001" />
                            {errors.cd_programa_trabalho && <p className="mt-1 text-sm text-red-600">{errors.cd_programa_trabalho}</p>}
                        </div>
                        {funcoes?.length > 0 && (
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Função</label>
                                <select id="funcao" onChange={montarCodigo} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Selecione...</option>
                                    {funcoes.map((f) => <option key={f.id_cod_funcao} value={f.cod_funcao}>{f.cod_funcao}</option>)}
                                </select>
                            </div>
                        )}
                        {subfuncoes?.length > 0 && (
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Subfunção</label>
                                <select id="subfuncao" onChange={montarCodigo} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Selecione...</option>
                                    {subfuncoes.map((s) => <option key={s.id_cod_sub_funcao} value={s.cod_sub_funcao}>{s.cod_sub_funcao}</option>)}
                                </select>
                            </div>
                        )}
                        {programasList?.length > 0 && (
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Programa</label>
                                <select id="programa" onChange={montarCodigo} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Selecione...</option>
                                    {programasList.map((p) => <option key={p.id_cod_programa} value={p.cod_programa}>{p.cod_programa}</option>)}
                                </select>
                            </div>
                        )}
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700">Nome do Programa de Trabalho</label>
                            <input type="text" value={data.nm_programa_trabalho} onChange={e => setData('nm_programa_trabalho', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.nm_programa_trabalho && <p className="mt-1 text-sm text-red-600">{errors.nm_programa_trabalho}</p>}
                        </div>
                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('orcamento.programa-trabalho.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
