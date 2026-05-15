import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ statuses, priorities }) {
    const { data, setData, post, processing, errors } = useForm({
        description: '',
        requester_phone: '',
        ticket_status_id: '',
        ticket_priority_id: '',
        deadline: '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('tickets.store'));
    }

    return (
        <AuthenticatedLayout header={
            <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold leading-tight text-gray-800">Novo Chamado</h2>
                <Link href={route('tickets.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">
                    Voltar
                </Link>
            </div>
        }>
            <Head title="Novo Chamado" />
            <div className="py-8">
                <div className="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <form onSubmit={handleSubmit} className="p-6 space-y-6">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">Descrição</label>
                                <textarea
                                    value={data.description}
                                    onChange={(e) => setData('description', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    rows={4}
                                />
                                {errors.description && <p className="mt-1 text-sm text-red-600">{errors.description}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700">Telefone</label>
                                <input
                                    type="text"
                                    value={data.requester_phone}
                                    onChange={(e) => setData('requester_phone', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                />
                                {errors.requester_phone && <p className="mt-1 text-sm text-red-600">{errors.requester_phone}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700">Status</label>
                                <select
                                    value={data.ticket_status_id}
                                    onChange={(e) => setData('ticket_status_id', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option value="">Selecione...</option>
                                    {statuses.map((s) => (
                                        <option key={s.id} value={s.id}>{s.name}</option>
                                    ))}
                                </select>
                                {errors.ticket_status_id && <p className="mt-1 text-sm text-red-600">{errors.ticket_status_id}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700">Prioridade</label>
                                <select
                                    value={data.ticket_priority_id}
                                    onChange={(e) => setData('ticket_priority_id', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option value="">Selecione...</option>
                                    {priorities.map((p) => (
                                        <option key={p.id} value={p.id}>{p.name}</option>
                                    ))}
                                </select>
                                {errors.ticket_priority_id && <p className="mt-1 text-sm text-red-600">{errors.ticket_priority_id}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700">Prazo</label>
                                <input
                                    type="date"
                                    value={data.deadline}
                                    onChange={(e) => setData('deadline', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                />
                                {errors.deadline && <p className="mt-1 text-sm text-red-600">{errors.deadline}</p>}
                            </div>

                            <div className="flex items-center gap-4">
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50"
                                >
                                    Salvar
                                </button>
                                <Link
                                    href={route('tickets.index')}
                                    className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300"
                                >
                                    Cancelar
                                </Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
