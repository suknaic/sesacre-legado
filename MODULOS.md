# Comparação de Módulos: Legado vs Laravel

> Comparação entre o sistema legado SESACRE e a implementação em Laravel + Inertia + React.

---

## 1. RECURSOS HUMANOS (RH)

| Submódulo | Legado | Laravel | Status |
|---|---|---|---|
| País | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Estado | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Cidade | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Cargo (JobPosition) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Função (JobFunction) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Vínculo (EmploymentBond) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Escolaridade (EducationLevel) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Formação/Curso (EducationFormation) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Estado Civil (MaritalStatus) | sim | Controller, Model, Migration, Factory, Test, Pages, Seeder | ✅ Completo |
| Situação Contratual (ContractSituation) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Pessoa Física (PersonalInfo) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Contrato (EmploymentContract) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Lotação (Organization) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Lotação Detalhada (OrganizationDetail) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Férias/Licenças/Concessões | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Histórico Recrutamento (RecruitmentHistory) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Relatórios RH (PDF) | sim | Controller, Pages com filtros e impressão | ✅ Completo |
| Controle de Acesso RH | sim | Controller, Pages (atribuição de roles a usuários), Seeders | ✅ Completo |

## 2. PLANEJAMENTO

| Submódulo | Legado | Laravel | Status |
|---|---|---|---|
| PPA Programa (StrategicPlan) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| PES (PesPlan) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| PPA Proj/Ativ (PpaProjectActivity) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Programa de Governo (GovernmentProgram) | sim | Controller, Pages (reusa StrategicPlan) | ✅ Completo |
| Metas Físicas / Objetivo (PlanObjective) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Ação (PlanAction) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Material (PlanMaterial) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Unidade Medida (MeasurementUnit) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| PAS / Plano Anual (AnnualPlan) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Pré-LOA / Proposta Orçamentária (BudgetProposal) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Execução Orçamentária (BudgetExecution) | sim | Controller, Model, Migration, Factory, Test, Pages (dashboard) | ✅ Completo |
| Eixo (PlanningAxis) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Diretriz (PlanningGuideline) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Indicador Saúde (HealthIndicator) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| PAS Ação/Indicador (PasAction) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| PAS Responsável (PasResponsible) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| PAS Liberação/Validação (PasValidation) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Liberação Fonte (BudgetSourceRelease) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| Central Demanda (CentralDemand) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| PTA / Plano Trabalho Anual (WorkPlan) | sim | Controller, Model, Migration, Factory, Test, Pages (itens inline) | ✅ Completo |
| Ordem de Entrega/Recebido (DeliveryOrder) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |

## 3. ORÇAMENTO

| Submódulo | Legado | Laravel | Status |
|---|---|---|---|
| QDD | sim | Controller, Model, Pages | ✅ Completo |
| QDD Valor / Sup/Red | sim | Controller, Model, Pages | ✅ Completo |
| Liberação Central | sim | Controller, Model, Pages | 🟡 Parcial |
| Programa Trabalho | sim | Controller, Model, Pages | ✅ Completo |
| Bloco Orçamentário | sim | Controller, Model, Pages | ✅ Completo |
| Fonte | sim | Controller, Model, Pages | ✅ Completo |
| Despesa | sim | Controller, Model, Pages | ✅ Completo |
| Despesa Elemento | sim | Controller, Model, Pages | ✅ Completo |
| Portaria | sim | Controller, Model, Pages | ✅ Completo |
| Rede Temática | sim | Controller, Model, Pages | ✅ Completo |
| Convênio | sim | Controller, Model, Pages | ✅ Completo |
| Empenho (Commitment) | sim | Controller (Commitment), Migration | 🟡 Parcial |

## 4. FINANCEIRO

| Submódulo | Legado | Laravel | Status |
|---|---|---|---|
| Solicitação Central (Pedido) | sim | Controller, Model, Pages | 🟡 Parcial |
| Autorizações (4 níveis) | sim | Controller, Model, Pages | 🟡 Parcial |
| Central Demanda | sim | Controller, Model, Pages | ✅ Completo |
| Central Responsável | sim | Controller, Model, Pages | ✅ Completo |
| Tipo Solicitação | sim | Controller, Model, Pages | ✅ Completo |
| Pré-Ordem | sim | Controller, Model, Pages | 🟡 Parcial |
| Ordem | sim | Controller, Model, Pages | 🟡 Parcial |
| GDOF (Documento Fiscal) | sim | Controller, Model, Pages | 🟡 Parcial |
| Doc Tramitação | sim | Controller, Model, Pages | ✅ Completo |
| Tipo Documento | sim | Controller, Model, Pages | ✅ Completo |
| Doc Situação | sim | Controller, Pages | ✅ Completo |
| Doc Vinc Encaminhamento | sim | Controller, Pages | ✅ Completo |
| Doc Vinc Recebimento | sim | Controller, Pages | ✅ Completo |

## 5. CONTÁBIL

| Submódulo | Legado | Laravel | Status |
|---|---|---|---|
| Empenho | sim | Controller, Model (HasFactory), Factory, Test, Pages | ✅ Completo |
| Anulação Empenho | sim | Controller, Model (HasFactory), Factory, Test, Pages | ✅ Completo |
| Liquidação | sim | Controller, Model (HasFactory), Factory, Test, Pages | ✅ Completo |
| Pagamento | sim | Controller, Model (HasFactory), Factory, Test, Pages | ✅ Completo |

## 6. COMPRAS / CONTRATOS

| Submódulo | Legado | Laravel | Status |
|---|---|---|---|
| Fornecedor (FinFornecedor) | sim | Controller, Model, Pages | ✅ Completo |
| Contrato (FinContrato) | sim | Controller, Model, Pages | 🟡 Parcial |
| GCON (Processos Licitatórios) | sim | Controller (Procurement), Migration | 🟡 Parcial |
| GCON Modalidade/Objeto/Situação | sim | Model, Migration | 🟡 Parcial |
| Medicamento | sim | Controller, Pages | 🟡 Parcial |
| Serviço | sim | Controller, Pages | 🟡 Parcial |
| Material Consumo | sim | Controller, Pages | 🟡 Parcial |
| Material Permanente | sim | Controller, Pages | 🟡 Parcial |
| Solicitação Compra (PurchaseRequest) | sim | Controller, Model, Migration, Pages | ✅ Completo |

## 7. DIÁRIAS

| Submódulo | Legado | Laravel | Status |
|---|---|---|---|---|
| Proposta e Concessão | sim | Controller, Model (HasFactory), Migration, Factory, Test, Pages | ✅ Completo |
| Autorizações | sim | Controller, Pages (fluxo approve/reject/reset), Test | ✅ Completo |
| Decreto Valor | sim | Controller, Model (HasFactory), Migration, Factory, Test, Pages | ✅ Completo |
| Central Responsável | sim | Controller, Pages (toggle organizações), Test | ✅ Completo |
| Perfil de Acesso | sim | Controller, Migration (can_access_diarias), Pages, Test | ✅ Completo |
| Relatórios | sim | Controller, Pages (filtros por período/tipo/etapa), Test | ✅ Completo |

## 8. CHAMADOS (Service Desk)

| Submódulo | Legado | Laravel | Status |
|---|---|---|---|
| Chamado (Ticket) | sim | Controller, Model (HasFactory), Factory, Test, Pages | ✅ Completo |
| Categorias (Principal/Tipo/Primária/Secundária) | sim | Model (HasFactory), Factory, Controller (via cascata no Ticket) | ✅ Completo |
| Status/Condição/Prioridade | sim | Model (HasFactory), Factory | ✅ Completo |
| Materiais (modulo chamados) | sim | Controller, Model (HasFactory), Factory, Test, Pages | ✅ Completo |

## 9. ADMINISTRAÇÃO / SISTEMA

| Submódulo | Legado | Laravel | Status |
|---|---|---|---|
| Pessoa Jurídica (LegalEntity) | sim | Controller, Model, Migration, Pages | ✅ Completo |
| Centrais de Demanda (Organization) | sim | Controller, Model, Pages | ✅ Completo |
| Tipo Gasto (ExpenseType) | sim | Controller, Model, Pages | ✅ Completo |
| Tipo Processo (ProcessType) | sim | Controller, Model, Pages | ✅ Completo |
| Tipo Administração | sim | Placeholder | 🔴 Incompleto |
| Tipo Tramitação (DocTramitacao) | sim | Controller | ✅ Completo |
| Tipo Remetente/Destinatário | sim | Placeholder | 🔴 Incompleto |
| Vincular Remetente/Admin | sim | Placeholder | 🔴 Incompleto |
| Log do Sistema (AuditLog) | sim | Model, Migration | 🔴 Incompleto |

## 10. PERMISSÕES / SEGURANÇA

| Submódulo | Legado | Laravel | Status |
|---|---|---|---|
| Recursos | sim | Model, Migration | 🔴 Incompleto |
| Grupo de Recursos | sim | Model, Migration | 🔴 Incompleto |
| Perfis de Acesso (RBAC) | sim | Model, Migration | 🔴 Incompleto |

## 11. INTEGRAÇÕES

| Submódulo | Legado | Laravel | Status |
|---|---|---|---|
| GRP (Integração SOAP) | sim | ❌ | ❌ Ausente |
| ANGRA (Leitura PDF) | sim | ❌ | ❌ Ausente |
| Mapas | sim | ❌ | ❌ Ausente |

---

## Resumo Geral

| Categoria | ✅ Completo | 🟡 Parcial | 🔴 Incompleto | ❌ Ausente |
|---|---|---|---|---|
| RH | 18 | 0 | 0 | 0 |
| Planejamento | 22 | 0 | 0 | 0 |
| Orçamento | 9 | 2 | 0 | 0 |
| Financeiro | 6 | 7 | 0 | 0 |
| Contábil | 4 | 0 | 0 | 0 |
| Compras/Contratos | 2 | 6 | 0 | 0 |
| Diárias | 6 | 0 | 0 | 0 |
| Chamados | 4 | 0 | 0 | 0 |
| Administração | 4 | 0 | 4 | 0 |
| Permissões | 0 | 0 | 3 | 0 |
| Integrações | 0 | 0 | 0 | 3 |
| **Total** | **75** | **16** | **5** | **3** |

---

## Prioridades

### Prioridade 1 — Finalizar módulos já iniciados (🟡 Parcial)
1. _(Nenhum — Contábil completo)_
2. **Diárias**: Finalizar PerDiemRequest e submódulos

### Prioridade 2 — Implementar módulos não iniciados (❌ Ausente)
1. _(Nenhum — Planejamento completo)_
2. **Diárias**: Autorizações, Relatórios
3. **Integrações**: GRP, ANGRA, Mapas

### Prioridade 3 — Completar módulos incompletos (🔴 Incompleto)
1. **Permissões/Segurança**: Implementar CRUD de Recursos, Grupos, Perfis
2. **Administração**: Tipo Administração, Tipo Remetente, Vincular Remetente/Admin
3. **Diárias**: Decreto Valor, Central Responsável, Perfil de Acesso

### Prioridade 4 — Qualidade
1. Adicionar factories + testes para todos os módulos parciais sem teste
2. Adicionar seeders para dados essenciais de cada módulo
3. Revisar e padronizar nomenclatura das rotas
4. Garantir que todos os testes passem
