import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';

const statusLabels = { 1: 'Rascunho', 2: 'Enviado', 3: 'Devolvido', 4: 'Autorizado' };

export default function Index({ validations }) {
    const { flash } = usePage().props;
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Validações do PAS</h2>
                <Link href={route('pas-validations.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Nova Validação</Link>
            </div>
        }>
            <Head title="Validações do PAS" />
            <div className="py-8">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">PAS</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Descrição</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Data</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-200 bg-white">
                                {validations.data.length === 0 ? (
                                    <tr><td colSpan="5" className="px-6 py-4 text-center text-sm text-gray-500">Nenhuma validação encontrada.</td></tr>
                                ) : validations.data.map((v) => (
                                    <tr key={v.id}>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{v.annual_plan?.name ?? '---'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">{statusLabels[v.validation_status] ?? v.validation_status}</td>
                                        <td className="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">{v.description ?? '---'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{v.created_at?.slice(0, 10)}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">
                                            <Link href={route('pas-validations.show', v.id)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                            <Link href={route('pas-validations.edit', v.id)} className="ml-3 text-indigo-600 hover:text-indigo-900">Editar</Link>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
