import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Index({ situacoes }) {
    return (
        <AuthenticatedLayout header={
            <h2 className="text-xl font-semibold leading-tight text-gray-800">Situações de Documento</h2>
        }>
            <Head title="Situações de Documento" />
            <div className="py-12"><div className="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50"><tr>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Código</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nome</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Descrição</th>
                        </tr></thead>
                        <tbody className="divide-y divide-gray-200 bg-white">
                            {situacoes.data.length === 0 ? (
                                <tr><td colSpan="3" className="px-6 py-4 text-center text-sm text-gray-500">Nenhuma situação encontrada.</td></tr>
                            ) : situacoes.data.map((s) => (
                                <tr key={s.id_documento_situacao}>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{s.id_documento_situacao}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{s.nm_documento_situacao}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{s.ds_documento_situacao || '-'}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
