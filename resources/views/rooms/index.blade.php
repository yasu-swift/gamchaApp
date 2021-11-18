<x-app-layout>
    <div class="container max-w-7xl mx-auto px-4 md:px-12 pb-3 mt-3">
        <x-flash-message :message="session('notice')" />
        <div class="flex flex-wrap -mx-1 lg:-mx-4 mb-4">
            @foreach ($rooms as $room)
                <article class="w-full px-4 md:w-1/2 text-xl text-gray-800 leading-normal">
                    <a href="{{ route('rooms.show', $room) }}">
                        <h2 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-1 text-3xl md:text-4xl">
                            {{ $room->title }}</h2>
                        <h3>部屋の人数{{ $room->userLimit }}</h3>
                        <p class="text-sm mb-2 md:text-base font-normal text-gray-600">
                            <span
                                class="text-red-400 font-bold">{{ date('Y-m-d H:i:s', strtotime('-1 day')) < $room->created_at ? 'NEW' : '' }}</span>
                            {{ $room->created_at }}
                        </p>
                        <img class="w-full mb-2" src="{{ $room->image_url }}" alt="">
                        <p class="text-gray-700 text-base">{{ Str::limit($room->body, 50) }}</p>
                    </a>
                </article>
            @endforeach
        </div>
        {{ $rooms->links() }}
    </div>
</x-app-layout>
