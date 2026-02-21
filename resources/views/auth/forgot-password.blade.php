<x-layout :title="$title">

    <x-slot:fullWidth>
        <div class="max-w-3xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-xl">

            <h1 class="text-2xl font-bold text-indigo-600 mb-6 text-center">
                Recuperar Senha
            </h1>

            <p class="text-gray-600 text-center mb-8">
                Informe seu e-mail para receber o link de redefinição da senha.
            </p>

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

            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block font-semibold mb-1" for="email">E-mail</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full p-3 border rounded-lg focus:ring focus:ring-indigo-300"
                        placeholder="seuemail@exemplo.com"
                    >
                    @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white p-3 rounded-lg font-semibold transition cursor-pointer"
                >
                    Enviar Link de Recuperação
                </button>
            </form>

        </div>
    </x-slot:fullWidth>

</x-layout>
