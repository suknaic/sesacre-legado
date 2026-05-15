import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';

export default function Index({ tipos }) {
    const { flash } = usePage().props;

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Tipos de Documento</h2>
                <Link href={route('financeiro.tipos-documento.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Novo Tipo</Link>
            </div>
        }>
            <Head title="Tipos de Documento" />
            <div className="py-12"><div className="mx-auto max-w-4xl sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}

                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50"><tr>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nome</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Descrição</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ativo</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                        </tr></thead>
                        <tbody className="divide-y divide-gray-200 bg-white">
                            {tipos.data.length === 0 ? (
                                <tr><td colSpan="4" className="px-6 py-4 text-center text-sm text-gray-500">Nenhum tipo encontrado.</td></tr>
                            ) : tipos.data.map((t) => (
                                <tr key={t.id_tipo_documento}>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{t.nm_tipo_documento}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{t.ds_tipo_documento || '-'}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm">
                                        <span className={`inline-flex rounded-full px-2 py-1 text-xs font-semibold ${t.st_tipo_documento ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`}>
                                            {t.st_tipo_documento ? 'Sim' : 'Não'}
                                        </span>
                                    </td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm">
                                        <Link href={route('financeiro.tipos-documento.show', t.id_tipo_documento)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                        <Link href={route('financeiro.tipos-documento.edit', t.id_tipo_documento)} className="ml-3 text-indigo-600 hover:text-indigo-900">Editar</Link>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
