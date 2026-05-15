import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ tipo }) {
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">{tipo.nm_tipo_documento}</h2>}>
            <Head title={tipo.nm_tipo_documento} />
            <div className="py-12"><div className="mx-auto max-w-2xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('financeiro.tipos-documento.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4">
                            <div><dt className="text-sm font-medium text-gray-500">Nome</dt><dd className="mt-1 text-sm text-gray-900">{tipo.nm_tipo_documento}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Descrição</dt><dd className="mt-1 text-sm text-gray-900">{tipo.ds_tipo_documento || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Ativo</dt>
                                <dd className="mt-1 text-sm">
                                    <span className={`inline-flex rounded-full px-2 py-1 text-xs font-semibold ${tipo.st_tipo_documento ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`}>
                                        {tipo.st_tipo_documento ? 'Sim' : 'Não'}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                        <div className="mt-6">
                            <Link href={route('financeiro.tipos-documento.edit', tipo.id_tipo_documento)}
                                className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link>
                        </div>
                    </div>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
