import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ indicator }) {
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Detalhes do Indicador de Saúde</h2>
                <Link href={route('health-indicators.index')} className="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-500">Voltar</Link>
            </div>
        }>
            <Head title="Detalhes do Indicador de Saúde" />
            <div className="py-8">
                <div className="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 space-y-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Nome</label>
                                <p className="mt-1 text-sm text-gray-900">{indicator.name}</p>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Ano</label>
                                <p className="mt-1 text-sm text-gray-900">{indicator.year ?? '---'}</p>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Código Nota</label>
                                <p className="mt-1 text-sm text-gray-900">{indicator.note_code ?? '---'}</p>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Tipo</label>
                                <p className="mt-1 text-sm text-gray-900">{indicator.indicator_type ?? '---'}</p>
                            </div>
                            {indicator.goal && (
                                <div>
                                    <label className="block text-sm font-medium text-gray-500">Meta</label>
                                    <p className="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{indicator.goal}</p>
                                </div>
                            )}
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Unidade</label>
                                <p className="mt-1 text-sm text-gray-900">{indicator.unit ?? '---'}</p>
                            </div>
                            <div className="pt-4">
                                <Link href={route('health-indicators.edit', indicator.id)} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
