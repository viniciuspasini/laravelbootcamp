# Guia Git Stash - Trocar de Branch Sem Commitar

Este guia explica como salvar temporariamente mudanças sem fazer commit, permitindo trocar de branch livremente durante o desenvolvimento.

---

## 📚 Índice

1. [Git Stash (Recomendado)](#opção-1-git-stash--mais-recomendada)
2. [Levar Mudanças Para Outra Branch](#opção-2-levar-mudanças-para-outra-branch)
3. [Commit Temporário (WIP)](#opção-3-commit-temporário-wip)
4. [Criar Nova Branch](#opção-4-criar-nova-branch-com-as-mudanças)
5. [Cenários Práticos](#-cenários-práticos---quando-usar-cada-opção)
6. [Comparação de Métodos](#-comparação-das-opções)
7. [Resolução de Problemas](#-erros-comuns-e-soluções)

---

## 🎯 O Problema

Você está trabalhando em uma branch mas precisa trocar para outra **sem fazer commit** das mudanças atuais.

**Situação comum:**
```bash
# Você está em aula-03-controllers
# Arquivos modificados: PostController.php, web.php
# Precisa ir para a main rapidamente
# Mas o trabalho não está pronto para commit
```

---

## 💾 Opção 1: Git Stash ⭐ (Mais Recomendada)

O `git stash` é como uma "gaveta temporária" que guarda suas mudanças sem fazer commit.

### **Uso Básico:**

```bash
# 1. Guardar mudanças temporariamente
git stash

# 2. Trocar de branch livremente
git checkout main

# 3. Quando voltar, recuperar as mudanças
git checkout aula-03-controllers
git stash pop
```

### **Uso com Descrição (Recomendado):**

```bash
# Salvar com descrição personalizada
git stash save "WIP: Implementando validação do formulário de posts"

# Ver lista de stashes
git stash list
# Saída:
# stash@{0}: On aula-03: WIP: Implementando validação do formulário
# stash@{1}: On aula-02: WIP: Criando rotas de posts

# Recuperar
git stash pop
```

---

## 📖 Comandos Completos do Git Stash

### **Salvar Stashes:**

```bash
# Stash básico (sem descrição)
git stash

# Stash com descrição
git stash save "Descrição detalhada do que está sendo salvo"

# Stash incluindo arquivos não rastreados (untracked)
git stash -u

# Stash incluindo TUDO (até arquivos ignorados)
git stash -a
```

### **Listar Stashes:**

```bash
# Ver todas as stashes salvas
git stash list

# Ver detalhes de uma stash específica
git stash show stash@{0}

# Ver detalhes completos (diff)
git stash show -p stash@{0}
```

### **Aplicar Stashes:**

```bash
# Aplicar a última stash E remover da lista
git stash pop

# Aplicar a última stash MAS manter na lista
git stash apply

# Aplicar stash específica e remover
git stash pop stash@{1}

# Aplicar stash específica mas manter
git stash apply stash@{1}
```

### **Gerenciar Stashes:**

```bash
# Deletar stash específica
git stash drop stash@{0}

# Deletar a última stash
git stash drop

# Deletar TODAS as stashes
git stash clear

# Criar branch a partir de uma stash
git stash branch nova-branch-recuperada stash@{0}
```

---

## 🎯 Exemplo Prático Completo - Git Stash

```bash
# === SITUAÇÃO INICIAL ===
# Você está na aula-03 codificando PostController
git checkout aula-03-controllers
# ... edita PostController.php ...
# ... edita routes/web.php ...

# Status: 2 arquivos modificados, não commitados

# === PRECISA TROCAR DE BRANCH ===
# Alguém te pede para mostrar algo na main

# 1. Salvar trabalho atual
git stash save "Aula 03: PostController método store pela metade"

# 2. Verificar que está limpo
git status
# Output: nothing to commit, working tree clean

# 3. Trocar de branch
git checkout main

# 4. Fazer o que precisa na main
cat app/Http/Controllers/Controller.php
# ... mostra para alguém ...

# === VOLTAR PARA CONTINUAR ===
# 5. Retornar para a aula
git checkout aula-03-controllers

# 6. Ver stashes disponíveis
git stash list
# stash@{0}: On aula-03: PostController método store pela metade

# 7. Recuperar trabalho
git stash pop

# 8. Verificar que está tudo de volta
git status
# Output: modified: PostController.php, routes/web.php

# Continua de onde parou!
```

---

## 💡 Opção 2: Levar Mudanças Para Outra Branch

Se as mudanças **não conflitarem** com a branch de destino, o Git permite trocar de branch levando as alterações.

### **Como Funciona:**

```bash
# Você tem mudanças não commitadas
git checkout main
# Se não houver conflito, suas mudanças vão junto
```

### **⚠️ Quando o Git PERMITE:**

```bash
# Branch A: modificou PostController.php
# Branch B (main): PostController.php está igual ao ponto de divergência

git checkout main
# ✅ Funciona! Mudanças vão junto
```

### **⚠️ Quando o Git BLOQUEIA:**

```bash
# Branch A: modificou PostController.php
# Branch B (main): PostController.php foi modificado diferente

git checkout main
# ❌ Erro:
# error: Your local changes to the following files would be overwritten by checkout:
#     app/Http/Controllers/PostController.php
# Please commit your changes or stash them before you switch branches.
```

### **Cuidados:**

- ❌ **NÃO RECOMENDADO** para uso regular
- Pode causar confusão sobre onde as mudanças pertencem
- Difícil saber se mudanças pertencem à branch atual ou vieram de outra
- Use apenas se tiver absoluta certeza do que está fazendo

---

## 🔄 Opção 3: Commit Temporário (WIP)

Fazer um commit "Work In Progress" e depois desfazê-lo quando voltar.

### **Processo Completo:**

```bash
# 1. Fazer commit temporário
git add .
git commit -m "WIP: Trabalho em progresso - não finalizado"

# 2. Trocar de branch (commit permite trocar livremente)
git checkout main
# ... faz o que precisa ...

# 3. Voltar para a branch
git checkout aula-03-controllers

# 4. Desfazer o commit mantendo as mudanças
git reset HEAD~1
# Arquivos voltam para estado "modificado" (não commitado)

# Continua trabalhando!
```

### **Variações do Reset:**

```bash
# Opção 1: Mantém mudanças no staging (git add já feito)
git reset --soft HEAD~1

# Opção 2: Remove do staging mas mantém mudanças (PADRÃO)
git reset HEAD~1

# Opção 3: DESCARTA TUDO - CUIDADO! ⚠️
git reset --hard HEAD~1
```

### **Quando Usar:**

✅ Precisa fazer push da branch mas o trabalho não está pronto
✅ Quer manter histórico mesmo que temporário
✅ Prefere commits visíveis a stashes "escondidas"

**Exemplo com Push:**

```bash
# Trabalho pela metade mas precisa mudar de computador
git add .
git commit -m "WIP: Salvando progresso para continuar depois"
git push origin aula-03-controllers

# No outro computador
git pull origin aula-03-controllers
# Trabalha...
git reset HEAD~1  # Desfaz o WIP
git add .
git commit -m "Aula 03: Concluída - Controllers implementados"
```

---

## 🌿 Opção 4: Criar Nova Branch com as Mudanças

Se decidir que o trabalho merece uma branch separada ou começou na branch errada.

### **Cenário 1: Começou na Main Sem Querer**

```bash
# Você está na main e começou a codar sem criar branch
git checkout main
# ... edita vários arquivos ...

# Percebe o erro!

# Solução: Criar branch levando as mudanças
git checkout -b aula-04-views
# Pronto! Agora está na branch correta com todas as mudanças
```

### **Cenário 2: Quer Experimentar em Branch Separada**

```bash
# Está na aula-03 mas quer testar abordagem diferente
git checkout -b aula-03-alternativa

# As mudanças vão para a nova branch
# Pode experimentar à vontade
# Se não gostar, só deletar a branch
```

### **Cenário 3: Dividir Trabalho em Múltiplas Branches**

```bash
# Trabalhou em 3 features diferentes sem commitar
# Quer separar em branches diferentes

# Salvar tudo primeiro
git stash save "Todo o trabalho não commitado"

# Branch 1: Feature A
git checkout -b feature-a
git stash pop
# Manter apenas arquivos da feature A
git add arquivos-feature-a
git commit -m "Feature A"
git stash

# Branch 2: Feature B
git checkout main
git checkout -b feature-b
git stash pop
# Manter apenas arquivos da feature B
git add arquivos-feature-b
git commit -m "Feature B"
```

---

## 🎯 Cenários Práticos - Quando Usar Cada Opção

### **Cenário 1: Revisar Código de Aula Anterior**

```bash
# Situação: Codificando aula 05, precisa ver aula 03

git stash save "Aula 05: Middleware de autenticação pela metade"
git checkout aula-03-controllers
# ... revisa como fez o controller ...
git checkout aula-05-autenticacao
git stash pop
```

**Por que stash?** Simples, rápido, não polui histórico.

---

### **Cenário 2: Esqueceu de Criar Branch**

```bash
# Situação: Começou a codar na main sem querer

# Solução 1 - Se NÃO commitou ainda:
git stash
git checkout -b aula-06-validacao
git stash pop

# Solução 2 - Se JÁ commitou:
git checkout -b aula-06-validacao     # Cria branch levando commit
git checkout main
git reset --hard origin/main          # Limpa a main
git checkout aula-06-validacao        # Volta para continuar
```

**Por que stash/branch?** Organiza corretamente o trabalho.

---

### **Cenário 3: Hotfix Urgente na Main**

```bash
# Situação: Trabalhando na aula 07, precisa corrigir bug urgente

git stash save "Aula 07: Sistema de upload - 60% completo"
git checkout main
git checkout -b hotfix-bug-login
# ... corrige o bug ...
git add .
git commit -m "Hotfix: Corrige bug no login"
git checkout main
git merge hotfix-bug-login
git push origin main
# Volta para a aula
git checkout aula-07-upload
git stash pop
```

**Por que stash?** Permite trabalhar em outra coisa sem perder progresso.

---

### **Cenário 4: Testar Mudanças em Múltiplas Branches**

```bash
# Situação: Quer testar mesma mudança em diferentes aulas

git stash save "Teste de nova funcionalidade"

# Testa na aula 05
git checkout aula-05-controllers
git stash apply  # Aplica SEM remover da lista
php artisan test
git reset --hard HEAD  # Descarta após testar

# Testa na aula 06
git checkout aula-06-views
git stash apply  # Aplica novamente
php artisan test
git reset --hard HEAD

# Aplica definitivamente onde funcionou
git checkout aula-07-integracao
git stash pop  # Aplica e remove da lista
```

**Por que stash apply?** Permite reusar a mesma stash várias vezes.

---

### **Cenário 5: Múltiplas Aulas Pausadas**

```bash
# Começou aula 08 mas não terminou
git checkout aula-08-api
# ... codifica ...
git stash save "Aula 08: API REST - endpoints de posts criados"

# Começou aula 09 mas também pausou
git checkout main
git checkout -b aula-09-autenticacao-api
# ... codifica ...
git stash save "Aula 09: JWT authentication implementado"

# Começou aula 10
git checkout main
git checkout -b aula-10-testes
# ... codifica ...
git stash save "Aula 10: Testes de integração"

# Listar todas as aulas pausadas
git stash list
# stash@{0}: On aula-10: Testes de integração
# stash@{1}: On aula-09: JWT authentication implementado
# stash@{2}: On aula-08: API REST - endpoints de posts criados

# Retomar aula específica
git checkout aula-08-api
git stash apply stash@{2}
```

**Por que stash list?** Gerencia múltiplos trabalhos em paralelo.

---

### **Cenário 6: Experimento que Pode Dar Errado**

```bash
# Situação: Quer testar refatoração arriscada

# Opção A - Com WIP commit (pode voltar fácil):
git add .
git commit -m "WIP: Antes da refatoração arriscada"
# ... tenta refatorar ...
# Se der errado:
git reset --hard HEAD~1

# Opção B - Com stash + branch:
git stash save "Código estável antes de refatorar"
git checkout -b experimento-refatoracao
git stash pop
# ... tenta refatorar ...
# Se der errado, só deletar a branch:
git checkout aula-X
git branch -D experimento-refatoracao
```

**Por que commit/stash?** Segurança para poder voltar.

---

## 📊 Comparação das Opções

| Método | Vantagens | Desvantagens | Quando Usar |
|--------|-----------|--------------|-------------|
| **Git Stash** | ✅ Não polui histórico<br>✅ Simples e rápido<br>✅ Pode ter múltiplas stashes<br>✅ Funciona entre branches diferentes | ❌ Pode esquecer stashes antigas<br>❌ Stashes não vão pro GitHub | ⭐ **USO DIÁRIO**<br>Pausar trabalho temporariamente<br>Trocar de branch rapidamente |
| **Levar Mudanças** | ✅ Muito rápido<br>✅ Zero comandos extras | ❌ Pode causar confusão<br>❌ Não funciona com conflitos<br>❌ Perigoso | ⚠️ **RARAMENTE**<br>Apenas se tiver absoluta certeza |
| **Commit WIP** | ✅ Fica no histórico<br>✅ Pode fazer push<br>✅ Fácil reverter<br>✅ Visível para outros | ❌ Polui histórico<br>❌ Precisa desfazer depois<br>❌ Aparece no log | 🔧 **TRABALHO LONGO PRAZO**<br>Backup antes de experimentos<br>Trocar de computador |
| **Nova Branch** | ✅ Organiza melhor<br>✅ Não perde nada<br>✅ Pode comparar depois | ❌ Cria branch extra<br>❌ Pode acumular branches | 🌿 **EXPERIMENTOS**<br>Mudanças significativas<br>Abordagens alternativas |

---

## ⚙️ Integração no Workflow de Aulas

### **Workflow Recomendado com Stash:**

```bash
# === INÍCIO DA AULA ===
git checkout main
git pull origin main
git checkout -b aula-XX-nome

# === DURANTE A AULA ===
# Desenvolve normalmente, faz commits quando completar partes...

# === PRECISA PAUSAR URGENTEMENTE ===
git stash save "Aula XX: [descrição exata do ponto atual]"
git checkout outra-branch
# ... faz o que precisa ...

# === RETOMAR AULA ===
git checkout aula-XX-nome
git stash pop
# Continua de onde parou

# === FINALIZAR AULA (sem pausas pendentes) ===
git add .
git commit -m "Aula XX: Concluída"
git push -u origin aula-XX-nome
```

---

## 🚨 Erros Comuns e Soluções

### **Erro 1: "Cannot apply stash" (conflitos)**

```bash
# Acontece quando código atual conflita com a stash

# Solução 1: Ver o que tem no stash antes
git stash show -p

# Solução 2: Criar branch a partir da stash
git stash branch recuperar-trabalho-pausado

# Solução 3: Aplicar e resolver conflitos manualmente
git stash apply
# Git marca conflitos no arquivo com <<<<<<<, =======, >>>>>>>
# Edite os arquivos manualmente
git add .
git stash drop
```

**Exemplo de conflito:**
```php
// PostController.php
<<<<<<< Updated upstream
public function store(Request $request) {
    // Código da branch atual
}
=======
public function store(Request $request) {
    // Código da stash
}
>>>>>>> Stashed changes
```

---

### **Erro 2: Fez Stash na Branch Errada**

```bash
# Situação: Salvou stash na aula-03 mas era pra aplicar na aula-04

# Solução: Stash é GLOBAL!
git checkout aula-04-views
git stash pop
# Funciona! Stash pode ser aplicada em qualquer branch
```

---

### **Erro 3: Esqueceu que Tinha Stash e Fez Commit**

```bash
# Situação: Fez stash, esqueceu, e re-implementou tudo

# Verificar se stash ainda existe
git stash list

# Ver conteúdo da stash
git stash show -p stash@{0}

# Se for duplicado do commit, só deletar
git stash drop stash@{0}

# Se tiver algo útil, pode criar branch para comparar
git stash branch comparar-com-commit stash@{0}
```

---

### **Erro 4: Perdeu Stash Importante (fez drop sem querer)**

```bash
# Git mantém stashes por ~90 dias mesmo depois de drop!

# Método 1: Procurar por stashes perdidas
git fsck --unreachable | grep commit | cut -d ' ' -f3 | xargs git log --merges --no-walk

# Método 2: Ver log de referências
git log --graph --oneline --decorate $(git fsck --no-reflogs | awk '/dangling commit/ {print $3}')

# Método 3: Recuperar através do reflog
git reflog
# Procure por "WIP on aula-XX"
git stash apply <hash-do-reflog>
```

---

### **Erro 5: Stash Lista Vazia Mas Tinha Certeza que Salvou**

```bash
# Verificar se salvou em repositório diferente
pwd  # Confere se está no diretório correto

# Ver todas as referências de stash
git show-ref stash

# Verificar reflog de stash
git reflog show refs/stash
```

---

### **Erro 6: Muitas Stashes Acumuladas**

```bash
# Ver lista completa
git stash list

# Limpar stashes antigas e desnecessárias
# CUIDADO: Isso é irreversível!

# Deletar stash específica
git stash drop stash@{5}

# Deletar todas (MUITO CUIDADO!)
git stash clear

# Recomendado: Revisar cada uma antes
git stash show -p stash@{0}  # Revisa
git stash drop stash@{0}     # Deleta se não precisar
```

---

## 💡 Dicas Avançadas

### **Dica 1: Stash Apenas Arquivos Específicos**

```bash
# Stash apenas arquivos específicos (Git 2.13+)
git stash push -m "Apenas o controller" app/Http/Controllers/PostController.php

# Stash tudo EXCETO arquivos específicos
git stash push -m "Tudo menos config" -- . ':!config/'
```

### **Dica 2: Stash com Arquivos Não Rastreados**

```bash
# Stash incluindo arquivos novos (untracked)
git stash -u

# Stash incluindo até arquivos ignorados (.gitignore)
git stash -a
```

### **Dica 3: Ver Diff Antes de Aplicar**

```bash
# Ver o que vai ser aplicado antes de aplicar
git stash show -p stash@{0}

# Aplicar apenas se parecer correto
git stash apply stash@{0}
```

### **Dica 4: Criar Branch Automaticamente da Stash**

```bash
# Cria branch e aplica stash em um comando
git stash branch nome-da-nova-branch stash@{0}

# Útil quando stash tem conflitos com branch atual
```

### **Dica 5: Salvar Stash com Contexto Completo**

```bash
# Incluir informações úteis no nome
git stash save "Aula 05 - AuthController@login - antes de testar nova abordagem - $(date +%Y-%m-%d)"
```

---

## 📋 Cheat Sheet - Comandos Mais Usados

```bash
# === STASH BÁSICO ===
git stash                                    # Salvar mudanças
git stash save "descrição"                   # Salvar com descrição
git stash pop                                # Aplicar e remover
git stash apply                              # Aplicar e manter
git stash list                               # Ver todas

# === STASH ESPECÍFICA ===
git stash apply stash@{2}                    # Aplicar específica
git stash drop stash@{2}                     # Deletar específica
git stash show -p stash@{0}                  # Ver diff completa

# === STASH AVANÇADO ===
git stash -u                                 # Incluir arquivos novos
git stash branch nova-branch                 # Criar branch da stash
git stash clear                              # Deletar TODAS

# === COMMIT WIP ===
git commit -m "WIP"                          # Commit temporário
git reset HEAD~1                             # Desfazer último commit
git reset --hard HEAD~1                      # Descartar tudo

# === BRANCH ===
git checkout -b nova-branch                  # Criar branch com mudanças
```

---

## 🎓 Resumo - Quando Usar O Quê

### **Use Git Stash quando:**
- ✅ Precisa trocar de branch rapidamente
- ✅ Vai pausar trabalho por pouco tempo (horas/dias)
- ✅ Não quer poluir histórico com WIP
- ✅ Trabalha sozinho ou mudanças são locais

### **Use Commit WIP quando:**
- ✅ Precisa fazer backup no GitHub
- ✅ Vai trocar de computador
- ✅ Trabalho vai ficar pausado por muito tempo
- ✅ Quer que outros vejam o progresso

### **Use Nova Branch quando:**
- ✅ Vai experimentar abordagem alternativa
- ✅ Trabalho merece branch própria
- ✅ Quer comparar duas implementações
- ✅ Começou na branch errada

### **NÃO leve mudanças junto:**
- ❌ Pode causar confusão
- ❌ Use apenas se tiver 100% de certeza
- ❌ Preferível usar stash sempre

---

**Pratique com stash no seu curso Laravel e ele vai se tornar natural! 🚀**
