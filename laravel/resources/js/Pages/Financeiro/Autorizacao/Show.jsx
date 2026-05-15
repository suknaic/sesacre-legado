import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Show({ autorizacao, tipoInfo }) {
    const { flash } = usePage().props;
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Autorização</h2>}>
            <Head title="Autorização" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                <div className="mb-4"><Link href={route('financeiro.autorizacoes.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">Pedido</dt><dd className="mt-1 text-sm text-gray-900">{autorizacao.pedido?.nr_pedido || autorizacao.id_pedido}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Nível</dt><dd className="mt-1 text-sm text-gray-900">{tipoInfo?.label || `Nível ${autorizacao.st_nivel}`}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Data</dt><dd className="mt-1 text-sm text-gray-900">{autorizacao.dt_autorizacao || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Pessoa</dt><dd className="mt-1 text-sm text-gray-900">{autorizacao.id_pessoa || '-'}</dd></div>
                        </dl>
                        <div className="mt-4">
                            <dt className="text-sm font-medium text-gray-500">Descrição</dt>
                            <dd className="mt-1 text-sm text-gray-900">{autorizacao.ds_autorizacao || '-'}</dd>
                        </div>
                    </div>
                </div>
                <div className="mt-6">
                    <Link href={route('financeiro.autorizacoes.edit', autorizacao.id_autorizacao)}
                        className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
