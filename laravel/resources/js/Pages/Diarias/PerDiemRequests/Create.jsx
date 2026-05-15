import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ travelTypes, transportTypes, decreeTypes, travelClasses }) {
    const { data, setData, post, processing, errors } = useForm({
        service_description: '',
        travel_type_id: '',
        transport_type_id: '',
        decree_type_id: '',
        travel_class_id: '',
        locations: '',
        notes: '',
        is_active: true,
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('per-diem-requests.store'));
    }

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Nova Solicitação de Diária</h2>}>
            <Head title="Nova Solicitação de Diária" />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="p-6">
                        <div className="mb-6"><Link href={route('per-diem-requests.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700" htmlFor="service_description">Descrição do Serviço</label>
                            <textarea id="service_description" rows={4} value={data.service_description}
                                onChange={e => setData('service_description', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.service_description && <p className="mt-1 text-sm text-red-600">{errors.service_description}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700" htmlFor="travel_type_id">Tipo de Viagem</label>
                            <select id="travel_type_id" value={data.travel_type_id}
                                onChange={e => setData('travel_type_id', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Selecione...</option>
                                {travelTypes.map(t => <option key={t.id} value={t.id}>{t.name}</option>)}
                            </select>
                            {errors.travel_type_id && <p className="mt-1 text-sm text-red-600">{errors.travel_type_id}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700" htmlFor="transport_type_id">Tipo de Transporte</label>
                            <select id="transport_type_id" value={data.transport_type_id}
                                onChange={e => setData('transport_type_id', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Selecione...</option>
                                {transportTypes.map(t => <option key={t.id} value={t.id}>{t.name}</option>)}
                            </select>
                            {errors.transport_type_id && <p className="mt-1 text-sm text-red-600">{errors.transport_type_id}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700" htmlFor="decree_type_id">Tipo de Decreto</label>
                            <select id="decree_type_id" value={data.decree_type_id}
                                onChange={e => setData('decree_type_id', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Selecione...</option>
                                {decreeTypes.map(t => <option key={t.id} value={t.id}>{t.name}</option>)}
                            </select>
                            {errors.decree_type_id && <p className="mt-1 text-sm text-red-600">{errors.decree_type_id}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700" htmlFor="travel_class_id">Classe de Viagem</label>
                            <select id="travel_class_id" value={data.travel_class_id}
                                onChange={e => setData('travel_class_id', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Selecione...</option>
                                {travelClasses.map(t => <option key={t.id} value={t.id}>{t.name}</option>)}
                            </select>
                            {errors.travel_class_id && <p className="mt-1 text-sm text-red-600">{errors.travel_class_id}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700" htmlFor="locations">Locais</label>
                            <input id="locations" type="text" value={data.locations}
                                onChange={e => setData('locations', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.locations && <p className="mt-1 text-sm text-red-600">{errors.locations}</p>}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700" htmlFor="notes">Observações</label>
                            <textarea id="notes" rows={3} value={data.notes}
                                onChange={e => setData('notes', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            {errors.notes && <p className="mt-1 text-sm text-red-600">{errors.notes}</p>}
                        </div>

                        <div className="mb-6">
                            <label className="flex items-center gap-2">
                                <input type="checkbox" checked={data.is_active} onChange={e => setData('is_active', e.target.checked)}
                                    className="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                <span className="text-sm text-gray-700">Ativo</span>
                            </label>
                        </div>

                        <div className="flex items-center justify-end gap-4">
                            <Link href={route('per-diem-requests.index')} className="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Cancelar</Link>
                            <button type="submit" disabled={processing}
                                className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 disabled:opacity-50">
                                {processing ? 'Salvando...' : 'Salvar'}</button>
                        </div>
                    </form>
                </div>
            </div></div>
        </AuthenticatedLayout>
    );
}
