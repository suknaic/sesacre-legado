# Worklog

## Objetivo atual
Migrar o sistema legado SESACRE (vanilla PHP) para Laravel 12 + Inertia + React.

## Estado atual
### Já implementado (RH/Sistema)
- 31 migrations (28 tabelas SESACRE + 3 Laravel core)
- 28 Models (11 com relacionamentos, 17 stubs vazios)
- LegacyDataSeeder: importa de 7 tabelas legado (countries, states, cities, systems, roles, users, role_user)
- Breeze auth scaffold (login, register, profile)
- Inertia + React + Tailwind + shadcn/ui

### Dashboard / Layout (redesenhado)
- Sidebar com menu completo colapsável (ícones SVG, sub-menus aninhados)
- Top navbar com logo SESACRENET + user dropdown (Meus Dados, Sair)
- 6 cards coloridos: Usuários (green), Programas (yellow), Contratos (blue), Pedidos (indigo), Empenhos (teal), Licitações (red)
- 3 painéis de estatísticas (Pedidos por Situação, Empenhos por Status, Processos por Modalidade)
- DashboardController com dados consolidados

### Planejamento/PES (implementado)
- 1 migration: strategic_plans, plan_objectives, plan_actions, annual_plans, budget_proposals, measurement_units, plan_materials
- 7 models: StrategicPlan, PlanObjective, PlanAction, AnnualPlan, BudgetProposal, MeasurementUnit, PlanMaterial
- StrategicPlanController + AnnualPlanController CRUD
- Nav links "PPA" e "Planos Anuais" no sidebar

### Diárias (implementado)
- 1 migration: travel_classes, transport_types, decree_types, travel_types, per_diem_requests, per_diem_destinations, per_diem_history, decree_values, per_diem_reports
- 9 models: TravelClass, TransportType, DecreeType, TravelType, PerDiemRequest, PerDiemDestination, PerDiemHistory, DecreeValue, PerDiemReport
- PerDiemRequestController CRUD
- Nav link "Proposta e Concessão" no sidebar

### Pendências
- 1 model stub restante (Country, GeoRegion, HealthRegion, ...)
- Substituir links '#' nos sidebars por rotas reais
- Criar CRUD pages (Index/Create/Show/Edit) para StrategicPlans, AnnualPlans, PerDiemRequests

## Módulo Financeiro (implementado)
- 6 controllers: PedidoController, AutorizacaoController, CentralDemandaController, CentralResponsavelController, TipoSolicitacaoController, PreOrdemController
- 24 Inertia pages (Index/Create/Show/Edit para cada controller)
- 5 novos models: PlaTipoGasto, SesLotacao, FinCentrais, FinCentralLiberacaoTrans, FinTipoAdministracao, FinContItens
- Rotas financeiro.* no web.php sob prefixo /financeiro
- Sidebar atualizado com links reais

## Pendências
- 10 models são stubs (sem fillable, casts, relationships)
- Melhorar exibição do fornecedor nas telas (mostrar nome, não ID)
- Remaining legacy domains não seedados: fin_pedido, gco_processo, fin_empenho

## Decisões
- 2026-05-14: Usar Inertia + React para frontend
- 2026-05-14: Manter mesmo banco PostgreSQL do legado (convivência)
- 2026-05-14: Começar migração por domínios: RH/Sistema → Financeiro → Compras → CHA → Planejamento → Contábil

## Histórico recente
- 2026-05-14: Projeto Laravel 12 criado com Breeze (Inertia+React)
- 2026-05-14: 31 migrations + 28 models + LegacyDataSeeder implementados
- 2026-05-14: Módulo Financeiro/Empenho: 3 migrations, 8 models, controller, 4 Inertia pages
- 2026-05-14: Módulo Compras/GCON: 2 migrations, 7 models, 2 controllers, 8 Inertia pages
- 2026-05-15: Módulo Financeiro/Solicitação: 6 controllers, 24 Inertia pages, 6 new models
