import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';

function formatBRL(value) {
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value || 0);
}

export default function Show({ contrato }) {
    const { flash } = usePage().props;

    function handleToggleAtivo() {
        if (confirm(contrato.st_ativo == 1 ? 'Desativar este contrato?' : 'Ativar este contrato?')) {
            router.put(route('compras.contratos.update', contrato.id_contrato), {
                nr_contrato: contrato.nr_contrato,
                id_fornecedor: contrato.id_fornecedor,
                id_programa_trabalho: contrato.id_programa_trabalho,
                id_fonte: contrato.id_fonte,
                id_tipo_gasto: contrato.id_tipo_gasto,
                ds_objeto: contrato.ds_objeto,
                vl_contrato: contrato.vl_contrato,
                dt_ini_vigencia_contrato: contrato.dt_ini_vigencia_contrato,
                dt_fim_vigencia_contrato: contrato.dt_fim_vigencia_contrato,
                st_ativo: contrato.st_ativo == 1 ? 0 : 1,
            });
        }
    }

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Contrato {contrato.nr_contrato}</h2>}>
            <Head title="Contrato" />
            <div className="py-12"><div className="mx-auto max-w-4xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}
                <div className="mb-4"><Link href={route('compras.contratos.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <h3 className="mb-4 text-sm font-semibold text-gray-700">Dados Principais</h3>
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">Nº Contrato</dt><dd className="mt-1 text-sm text-gray-900">{contrato.nr_contrato}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Fornecedor</dt><dd className="mt-1 text-sm text-gray-900">{contrato.fornecedor_nome}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Programa Trabalho</dt><dd className="mt-1 text-sm text-gray-900">{contrato.programa_trabalho?.cd_programa_trabalho || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Fonte</dt><dd className="mt-1 text-sm text-gray-900">{contrato.fonte?.nr_fonte || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Modalidade</dt><dd className="mt-1 text-sm text-gray-900">{contrato.modalidade?.nm_modalidade || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Tipo Gasto</dt><dd className="mt-1 text-sm text-gray-900">{contrato.tipo_gasto?.nm_tipo_gasto || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Valor</dt><dd className="mt-1 text-sm text-gray-900">{formatBRL(contrato.vl_contrato)}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Tipo Contrato</dt><dd className="mt-1 text-sm text-gray-900">{contrato.tp_contrato || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Ativo</dt><dd className="mt-1 text-sm">
                                <span className={`inline-flex rounded-full px-2 py-1 text-xs font-semibold ${contrato.st_ativo == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`}>
                                    {contrato.st_ativo == 1 ? 'Sim' : 'Não'}
                                </span>
                            </dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Serviço Continuado</dt><dd className="mt-1 text-sm text-gray-900">{contrato.fl_servico_continuado == 1 ? 'Sim' : 'Não'}</dd></div>
                        </dl>
                        {contrato.ds_objeto && (
                            <div className="mt-4"><dt className="text-sm font-medium text-gray-500">Objeto</dt><dd className="mt-1 text-sm text-gray-900">{contrato.ds_objeto}</dd></div>
                        )}
                    </div>
                </div>

                <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <h3 className="mb-4 text-sm font-semibold text-gray-700">Vigência</h3>
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <div><dt className="text-sm font-medium text-gray-500">Início</dt><dd className="mt-1 text-sm text-gray-900">{contrato.dt_ini_vigencia_contrato}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Fim</dt><dd className="mt-1 text-sm text-gray-900">{contrato.dt_fim_vigencia_contrato}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Prazo Entrega</dt><dd className="mt-1 text-sm text-gray-900">{contrato.nr_prazo_entrega ? contrato.nr_prazo_entrega + ' dias' : '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Assinatura</dt><dd className="mt-1 text-sm text-gray-900">{contrato.dt_assinatura || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Publicação</dt><dd className="mt-1 text-sm text-gray-900">{contrato.dt_publicacao || '-'}</dd></div>
                        </dl>
                    </div>
                </div>

                <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <h3 className="mb-4 text-sm font-semibold text-gray-700">Gestão e Fiscalização</h3>
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <div><dt className="text-sm font-medium text-gray-500">Gestor Titular</dt><dd className="mt-1 text-sm text-gray-900">{contrato.gestor_titular?.nm_pessoa || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Gestor Substituto</dt><dd className="mt-1 text-sm text-gray-900">{contrato.gestor_substituto?.nm_pessoa || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Fiscal Titular</dt><dd className="mt-1 text-sm text-gray-900">{contrato.fiscal_titular?.nm_pessoa || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Fiscal Substituto</dt><dd className="mt-1 text-sm text-gray-900">{contrato.fiscal_substituto?.nm_pessoa || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Sub-Fiscal Titular</dt><dd className="mt-1 text-sm text-gray-900">{contrato.sub_fiscal_titular?.nm_pessoa || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Sub-Fiscal Substituto</dt><dd className="mt-1 text-sm text-gray-900">{contrato.sub_fiscal_substituto?.nm_pessoa || '-'}</dd></div>
                        </dl>
                    </div>
                </div>

                <div className="mt-6 flex gap-4">
                    <Link href={route('compras.contratos.edit', contrato.id_contrato)} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link>
                    <button onClick={handleToggleAtivo} className={`rounded-md px-4 py-2 text-sm font-semibold text-white shadow ${contrato.st_ativo == 1 ? 'bg-red-600 hover:bg-red-500' : 'bg-green-600 hover:bg-green-500'}`}>
                        {contrato.st_ativo == 1 ? 'Desativar' : 'Ativar'}
                    </button>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
