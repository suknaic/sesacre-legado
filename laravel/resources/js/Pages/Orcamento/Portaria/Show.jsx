import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

const statusLabels = { 1: 'Rascunho', 2: 'Assinado', 3: 'Cancelado' };

export default function Show({ portaria }) {
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">{portaria.nm_portaria}</h2>}>
            <Head title={portaria.nm_portaria} />
            <div className="py-12"><div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div className="mb-4"><Link href={route('orcamento.portarias.index')} className="text-sm text-indigo-600 hover:text-indigo-900">&larr; Voltar</Link></div>
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6">
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div><dt className="text-sm font-medium text-gray-500">Portaria</dt><dd className="mt-1 text-sm text-gray-900">{portaria.nm_portaria}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Rede Temática</dt><dd className="mt-1 text-sm text-gray-900">{portaria.rede_tematica?.nm_rede_tematica || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Data</dt><dd className="mt-1 text-sm text-gray-900">{portaria.dt_portaria || '-'}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Valor Total</dt><dd className="mt-1 text-sm text-gray-900">{new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(portaria.vl_total || 0)}</dd></div>
                            <div><dt className="text-sm font-medium text-gray-500">Status</dt><dd className="mt-1 text-sm text-gray-900">{statusLabels[portaria.st_portaria] || '-'}</dd></div>
                        </dl>
                    </div>
                </div>
                <div className="mt-6"><Link href={route('orcamento.portarias.edit', portaria.id_portaria)}
                    className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Editar</Link></div>
            </div></div>
        </AuthenticatedLayout>
    );
}
