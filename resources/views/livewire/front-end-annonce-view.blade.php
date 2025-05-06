<div>
    <div class="container mx-auto mt-5">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($annonces as $annonce)
                <div class="card relative bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <img src="{{ asset('storage/' . $annonce->image) }}" alt="{{ $annonce->title }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-semibold">{{ $annonce->title }}</h2>
                        <p class="text-gray-600">{{ $annonce->description }}</p>
                        <p class="text-lg font-bold text-blue-600 mt-2">{{ $annonce->price }} €</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
