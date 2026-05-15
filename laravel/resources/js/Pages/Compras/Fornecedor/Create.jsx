import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ medicamentos, servicos, materiaisConsumo, materiaisPermanente }) {
    const { data, setData, post, processing, errors } = useForm({
        nm_pessoa: '',
        nr_cpf_cnpj: '',
        nr_telefone_celular: '',
        nm_email: '',
        ds_logradouro: '',
        ds_bairro: '',
        nr_cep: '',
        id_cidade: '',
        medicamentos: [],
        servicos: [],
        materiais_consumo: [],
        materiais_permanente: [],
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('compras.fornecedores.store'));
    }

    function toggleMulti(key, id) {
        const current = data[key] || [];
        const next = current.includes(id) ? current.filter(x => x !== id) : [...current, id];
        setData(key, next);
    }

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Novo Fornecedor</h2>}>
            <Head title="Novo Fornecedor" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('compras.fornecedores.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <h3 className="mb-4 text-sm font-semibold text-gray-700">Dados da Pessoa</h3>
                        <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Nome *</label>
                                <input type="text" value={data.nm_pessoa} onChange={e => setData('nm_pessoa', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.nm_pessoa && <p className="mt-1 text-sm text-red-600">{errors.nm_pessoa}</p>}
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">CPF/CNPJ *</label>
                                <input type="text" value={data.nr_cpf_cnpj} onChange={e => setData('nr_cpf_cnpj', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.nr_cpf_cnpj && <p className="mt-1 text-sm text-red-600">{errors.nr_cpf_cnpj}</p>}
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Telefone</label>
                                <input type="text" value={data.nr_telefone_celular} onChange={e => setData('nr_telefone_celular', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" value={data.nm_email} onChange={e => setData('nm_email', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                {errors.nm_email && <p className="mt-1 text-sm text-red-600">{errors.nm_email}</p>}
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Logradouro</label>
                                <input type="text" value={data.ds_logradouro} onChange={e => setData('ds_logradouro', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Bairro</label>
                                <input type="text" value={data.ds_bairro} onChange={e => setData('ds_bairro', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">CEP</label>
                                <input type="text" value={data.nr_cep} onChange={e => setData('nr_cep', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                        </div>

                        <h3 className="mb-4 mt-6 text-sm font-semibold text-gray-700">Vínculos (Catálogos)</h3>
                        <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Medicamentos</label>
                                <div className="mt-1 max-h-32 overflow-y-auto rounded-md border border-gray-300 p-2">
                                    {medicamentos.length === 0 ? <p className="text-xs text-gray-400">Nenhum medicamento cadastrado.</p> : medicamentos.map(m => (
                                        <label key={m.id_medicamento} className="flex items-center gap-2 py-1">
                                            <input type="checkbox" checked={data.medicamentos.includes(m.id_medicamento)} onChange={() => toggleMulti('medicamentos', m.id_medicamento)}
                                                className="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                            <span className="text-sm">{m.nm_medicamento}</span>
                                        </label>
                                    ))}
                                </div>
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Serviços</label>
                                <div className="mt-1 max-h-32 overflow-y-auto rounded-md border border-gray-300 p-2">
                                    {servicos.length === 0 ? <p className="text-xs text-gray-400">Nenhum serviço cadastrado.</p> : servicos.map(s => (
                                        <label key={s.id_servico} className="flex items-center gap-2 py-1">
                                            <input type="checkbox" checked={data.servicos.includes(s.id_servico)} onChange={() => toggleMulti('servicos', s.id_servico)}
                                                className="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                            <span className="text-sm">{s.nm_servico}</span>
                                        </label>
                                    ))}
                                </div>
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Materiais de Consumo</label>
                                <div className="mt-1 max-h-32 overflow-y-auto rounded-md border border-gray-300 p-2">
                                    {materiaisConsumo.length === 0 ? <p className="text-xs text-gray-400">Nenhum material cadastrado.</p> : materiaisConsumo.map(m => (
                                        <label key={m.id_material_consumo} className="flex items-center gap-2 py-1">
                                            <input type="checkbox" checked={data.materiais_consumo.includes(m.id_material_consumo)} onChange={() => toggleMulti('materiais_consumo', m.id_material_consumo)}
                                                className="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                            <span className="text-sm">{m.nm_material_consumo}</span>
                                        </label>
                                    ))}
                                </div>
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700">Materiais Permanentes</label>
                                <div className="mt-1 max-h-32 overflow-y-auto rounded-md border border-gray-300 p-2">
                                    {materiaisPermanente.length === 0 ? <p className="text-xs text-gray-400">Nenhum material cadastrado.</p> : materiaisPermanente.map(m => (
                                        <label key={m.id_material_permanente} className="flex items-center gap-2 py-1">
                                            <input type="checkbox" checked={data.materiais_permanente.includes(m.id_material_permanente)} onChange={() => toggleMulti('materiais_permanente', m.id_material_permanente)}
                                                className="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                            <span className="text-sm">{m.nm_material_permanente}</span>
                                        </label>
                                    ))}
                                </div>
                            </div>
                        </div>

                        <div className="flex items-center justify-end gap-4 mt-6">
                            <Link href={route('compras.fornecedores.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
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
