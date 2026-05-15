import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';

const typeLabels = { F: 'Férias', L: 'Licenças', C: 'Concessões', A: 'Afastamentos', I: 'Inativos' };
const typeColors = { F: 'bg-green-100 text-green-800', L: 'bg-blue-100 text-blue-800', C: 'bg-purple-100 text-purple-800', A: 'bg-yellow-100 text-yellow-800', I: 'bg-red-100 text-red-800' };

export default function Index({ contractSituations }) {
    const { flash } = usePage().props;
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Situações Contratuais</h2>
                <Link href={route('contract-situations.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Nova Situação</Link>
            </div>
        }>
            <Head title="Situações Contratuais" />
            <div className="py-8"><div className="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                {flash?.error && <div className="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{flash.error}</div>}
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50"><tr>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nome</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tipo</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ativo</th>
                            <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                        </tr></thead>
                        <tbody className="divide-y divide-gray-200 bg-white">
                            {contractSituations.data.length === 0 ? (
                                <tr><td colSpan="4" className="px-6 py-4 text-center text-sm text-gray-500">Nenhuma situação contratual encontrada.</td></tr>
                            ) : contractSituations.data.map((s) => (
                                <tr key={s.id}>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{s.name}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm">
                                        <span className={`inline-flex rounded-full px-2 text-xs font-semibold ${typeColors[s.type] || 'bg-gray-100 text-gray-800'}`}>
                                            {typeLabels[s.type] || s.type}
                                        </span>
                                    </td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm">{s.is_active ? <span className="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold text-green-800">Sim</span> : <span className="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold text-red-800">Não</span>}</td>
                                    <td className="whitespace-nowrap px-6 py-4 text-sm">
                                        <Link href={route('contract-situations.edit', s.id)} className="text-indigo-600 hover:text-indigo-900">Editar</Link>
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
