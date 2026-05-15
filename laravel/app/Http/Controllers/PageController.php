<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function show(string $slug): Response
    {
        $pages = [
            'ferias-licencas-concessoes' => [
                'title' => 'Férias, Licenças e Concessões',
                'description' => 'Gestão de férias, licenças e concessões de servidores.',
            ],
            'relatorios-diversos' => [
                'title' => 'Relatórios Diversos',
                'description' => 'Relatórios diversos em PDF do módulo de Recursos Humanos.',
            ],
            'relatorios-ferias' => [
                'title' => 'Relatórios de Férias',
                'description' => 'Relatórios de férias, licenças e concessões em PDF.',
            ],
            'relatorios-grafico' => [
                'title' => 'Gráficos',
                'description' => 'Gráficos e indicadores do módulo de Recursos Humanos.',
            ],
            'chamados-materiais' => [
                'title' => 'Materiais - Chamados',
                'description' => 'Gestão de materiais utilizados nos chamados.',
            ],
            'pes' => [
                'title' => 'PES - Plano Estratégico',
                'description' => 'Plano Estratégico da Secretaria de Saúde.',
            ],
            'programa-setorial' => [
                'title' => 'Programa Setorial',
                'description' => 'Gestão de programas setoriais.',
            ],
            'programa-governo' => [
                'title' => 'Programa de Governo',
                'description' => 'Gestão de programas de governo.',
            ],
            'execucao-orcamentaria' => [
                'title' => 'Execução Orçamentária',
                'description' => 'Acompanhamento da execução orçamentária.',
            ],
            'qdd' => [
                'title' => 'QDD - Quadro de Detalhamento da Despesa',
                'description' => 'Gestão do Quadro de Detalhamento da Despesa.',
            ],
            'liberacao-central' => [
                'title' => 'Liberação Central - Recurso',
                'description' => 'Liberação de recurso para centrais de demanda.',
            ],
            'validar-liberacao' => [
                'title' => 'Validar Liberação',
                'description' => 'Validação de liberações de recursos.',
            ],
            'programa-trabalho' => [
                'title' => 'Programa Trabalho',
                'description' => 'Gestão de programas de trabalho.',
            ],
            'bloco-orcamentario' => [
                'title' => 'Bloco Orçamentário',
                'description' => 'Gestão de blocos orçamentários.',
            ],
            'solicitacao-central' => [
                'title' => 'Solicitação Central',
                'description' => 'Solicitação de recursos para centrais de demanda.',
            ],
            'aut-central' => [
                'title' => 'Autorização Central',
                'description' => 'Autorização central de recursos.',
            ],
            'aut-orcamento' => [
                'title' => 'Autorização Orçamentária',
                'description' => 'Autorização orçamentária de recursos.',
            ],
            'aut-financeiro' => [
                'title' => 'Autorização Financeira',
                'description' => 'Autorização financeira de recursos.',
            ],
            'aut-ordenador' => [
                'title' => 'Autorização do Ordenador',
                'description' => 'Autorização do ordenador de despesas.',
            ],
            'ordem' => [
                'title' => 'Ordem',
                'description' => 'Gestão de ordens financeiras.',
            ],
            'reativacao-ordem' => [
                'title' => 'Reativação da Ordem',
                'description' => 'Reativação de ordens financeiras.',
            ],
            'autorizacao-reativacao' => [
                'title' => 'Autorização da Reativação',
                'description' => 'Autorização para reativação de ordens.',
            ],
            'documento-fiscal' => [
                'title' => 'Documento Fiscal',
                'description' => 'Gestão de documentos fiscais.',
            ],
            'encaminhar-doc-fiscal' => [
                'title' => 'Encaminhar Documento Fiscal',
                'description' => 'Encaminhamento de documentos fiscais.',
            ],
            'receber-doc-fiscal' => [
                'title' => 'Receber Documento Fiscal',
                'description' => 'Recebimento de documentos fiscais.',
            ],
            'anulacao-empenho' => [
                'title' => 'Anulação do Empenho',
                'description' => 'Anulação de empenhos contábeis.',
            ],
            'autorizacao-anulacao' => [
                'title' => 'Autorização da Anulação do Empenho',
                'description' => 'Autorização para anulação de empenhos.',
            ],
            'liquidacao' => [
                'title' => 'Liquidação',
                'description' => 'Gestão de liquidações contábeis.',
            ],
            'pagamento' => [
                'title' => 'Pagamento',
                'description' => 'Gestão de pagamentos contábeis.',
            ],
            'relatorios-fornecedores' => [
                'title' => 'Relatórios de Fornecedores',
                'description' => 'Relatórios gerenciais de fornecedores.',
            ],
            'gestao-contratos' => [
                'title' => 'Gestão Contratos',
                'description' => 'Gestão de contratos administrativos.',
            ],
            'banco-produto' => [
                'title' => 'Banco de Produto',
                'description' => 'Catálogo de produtos e materiais.',
            ],
            'perfil-contratos' => [
                'title' => 'Perfil Contratos',
                'description' => 'Perfis e regras para gestão de contratos.',
            ],
            'diarias-autorizacoes' => [
                'title' => 'Autorizações de Diárias',
                'description' => 'Autorizações para concessão de diárias.',
            ],
            'diarias-perfil-acesso' => [
                'title' => 'Perfil de Acesso - Diárias',
                'description' => 'Gestão de perfis de acesso do módulo de diárias.',
            ],
            'diarias-valores' => [
                'title' => 'Valores das Diárias',
                'description' => 'Tabela de valores das diárias.',
            ],
            'diarias-vincular-central' => [
                'title' => 'Vincular Central de Demanda',
                'description' => 'Vinculação de centrais de demanda no módulo de diárias.',
            ],
            'tipo-administracao' => [
                'title' => 'Tipos de Administração/Gestores',
                'description' => 'Gestão de tipos de administração e gestores.',
            ],
            'tipo-remetente' => [
                'title' => 'Tipo de Remetente/Destinatário',
                'description' => 'Gestão de tipos de remetente e destinatário.',
            ],
            'vincular-remetente' => [
                'title' => 'Vincular Remetente/Destinatário',
                'description' => 'Vinculação de tipos de remetente e destinatário.',
            ],
            'vincular-administracao' => [
                'title' => 'Vincular Administração/Solicitação',
                'description' => 'Vinculação entre administração e solicitação.',
            ],
        ];

        $page = $pages[$slug] ?? [
            'title' => 'Página não encontrada',
            'description' => 'Esta página não existe.',
        ];

        return Inertia::render('Placeholder', $page);
    }
}
