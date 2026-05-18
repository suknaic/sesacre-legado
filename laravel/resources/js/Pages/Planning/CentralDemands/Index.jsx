import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Index({ demands }) {
    const { flash } = usePage().props;
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Centrais de Demanda</h2>
                <Link href={route('central-demands.create')} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Nova Central</Link>
            </div>
        }>
            <Head title="Centrais de Demanda" />
            <div className="py-8">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Pessoa</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Lotação Central</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-200 bg-white">
                                {demands.data.length === 0 ? (
                                    <tr><td colSpan="3" className="px-6 py-4 text-center text-sm text-gray-500">Nenhuma central encontrada.</td></tr>
                                ) : demands.data.map((d) => (
                                    <tr key={d.id}>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{d.personal_info?.name ?? '---'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{d.organization?.name ?? '---'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">
                                            <Link href={route('central-demands.show', d.id)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                            <Link href={route('central-demands.edit', d.id)} className="ml-3 text-indigo-600 hover:text-indigo-900">Editar</Link>
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
