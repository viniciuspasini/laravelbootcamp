<x-layout :title="$title">

    <div class="md:col-span-3 flex justify-center items-center">
        <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md">
            <h1 class="text-3xl font-bold text-center mb-6">Entrar na sua conta</h1>

            <!-- success Alert -->
            @session('status')
            <div class="mb-2 relative w-full overflow-hidden rounded-sm border border-green-500 bg-surface text-on-surface bg-green-300" role="alert">
                <div class="flex w-full items-center gap-2 bg-success/10 p-4">
                    <div class="bg-green-500/15 text-green-500 rounded-full p-1" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-2">
                        <h3 class="text-sm font-semibold text-success">{{ $value }}</h3>
                    </div>
                </div>
            </div>
            @endsession

            <form method="POST" action="{{route('login.store')}}" class="space-y-5">
                @csrf
                <!-- E-mail -->
                <div>
                    <label for="email" class="block text-sm font-medium mb-1">E-mail</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-indigo-500"
                        placeholder="seu@email.com"
                    >
                    @error('email') <span class="text-red-600 italic text-center">{{$message}}</span> @enderror
                </div>

                <!-- Senha -->
                <div class="mb-1">
                    <label for="password" class="block text-sm font-medium mb-1">Senha</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-indigo-500"
                        placeholder="••••••••"
                    >
                    @error('password') <span class="text-red-600 italic text-center">{{$message}}</span> @enderror
                </div>

                <!-- Lembrar login -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="remember" class="text-indigo-600 rounded">
                        <span class="text-sm text-gray-600">Lembrar-me</span>
                    </label>
                    <a href="{{route('password.request')}}" class="text-sm text-indigo-600 hover:underline">
                        Esqueci minha senha
                    </a>
                </div>

                <!-- Botão -->
                <button
                    type="submit"
                    class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition-colors mt-1"
                >
                    Entrar
                </button>
            </form>

            <!-- Cadastro -->
            <p class="text-sm text-center text-gray-600 mt-6">
                Ainda não tem conta?
                <a href="#" class="text-indigo-600 hover:underline font-medium">
                    Cadastre-se
                </a>
            </p>
        </div>
    </div>

</x-layout>
