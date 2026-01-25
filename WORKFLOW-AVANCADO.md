# Workflow Git Avançado para Videoaulas

Este documento descreve um workflow Git profissional aplicado ao aprendizado do curso Laravel, simulando um ambiente de desenvolvimento real com Pull Requests e Releases.

---

## 📚 Visão Geral do Processo

```
aula-XX → PR → merge na develop → release/vX.X.X → PR → merge na main
```

**Fluxo completo:**
1. Criar branch da aula a partir da `main`
2. Desenvolver durante a videoaula (commits)
3. Push da branch para o remoto
4. Criar Pull Request (PR) no GitHub
5. Revisar e fazer merge do PR na `main`
6. Criar tag de release
7. Publicar release no GitHub

---

## 🚀 Setup Inicial (Fazer uma vez)

### Estrutura de Branches

Este workflow usa a branch `main` como branch principal:
- **main**: Branch de produção (código estável após cada aula)
- **aula-XX-nome**: Branches temporárias para cada videoaula

---

## 🎬 Workflow Completo - Passo a Passo

### **PASSO 1: Iniciar Nova Videoaula**

```bash
# 1. Garantir que está na main atualizada
git checkout main
git pull origin main

# 2. Criar branch para a aula
git checkout -b aula-01-instalacao-laravel
```

---

### **PASSO 2: Desenvolver Durante a Aula**

```bash
# Trabalhe normalmente, fazendo commits conforme avança

# Primeiro commit
git add .
git commit -m "Aula 01: Instalação do Laravel e dependências"

# Segundo commit
git add .
git commit -m "Aula 01: Configuração do ambiente e .env"

# Terceiro commit
git add .
git commit -m "Aula 01: Primeira rota e view criadas"
```

---

### **PASSO 3: Finalizar Aula e Subir para o Remoto**

```bash
# 1. Commit final
git add .
git commit -m "Aula 01: Concluída - Projeto Laravel instalado e configurado"

# 2. Push da branch para o GitHub
git push -u origin aula-01-instalacao-laravel
```

---

### **PASSO 4: Criar Pull Request no GitHub**

**Pelo navegador:**

1. Acesse: https://github.com/viniciuspasini/laravelbootcamp
2. Você verá um banner amarelo: "**aula-01-instalacao-laravel** had recent pushes"
3. Clique em **"Compare & pull request"**

**OU use o GitHub CLI:**

```bash
gh pr create --title "Aula 01: Instalação e Configuração do Laravel" \
  --body "## 📚 Aula 01 - Instalação e Configuração

### O que foi implementado:
- ✅ Instalação do Laravel 12
- ✅ Configuração do ambiente (.env)
- ✅ Primeira rota e view

### Conhecimentos adquiridos:
- Composer e dependências
- Estrutura de pastas do Laravel
- Sistema de rotas básico
- Blade templates

### Testes realizados:
- [x] Servidor rodando em http://localhost:8000
- [x] Página welcome carregando corretamente

---
**Referência:** Videoaula 01 do curso Laravel Bootcamp" \
  --base main \
  --head aula-01-instalacao-laravel
```

---

### **PASSO 5: Revisar e Aprovar o Pull Request**

**⚠️ IMPORTANTE: Limitação do GitHub**

O GitHub **NÃO permite** que você aprove suas próprias Pull Requests. Esta é uma proteção para garantir Code Review por outra pessoa.

**Como você está estudando sozinho, há duas opções:**

#### **Opção A: Pular a Aprovação (Recomendado para Estudo)**

1. No GitHub, acesse o Pull Request criado
2. Vá na aba **"Files changed"**
3. Revise as mudanças (pratique a leitura do código!)
4. Adicione comentários para si mesmo se quiser
5. **Pule direto para o Passo 6** (Fazer Merge)

**Pelo CLI:**

```bash
# Listar PRs abertos
gh pr list

# Ver detalhes do PR
gh pr view 1

# Adicionar comentário (mas não aprovar)
gh pr comment 1 --body "Código revisado. Implementação correta! ✅"

# Ir direto para o merge (próximo passo)
```

#### **Opção B: Desabilitar Proteções de Branch**

Se você configurou proteções que exigem aprovação:

1. Acesse: **Settings** → **Branches** → **Branch protection rules**
2. Edite a regra da branch `main`
3. Desmarque: **"Require approvals before merging"**
4. Salve

**Nota:** Só faça isso em repositórios pessoais de estudo!

---

### **PASSO 6: Fazer Merge do Pull Request**

**Opção A - Pelo GitHub:**
1. No Pull Request, clique em **"Merge pull request"**
2. Escolha o tipo de merge:
    - **Create a merge commit** (recomendado para aprendizado)
    - **Squash and merge** (junta todos os commits em um)
    - **Rebase and merge** (mantém histórico linear)
3. Confirme o merge
4. **Marque a opção:** "Delete branch" (opcional, mas recomendado)

**Opção B - Pelo CLI:**

```bash
# Fazer merge do PR
gh pr merge 1 --merge --delete-branch

# Ou com squash (juntar commits)
gh pr merge 1 --squash --delete-branch

# Ou com rebase
gh pr merge 1 --rebase --delete-branch
```

---

### **PASSO 7: Atualizar sua Branch Main Local**

```bash
# Voltar para main
git checkout main

# Puxar as mudanças do merge
git pull origin main

# Deletar branch local (se não foi deletada automaticamente)
git branch -d aula-01-instalacao-laravel
```

---

### **PASSO 8: Criar Release (Tag)**

As releases devem ser criadas após cada marco importante (ex: cada 5 aulas ou ao final de um módulo).

**Convenção de versionamento:**
- `v0.1.0` - Aula 01
- `v0.2.0` - Aula 02
- `v1.0.0` - Fim do módulo 1
- `v2.0.0` - Fim do módulo 2

**Criar release pelo CLI:**

```bash
# 1. Criar tag localmente
git tag -a v0.1.0 -m "Release v0.1.0 - Aula 01: Instalação e Configuração"

# 2. Enviar tag para o GitHub
git push origin v0.1.0

# 3. Criar release no GitHub
gh release create v0.1.0 \
  --title "v0.1.0 - Aula 01: Instalação e Configuração" \
  --notes "## 🎓 Aula 01 Concluída

### ✨ Novidades desta versão:
- Projeto Laravel 12 instalado
- Ambiente de desenvolvimento configurado
- Primeira rota e view funcionando

### 📚 Conceitos aprendidos:
- Composer e gerenciamento de dependências
- Estrutura MVC do Laravel
- Sistema de rotas
- Blade templates

### 🔗 Pull Request:
#1

---
**Curso:** Laravel Bootcamp
**Data:** $(date +'%d/%m/%Y')"
```

**Ou pelo navegador:**

1. Acesse: https://github.com/viniciuspasini/laravelbootcamp/releases
2. Clique em **"Create a new release"**
3. **Tag version:** `v0.1.0`
4. **Release title:** `v0.1.0 - Aula 01: Instalação e Configuração`
5. **Descrição:** Preencha com as informações da aula
6. Clique em **"Publish release"**

---

## 📋 Resumo dos Comandos (Copiar e Colar)

### Para cada nova aula:

```bash
# === INÍCIO DA AULA ===
git checkout main
git pull origin main
git checkout -b aula-XX-nome-descritivo

# === DURANTE A AULA ===
# ... desenvolver e fazer commits ...
git add .
git commit -m "Aula XX: Descrição da mudança"

# === FIM DA AULA ===
git add .
git commit -m "Aula XX: Concluída - Resumo do que foi feito"
git push -u origin aula-XX-nome-descritivo

# === CRIAR PULL REQUEST ===
gh pr create \
  --title "Aula XX: Título" \
  --body "Descrição detalhada" \
  --base main \
  --head aula-XX-nome-descritivo

# === REVISAR E MERGEAR ===
gh pr list                                              # Listar PRs
gh pr view NUMERO_DO_PR                                 # Ver detalhes
gh pr comment NUMERO_DO_PR --body "Código revisado!"   # Comentar (opcional)
gh pr merge NUMERO_DO_PR --merge --delete-branch        # Fazer merge

# === ATUALIZAR MAIN LOCAL ===
git checkout main
git pull origin main

# === CRIAR RELEASE (opcional - a cada X aulas) ===
git tag -a v0.X.0 -m "Release v0.X.0 - Aula XX"
git push origin v0.X.0
gh release create v0.X.0 \
  --title "v0.X.0 - Aula XX: Título" \
  --notes "Descrição da release"
```

---

## 🎯 Exemplo Prático Completo

### Aula 03 - Criando Models e Migrations

```bash
# 1. INÍCIO
git checkout main
git pull origin main
git checkout -b aula-03-models-migrations

# 2. DURANTE A AULA (múltiplos commits)
git add app/Models/Post.php
git commit -m "Aula 03: Criado model Post"

git add database/migrations/2024_01_25_create_posts_table.php
git commit -m "Aula 03: Criada migration de posts"

php artisan migrate
git add .
git commit -m "Aula 03: Executada migration"

# 3. FINALIZAR
git add .
git commit -m "Aula 03: Concluída - Models e migrations implementados"
git push -u origin aula-03-models-migrations

# 4. CRIAR PR
gh pr create \
  --title "Aula 03: Models e Migrations" \
  --body "## 📚 Aula 03 - Models e Migrations

### Implementações:
- ✅ Model Post criado
- ✅ Migration posts criada
- ✅ Tabela posts no banco de dados

### Aprendizados:
- Eloquent ORM
- Schema Builder
- Migrations e rollback
- Convenções do Laravel

### Comandos executados:
\`\`\`bash
php artisan make:model Post -m
php artisan migrate
\`\`\`" \
  --base main \
  --head aula-03-models-migrations

# 5. REVISAR E MERGEAR
gh pr list
gh pr view 3                                                          # Ver detalhes da PR
gh pr comment 3 --body "Models e migrations bem implementados! ✅"   # Comentar (opcional)
gh pr merge 3 --merge --delete-branch                                # Fazer merge

# 6. ATUALIZAR LOCAL
git checkout main
git pull origin main

# 7. CRIAR RELEASE (se for marco importante)
git tag -a v0.3.0 -m "Release v0.3.0 - Aula 03: Models e Migrations"
git push origin v0.3.0
gh release create v0.3.0 \
  --title "v0.3.0 - Aula 03: Models e Migrations" \
  --notes "## 🎓 Aula 03 Concluída

### ✨ Novidades:
- Model Post com Eloquent ORM
- Migration da tabela posts
- Banco de dados estruturado

### 📚 Conceitos:
- Eloquent ORM
- Schema Builder
- Migrations

### 🔗 Pull Request: #3"
```

---

## 💡 Estratégias de Release

### **Opção 1: Release por Aula**
```
v0.1.0 - Aula 01
v0.2.0 - Aula 02
v0.3.0 - Aula 03
```

### **Opção 2: Release por Módulo**
```
v1.0.0 - Módulo 1 completo (Aulas 01-05)
v2.0.0 - Módulo 2 completo (Aulas 06-10)
v3.0.0 - Módulo 3 completo (Aulas 11-15)
```

### **Opção 3: Semantic Versioning Adaptado**
```
v0.1.0 - Fundamentos (Aulas 01-03)
v0.2.0 - CRUD Básico (Aulas 04-06)
v0.3.0 - Relacionamentos (Aulas 07-09)
v1.0.0 - Projeto Básico Completo
v1.1.0 - Autenticação
v1.2.0 - Upload de Arquivos
v2.0.0 - Projeto Final Completo
```

---

## 🛠️ Comandos Úteis Adicionais

### Ver todas as releases
```bash
gh release list
```

### Ver detalhes de uma release
```bash
gh release view v0.3.0
```

### Deletar uma release (se errou)
```bash
gh release delete v0.3.0
git tag -d v0.3.0
git push origin :refs/tags/v0.3.0
```

### Ver todos os PRs (abertos e fechados)
```bash
gh pr list --state all
```

### Ver histórico de merges
```bash
git log --oneline --graph --all
```

### Comparar duas releases
```bash
git diff v0.2.0..v0.3.0
```

### Ver arquivos alterados entre releases
```bash
git diff --name-only v0.2.0..v0.3.0
```

---

## 📊 Visualizando seu Progresso

### No GitHub:

1. **Pull Requests**: https://github.com/viniciuspasini/laravelbootcamp/pulls
    - Histórico de todas as aulas

2. **Releases**: https://github.com/viniciuspasini/laravelbootcamp/releases
    - Marcos importantes do aprendizado

3. **Network Graph**: https://github.com/viniciuspasini/laravelbootcamp/network
    - Visualização gráfica do fluxo de branches

4. **Insights → Contributors**:
    - Estatísticas de commits

---

## 🎓 Benefícios deste Workflow

### Para Aprendizado:
- ✅ Prática de Git Flow profissional
- ✅ Experiência com Pull Requests
- ✅ Conhecimento de Code Review
- ✅ Gestão de releases e versionamento
- ✅ Histórico organizado de progresso

### Para Portfólio:
- ✅ Demonstra conhecimento de Git avançado
- ✅ Mostra organização e boas práticas
- ✅ Histórico de commits bem estruturado
- ✅ Documentação de progresso

### Para Revisão:
- ✅ Fácil ver o que foi feito em cada aula
- ✅ Possível voltar a qualquer ponto
- ✅ Comparar evolução do projeto
- ✅ Encontrar quando algo foi implementado

---

## 🚨 Resolução de Problemas

### Não consigo aprovar minha própria Pull Request

**Problema:**
```bash
gh pr review 1 --approve
# Erro: GraphQL: Review cannot be created for the author of the pull request
```

**Causa:** O GitHub não permite aprovar suas próprias PRs por questões de segurança.

**Solução:**

```bash
# Opção 1: Adicionar comentário e fazer merge direto
gh pr comment 1 --body "Código revisado. Tudo OK! ✅"
gh pr merge 1 --merge --delete-branch

# Opção 2: Fazer merge sem aprovação pelo GitHub web
# Vá na PR e clique direto em "Merge pull request"

# Opção 3: Se tiver proteções na branch, desabilitar temporariamente
# Settings → Branches → Edit rule → Desmarcar "Require approvals"
```

---

### PR com conflitos

Se aparecer conflito ao tentar mergear:

```bash
# 1. Atualizar sua branch com a main
git checkout aula-XX-nome
git fetch origin
git merge origin/main

# 2. Resolver conflitos manualmente nos arquivos

# 3. Commitar a resolução
git add .
git commit -m "Resolve conflitos com main"

# 4. Push
git push origin aula-XX-nome

# O PR será atualizado automaticamente
```

### Esqueceu de criar branch antes de começar

```bash
# Se ainda não commitou
git stash
git checkout -b aula-XX-nome
git stash pop

# Se já commitou na main
git checkout -b aula-XX-nome
git checkout main
git reset --hard origin/main
git checkout aula-XX-nome
```

### Quer alterar mensagem do último commit

```bash
git commit --amend -m "Nova mensagem"
git push --force-with-lease origin aula-XX-nome
```

---

## 📝 Template de Descrição de PR

Use este template ao criar PRs:

```markdown
## 📚 Aula XX - [Título da Aula]

### 🎯 Objetivo da Aula:
[Breve descrição do objetivo]

### ✨ O que foi implementado:
- [ ] Feature 1
- [ ] Feature 2
- [ ] Feature 3

### 📚 Conceitos aprendidos:
- Conceito 1
- Conceito 2
- Conceito 3

### 🧪 Testes realizados:
- [ ] Teste manual 1
- [ ] Teste manual 2
- [ ] Testes automatizados passando

### 📸 Screenshots (se aplicável):
[Cole imagens aqui]

### 🔗 Referências:
- Link da videoaula
- Documentação consultada

### ✅ Checklist:
- [ ] Código funcionando
- [ ] Sem erros no console
- [ ] Commits bem descritos
- [ ] Pronto para merge

---
**Videoaula:** [número/nome]
**Duração:** Xmin
**Data:** DD/MM/YYYY
```

---

## 🎯 Próximos Passos

Após dominar este workflow, você pode evoluir para:

1. **GitHub Actions**: Testes automatizados a cada PR
2. **Code Coverage**: Análise de cobertura de testes
3. **Conventional Commits**: Padronização de mensagens
4. **Changelog Automático**: Geração automática de notas de release
5. **Branch Protection Rules**: Regras de proteção na main

---

**Bom aprendizado e boas práticas de Git! 🚀**
