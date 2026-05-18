import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ ticket }) {
    const sec = ticket.secondary_category;
    const primary = sec?.primary_category;
    const type = primary?.category_type;
    const cat = type?.category;

    const categoryChain = [cat?.name, type?.name, primary?.name, sec?.name].filter(Boolean).join(' > ');

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
                <div className="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-6">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 space-y-4">
                            <div>
                                <span className="text-sm font-medium text-gray-500">ID</span>
                                <p className="text-gray-900">#{ticket.id}</p>
                            </div>

                            {categoryChain && (
                                <div>
                                    <span className="text-sm font-medium text-gray-500">Categoria</span>
                                    <p className="text-gray-900">{categoryChain}</p>
                                </div>
                            )}

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

                            {ticket.rating && (
                                <div>
                                    <span className="text-sm font-medium text-gray-500">Avaliação</span>
                                    <p className="text-gray-900">{ticket.rating}{ticket.rating_comment ? ` — ${ticket.rating_comment}` : ''}</p>
                                </div>
                            )}
                        </div>
                    </div>

                    {ticket.notes?.length > 0 && (
                        <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                            <div className="p-6">
                                <h3 className="text-lg font-medium text-gray-900 mb-4">Anotações</h3>
                                <div className="space-y-3">
                                    {ticket.notes.map((note) => (
                                        <div key={note.id} className="rounded-lg bg-gray-50 p-4">
                                            <p className="text-sm text-gray-700 whitespace-pre-wrap">{note.note}</p>
                                            <p className="mt-1 text-xs text-gray-500">
                                                {note.note_date?.split('T')[0] || note.created_at?.split('T')[0]}
                                            </p>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>
                    )}

                    {ticket.services?.length > 0 && (
                        <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                            <div className="p-6">
                                <h3 className="text-lg font-medium text-gray-900 mb-4">Serviços</h3>
                                <div className="space-y-3">
                                    {ticket.services.map((s) => (
                                        <div key={s.id} className="rounded-lg bg-gray-50 p-4">
                                            <p className="text-sm text-gray-700">{s.service_description || '-'}</p>
                                            <div className="mt-1 text-xs text-gray-500 space-x-4">
                                                <span>Qtd: {s.quantity || '-'}</span>
                                                <span>Valor: R$ {s.service_value ?? '-'}</span>
                                                <span>Total: R$ {s.total_value ?? '-'}</span>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>
                    )}

                    {ticket.attachments?.length > 0 && (
                        <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                            <div className="p-6">
                                <h3 className="text-lg font-medium text-gray-900 mb-4">Anexos</h3>
                                <div className="space-y-2">
                                    {ticket.attachments.map((att) => (
                                        <div key={att.id}>
                                            <a href={att.link} target="_blank" rel="noopener noreferrer" className="text-indigo-600 hover:text-indigo-900 text-sm">
                                                {att.description || att.link}
                                            </a>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
