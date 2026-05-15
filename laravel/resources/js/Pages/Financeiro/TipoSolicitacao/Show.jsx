import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ tipo }) {
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Tipo de Solicitação</h2>}>
            <Head title="Tipo de Solicitação" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('financeiro.tipos-solicitacao.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">ID</dt><dd className="mt-1 text-sm text-gray-900">{tipo.id_tipo_solicitacao}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Nome</dt><dd className="mt-1 text-sm text-gray-900">{tipo.nm_tipo_solicitacao}</dd></div>
                            {tipo.pedidos_count !== undefined && (
                                <div><dt className="text-sm font-medium text-gray-500">Pedidos Vinculados</dt><dd className="mt-1 text-sm text-gray-900">{tipo.pedidos_count}</dd></div>
                            )}
                        </dl>
                    </div>
                </div>
                <div className="mt-6">
                    <Link href={route('financeiro.tipos-solicitacao.edit', tipo.id_tipo_solicitacao)}
                        className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
