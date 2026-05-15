import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';

export default function Show({ fornecedor }) {
    const { flash } = usePage().props;

    function handleToggleAtivo() {
        if (confirm(fornecedor.sit_fornecedor == 1 ? 'Desativar este fornecedor?' : 'Ativar este fornecedor?')) {
            router.put(route('compras.fornecedores.update', fornecedor.id_fornecedor), {
                sit_fornecedor: fornecedor.sit_fornecedor == 1 ? 0 : 1,
                nm_pessoa: fornecedor.pessoa?.nm_pessoa,
                nr_cpf_cnpj: fornecedor.documento_raw || '',
            });
        }
    }

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Fornecedor</h2>}>
            <Head title="Fornecedor" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}
                <div className="mb-4"><Link href={route('compras.fornecedores.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">ID</dt><dd className="mt-1 text-sm text-gray-900">{fornecedor.id_fornecedor}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Nome</dt><dd className="mt-1 text-sm text-gray-900">{fornecedor.pessoa?.nm_pessoa || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">CPF/CNPJ</dt><dd className="mt-1 text-sm text-gray-900">{fornecedor.documento || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Telefone</dt><dd className="mt-1 text-sm text-gray-900">{fornecedor.pessoa?.nr_telefone_celular || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Email</dt><dd className="mt-1 text-sm text-gray-900">{fornecedor.pessoa?.nm_email || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Logradouro</dt><dd className="mt-1 text-sm text-gray-900">{fornecedor.pessoa?.ds_logradouro || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Bairro</dt><dd className="mt-1 text-sm text-gray-900">{fornecedor.pessoa?.ds_bairro || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">CEP</dt><dd className="mt-1 text-sm text-gray-900">{fornecedor.pessoa?.nr_cep || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Situação</dt><dd className="mt-1 text-sm">
                                <span className={`inline-flex rounded-full px-2 py-1 text-xs font-semibold ${fornecedor.sit_fornecedor == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`}>
                                    {fornecedor.sit_fornecedor == 1 ? 'Ativo' : 'Inativo'}
                                </span>
                            </dd></div>
                        </dl>
                    </div>
                </div>

                {fornecedor.medicamentos?.length > 0 && (
                    <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <h3 className="text-sm font-medium text-gray-700 mb-2">Medicamentos Vinculados</h3>
                            <div className="flex flex-wrap gap-2">
                                {fornecedor.medicamentos.map(m => (
                                    <span key={m.id_medicamento} className="rounded-full bg-blue-100 px-3 py-1 text-xs text-blue-800">{m.nm_medicamento}</span>
                                ))}
                            </div>
                        </div>
                    </div>
                )}

                {fornecedor.servicos?.length > 0 && (
                    <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <h3 className="text-sm font-medium text-gray-700 mb-2">Serviços Vinculados</h3>
                            <div className="flex flex-wrap gap-2">
                                {fornecedor.servicos.map(s => (
                                    <span key={s.id_servico} className="rounded-full bg-green-100 px-3 py-1 text-xs text-green-800">{s.nm_servico}</span>
                                ))}
                            </div>
                        </div>
                    </div>
                )}

                {fornecedor.materiais_consumo?.length > 0 && (
                    <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <h3 className="text-sm font-medium text-gray-700 mb-2">Materiais de Consumo Vinculados</h3>
                            <div className="flex flex-wrap gap-2">
                                {fornecedor.materiais_consumo.map(m => (
                                    <span key={m.id_material_consumo} className="rounded-full bg-purple-100 px-3 py-1 text-xs text-purple-800">{m.nm_material_consumo}</span>
                                ))}
                            </div>
                        </div>
                    </div>
                )}

                {fornecedor.materiais_permanente?.length > 0 && (
                    <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <h3 className="text-sm font-medium text-gray-700 mb-2">Materiais Permanentes Vinculados</h3>
                            <div className="flex flex-wrap gap-2">
                                {fornecedor.materiais_permanente.map(m => (
                                    <span key={m.id_material_permanente} className="rounded-full bg-yellow-100 px-3 py-1 text-xs text-yellow-800">{m.nm_material_permanente}</span>
                                ))}
                            </div>
                        </div>
                    </div>
                )}

                <div className="mt-6 flex gap-4">
                    <Link href={route('compras.fornecedores.edit', fornecedor.id_fornecedor)} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link>
                    <button onClick={handleToggleAtivo} className={`rounded-md px-4 py-2 text-sm font-semibold text-white shadow ${fornecedor.sit_fornecedor == 1 ? 'bg-red-600 hover:bg-red-500' : 'bg-green-600 hover:bg-green-500'}`}>
                        {fornecedor.sit_fornecedor == 1 ? 'Desativar' : 'Ativar'}
                    </button>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
