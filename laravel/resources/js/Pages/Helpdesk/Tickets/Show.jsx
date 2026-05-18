import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm, usePage, router } from '@inertiajs/react';
import { useState } from 'react';

function AddServiceForm({ ticket }) {
    const { data, setData, post, processing, errors } = useForm({
        service_description: '',
        quantity: '',
        service_value: '',
        total_value: '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('tickets.services.add', ticket.id), {
            onSuccess: () => {
                setData('service_description', '');
                setData('quantity', '');
                setData('service_value', '');
                setData('total_value', '');
            },
        });
    }

    return (
        <form onSubmit={handleSubmit} className="rounded-lg bg-gray-50 p-4 space-y-3">
            <h4 className="text-sm font-semibold text-gray-700">Adicionar Serviço</h4>
            <div>
                <textarea
                    value={data.service_description}
                    onChange={(e) => setData('service_description', e.target.value)}
                    placeholder="Descrição do serviço"
                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                    rows={2}
                />
                {errors.service_description && <p className="mt-1 text-xs text-red-600">{errors.service_description}</p>}
            </div>
            <div className="grid grid-cols-3 gap-3">
                <div>
                    <input
                        type="number"
                        value={data.quantity}
                        onChange={(e) => setData('quantity', e.target.value)}
                        placeholder="Qtd"
                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                    />
                </div>
                <div>
                    <input
                        type="number"
                        step="0.01"
                        value={data.service_value}
                        onChange={(e) => setData('service_value', e.target.value)}
                        placeholder="Valor unit."
                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                    />
                </div>
                <div>
                    <input
                        type="number"
                        step="0.01"
                        value={data.total_value}
                        onChange={(e) => setData('total_value', e.target.value)}
                        placeholder="Valor total"
                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                    />
                </div>
            </div>
            <button
                type="submit"
                disabled={processing}
                className="rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50"
            >
                Adicionar
            </button>
        </form>
    );
}

function EditServiceForm({ service, ticket, onClose }) {
    const { data, setData, put, processing, errors } = useForm({
        service_description: service.service_description ?? '',
        quantity: service.quantity ?? '',
        service_value: service.service_value ?? '',
        total_value: service.total_value ?? '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        put(route('tickets.services.update', [ticket.id, service.id]), {
            onSuccess: () => onClose(),
        });
    }

    return (
        <form onSubmit={handleSubmit} className="space-y-2 mt-2">
            <textarea
                value={data.service_description}
                onChange={(e) => setData('service_description', e.target.value)}
                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                rows={2}
            />
            {errors.service_description && <p className="text-xs text-red-600">{errors.service_description}</p>}
            <div className="grid grid-cols-3 gap-2">
                <input type="number" value={data.quantity} onChange={(e) => setData('quantity', e.target.value)} placeholder="Qtd" className="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
                <input type="number" step="0.01" value={data.service_value} onChange={(e) => setData('service_value', e.target.value)} placeholder="Valor unit." className="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
                <input type="number" step="0.01" value={data.total_value} onChange={(e) => setData('total_value', e.target.value)} placeholder="Valor total" className="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
            </div>
            <div className="flex gap-2">
                <button type="submit" disabled={processing} className="rounded-md bg-indigo-600 px-3 py-1 text-xs font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50">Salvar</button>
                <button type="button" onClick={onClose} className="rounded-md bg-gray-200 px-3 py-1 text-xs font-semibold text-gray-700 hover:bg-gray-300">Cancelar</button>
            </div>
        </form>
    );
}

function AddMaterialForm({ service }) {
    const { data, setData, post, processing, errors } = useForm({
        material_id: '',
        quantity: '',
        value: '',
    });
    const { materials } = usePage().props;

    function handleSubmit(e) {
        e.preventDefault();
        post(route('services.materials.add', service.id), {
            onSuccess: () => {
                setData('material_id', '');
                setData('quantity', '');
                setData('value', '');
            },
        });
    }

    return (
        <form onSubmit={handleSubmit} className="flex flex-wrap gap-2 items-end mt-2">
            <div>
                <select
                    value={data.material_id}
                    onChange={(e) => setData('material_id', e.target.value)}
                    className="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                >
                    <option value="">Selecione material...</option>
                    {materials?.map((m) => (
                        <option key={m.id} value={m.id}>{m.name}{m.patrimony_number ? ` (${m.patrimony_number})` : ''}</option>
                    ))}
                </select>
                {errors.material_id && <p className="text-xs text-red-600">{errors.material_id}</p>}
            </div>
            <input type="number" value={data.quantity} onChange={(e) => setData('quantity', e.target.value)} placeholder="Qtd" className="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm w-20" />
            <input type="number" step="0.01" value={data.value} onChange={(e) => setData('value', e.target.value)} placeholder="Valor" className="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm w-24" />
            <button type="submit" disabled={processing} className="rounded-md bg-green-600 px-3 py-1.5 text-xs font-semibold text-white shadow hover:bg-green-500 disabled:opacity-50">
                Vincular
            </button>
        </form>
    );
}

export default function Show({ ticket }) {
    const { flash } = usePage().props;
    const [editingService, setEditingService] = useState(null);

    const sec = ticket.secondary_category;
    const primary = sec?.primary_category;
    const type = primary?.category_type;
    const cat = type?.category;
    const categoryChain = [cat?.name, type?.name, primary?.name, sec?.name].filter(Boolean).join(' > ');

    function removeService(service) {
        if (confirm('Remover este serviço?')) {
            router.delete(route('tickets.services.remove', [ticket.id, service.id]));
        }
    }

    function removeMaterial(service, material) {
        if (confirm('Remover este material do serviço?')) {
            router.delete(route('services.materials.remove', [service.id, material.id]));
        }
    }

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
                    {flash?.success && <div className="rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}

                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 space-y-4">
                            <div><span className="text-sm font-medium text-gray-500">ID</span><p className="text-gray-900">#{ticket.id}</p></div>
                            {categoryChain && <div><span className="text-sm font-medium text-gray-500">Categoria</span><p className="text-gray-900">{categoryChain}</p></div>}
                            <div><span className="text-sm font-medium text-gray-500">Descrição</span><p className="text-gray-900 whitespace-pre-wrap">{ticket.description || '-'}</p></div>
                            <div><span className="text-sm font-medium text-gray-500">Status</span><p className="text-gray-900">{ticket.status?.name || '-'}</p></div>
                            <div><span className="text-sm font-medium text-gray-500">Prioridade</span><p className="text-gray-900">{ticket.priority?.name || '-'}</p></div>
                            <div><span className="text-sm font-medium text-gray-500">Telefone</span><p className="text-gray-900">{ticket.requester_phone || '-'}</p></div>
                            <div><span className="text-sm font-medium text-gray-500">Prazo</span><p className="text-gray-900">{ticket.deadline?.split('T')[0] || '-'}</p></div>
                            <div><span className="text-sm font-medium text-gray-500">Criado em</span><p className="text-gray-900">{ticket.created_at?.split('T')[0] || '-'}</p></div>
                            {ticket.resolution && <div><span className="text-sm font-medium text-gray-500">Resolução</span><p className="text-gray-900 whitespace-pre-wrap">{ticket.resolution}</p></div>}
                            {ticket.rating && <div><span className="text-sm font-medium text-gray-500">Avaliação</span><p className="text-gray-900">{ticket.rating}{ticket.rating_comment ? ` — ${ticket.rating_comment}` : ''}</p></div>}
                        </div>
                    </div>

                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <h3 className="text-lg font-medium text-gray-900 mb-4">Serviços</h3>
                            <div className="space-y-4">
                                <AddServiceForm ticket={ticket} />

                                {ticket.services?.map((s) => (
                                    <div key={s.id} className="rounded-lg border border-gray-200 p-4">
                                        <div className="flex items-start justify-between">
                                            <div className="flex-1">
                                                {editingService === s.id ? (
                                                    <EditServiceForm service={s} ticket={ticket} onClose={() => setEditingService(null)} />
                                                ) : (
                                                    <>
                                                        <p className="text-sm text-gray-700 whitespace-pre-wrap">{s.service_description || '-'}</p>
                                                        <div className="mt-1 text-xs text-gray-500 space-x-4">
                                                            <span>Qtd: {s.quantity ?? '-'}</span>
                                                            <span>Valor unit: R$ {s.service_value ?? '-'}</span>
                                                            <span>Total: R$ {s.total_value ?? '-'}</span>
                                                        </div>
                                                    </>
                                                )}
                                            </div>
                                            {editingService !== s.id && (
                                                <div className="flex gap-2 ml-2">
                                                    <button onClick={() => setEditingService(s.id)} className="text-xs text-indigo-600 hover:text-indigo-900">Editar</button>
                                                    <button onClick={() => removeService(s)} className="text-xs text-red-600 hover:text-red-900">Remover</button>
                                                </div>
                                            )}
                                        </div>

                                        {s.materials?.length > 0 && (
                                            <div className="mt-3 border-t border-gray-100 pt-3">
                                                <h5 className="text-xs font-medium text-gray-500 uppercase mb-2">Materiais Utilizados</h5>
                                                <div className="space-y-1">
                                                    {s.materials.map((sm) => (
                                                        <div key={sm.id} className="flex items-center justify-between text-xs text-gray-600 bg-gray-50 rounded px-2 py-1">
                                                            <span>{sm.material?.name || 'Material #' + sm.material_id}{sm.quantity ? ` (x${sm.quantity})` : ''}</span>
                                                            <div className="flex items-center gap-2">
                                                                {sm.value && <span>R$ {sm.value}</span>}
                                                                <button onClick={() => removeMaterial(s, sm)} className="text-red-500 hover:text-red-700">&times;</button>
                                                            </div>
                                                        </div>
                                                    ))}
                                                </div>
                                            </div>
                                        )}

                                        <div className="mt-2">
                                            <AddMaterialForm service={s} />
                                        </div>
                                    </div>
                                ))}

                                {(!ticket.services || ticket.services.length === 0) && (
                                    <p className="text-sm text-gray-500">Nenhum serviço registrado.</p>
                                )}
                            </div>
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
                                            <p className="mt-1 text-xs text-gray-500">{note.note_date?.split('T')[0] || note.created_at?.split('T')[0]}</p>
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
                                            <a href={att.link} target="_blank" rel="noopener noreferrer" className="text-indigo-600 hover:text-indigo-900 text-sm">{att.description || att.link}</a>
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
