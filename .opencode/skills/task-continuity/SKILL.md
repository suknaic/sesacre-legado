---
name: task-continuity
description: Mantém continuidade de tarefa com arquivo de estado. Use quando iniciar qualquer tarefa que dure mais de 5 minutos, ao retomar trabalho após interrupção, antes de fazer mudanças significativas, ou quando houver risco de perda de contexto entre sessões.
---

# Task Continuity

Mantenha continuidade operacional de uma tarefa em andamento, independentemente de troca de modelo, sessão ou interrupção.

## Quando usar

Este skill é ativado automaticamente quando:
- Você começa uma tarefa que levará mais de 5 minutos
- Retoma um trabalho após fechar/reabrir a sessão
- Precisa alternar entre diferentes tarefas no mesmo repositório
- Identifica que o contexto atual pode ser perdido
- Faz uma pausa em uma tarefa para trabalhar em outra

## Objetivo

Garantir que qualquer execução futura consiga retomar a tarefa exatamente do ponto atual, usando um arquivo de estado no projeto.

## Regras obrigatórias

1. Sempre procure `WORKLOG.md` no diretório raiz do projeto antes de começar qualquer tarefa.
2. Se não existir, crie `WORKLOG.md` usando o template deste skill.
3. Antes de executar mudanças, leia:
   - objetivo atual;
   - estado atual;
   - próximos passos;
   - pendências;
   - decisões registradas.
4. Ao concluir qualquer etapa relevante, atualize `WORKLOG.md`.
5. Registre apenas informação útil para retomada:
   - o que foi feito;
   - o que falta fazer;
   - bloqueios;
   - observações importantes.
6. Se a tarefa for longa, use checkpoints curtos ao longo do caminho.
7. Nunca finalize uma interação sem deixar explícito o próximo passo.
8. Não apague histórico útil; compacte apenas quando necessário (ex: após 20+ entradas).
9. Se houver mudança de rumo, atualize também a seção de decisões.

## Formato do `WORKLOG.md`

```markdown
# Worklog

## Objetivo atual
- Descrição curta da tarefa.

## Estado atual
- O que já foi feito.
- Onde a tarefa parou.

## Próximos passos
- Próxima ação imediata.
- Segunda ação, se houver.

## Pendências
- Bloqueios, dúvidas ou dependências.

## Decisões
- YYYY-MM-DD: decisão e motivo.

## Histórico recente
- YYYY-MM-DD HH:MM: resumo curto da última etapa.