import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

const statusLabels = { 1: 'Rascunho', 2: 'Enviado', 3: 'Devolvido', 4: 'Autorizado' };

export default function Show({ validation }) {
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Detalhes da Validação do PAS</h2>
                <Link href={route('pas-validations.index')} className="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-500">Voltar</Link>
            </div>
        }>
            <Head title="Detalhes da Validação do PAS" />
            <div className="py-8">
                <div className="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 space-y-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-500">PAS</label>
                                <p className="mt-1 text-sm text-gray-900">{validation.annual_plan?.name ?? '---'}</p>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Status</label>
                                <p className="mt-1 text-sm text-gray-900">{statusLabels[validation.validation_status] ?? validation.validation_status}</p>
                            </div>
                            {validation.description && (
                                <div>
                                    <label className="block text-sm font-medium text-gray-500">Descrição</label>
                                    <p className="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{validation.description}</p>
                                </div>
                            )}
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Data</label>
                                <p className="mt-1 text-sm text-gray-900">{validation.created_at?.slice(0, 10)}</p>
                            </div>
                            <div className="pt-4">
                                <Link href={route('pas-validations.edit', validation.id)} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
