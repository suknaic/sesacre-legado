import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

const colorMap = {
    green: { bg: 'bg-emerald-600', iconBg: 'bg-emerald-700/50' },
    yellow: { bg: 'bg-amber-500', iconBg: 'bg-amber-600/50' },
    blue: { bg: 'bg-blue-600', iconBg: 'bg-blue-700/50' },
    indigo: { bg: 'bg-indigo-600', iconBg: 'bg-indigo-700/50' },
    teal: { bg: 'bg-teal-500', iconBg: 'bg-teal-600/50' },
    red: { bg: 'bg-red-600', iconBg: 'bg-red-700/50' },
};

function StatCard({ color, icon, label, value, link }) {
    const c = colorMap[color] || colorMap.indigo;
    return (
        <div className={`${c.bg} overflow-hidden rounded-lg shadow-lg`}>
            <div className="p-5">
                <div className="flex items-center gap-4">
                    <div className={`${c.iconBg} flex h-14 w-14 items-center justify-center rounded-full`}>
                        <svg className="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                            <path strokeLinecap="round" strokeLinejoin="round" d={icon} />
                        </svg>
                    </div>
                    <div className="text-white">
                        <p className="text-3xl font-bold">{value ?? '-'}</p>
                        <p className="text-sm font-medium text-white/80">{label}</p>
                    </div>
                </div>
            </div>
            <div className="border-t border-white/20 px-5 py-3">
                {link ? (
                    <Link href={link} className="block text-center text-sm font-medium text-white/90 hover:text-white">
                        Visualizar
                    </Link>
                ) : (
                    <span className="block text-center text-sm text-white/60">Indisponível</span>
                )}
            </div>
        </div>
    );
}

export default function Dashboard({ stats, chartData }) {
    const cards = [
        { color: 'green', icon: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', label: 'Total de Usuários', value: stats.totalUsers, link: route('personal-info.index') },
        { color: 'yellow', icon: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', label: 'Programas de Trabalho', value: stats.totalBudgets, link: null },
        { color: 'blue', icon: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', label: 'Total Contratos', value: stats.totalContracts, link: null },
        { color: 'indigo', icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01', label: 'Pedidos de Necessidade', value: stats.totalPurchaseRequests, link: route('purchase-requests.index') },
        { color: 'teal', icon: 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z', label: 'Total de Empenhos', value: stats.totalCommitments, link: route('commitments.index') },
        { color: 'red', icon: 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', label: 'Total de Licitações', value: stats.totalProcurements, link: route('procurements.index') },
    ];

    return (
        <AuthenticatedLayout
            header={
                <div className="flex items-center justify-between">
                    <h2 className="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
                    <span className="text-sm text-gray-500">SESACRE - Secretaria de Saúde do Acre</span>
                </div>
            }
        >
            <Head title="Dashboard" />

            <div className="py-8">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div className="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        {cards.map((card, i) => (
                            <StatCard key={i} {...card} />
                        ))}
                    </div>

                    <div className="grid grid-cols-1 gap-6 lg:grid-cols-3">
                        <div className="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                            <h3 className="mb-4 text-base font-semibold text-gray-900">Pedidos por Situação</h3>
                            <div className="space-y-3">
                                {chartData.purchaseRequestBySituation.length === 0 ? (
                                    <p className="text-sm text-gray-500">Nenhum pedido registrado.</p>
                                ) : (
                                    chartData.purchaseRequestBySituation.map((item, i) => (
                                        <div key={i} className="flex items-center justify-between">
                                            <span className="text-sm text-gray-600">Situação #{item.purchase_request_situation_id}</span>
                                            <span className="text-sm font-semibold text-gray-900">{item.total}</span>
                                        </div>
                                    ))
                                )}
                            </div>
                        </div>

                        <div className="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                            <h3 className="mb-4 text-base font-semibold text-gray-900">Empenhos por Status</h3>
                            <div className="space-y-3">
                                {chartData.commitmentsByStatus.length === 0 ? (
                                    <p className="text-sm text-gray-500">Nenhum empenho registrado.</p>
                                ) : (
                                    chartData.commitmentsByStatus.map((item, i) => (
                                        <div key={i} className="flex items-center justify-between">
                                            <span className="text-sm text-gray-600">Status #{item.commitment_status_id}</span>
                                            <span className="text-sm font-semibold text-gray-900">{item.total}</span>
                                        </div>
                                    ))
                                )}
                            </div>
                        </div>

                        <div className="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                            <h3 className="mb-4 text-base font-semibold text-gray-900">Processos por Modalidade</h3>
                            <div className="space-y-3">
                                {chartData.procurementsByModality.length === 0 ? (
                                    <p className="text-sm text-gray-500">Nenhum processo registrado.</p>
                                ) : (
                                    chartData.procurementsByModality.map((item, i) => (
                                        <div key={i} className="flex items-center justify-between">
                                            <span className="text-sm text-gray-600">Modalidade #{item.procurement_modality_id}</span>
                                            <span className="text-sm font-semibold text-gray-900">{item.total}</span>
                                        </div>
                                    ))
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
