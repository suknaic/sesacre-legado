import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ responsavel }) {
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Responsável por Central</h2>}>
            <Head title="Responsável" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('financeiro.centrais-responsavel.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">ID</dt><dd className="mt-1 text-sm text-gray-900">{responsavel.id_central_responsavel}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Lotação</dt><dd className="mt-1 text-sm text-gray-900">{responsavel.id_lotacao}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Pessoa</dt><dd className="mt-1 text-sm text-gray-900">{responsavel.id_pessoa}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Tipo Administração</dt><dd className="mt-1 text-sm text-gray-900">{responsavel.id_tipo_administracao}</dd></div>
                        </dl>
                    </div>
                </div>
                <div className="mt-6">
                    <Link href={route('financeiro.centrais-responsavel.edit', responsavel.id_central_responsavel)}
                        className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
