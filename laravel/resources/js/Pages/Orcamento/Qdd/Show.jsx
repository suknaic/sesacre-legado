import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ qdd }) {
    const totalInicial = qdd.valores.reduce((s, v) => s + Number(v.vl_qdd_inical || 0), 0);
    const totalSaldo = qdd.valores.reduce((s, v) => s + Number(v.vl_saldo || 0), 0);
    const totalEmpenhado = qdd.valores.reduce((s, v) => s + Number(v.vl_empenhado || 0), 0);

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">QDD {qdd.aa_qdd}</h2>}>
            <Head title={`QDD ${qdd.aa_qdd}`} />
            <div className="py-12"><div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('orcamento.qdd.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <div><dt className="text-sm font-medium text-gray-500">Ano</dt><dd className="mt-1 text-sm text-gray-900">{qdd.aa_qdd}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Total Valor Inicial</dt><dd className="mt-1 text-sm text-gray-900">{new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(totalInicial)}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Saldo Total</dt><dd className="mt-1 text-sm text-gray-900">{new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(totalSaldo)}</dd></div>
                        </dl>
                    </div>
                </div>
                {qdd.valores.length > 0 && (
                    <div className="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="border-b border-gray-200 px-6 py-4">
                            <h3 className="text-lg font-medium text-gray-900">Valores por Fonte, Programa e Elemento</h3>
                        </div>
                        <div className="overflow-x-auto">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50"><tr>
                                    <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Fonte</th>
                                    <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Programa</th>
                                    <th className="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Elemento</th>
                                    <th className="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Inicial</th>
                                    <th className="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Empenhado</th>
                                    <th className="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Saldo</th>
                                </tr></thead>
                                <tbody className="divide-y divide-gray-200 bg-white">
                                    {qdd.valores.map((v) => (
                                        <tr key={v.id_qdd_valor}>
                                            <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-900">{v.fonte?.nr_fonte || '-'}</td>
                                            <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-900">{v.programaTrabalho?.nm_programa_trabalho || '-'}</td>
                                            <td className="whitespace-nowrap px-4 py-3 text-sm text-gray-900">{v.despesaElemento?.nm_despesa_elemento || '-'}</td>
                                            <td className="whitespace-nowrap px-4 py-3 text-sm text-right text-gray-900">{new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(v.vl_qdd_inical || 0)}</td>
                                            <td className="whitespace-nowrap px-4 py-3 text-sm text-right text-gray-900">{new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(v.vl_empenhado || 0)}</td>
                                            <td className="whitespace-nowrap px-4 py-3 text-sm text-right text-gray-900">{new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(v.vl_saldo || 0)}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                )}
                <div className="mt-6"><Link href={route('orcamento.qdd.edit', qdd.id_qdd)}
                    className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link></div>
            </div></div>
        </AuthenticatedLayout>
    );
}
