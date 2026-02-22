<header class="bg-white shadow-sm sticky top-0 z-10">
    <div class="max-w-6xl mx-auto flex justify-between items-center p-4">
        <h1 class="text-2xl font-bold text-indigo-600"><a href="{{route('home.index')}}">Laravel Bootcamp</a></h1>
        <nav class="space-x-6 flex items-center">
            <a href="{{route('home.index')}}" class="hover:text-indigo-600">Home</a>
            <a href="{{route('courses.index')}}" class="hover:text-indigo-600">Meus Cursos</a>
            <a href="{{route('contact.create')}}" class="hover:text-indigo-600">Contact</a>

            @auth
                <div x-data="{ isOpen: false, openedWithKeyboard: false }" class="relative w-fit flex gap-2" x-on:keydown.esc.window="isOpen = false, openedWithKeyboard = false">


                    @if(Auth::user()->profile?->avatar)
                        <img class="size-10 rounded-full object-cover" src="https://penguinui.s3.amazonaws.com/component-assets/avatar-1.webp" alt="Rounded avatar">
                    @else
                        <span class="flex size-10 items-center justify-center overflow-hidden rounded-full border border-primary bg-primary text-lg font-bold tracking-wider text-on-primary/80 dark:border-primary-dark dark:bg-primary-dark dark:text-on-primary/80">{{strtoupper(substr(Auth::user()->firstName, 0, 1).substr(Auth::user()->lastName, 0, 1))}}</span>
                    @endif

                    <!-- Toggle Button -->
                    <button type="button" x-on:click="isOpen = ! isOpen" class="inline-flex items-center gap-2 whitespace-nowrap rounded-radius bg-surface-alt tracking-wide transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-outline-strong dark:border-outline-dark dark:bg-surface-dark-alt dark:focus-visible:outline-outline-dark-strong" aria-haspopup="true" x-on:keydown.space.prevent="openedWithKeyboard = true" x-on:keydown.enter.prevent="openedWithKeyboard = true" x-on:keydown.down.prevent="openedWithKeyboard = true" x-bind:class="isOpen || openedWithKeyboard ? 'text-on-surface-strong dark:text-on-surface-dark-strong' : 'text-on-surface dark:text-on-surface-dark'" x-bind:aria-expanded="isOpen || openedWithKeyboard">
                        {{Auth::user()->firstName .' '.Auth::user()->lastName}}
                        <svg aria-hidden="true" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 rotate-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </button>
                    <!-- Dropdown Menu -->
                    <div x-cloak x-show="isOpen || openedWithKeyboard" x-transition x-trap="openedWithKeyboard" x-on:click.outside="isOpen = false, openedWithKeyboard = false" x-on:keydown.down.prevent="$focus.wrap().next()" x-on:keydown.up.prevent="$focus.wrap().previous()" class="shadow bg-white absolute top-11 right-0 flex w-fit min-w-48 flex-col overflow-hidden rounded-radius border rounded border-outline border-gray-300 bg-surface-alt dark:border-outline-dark dark:bg-surface-dark-alt" role="menu">
                        <a href="#" class="bg-surface-alt px-4 py-2 text-sm text-on-surface hover:bg-gray-100 hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/10 focus-visible:text-on-surface-strong focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-on-surface-dark dark:hover:bg-surface-alt/5 dark:hover:text-on-surface-dark-strong dark:focus-visible:bg-surface-alt/10 dark:focus-visible:text-on-surface-dark-strong" role="menuitem">Perfil</a>

                        <form action="{{route('login.destroy')}}" method="post" class="w-full">
                            @csrf
                            @method('DELETE')
                            <a @click.prevent="$el.closest('form').submit()" href="{{route('login.destroy')}}" class="block w-full bg-surface-alt px-4 py-2 text-sm text-on-surface hover:bg-gray-100 hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/10 focus-visible:text-on-surface-strong focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-on-surface-dark dark:hover:bg-surface-alt/5 dark:hover:text-on-surface-dark-strong dark:focus-visible:bg-surface-alt/10 dark:focus-visible:text-on-surface-dark-strong" role="menuitem">Logout</a>
                        </form>

                    </div>
                </div>

            @else
                <a href="{{route('login.create')}}" class="hover:text-indigo-600">Login</a>
            @endauth

        </nav>
    </div>
</header>
