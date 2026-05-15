import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ despesaElemento }) {
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">{despesaElemento.cd_despesa_elemento} - {despesaElemento.nm_despesa_elemento}</h2>}>
            <Head title={despesaElemento.nm_despesa_elemento} />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('orcamento.despesa-elementos.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">Código</dt><dd className="mt-1 text-sm text-gray-900">{despesaElemento.cd_despesa_elemento}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Nome</dt><dd className="mt-1 text-sm text-gray-900">{despesaElemento.nm_despesa_elemento}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Despesa</dt><dd className="mt-1 text-sm text-gray-900">{despesaElemento.despesa?.cd_despesa || '-'} - {despesaElemento.despesa?.nm_despesa || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Ativo</dt><dd className="mt-1 text-sm text-gray-900">{despesaElemento.st_ativo ? 'Sim' : 'Não'}</dd></div>
                        </dl>
                    </div>
                </div>
                <div className="mt-6"><Link href={route('orcamento.despesa-elementos.edit', despesaElemento.id_despesa_elemento)}
                    className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link></div>
            </div></div>
        </AuthenticatedLayout>
    );
}
