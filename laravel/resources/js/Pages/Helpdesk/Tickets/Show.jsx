import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ ticket }) {
    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Chamado #{ticket.id}</h2>
                <div className="flex gap-2">
                    <Link href={route('tickets.edit', ticket.id)} className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                        Editar
                    </Link>
                    <Link href={route('tickets.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">
                        Voltar
                    </Link>
                </div>
            </div>
        }>
            <Head title={`Chamado #${ticket.id}`} />
            <div className="py-8">
                <div className="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 space-y-4">
                            <div>
                                <span className="text-sm font-medium text-gray-500">ID</span>
                                <p className="text-gray-900">#{ticket.id}</p>
                            </div>

                            <div>
                                <span className="text-sm font-medium text-gray-500">Descrição</span>
                                <p className="text-gray-900 whitespace-pre-wrap">{ticket.description || '-'}</p>
                            </div>

                            <div>
                                <span className="text-sm font-medium text-gray-500">Status</span>
                                <p className="text-gray-900">{ticket.status?.name || '-'}</p>
                            </div>

                            <div>
                                <span className="text-sm font-medium text-gray-500">Prioridade</span>
                                <p className="text-gray-900">{ticket.priority?.name || '-'}</p>
                            </div>

                            <div>
                                <span className="text-sm font-medium text-gray-500">Telefone</span>
                                <p className="text-gray-900">{ticket.requester_phone || '-'}</p>
                            </div>

                            <div>
                                <span className="text-sm font-medium text-gray-500">Prazo</span>
                                <p className="text-gray-900">{ticket.deadline?.split('T')[0] || '-'}</p>
                            </div>

                            <div>
                                <span className="text-sm font-medium text-gray-500">Criado em</span>
                                <p className="text-gray-900">{ticket.created_at?.split('T')[0] || '-'}</p>
                            </div>

                            {ticket.resolution && (
                                <div>
                                    <span className="text-sm font-medium text-gray-500">Resolução</span>
                                    <p className="text-gray-900 whitespace-pre-wrap">{ticket.resolution}</p>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
