import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ guideline }) {
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Detalhes da Diretriz</h2>
                <Link href={route('planning-guidelines.index')} className="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-500">Voltar</Link>
            </div>
        }>
            <Head title="Detalhes da Diretriz" />
            <div className="py-8">
                <div className="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 space-y-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Eixo</label>
                                <p className="mt-1 text-sm text-gray-900">{guideline.planning_axis?.name ?? '---'}</p>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-500">PES</label>
                                <p className="mt-1 text-sm text-gray-900">{guideline.planning_axis?.pes_plan?.name ?? '---'}</p>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Nome</label>
                                <p className="mt-1 text-sm text-gray-900">{guideline.name}</p>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Ordem</label>
                                <p className="mt-1 text-sm text-gray-900">{guideline.order}</p>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-500">Ativo</label>
                                <p className="mt-1 text-sm">{guideline.is_active ? <span className="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold text-green-800">Sim</span> : 'Não'}</p>
                            </div>
                            <div className="pt-4">
                                <Link href={route('planning-guidelines.edit', guideline.id)} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
