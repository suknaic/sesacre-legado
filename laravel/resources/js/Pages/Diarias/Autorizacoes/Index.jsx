import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';

function stageLabel(stage) {
    const labels = { '-1': 'Rejeitada', '1': 'Etapa 1', '2': 'Etapa 2', '3': 'Etapa 3', '4': 'Etapa 4', '5': 'Aprovada' };
    return labels[stage] ?? `Etapa ${stage}`;
}

function stageColor(stage) {
    if (stage === -1) return 'text-red-600 bg-red-100';
    if (stage >= 5) return 'text-green-600 bg-green-100';
    return 'text-yellow-600 bg-yellow-100';
}

export default function Index({ pending }) {
    const { flash } = usePage().props;

    function handleAction(id, action) {
        if (confirm(`Tem certeza que deseja ${action === 'approve' ? 'aprovar' : 'rejeitar'} esta solicitação?`)) {
            router.post(route(`diarias-autorizacoes.${action}`, id));
        }
    }

    return (
        <AuthenticatedLayout header={
            <h2 className="text-xl font-semibold leading-tight text-gray-800">Autorizações de Diárias</h2>
        }>
            <Head title="Autorizações de Diárias" />
            <div className="py-8">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    {flash?.success && <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{flash.success}</div>}
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">ID</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Serviço</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tipo Viagem</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Etapa</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ações</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-200 bg-white">
                                {pending.data.length === 0 ? (
                                    <tr><td colSpan="5" className="px-6 py-4 text-center text-sm text-gray-500">Nenhuma solicitação pendente.</td></tr>
                                ) : pending.data.map((req) => (
                                    <tr key={req.id}>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{req.id}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{req.service_description || '-'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{req.travel_type?.name || '-'}</td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm">
                                            <span className={`inline-flex rounded-full px-2 text-xs font-semibold ${stageColor(req.stage)}`}>{stageLabel(req.stage)}</span>
                                        </td>
                                        <td className="whitespace-nowrap px-6 py-4 text-sm space-x-2">
                                            <Link href={route('per-diem-requests.show', req.id)} className="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                            {req.stage < 5 && req.stage !== -1 && (
                                                <>
                                                    <button onClick={() => handleAction(req.id, 'approve')} className="text-green-600 hover:text-green-900">Aprovar</button>
                                                    <button onClick={() => handleAction(req.id, 'reject')} className="text-red-600 hover:text-red-900">Rejeitar</button>
                                                </>
                                            )}
                                            {req.stage === -1 && (
                                                <button onClick={() => handleAction(req.id, 'reset')} className="text-blue-600 hover:text-blue-900">Reabrir</button>
                                            )}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
