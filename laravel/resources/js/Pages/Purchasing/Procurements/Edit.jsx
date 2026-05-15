import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Edit({ procurement, modalities, objects, situations }) {
    const { data, setData, put, processing, errors } = useForm({
        ada_code: procurement.ada_code || '',
        auction_code: procurement.auction_code || '',
        estimated_total: procurement.estimated_total || '',
        adjudicated_total: procurement.adjudicated_total || '',
        process_date: procurement.process_date || '',
        procurement_object_id: procurement.procurement_object_id || '',
        procurement_modality_id: procurement.procurement_modality_id || '',
        procurement_situation_id: procurement.procurement_situation_id || '',
        year: procurement.year || '',
        technical_manager: procurement.technical_manager || '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        put(route('procurements.update', procurement.id));
    }

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Editar Processo {procurement.ada_code || `#${procurement.id}`}
                </h2>
            }
        >
            <Head title="Editar Processo de Compra" />

            <div className="py-12">
                <div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <form onSubmit={handleSubmit} className="p-6">
                            <div className="mb-6">
                                <Link
                                    href={route('procurements.show', procurement.id)}
                                    className="text-sm text-indigo-600 hover:text-indigo-900"
                                >
                                    &larr; Voltar
                                </Link>
                            </div>

                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700" htmlFor="ada_code">
                                    Código ADA
                                </label>
                                <input
                                    id="ada_code"
                                    type="text"
                                    value={data.ada_code}
                                    onChange={(e) => setData('ada_code', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                {errors.ada_code && <p className="mt-1 text-sm text-red-600">{errors.ada_code}</p>}
                            </div>

                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700" htmlFor="auction_code">
                                    Código Leilão
                                </label>
                                <input
                                    id="auction_code"
                                    type="text"
                                    value={data.auction_code}
                                    onChange={(e) => setData('auction_code', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                {errors.auction_code && <p className="mt-1 text-sm text-red-600">{errors.auction_code}</p>}
                            </div>

                            <div className="mb-4 grid grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700" htmlFor="procurement_modality_id">
                                        Modalidade
                                    </label>
                                    <select
                                        id="procurement_modality_id"
                                        value={data.procurement_modality_id}
                                        onChange={(e) => setData('procurement_modality_id', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    >
                                        <option value="">Selecione...</option>
                                        {modalities.map((m) => (
                                            <option key={m.id} value={m.id}>{m.name}</option>
                                        ))}
                                    </select>
                                    {errors.procurement_modality_id && <p className="mt-1 text-sm text-red-600">{errors.procurement_modality_id}</p>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700" htmlFor="procurement_object_id">
                                        Objeto
                                    </label>
                                    <select
                                        id="procurement_object_id"
                                        value={data.procurement_object_id}
                                        onChange={(e) => setData('procurement_object_id', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    >
                                        <option value="">Selecione...</option>
                                        {objects.map((o) => (
                                            <option key={o.id} value={o.id}>{o.name}</option>
                                        ))}
                                    </select>
                                    {errors.procurement_object_id && <p className="mt-1 text-sm text-red-600">{errors.procurement_object_id}</p>}
                                </div>
                            </div>

                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700" htmlFor="procurement_situation_id">
                                    Situação
                                </label>
                                <select
                                    id="procurement_situation_id"
                                    value={data.procurement_situation_id}
                                    onChange={(e) => setData('procurement_situation_id', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option value="">Selecione...</option>
                                    {situations.map((s) => (
                                        <option key={s.id} value={s.id}>{s.name}</option>
                                    ))}
                                </select>
                                {errors.procurement_situation_id && <p className="mt-1 text-sm text-red-600">{errors.procurement_situation_id}</p>}
                            </div>

                            <div className="mb-4 grid grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700" htmlFor="estimated_total">
                                        Valor Estimado
                                    </label>
                                    <input
                                        id="estimated_total"
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        value={data.estimated_total}
                                        onChange={(e) => setData('estimated_total', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    />
                                    {errors.estimated_total && <p className="mt-1 text-sm text-red-600">{errors.estimated_total}</p>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700" htmlFor="adjudicated_total">
                                        Valor Adjudicado
                                    </label>
                                    <input
                                        id="adjudicated_total"
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        value={data.adjudicated_total}
                                        onChange={(e) => setData('adjudicated_total', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    />
                                    {errors.adjudicated_total && <p className="mt-1 text-sm text-red-600">{errors.adjudicated_total}</p>}
                                </div>
                            </div>

                            <div className="mb-4 grid grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700" htmlFor="process_date">
                                        Data do Processo
                                    </label>
                                    <input
                                        id="process_date"
                                        type="date"
                                        value={data.process_date}
                                        onChange={(e) => setData('process_date', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    />
                                    {errors.process_date && <p className="mt-1 text-sm text-red-600">{errors.process_date}</p>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700" htmlFor="year">
                                        Ano
                                    </label>
                                    <input
                                        id="year"
                                        type="number"
                                        min="2000"
                                        max="2100"
                                        value={data.year}
                                        onChange={(e) => setData('year', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    />
                                    {errors.year && <p className="mt-1 text-sm text-red-600">{errors.year}</p>}
                                </div>
                            </div>

                            <div className="mb-6">
                                <label className="block text-sm font-medium text-gray-700" htmlFor="technical_manager">
                                    Gestor Técnico
                                </label>
                                <input
                                    id="technical_manager"
                                    type="text"
                                    value={data.technical_manager}
                                    onChange={(e) => setData('technical_manager', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                {errors.technical_manager && <p className="mt-1 text-sm text-red-600">{errors.technical_manager}</p>}
                            </div>

                            <div className="flex items-center justify-end gap-4">
                                <Link
                                    href={route('procurements.show', procurement.id)}
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
