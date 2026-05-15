import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Show({ preOrdem }) {
    const { flash } = usePage().props;
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Pré-Ordem #{preOrdem.id_pre_ordem}</h2>}>
            <Head title="Pré-Ordem" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                <div className="mb-4"><Link href={route('financeiro.pre-ordens.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">ID</dt><dd className="mt-1 text-sm text-gray-900">{preOrdem.id_pre_ordem}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Pedido</dt><dd className="mt-1 text-sm text-gray-900">{preOrdem.pedido?.nr_pedido || preOrdem.id_pedido}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Fornecedor</dt><dd className="mt-1 text-sm text-gray-900">{preOrdem.fornecedor?.id_pessoa || preOrdem.id_fornecedor}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Quantidade Itens</dt><dd className="mt-1 text-sm text-gray-900">{preOrdem.qt_itens_pre || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Valor Itens</dt><dd className="mt-1 text-sm text-gray-900">
                                {new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(preOrdem.vl_itens_pre || 0)}
                            </dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Valor Total</dt><dd className="mt-1 text-lg font-semibold text-gray-900">
                                {new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(preOrdem.vl_total || 0)}
                            </dd></div>
                        </dl>
                    </div>
                </div>
                <div className="mt-6">
                    <Link href={route('financeiro.pre-ordens.edit', preOrdem.id_pre_ordem)}
                        className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
