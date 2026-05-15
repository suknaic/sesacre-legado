import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Edit({ commitment, types, statuses }) {
    const { data, setData, put, processing, errors } = useForm({
        number: commitment.number || '',
        commitment_type_id: commitment.commitment_type_id || '',
        commitment_status_id: commitment.commitment_status_id || '',
        amount: commitment.amount || '',
        description: commitment.description || '',
        system_date: commitment.system_date || '',
        external_date: commitment.external_date || '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        put(route('commitments.update', commitment.id));
    }

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Editar Empenho {commitment.number || `#${commitment.id}`}
                </h2>
            }
        >
            <Head title="Editar Empenho" />

            <div className="py-12">
                <div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <form onSubmit={handleSubmit} className="p-6">
                            <div className="mb-6">
                                <Link
                                    href={route('commitments.show', commitment.id)}
                                    className="text-sm text-indigo-600 hover:text-indigo-900"
                                >
                                    &larr; Voltar
                                </Link>
                            </div>

                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700" htmlFor="number">
                                    Número
                                </label>
                                <input
                                    id="number"
                                    type="text"
                                    value={data.number}
                                    onChange={(e) => setData('number', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                {errors.number && <p className="mt-1 text-sm text-red-600">{errors.number}</p>}
                            </div>

                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700" htmlFor="commitment_type_id">
                                    Tipo
                                </label>
                                <select
                                    id="commitment_type_id"
                                    value={data.commitment_type_id}
                                    onChange={(e) => setData('commitment_type_id', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option value="">Selecione...</option>
                                    {types.map((type) => (
                                        <option key={type.id} value={type.id}>
                                            {type.name}
                                        </option>
                                    ))}
                                </select>
                                {errors.commitment_type_id && <p className="mt-1 text-sm text-red-600">{errors.commitment_type_id}</p>}
                            </div>

                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700" htmlFor="commitment_status_id">
                                    Status
                                </label>
                                <select
                                    id="commitment_status_id"
                                    value={data.commitment_status_id}
                                    onChange={(e) => setData('commitment_status_id', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option value="">Selecione...</option>
                                    {statuses.map((status) => (
                                        <option key={status.id} value={status.id}>
                                            {status.name}
                                        </option>
                                    ))}
                                </select>
                                {errors.commitment_status_id && <p className="mt-1 text-sm text-red-600">{errors.commitment_status_id}</p>}
                            </div>

                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700" htmlFor="amount">
                                    Valor
                                </label>
                                <input
                                    id="amount"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    value={data.amount}
                                    onChange={(e) => setData('amount', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                {errors.amount && <p className="mt-1 text-sm text-red-600">{errors.amount}</p>}
                            </div>

                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700" htmlFor="system_date">
                                    Data do Sistema
                                </label>
                                <input
                                    id="system_date"
                                    type="date"
                                    value={data.system_date}
                                    onChange={(e) => setData('system_date', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                {errors.system_date && <p className="mt-1 text-sm text-red-600">{errors.system_date}</p>}
                            </div>

                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700" htmlFor="external_date">
                                    Data Externa
                                </label>
                                <input
                                    id="external_date"
                                    type="date"
                                    value={data.external_date}
                                    onChange={(e) => setData('external_date', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                {errors.external_date && <p className="mt-1 text-sm text-red-600">{errors.external_date}</p>}
                            </div>

                            <div className="mb-6">
                                <label className="block text-sm font-medium text-gray-700" htmlFor="description">
                                    Descrição
                                </label>
                                <textarea
                                    id="description"
                                    rows={4}
                                    value={data.description}
                                    onChange={(e) => setData('description', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                {errors.description && <p className="mt-1 text-sm text-red-600">{errors.description}</p>}
                            </div>

                            <div className="flex items-center justify-end gap-4">
                                <Link
                                    href={route('commitments.show', commitment.id)}
                                    className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300"
                                >
                                    Cancelar
                                </Link>
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50"
                                >
                                    {processing ? 'Salvando...' : 'Salvar'}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
