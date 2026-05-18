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
| Relatórios RH (PDF) | sim | Placeholder no menu | 🔴 Incompleto |
| Controle de Acesso RH | sim | ❌ | ❌ Ausente |

## 2. PLANEJAMENTO

| Submódulo | Legado | Laravel | Status |
|---|---|---|---|
| PES | sim | Placeholder | 🔴 Incompleto |
| Eixo | sim | ❌ | ❌ Ausente |
| Diretriz | sim | ❌ | ❌ Ausente |
| Objetivo (PlanObjective) | sim | Controller, Migration | 🟡 Parcial (sem Pages/Test completos) |
| Ação (PlanAction) | sim | Controller, Migration | 🟡 Parcial |
| Indicador Saúde | sim | ❌ | ❌ Ausente |
| PPA Programa (StrategicPlan) | sim | Controller, Model, Migration, Factory, Test, Pages | ✅ Completo |
| PPA Proj/Ativ | sim | ❌ | ❌ Ausente |
| PAS (AnnualPlan) | sim | Controller (AnnualPlan), Migration | 🟡 Parcial |
| PAS Ação/Indicador | sim | ❌ | ❌ Ausente |
| PAS Responsável | sim | ❌ | ❌ Ausente |
| PAS Liberação/Validação | sim | ❌ | ❌ Ausente |
| Pré-LOA (BudgetProposal) | sim | Controller, Migration | 🟡 Parcial |
| PTA | sim | ❌ | ❌ Ausente |
| Material (PlanMaterial) | sim | Controller, Migration | 🟡 Parcial |
| Unidade Medida (MeasurementUnit) | sim | Controller, Migration | 🟡 Parcial |
| Ordem de Entrega/Recebido | sim | ❌ | ❌ Ausente |
| Liberação Fonte | sim | ❌ | ❌ Ausente |
| Central Demanda (Planejamento) | sim | ❌ | ❌ Ausente |

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
| Empenho | sim | Controller, Model, Pages | 🟡 Parcial |
| Anulação Empenho | sim | Controller, Model, Pages | 🟡 Parcial |
| Liquidação | sim | Controller, Model, Pages | 🟡 Parcial |
| Pagamento | sim | Controller, Model, Pages | 🟡 Parcial |

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
|---|---|---|---|
| Proposta e Concessão | sim | Controller, Model, Migration, Pages | 🟡 Parcial |
| Autorizações | sim | Placeholder | 🔴 Incompleto |
| Decreto Valor | sim | Model, Migration | 🔴 Incompleto |
| Central Responsável | sim | Placeholder | 🔴 Incompleto |
| Perfil de Acesso | sim | Placeholder | 🔴 Incompleto |
| Relatórios | sim | ❌ | ❌ Ausente |

## 8. CHAMADOS (Service Desk)

| Submódulo | Legado | Laravel | Status |
|---|---|---|---|
| Chamado (Ticket) | sim | Controller, Model, Migration, Pages | ✅ Completo |
| Categorias (Principal/Tipo/Primária/Secundária) | sim | Model, Migration | 🟡 Parcial |
| Status/Condição/Prioridade/Material | sim | Model, Migration | 🟡 Parcial |
| Materiais (modulo chamados) | sim | Placeholder | 🔴 Incompleto |

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
| RH | 16 | 0 | 1 | 1 |
| Planejamento | 1 | 5 | 1 | 10 |
| Orçamento | 9 | 2 | 0 | 0 |
| Financeiro | 6 | 7 | 0 | 0 |
| Contábil | 0 | 4 | 0 | 0 |
| Compras/Contratos | 2 | 6 | 0 | 0 |
| Diárias | 0 | 1 | 4 | 1 |
| Chamados | 1 | 2 | 1 | 0 |
| Administração | 4 | 0 | 4 | 0 |
| Permissões | 0 | 0 | 3 | 0 |
| Integrações | 0 | 0 | 0 | 3 |
| **Total** | **39** | **27** | **14** | **15** |

---

## Prioridades

### Prioridade 1 — Finalizar módulos já iniciados (🟡 Parcial)
São módulos que já têm estrutura (Controller + Model + Migration + Pages) mas faltam factories, testes, ou refinamentos:

1. **RH**: Finalizar PersonalInfo, EmploymentContract, Organization (factories + testes)
2. **RH**: Completar Férias/Licenças (CRUD full), RecruitmentHistory (tests)
3. **Planejamento**: Finalizar PlanObjective, PlanAction, PlanMaterial, MeasurementUnit, BudgetProposal (Pages + testes)
4. **Contábil**: Adicionar factories + testes para Empenho, Anulação, Liquidação, Pagamento
5. **Diárias**: Finalizar PerDiemRequest e submódulos

### Prioridade 2 — Implementar módulos não iniciados (❌ Ausente)
1. **Planejamento**: Eixo, Diretriz, Indicador Saúde, PPA Proj/Ativ, PAS Ação/Indicador, PAS Responsável, PAS Liberação/Validação, PTA, Ordem de Entrega/Recebido, Liberação Fonte, Central Demanda Planejamento
2. **Diárias**: Autorizações, Relatórios
3. **Integrações**: GRP, ANGRA, Mapas

### Prioridade 3 — Completar módulos incompletos (🔴 Incompleto)
1. **RH**: Lotação Detalhada, Relatórios RH, Controle de Acesso RH
2. **Permissões/Segurança**: Implementar CRUD de Recursos, Grupos, Perfis
3. **Administração**: Tipo Administração, Tipo Remetente, Vincular Remetente/Admin
4. **Diárias**: Decreto Valor, Central Responsável, Perfil de Acesso
5. **Chamados**: Materiais, Categorias

### Prioridade 4 — Qualidade
1. Adicionar factories + testes para todos os módulos parciais sem teste
2. Adicionar seeders para dados essenciais de cada módulo
3. Revisar e padronizar nomenclatura das rotas
4. Garantir que todos os testes passem
