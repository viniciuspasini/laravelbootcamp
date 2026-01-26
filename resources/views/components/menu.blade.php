<header class="bg-white shadow-sm sticky top-0 z-10">
    <div class="max-w-6xl mx-auto flex justify-between items-center p-4">
        <h1 class="text-2xl font-bold text-indigo-600"><a href="{{route('home.index')}}">Laravel Bootcamp</a></h1>
        <nav class="space-x-6">
            <a href="{{route('home.index')}}" class="hover:text-indigo-600">Home</a>
            <a href="{{route('courses.index')}}" class="hover:text-indigo-600">Meus Cursos</a>
            <a href="{{route('contact.create')}}" class="hover:text-indigo-600">Contact</a>
            <a href="{{route('login.create')}}" class="hover:text-indigo-600">Login</a>
        </nav>
    </div>
</header>
