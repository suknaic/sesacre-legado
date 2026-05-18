import { Link, usePage } from '@inertiajs/react';
import { useState } from 'react';

const menuItems = [
    {
        label: 'Início',
        icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
        route: '/dashboard',
    },
    {
        label: 'Recursos Humanos',
        icon: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
        children: [
            {
                label: 'Administração',
                children: [
                    { label: 'Cargo', route: '/job-positions' },
                    { label: 'Curso', route: '/education-formations' },
                    { label: 'Escolaridade', route: '/education-levels' },
                    { label: 'Função', route: '/job-functions' },
                    { label: 'Lotação', route: '/organizations' },
                    { label: 'Detalhe de Lotação', route: '/organization-details' },
                    { label: 'Vínculo', route: '/employment-bonds' },
                    { label: 'Estado Civil', route: '/marital-statuses' },
                    { label: 'Situação Contratual', route: '/contract-situations' },
                    { label: 'Controle de Acesso', route: '/rh-access' },
                ],
            },
            {
                label: 'Origem',
                children: [
                    { label: 'País', route: '/countries' },
                    { label: 'Estado', route: '/states' },
                    { label: 'Cidade', route: '/cities' },
                ],
            },
            { label: 'Contrato', route: '/employment-contracts' },
            { label: 'Férias, Licenças e Concessões', route: '/ferias-licencas' },
            { label: 'Funcionário', route: '/personal-info' },
            {
                label: 'Relatórios',
                children: [
                    { label: 'Diversos', route: '/rh-reports/diverse' },
                    { label: 'Férias', route: '/rh-reports/vacations' },
                ],
            },
        ],
    },
    {
        label: 'Planejamento',
        icon: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
        route: '/planning',
    },
    {
        label: 'Chamados',
        icon: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        children: [
            { label: 'Chamados', route: '/tickets' },
            { label: 'Materiais', route: '/materials' },
        ],
    },
    {
        label: 'Orçamento',
        icon: 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6',
        children: [
            { label: 'QDD', route: '/orcamento/qdd' },
            {
                label: 'Liberação Central',
                children: [
                    { label: 'Recurso para Central', route: '/orcamento/central-liberacoes' },
                    { label: 'Validar Liberação', route: '/orcamento/central-liberacoes' },
                ],
            },
            { label: 'Programa Trabalho', route: '/orcamento/programa-trabalho' },
            { label: 'Bloco Orçamentário', route: '/orcamento/blocos-orcamentarios' },
            { label: 'Portaria', route: '/orcamento/portarias' },
            { label: 'Fonte', route: '/orcamento/fontes' },
            { label: 'Despesa', route: '/orcamento/despesas' },
            {
                label: 'Empenho',
                children: [
                    { label: 'Adicionar Empenho', route: '/commitments/create' },
                ],
            },
        ],
    },
    {
        label: 'Financeiro',
        icon: 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        children: [
            { label: 'Solicitação Central', route: '/financeiro/pedidos' },
            {
                label: 'Autorizações',
                children: [
                    { label: 'Aut. Central', route: '/financeiro/autorizacoes' },
                    { label: 'Aut. Orçamento', route: '/financeiro/autorizacoes' },
                    { label: 'Aut. Financeiro', route: '/financeiro/autorizacoes' },
                    { label: 'Aut. Ordenador', route: '/financeiro/autorizacoes' },
                ],
            },
            {
                label: 'Gerenciar Ordem',
                children: [
                    { label: 'Ordem', route: '/financeiro/ordens' },
                ],
            },
            {
                label: 'GDOF',
                children: [
                    { label: 'Documento Fiscal', route: '/financeiro/documentos-fiscais' },
                ],
            },
        ],
    },
    {
        label: 'Contábil',
        icon: 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z',
        children: [
            {
                label: 'Gerenciar Empenho',
                children: [
                    { label: 'Empenho', route: '/commitments' },
                    { label: 'Anulação do Empenho', route: '/contabil/empenhos-anulacao' },
                    { label: 'Autorização da Anulação', route: '/contabil/empenhos-anulacao' },
                ],
            },
            { label: 'Liquidação', route: '/contabil/liquidacoes' },
            { label: 'Pagamento', route: '/contabil/pagamentos' },
        ],
    },
    {
        label: 'Compras/Contratos',
        icon: 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z',
        children: [
            { label: 'Fornecedores', route: '/compras/fornecedores' },
            { label: 'Gestão Compras', route: '/procurements' },
            { label: 'Gestão Contratos', route: '/compras/contratos' },
            { label: 'Medicamentos', route: '/compras/medicamentos' },
            { label: 'Serviços', route: '/compras/servicos' },
            { label: 'Materiais de Consumo', route: '/compras/materiais-consumo' },
            { label: 'Materiais Permanentes', route: '/compras/materiais-permanente' },
        ],
    },
    {
        label: 'Diárias',
        icon: 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        children: [
            { label: 'Proposta e Concessão', route: '/per-diem-requests' },
            { label: 'Autorizações', route: '/page/diarias-autorizacoes' },
            {
                label: 'Administração',
                children: [
                    { label: 'Perfil de Acesso', route: '/page/diarias-perfil-acesso' },
                    { label: 'Valores das Diárias', route: '/decree-values' },
                    { label: 'Vincular Central', route: '/page/diarias-vincular-central' },
                ],
            },
        ],
    },
    {
        label: 'Administração',
        icon: 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
        children: [
            {
                label: 'Pessoa',
                children: [
                    { label: 'Física', route: '/personal-info' },
                    { label: 'Jurídica', route: '/legal-entities' },
                ],
            },
            { label: 'Centrais de Demanda', route: '/organizations' },
            { label: 'Centrais (Financeiro)', route: '/financeiro/centrais-demanda' },
            { label: 'Responsáveis por Central', route: '/financeiro/centrais-responsavel' },
            { label: 'Tipo Gasto', route: '/expense-types' },
            { label: 'Tipos de Solicitação', route: '/financeiro/tipos-solicitacao' },
            { label: 'Tipos de Administração', route: '/page/tipo-administracao' },
            { label: 'Tipo de Remetente/Destinatário', route: '/page/tipo-remetente' },
            { label: 'Vincular Remetente/Destinatário', route: '/page/vincular-remetente' },
            { label: 'Vincular Administração/Solicitação', route: '/page/vincular-administracao' },
            { label: 'Tipos de Tramitações', route: '/process-types' },
        ],
    },
    {
        label: 'Outros Serviços',
        icon: 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        children: [
            { label: 'GEP', route: 'http://gep.ac.gov.br', external: true },
            { label: 'GRP', route: 'http://www.grp.ac.gov.br/asi/', external: true },
            { label: 'SIDIS', route: 'http://www.sidis.ac.gov.br/', external: true },
            { label: 'SESACRELEGIS', route: 'https://sesacrelegis.wixsite.com/diretoriajuridica', external: true },
            { label: 'CENTRAL DE NORMAS', route: 'http://intranet.sesacre', external: true },
            { label: 'DIÁRIO OFICIAL', route: 'http://www.diario.ac.gov.br', external: true },
            { label: 'WEBMAIL', route: 'http://www.webmail.ac.gov.br/', external: true },
        ],
    },
];

function SidebarItem({ item, depth = 0 }) {
    const [open, setOpen] = useState(false);
    const hasChildren = item.children && item.children.length > 0;

    if (item.external) {
        return (
            <a
                href={item.route}
                target="_blank"
                rel="noopener noreferrer"
                className="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors"
                style={{ paddingLeft: `${12 + depth * 16}px` }}
            >
                {depth === 0 && item.icon && (
                    <svg className="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                        <path strokeLinecap="round" strokeLinejoin="round" d={item.icon} />
                    </svg>
                )}
                <span className="truncate">{item.label}</span>
                <svg className="ml-auto h-3 w-3 shrink-0 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                    <path strokeLinecap="round" strokeLinejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </a>
        );
    }

    if (hasChildren) {
        return (
            <div>
                <button
                    onClick={() => setOpen(!open)}
                    className={`flex w-full items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors ${depth > 0 ? 'pl-' + (4 + depth * 4) : ''}`}
                    style={{ paddingLeft: `${12 + depth * 16}px` }}
                >
                    {depth === 0 && item.icon && (
                        <svg className="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                            <path strokeLinecap="round" strokeLinejoin="round" d={item.icon} />
                        </svg>
                    )}
                    <span className="truncate">{item.label}</span>
                    <svg
                        className={`ml-auto h-4 w-4 shrink-0 transition-transform ${open ? 'rotate-90' : ''}`}
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}
                    >
                        <path strokeLinecap="round" strokeLinejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                {open && (
                    <div className="overflow-hidden">
                        {item.children.map((child, i) => (
                            <SidebarItem key={i} item={child} depth={depth + 1} />
                        ))}
                    </div>
                )}
            </div>
        );
    }

    return (
        <Link
            href={item.route || '#'}
            className={`flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors ${depth > 0 ? '' : ''}`}
            style={{ paddingLeft: `${12 + depth * 16}px` }}
        >
            {depth === 0 && item.icon && (
                <svg className="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                    <path strokeLinecap="round" strokeLinejoin="round" d={item.icon} />
                </svg>
            )}
            <span className="truncate">{item.label}</span>
        </Link>
    );
}

export default function Sidebar({ open, onClose }) {
    const { url } = usePage();

    return (
        <>
            {open && (
                <div className="fixed h-full inset-0 z-40 bg-black/50 lg:hidden" onClick={onClose} />
            )}
            <aside
                className={`fixed top-0 left-0 z-50 h-[100vh] w-64 transform bg-gray-900 transition-transform duration-200 ease-in-out lg:translate-x-0 ${
                    open ? 'translate-x-0' : '-translate-x-full'
                }`}
            >
                <div className="flex h-16 items-center border-b border-gray-700 px-6">
                    <Link href="/" className="flex items-center gap-3">
                        <div className="flex h-8 w-8 items-center justify-center rounded bg-indigo-600 text-sm font-bold text-white">
                            S
                        </div>
                        <span className="text-lg font-bold text-white">SEMULHER</span>
                    </Link>
                </div>

                <nav className="h-[calc(100%-4rem)] overflow-y-auto py-4">
                    {menuItems.map((item, i) => (
                        <SidebarItem key={i} item={item} />
                    ))}
                </nav>
            </aside>
        </>
    );
}
