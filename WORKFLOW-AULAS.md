# Workflow Git para Videoaulas do Curso Laravel

Este documento explica o processo para gerenciar branches durante o curso de Laravel, criando uma branch para cada videoaula.

---

## 🎬 Ao Iniciar uma Nova Videoaula

```bash
# 1. Certifique-se que está na main e atualizada
git checkout main
git pull origin main

# 2. Crie uma branch para a aula (exemplo: aula 1, aula 2, etc.)
git checkout -b aula-01-instalacao

# ou use um nome descritivo como:
git checkout -b aula-05-criando-models
```

**Comando combinado (mais rápido):**
```bash
git checkout main && git pull origin main && git checkout -b aula-XX-nome-descritivo
```

---

## 💻 Durante a Videoaula

Trabalhe normalmente no código. Você pode fazer commits ao longo da aula:

```bash
# Adicionar mudanças
git add .

# Fazer commit (pode fazer vários durante a aula)
git commit -m "Aula 01: Configuração inicial do projeto"
```

**Dica:** Faça commits sempre que completar uma parte importante da aula!

---

## ✅ Ao Finalizar a Videoaula

```bash
# 1. Commit final se houver alterações pendentes
git add .
git commit -m "Aula 01: Finalizada - Instalação e configuração completa"

# 2. Voltar para a main
git checkout main

# 3. Fazer merge da branch da aula
git merge aula-01-instalacao

# 4. Fazer push para o GitHub
git push origin main

# 5. (Opcional) Fazer push da branch da aula também
git push origin aula-01-instalacao

# 6. (Opcional) Deletar a branch local se não precisar mais
git branch -d aula-01-instalacao
```

**Comando combinado (mais rápido):**
```bash
git add . && git commit -m "Aula XX: Concluída" && git checkout main && git merge aula-XX-nome-descritivo && git push origin main
```

---

## 🎯 Exemplo Prático Completo

### Aula 3 - Criando Controllers

**1. Iniciar a aula:**
```bash
git checkout main
git checkout -b aula-03-criando-controllers
```

**2. Durante a aula (fazer vários commits):**
```bash
# Primeira alteração
git add .
git commit -m "Criado controller de Posts"

# Segunda alteração
git add .
git commit -m "Adicionado método index no PostController"

# Terceira alteração
git add .
git commit -m "Criadas rotas para PostController"
```

**3. Finalizar a aula:**
```bash
git add .
git commit -m "Aula 03: Concluída - Controllers criados e funcionando"
git checkout main
git merge aula-03-criando-controllers
git push origin main
git push origin aula-03-criando-controllers  # Opcional: manter branch no GitHub
```

---

## 💡 Comandos Úteis

### Ver todas as suas branches de aulas
```bash
git branch
```

### Ver histórico de commits
```bash
git log --oneline --graph
```

### Voltar para ver o código de uma aula anterior
```bash
git checkout aula-01-instalacao
# Ver o código...
git checkout main  # Voltar para main
```

### Ver diferenças entre branches
```bash
git diff main aula-03-criando-controllers
```

### Deletar branch local
```bash
git branch -d aula-01-instalacao
```

### Deletar branch remota no GitHub
```bash
git push origin --delete aula-01-instalacao
```

### Listar todas as branches (local e remoto)
```bash
git branch -a
```

---

## 📋 Convenção de Nomenclatura de Branches

Use nomes descritivos e numerados:

- `aula-01-instalacao`
- `aula-02-rotas`
- `aula-03-controllers`
- `aula-04-models-migrations`
- `aula-05-relacionamentos`
- `aula-06-validacao`
- `aula-07-autenticacao`
- etc...

**Padrão:** `aula-XX-descricao-curta`

---

## ✨ Dicas Extras

### 1. Manter as branches das aulas no GitHub
Se você quiser ter um histórico visual de cada aula no GitHub:
```bash
git push origin aula-03-criando-controllers
```

### 2. Ver o que mudou em uma aula específica
```bash
git log aula-03-criando-controllers --oneline
```

### 3. Se cometer um erro e quiser descartar mudanças
```bash
# Descartar mudanças não commitadas
git restore .

# Voltar ao commit anterior
git reset --hard HEAD~1
```

### 4. Se esqueceu de criar a branch antes de começar
```bash
# Crie a branch agora (suas mudanças vão junto)
git checkout -b aula-XX-nome
```

### 5. Verificar em qual branch você está
```bash
git branch --show-current
```

---

## 🚨 Problemas Comuns

### "Não consigo fazer checkout porque tenho mudanças não salvas"

**Solução 1:** Commitar as mudanças
```bash
git add .
git commit -m "WIP: Trabalho em progresso"
```

**Solução 2:** Usar stash (guardar temporariamente)
```bash
git stash
git checkout main
git stash pop  # Recuperar mudanças depois
```

### "Conflito ao fazer merge"

Se aparecer conflito ao fazer `git merge`:

1. Abra os arquivos com conflito
2. Procure por `<<<<<<<`, `=======`, `>>>>>>>`
3. Edite manualmente para resolver
4. Depois:
```bash
git add .
git commit -m "Resolvido conflito do merge"
```

---

## 📊 Visualizando seu Progresso

Você pode ver todas as aulas concluídas no GitHub:

1. Acesse: https://github.com/viniciuspasini/laravelbootcamp
2. Clique em "branches" para ver todas as aulas
3. Use a aba "Commits" para ver o histórico completo
4. Use "Network Graph" para visualizar as branches graficamente

---

**Bom curso! 🚀**
