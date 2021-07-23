<aside class="md:w-2/5 bg-teal-500 p-5 rounded m-3">
    <h2 class="text-2xl my-5 text-white uppercase font-bold text-center">Contacta al Reclutador</h2>
    <form enctype="multipart/form-data" action="{{ route('candidatos.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="nombre" class="block text-white text-sm font-bold mb-4">
                Nombre:
            </label>
            <input type="text" name="nombre" placeholder="Tu nombre" value="{{ old('nombre')}}" id="nombre" class="p-3 bg-gray-100 rounded form-input w-full @error('nombre') border border-red-500 @enderror">
            @error('nombre')
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 w-full mt-5" role="alert">
                    <p>{{$message}}</p>
                </div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="email" class="block text-white text-sm font-bold mb-4">
                Email:
            </label>
            <input type="email" name="email" placeholder="Tu email" value="{{ old('email')}}" id="email" class="p-3 bg-gray-100 rounded form-input w-full @error('email') border border-red-500 @enderror">
            @error('email')
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 w-full mt-5" role="alert">
                    <p>{{$message}}</p>
                </div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="cv" class="block text-white text-sm font-bold mb-4">
                CV (PDF):
            </label>
            <input type="file" accept="application/pdf" name="cv" placeholder="Tu cv" value="{{ old('cv')}}" id="cv" class="p-3 rounded form-input w-full @error('cv') border border-red-500 @enderror">
            @error('cv')
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 w-full mt-5" role="alert">
                    <p>{{$message}}</p>
                </div>
            @enderror
        </div>
        <input type="hidden" name="vacante_id" value="{{$vacante->id}}">
        <input type="submit" value="Contactar" class="bg-teal-600 w-full hover:bg-teal-700 text-gray-100 p-3 focus:outline-none focus:shadow-outline uppercase">
    </form>
</aside>