# Guia de Componentes Blade e Slots - Laravel 12

Este guia explica como criar e usar componentes Blade com múltiplos slots no Laravel 12.

---

## 📚 Índice

1. [Conceitos Básicos](#-conceitos-básicos)
2. [Criando Componentes](#-criando-componentes)
3. [Slots Nomeados](#-slots-nomeados)
4. [Exemplos Práticos](#-exemplos-práticos)
5. [Props e Atributos](#-props-e-atributos)
6. [Componentes Anônimos](#-componentes-anônimos)
7. [Boas Práticas](#-boas-práticas)

---

## 🎯 Conceitos Básicos

### **O que são Componentes Blade?**

Componentes são pedaços reutilizáveis de interface que você pode usar em várias partes da aplicação.

**Analogia:**
- Componente = Molde de bolo
- Slot = Onde você coloca o recheio
- Props = Sabor, tamanho, etc

### **Tipos de Slots:**

```blade
{{ $slot }}           # Slot padrão (conteúdo principal)
{{ $header }}         # Slot nomeado obrigatório
{{ $footer ?? '' }}   # Slot nomeado opcional
```

---

## 🛠️ Criando Componentes

### **Passo a Passo Completo:**

#### **1. Criar o Componente:**

```bash
# Criar componente com classe
php artisan make:component Card

# Criar componente anônimo (sem classe)
php artisan make:component Card --view
```

**O que é criado:**

```
app/View/Components/Card.php              # Classe do componente
resources/views/components/card.blade.php  # Template do componente
```

#### **2. Definir Template do Componente:**

```blade
{{-- resources/views/components/card.blade.php --}}
<div class="card border rounded shadow">
    {{-- Slot header (obrigatório) --}}
    <div class="card-header bg-gray-100 p-4">
        {{ $header }}
    </div>

    {{-- Slot padrão (conteúdo principal) --}}
    <div class="card-body p-4">
        {{ $slot }}
    </div>

    {{-- Slot footer (opcional) --}}
    @if(isset($footer))
        <div class="card-footer bg-gray-50 p-4">
            {{ $footer }}
        </div>
    @endif
</div>
```

#### **3. Usar o Componente:**

```blade
{{-- resources/views/welcome.blade.php --}}
<x-card>
    {{-- Slot header --}}
    <x-slot:header>
        <h2>Título do Card</h2>
    </x-slot>

    {{-- Slot padrão --}}
    <p>Este é o conteúdo principal.</p>
    <p>Pode ter vários elementos.</p>

    {{-- Slot footer (opcional) --}}
    <x-slot:footer>
        <button>OK</button>
    </x-slot>
</x-card>
```

---

## 🏷️ Slots Nomeados

### **Sintaxe Moderna (Laravel 8.5+):**

```blade
{{-- Recomendado: sintaxe com dois-pontos --}}
<x-card>
    <x-slot:header>
        Conteúdo do header
    </x-slot>

    <x-slot:footer>
        Conteúdo do footer
    </x-slot>
</x-card>
```

### **Sintaxe Antiga (ainda funciona):**

```blade
<x-card>
    <x-slot name="header">
        Conteúdo do header
    </x-slot>

    <x-slot name="footer">
        Conteúdo do footer
    </x-slot>
</x-card>
```

### **Slot Padrão:**

Todo conteúdo que **NÃO** está dentro de um `<x-slot>` vai para o `{{ $slot }}`:

```blade
<x-card>
    <x-slot:header>Header</x-slot>

    <!-- Tudo aqui vai para $slot -->
    <p>Parágrafo 1</p>
    <p>Parágrafo 2</p>
    <ul>
        <li>Item 1</li>
    </ul>

    <x-slot:footer>Footer</x-slot>
</x-card>
```

---

## 📦 Exemplos Práticos

### **Exemplo 1: Card de Post**

#### **Componente:**

```blade
{{-- resources/views/components/post-card.blade.php --}}
<article class="post-card bg-white rounded-lg shadow-md overflow-hidden">
    {{-- Slot image (opcional) --}}
    @if(isset($image))
        <div class="post-image">
            {{ $image }}
        </div>
    @endif

    {{-- Slot header --}}
    <header class="post-header p-6">
        {{ $header }}
    </header>

    {{-- Slot padrão: conteúdo --}}
    <div class="post-content px-6 pb-4">
        {{ $slot }}
    </div>

    {{-- Slot meta (informações adicionais) --}}
    @if(isset($meta))
        <div class="post-meta px-6 py-3 bg-gray-50 text-sm text-gray-600">
            {{ $meta }}
        </div>
    @endif

    {{-- Slot actions (botões) --}}
    @if(isset($actions))
        <footer class="post-actions p-4 border-t flex gap-2">
            {{ $actions }}
        </footer>
    @endif
</article>
```

#### **Uso:**

```blade
{{-- resources/views/posts/index.blade.php --}}
@foreach($posts as $post)
    <x-post-card>
        {{-- Slot image --}}
        <x-slot:image>
            <img src="{{ asset('storage/' . $post->image_path) }}"
                 alt="{{ $post->title }}"
                 class="w-full h-48 object-cover">
        </x-slot>

        {{-- Slot header --}}
        <x-slot:header>
            <h2 class="text-2xl font-bold text-gray-900">
                {{ $post->title }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                {{ $post->category->name }}
            </p>
        </x-slot>

        {{-- Slot padrão (conteúdo) --}}
        <p class="text-gray-700">
            {{ Str::limit($post->content, 200) }}
        </p>

        {{-- Slot meta --}}
        <x-slot:meta>
            <span>Por {{ $post->author->name }}</span>
            <span>•</span>
            <span>{{ $post->created_at->diffForHumans() }}</span>
            <span>•</span>
            <span>{{ $post->views }} visualizações</span>
        </x-slot>

        {{-- Slot actions --}}
        <x-slot:actions>
            <a href="{{ route('posts.show', $post) }}" class="btn-primary">
                Ler mais
            </a>
            @can('update', $post)
                <a href="{{ route('posts.edit', $post) }}" class="btn-secondary">
                    Editar
                </a>
            @endcan
            @can('delete', $post)
                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger"
                            onclick="return confirm('Tem certeza?')">
                        Deletar
                    </button>
                </form>
            @endcan
        </x-slot>
    </x-post-card>
@endforeach
```

---

### **Exemplo 2: Modal Reutilizável**

#### **Componente:**

```blade
{{-- resources/views/components/modal.blade.php --}}
@props([
    'id' => 'modal',
    'size' => 'md',  // sm, md, lg, xl
    'closable' => true
])

@php
$sizeClasses = [
    'sm' => 'max-w-sm',
    'md' => 'max-w-md',
    'lg' => 'max-w-lg',
    'xl' => 'max-w-xl',
    '2xl' => 'max-w-2xl',
];
@endphp

<div id="{{ $id }}"
     class="modal fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50"
     onclick="if(event.target === this && {{ $closable ? 'true' : 'false' }}) closeModal('{{ $id }}')">

    <div class="relative top-20 mx-auto p-5 border {{ $sizeClasses[$size] }} shadow-lg rounded-md bg-white">

        {{-- Header --}}
        <div class="modal-header flex justify-between items-center pb-3 border-b">
            <h3 class="text-xl font-bold text-gray-900">
                {{ $title }}
            </h3>

            @if($closable)
                <button onclick="closeModal('{{ $id }}')"
                        class="text-gray-400 hover:text-gray-600 text-2xl leading-none">
                    &times;
                </button>
            @endif
        </div>

        {{-- Body --}}
        <div class="modal-body py-4 text-gray-700">
            {{ $slot }}
        </div>

        {{-- Footer (opcional) --}}
        @if(isset($footer))
            <div class="modal-footer pt-3 border-t flex justify-end gap-2">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}
</script>
```

#### **Uso:**

```blade
{{-- resources/views/posts/index.blade.php --}}

{{-- Botão para abrir modal --}}
<button onclick="openModal('deleteModal-{{ $post->id }}')" class="btn-danger">
    Deletar
</button>

{{-- Modal de confirmação --}}
<x-modal id="deleteModal-{{ $post->id }}" size="md">
    {{-- Slot title --}}
    <x-slot:title>
        Confirmar Exclusão
    </x-slot>

    {{-- Slot padrão (conteúdo) --}}
    <div class="space-y-3">
        <p>Tem certeza que deseja deletar o post:</p>
        <p class="font-bold text-lg">{{ $post->title }}</p>
        <p class="text-red-600">Esta ação não pode ser desfeita!</p>
    </div>

    {{-- Slot footer --}}
    <x-slot:footer>
        <button onclick="closeModal('deleteModal-{{ $post->id }}')"
                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">
            Cancelar
        </button>
        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                Sim, deletar
            </button>
        </form>
    </x-slot>
</x-modal>
```

---

### **Exemplo 3: Alert com Tipos Diferentes**

#### **Componente:**

```blade
{{-- resources/views/components/alert.blade.php --}}
@props(['type' => 'info'])

@php
$config = [
    'success' => [
        'bg' => 'bg-green-50',
        'border' => 'border-green-500',
        'text' => 'text-green-900',
        'icon' => '✓'
    ],
    'error' => [
        'bg' => 'bg-red-50',
        'border' => 'border-red-500',
        'text' => 'text-red-900',
        'icon' => '✕'
    ],
    'warning' => [
        'bg' => 'bg-yellow-50',
        'border' => 'border-yellow-500',
        'text' => 'text-yellow-900',
        'icon' => '⚠'
    ],
    'info' => [
        'bg' => 'bg-blue-50',
        'border' => 'border-blue-500',
        'text' => 'text-blue-900',
        'icon' => 'ℹ'
    ],
];

$style = $config[$type];
@endphp

<div class="border-l-4 p-4 {{ $style['bg'] }} {{ $style['border'] }} {{ $style['text'] }}"
     role="alert">
    <div class="flex items-start">
        {{-- Slot icon (ou usa padrão) --}}
        <div class="flex-shrink-0 mr-3 text-xl">
            @if(isset($icon))
                {{ $icon }}
            @else
                {{ $style['icon'] }}
            @endif
        </div>

        {{-- Slot title (opcional) --}}
        @if(isset($title))
            <div class="flex-1">
                <h4 class="font-bold mb-1">{{ $title }}</h4>
                <div>{{ $slot }}</div>
            </div>
        @else
            <div class="flex-1">
                {{ $slot }}
            </div>
        @endif

        {{-- Slot action (botão fechar, etc) --}}
        @if(isset($action))
            <div class="ml-3">
                {{ $action }}
            </div>
        @endif
    </div>
</div>
```

#### **Uso:**

```blade
{{-- Alert simples de sucesso --}}
<x-alert type="success">
    Post criado com sucesso!
</x-alert>

{{-- Alert com título --}}
<x-alert type="error">
    <x-slot:title>
        Erro ao salvar
    </x-slot>

    Não foi possível salvar o post. Verifique os campos e tente novamente.
</x-alert>

{{-- Alert com ícone customizado --}}
<x-alert type="warning">
    <x-slot:icon>
        🔥
    </x-slot>

    Seu plano expira em 3 dias!
</x-alert>

{{-- Alert com botão de fechar --}}
<x-alert type="info">
    <x-slot:title>
        Nova funcionalidade
    </x-slot>

    Agora você pode fazer upload de múltiplas imagens!

    <x-slot:action>
        <button onclick="this.closest('[role=alert]').remove()"
                class="text-xl hover:opacity-70">
            &times;
        </button>
    </x-slot>
</x-alert>
```

---

### **Exemplo 4: Layout de Duas Colunas**

#### **Componente:**

```blade
{{-- resources/views/components/two-column-layout.blade.php --}}
@props([
    'sidebarWidth' => 'w-1/4',  // w-1/4, w-1/3, w-64, etc
    'sidebarPosition' => 'left'  // left ou right
])

<div class="flex gap-6">
    @if($sidebarPosition === 'left')
        {{-- Sidebar à esquerda --}}
        <aside class="{{ $sidebarWidth }} flex-shrink-0">
            {{ $sidebar }}
        </aside>

        {{-- Conteúdo principal --}}
        <main class="flex-1">
            {{ $content }}
        </main>
    @else
        {{-- Conteúdo principal --}}
        <main class="flex-1">
            {{ $content }}
        </main>

        {{-- Sidebar à direita --}}
        <aside class="{{ $sidebarWidth }} flex-shrink-0">
            {{ $sidebar }}
        </aside>
    @endif
</div>
```

#### **Uso:**

```blade
{{-- resources/views/dashboard.blade.php --}}
<x-two-column-layout sidebar-width="w-64" sidebar-position="left">
    {{-- Slot sidebar --}}
    <x-slot:sidebar>
        <nav class="space-y-2">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 bg-blue-500 text-white rounded">
                Dashboard
            </a>
            <a href="{{ route('posts.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded">
                Posts
            </a>
            <a href="{{ route('categories.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded">
                Categorias
            </a>
            <a href="{{ route('settings') }}" class="block px-4 py-2 hover:bg-gray-100 rounded">
                Configurações
            </a>
        </nav>

        <div class="mt-8 p-4 bg-blue-50 rounded">
            <h3 class="font-bold mb-2">Estatísticas</h3>
            <p class="text-sm">Total de posts: <strong>{{ $totalPosts }}</strong></p>
            <p class="text-sm">Visitantes hoje: <strong>{{ $todayVisitors }}</strong></p>
        </div>
    </x-slot>

    {{-- Slot content --}}
    <x-slot:content>
        <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

        <div class="grid grid-cols-3 gap-6 mb-8">
            {{-- Cards de estatísticas --}}
            <x-stat-card title="Posts Publicados" :value="$publishedPosts" />
            <x-stat-card title="Rascunhos" :value="$draftPosts" />
            <x-stat-card title="Comentários" :value="$totalComments" />
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Posts Recentes</h2>
            @foreach($recentPosts as $post)
                <div class="border-b py-3">
                    <a href="{{ route('posts.show', $post) }}" class="font-medium hover:text-blue-600">
                        {{ $post->title }}
                    </a>
                    <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                </div>
            @endforeach
        </div>
    </x-slot>
</x-two-column-layout>
```

---

### **Exemplo 5: Tabs (Abas)**

#### **Componente Principal:**

```blade
{{-- resources/views/components/tabs.blade.php --}}
@props(['default' => null])

<div class="tabs" x-data="{ activeTab: '{{ $default }}' }">
    {{-- Navegação das tabs --}}
    <div class="tab-navigation flex border-b">
        {{ $navigation }}
    </div>

    {{-- Conteúdo das tabs --}}
    <div class="tab-content mt-4">
        {{ $slot }}
    </div>
</div>
```

#### **Componente de Tab Individual:**

```blade
{{-- resources/views/components/tab.blade.php --}}
@props(['name', 'label'])

{{-- Conteúdo da tab (mostrado/escondido com Alpine.js) --}}
<div x-show="activeTab === '{{ $name }}'"
     x-transition
     class="tab-pane">
    {{ $slot }}
</div>
```

#### **Componente de Botão de Tab:**

```blade
{{-- resources/views/components/tab-button.blade.php --}}
@props(['name', 'label'])

<button @click="activeTab = '{{ $name }}'"
        :class="{ 'border-b-2 border-blue-500 text-blue-600': activeTab === '{{ $name }}' }"
        class="px-6 py-3 font-medium hover:text-blue-600 transition">
    {{ $label }}
</button>
```

#### **Uso:**

```blade
{{-- resources/views/profile/show.blade.php --}}

{{-- Incluir Alpine.js --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<x-tabs default="perfil">
    {{-- Slot navigation: botões das tabs --}}
    <x-slot:navigation>
        <x-tab-button name="perfil" label="Perfil" />
        <x-tab-button name="posts" label="Meus Posts" />
        <x-tab-button name="config" label="Configurações" />
        <x-tab-button name="seguranca" label="Segurança" />
    </x-slot>

    {{-- Slot padrão: conteúdo de cada tab --}}
    <x-tab name="perfil">
        <h2 class="text-2xl font-bold mb-4">Informações do Perfil</h2>
        <div class="space-y-4">
            <div>
                <label class="font-medium">Nome:</label>
                <p>{{ $user->name }}</p>
            </div>
            <div>
                <label class="font-medium">Email:</label>
                <p>{{ $user->email }}</p>
            </div>
            <div>
                <label class="font-medium">Membro desde:</label>
                <p>{{ $user->created_at->format('d/m/Y') }}</p>
            </div>
        </div>
    </x-tab>

    <x-tab name="posts">
        <h2 class="text-2xl font-bold mb-4">Meus Posts</h2>
        <div class="space-y-4">
            @forelse($user->posts as $post)
                <x-post-card :post="$post" />
            @empty
                <p class="text-gray-500">Você ainda não criou nenhum post.</p>
            @endforelse
        </div>
    </x-tab>

    <x-tab name="config">
        <h2 class="text-2xl font-bold mb-4">Configurações</h2>
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PATCH')
            {{-- Formulário de configurações --}}
        </form>
    </x-tab>

    <x-tab name="seguranca">
        <h2 class="text-2xl font-bold mb-4">Segurança</h2>
        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            @method('PUT')
            {{-- Formulário de senha --}}
        </form>
    </x-tab>
</x-tabs>
```

---

## 🔧 Props e Atributos

### **Definindo Props:**

```blade
{{-- resources/views/components/button.blade.php --}}
@props([
    'type' => 'button',
    'color' => 'blue',
    'size' => 'md',
    'disabled' => false
])

@php
$sizeClasses = [
    'sm' => 'px-3 py-1 text-sm',
    'md' => 'px-4 py-2',
    'lg' => 'px-6 py-3 text-lg',
];

$colorClasses = [
    'blue' => 'bg-blue-500 hover:bg-blue-600 text-white',
    'red' => 'bg-red-500 hover:bg-red-600 text-white',
    'green' => 'bg-green-500 hover:bg-green-600 text-white',
    'gray' => 'bg-gray-500 hover:bg-gray-600 text-white',
];
@endphp

<button type="{{ $type }}"
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge([
            'class' => 'rounded font-medium transition ' .
                       $sizeClasses[$size] . ' ' .
                       $colorClasses[$color]
        ]) }}>
    {{ $slot }}
</button>
```

### **Usando Props:**

```blade
{{-- Botão padrão --}}
<x-button>Clique aqui</x-button>

{{-- Botão personalizado --}}
<x-button type="submit" color="green" size="lg">
    Salvar
</x-button>

{{-- Botão com atributos adicionais --}}
<x-button color="red" onclick="return confirm('Tem certeza?')">
    Deletar
</x-button>

{{-- Botão desabilitado --}}
<x-button :disabled="!$canSubmit" color="blue">
    Enviar
</x-button>
```

### **Merge de Atributos:**

```blade
{{-- Componente --}}
@props(['type' => 'info'])

<div {{ $attributes->merge(['class' => 'alert alert-' . $type]) }}>
    {{ $slot }}
</div>

{{-- Uso --}}
<x-alert type="success" class="mb-4 shadow-lg">
    Sucesso!
</x-alert>

{{-- Resultado --}}
<div class="alert alert-success mb-4 shadow-lg">
    Sucesso!
</div>
```

---

## 👻 Componentes Anônimos

Componentes sem classe PHP, apenas template Blade.

### **Criar Componente Anônimo:**

```bash
# Opção 1: Criar manualmente
# Criar arquivo: resources/views/components/nome.blade.php

# Opção 2: Via artisan
php artisan make:component Nome --view
```

### **Exemplo:**

```blade
{{-- resources/views/components/badge.blade.php --}}
@props(['color' => 'gray'])

@php
$colors = [
    'gray' => 'bg-gray-100 text-gray-800',
    'red' => 'bg-red-100 text-red-800',
    'green' => 'bg-green-100 text-green-800',
    'blue' => 'bg-blue-100 text-blue-800',
];
@endphp

<span {{ $attributes->merge(['class' => 'px-2 py-1 text-xs rounded-full ' . $colors[$color]]) }}>
    {{ $slot }}
</span>

{{-- Uso --}}
<x-badge color="green">Publicado</x-badge>
<x-badge color="red">Rascunho</x-badge>
<x-badge color="blue">Em revisão</x-badge>
```

---

## ✨ Boas Práticas

### **1. Nomenclatura Clara:**

```bash
# Bom ✓
<x-post-card>
<x-user-avatar>
<x-modal>

# Evite ✗
<x-pc>
<x-thing>
<x-component1>
```

### **2. Slots com Nomes Descritivos:**

```blade
# Bom ✓
<x-slot:header>
<x-slot:footer>
<x-slot:actions>

# Evite ✗
<x-slot:top>
<x-slot:bottom>
<x-slot:stuff>
```

### **3. Props com Valores Padrão:**

```blade
@props([
    'size' => 'md',      # Sempre defina um padrão
    'color' => 'blue',
    'rounded' => true
])
```

### **4. Documentar Componentes Complexos:**

```blade
{{--
Componente: Modal
Props:
  - id: string (obrigatório) - ID único do modal
  - size: sm|md|lg|xl (padrão: md) - Tamanho do modal
  - closable: boolean (padrão: true) - Se pode fechar clicando fora

Slots:
  - title: Título do modal (obrigatório)
  - slot: Conteúdo principal (obrigatório)
  - footer: Botões de ação (opcional)

Exemplo:
<x-modal id="myModal" size="lg">
    <x-slot:title>Título</x-slot>
    Conteúdo aqui
    <x-slot:footer>
        <button>Salvar</button>
    </x-slot>
</x-modal>
--}}
```

### **5. Organizar Componentes em Pastas:**

```
resources/views/components/
├── layout/
│   ├── header.blade.php
│   ├── footer.blade.php
│   └── sidebar.blade.php
├── ui/
│   ├── button.blade.php
│   ├── input.blade.php
│   └── badge.blade.php
├── cards/
│   ├── post-card.blade.php
│   ├── user-card.blade.php
│   └── stat-card.blade.php
└── modals/
    ├── confirm.blade.php
    └── form.blade.php
```

**Uso com subpastas:**

```blade
<x-ui.button>Clique</x-ui.button>
<x-cards.post-card :post="$post" />
<x-modals.confirm id="delete" />
```

---

## 📋 Cheat Sheet

```blade
# === CRIAR COMPONENTE ===
php artisan make:component Nome              # Com classe
php artisan make:component Nome --view       # Sem classe (anônimo)

# === DEFINIR SLOTS NO COMPONENTE ===
{{ $slot }}              # Slot padrão
{{ $header }}            # Slot obrigatório
{{ $footer ?? '' }}      # Slot opcional
@if(isset($footer))      # Verificar se existe
    {{ $footer }}
@endif

# === USAR COMPONENTE ===
<x-nome>                 # Usar componente
    <x-slot:header>      # Slot nomeado
        Conteúdo
    </x-slot>

    Conteúdo padrão      # Vai para $slot
</x-nome>

# === PROPS ===
@props(['size' => 'md']) # Definir props
<x-button size="lg">     # Passar props
<x-button :size="$var">  # Props dinâmicas

# === ATRIBUTOS ===
{{ $attributes }}                    # Todos os atributos
{{ $attributes->merge(['class']) }}  # Merge de classes
{{ $attributes->get('id') }}         # Pegar atributo específico
```

---

## 🎯 Quando Criar um Componente?

### **✅ Crie componente quando:**
- Vai reutilizar em vários lugares
- Tem lógica visual complexa
- Quer manter código organizado
- Precisa de variações (cores, tamanhos)

### **❌ Não crie componente quando:**
- Usa apenas uma vez
- É muito simples (uma div vazia)
- Deixaria o código mais complexo

---

## 📚 Exemplos de Componentes Úteis

```bash
# UI Básico
button, input, select, checkbox, radio, badge, tag

# Cards
post-card, user-card, product-card, stat-card

# Layout
header, footer, sidebar, navbar, container, grid

# Feedback
alert, notification, toast, modal, confirm-dialog

# Formulários
form-group, input-group, file-upload, wysiwyg-editor

# Navegação
tabs, accordion, breadcrumb, pagination, dropdown

# Conteúdo
avatar, image-gallery, video-player, code-block
```

---

**Pratique criando componentes reutilizáveis durante seu curso! 🚀**
