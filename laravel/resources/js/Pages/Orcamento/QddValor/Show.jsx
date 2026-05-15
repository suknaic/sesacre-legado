import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ qddValor }) {
    const vlAtual = Number(qddValor.vl_qdd_inical || 0) + Number(qddValor.vl_qdd_suplementado || 0) - Number(qddValor.vl_qdd_reduzido || 0);
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Valor QDD #{qddValor.id_qdd_valor}</h2>}>
            <Head title="Valor QDD" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('orcamento.qdd-valor.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">QDD</dt><dd className="mt-1 text-sm text-gray-900">{qddValor.qdd?.aa_qdd || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Fonte</dt><dd className="mt-1 text-sm text-gray-900">{qddValor.fonte?.nr_fonte || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Programa de Trabalho</dt><dd className="mt-1 text-sm text-gray-900">{qddValor.programaTrabalho?.cd_programa_trabalho || '-'} - {qddValor.programaTrabalho?.nm_programa_trabalho || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Elemento de Despesa</dt><dd className="mt-1 text-sm text-gray-900">{qddValor.despesaElemento?.cd_despesa_elemento || '-'} - {qddValor.despesaElemento?.nm_despesa_elemento || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Valor Inicial</dt><dd className="mt-1 text-sm text-gray-900">{new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(qddValor.vl_qdd_inical || 0)}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Suplementado</dt><dd className="mt-1 text-sm text-gray-900">{new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(qddValor.vl_qdd_suplementado || 0)}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Reduzido</dt><dd className="mt-1 text-sm text-gray-900">{new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(qddValor.vl_qdd_reduzido || 0)}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Valor Atual</dt><dd className="mt-1 text-sm text-gray-900">{new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(vlAtual)}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Empenhado</dt><dd className="mt-1 text-sm text-gray-900">{new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(qddValor.vl_empenhado || 0)}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Bloqueado</dt><dd className="mt-1 text-sm text-gray-900">{new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(qddValor.vl_bloqueado || 0)}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Liberado</dt><dd className="mt-1 text-sm text-gray-900">{new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(qddValor.vl_liberado || 0)}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Saldo</dt><dd className="mt-1 text-sm text-gray-900">{new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(qddValor.vl_saldo || 0)}</dd></div>
                        </dl>
                    </div>
                </div>
                <div className="mt-6"><Link href={route('orcamento.qdd-valor.edit', qddValor.id_qdd_valor)}
                    className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link></div>
            </div></div>
        </AuthenticatedLayout>
    );
}
