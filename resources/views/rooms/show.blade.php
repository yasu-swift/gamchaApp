<x-app-layout>
    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-8 py-4 bg-white shadow-md">
        @if (session('notice'))
            <div class="bg-blue-100 border-blue-500 text-blue-700 border-l-4 p-4 my-2">
                {{ session('notice') }}
            </div>
        @endif
        <x-validation-errors :errors="$errors" />
        <article class="mb-2">
            <h2 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-1 text-3xl md:text-4xl">
                {{ $room->title }}</h2>
            {{-- <h3>{{ $room->user->name }}</h3> --}}
            <p class="text-sm mb-2 md:text-base font-normal text-gray-600">
                <span
                    class="text-red-400 font-bold">{{ date('Y-m-d H:i:s', strtotime('-1 day')) < $room->created_at ? 'NEW' : '' }}</span>
                {{ $room->created_at }}
            </p>
            <br>
            <p class="text-sm mb-2 md:text-base font-normal text-gray-600">上限人数</p>
            {{-- <img src="{{ Storage::url($room->image) }}" alt="" class="mb-4"> --}}
            <p class="text-gray-700 text-base">{{ $room->userLimit }}</p>
            <br>
            <p class="text-gray-700 text-base">{!! nl2br(e($room->body)) !!}</p>
        </article>
        <div class="flex flex-row text-center my-4">
            @can('update', $room)
                <a href="{{ route('rooms.edit', $room) }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">編集</a>
            @endcan
            @can('delete', $room)
                <form action="{{ route('rooms.destroy', $room) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="削除" onclick="if(!confirm('削除しますか？')){return false};"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20">
                </form>
            @endcan
        </div>
    </div>
</x-app-layout>
