import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ centralLiberacao }) {
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Liberação #{centralLiberacao.id_central_liberacao}</h2>}>
            <Head title="Liberação" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('orcamento.central-liberacoes.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">Data/Hora</dt><dd className="mt-1 text-sm text-gray-900">{centralLiberacao.dh_central_liberacao || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Descrição</dt><dd className="mt-1 text-sm text-gray-900">{centralLiberacao.ds_central_liberacao || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Tipo</dt><dd className="mt-1 text-sm text-gray-900">{centralLiberacao.tp_central_liberacao || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Status</dt><dd className="mt-1 text-sm text-gray-900">{centralLiberacao.st_central_liberacao === 1 ? 'Ativo' : centralLiberacao.st_central_liberacao === 3 ? 'Cancelado' : '-'}</dd></div>
                        </dl>
                    </div>
                </div>
                <div className="mt-6"><Link href={route('orcamento.central-liberacoes.edit', centralLiberacao.id_central_liberacao)}
                    className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link></div>
            </div></div>
        </AuthenticatedLayout>
    );
}
