<x-app-layout>
    {{-- {{ dd($comment) }} --}}
    <link href="{{ asset('css/view.css') }}" rel="stylesheet">
    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-8 py-4 bg-white shadow-md">
        <x-flash-message :message="session('notice')" />
        <x-validation-errors :errors="$errors" />
        <article class="mb-2">
            <h2 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-1 text-3xl md:text-4xl">
                {{ $room->title }}</h2>
            <h2>ルーム作成者: {{ $room->user->name }}</h2>
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

        {{-- コメント --}}
        <section class="font-sans break-normal text-gray-900 ">
            <style>
                .other::before {
                    content: "";
                    position: absolute;
                    top: 90%;
                    left: -15px;
                    margin-top: -30px;
                    border: 5px solid transparent;
                    border-right: 15px solid #c7deff;
                }

                .self::after {
                    content: "";
                    position: absolute;
                    top: 50%;
                    left: 100%;
                    margin-top: -15px;
                    border: 3px solid transparent;
                    border-left: 9px solid #ffc7c7;
                }
            </style>
            <h1>コメント一覧</h1>
            <hr>
            @foreach ($comments as $comment)
                {{-- {{ dd(Auth::user()) }} --}}
                <div class="text-xs w-max mb-3 p-2 rounded-lg bg-red-200 relative @if ($comment->user->id == Auth::user()->id) text-right self ml-auto @else other class=w-max mb-3 p-2 rounded-lg bg-blue-200 relative @endif">


                    {{-- <p >{{ $comment->created_at }} ＠{{ $comment->user->name }}</p> --}}
                    {{-- <li class="@if ($comment->user == Auth::user())  @endif">
                        {{ $comment->body }}
                    </li> --}}
                    <div class="my-2 @if ($comment->user == Auth::user()) text-right col-sm-2 @endif"
                        style="@if ($comment->user == Auth::user()) @endif">
                        <a href="http://localhost/users/{{ $comment->user_id }}">
                            <span class="font-bold mr-5">{{ $comment->user->name }}</span>
                        </a>
                        <span class="text-sm">{{ $comment->created_at }}</span>
                        <p class="font-bold mr-3">{!! nl2br(e($comment->body)) !!}</p>
                        <div class="flex justify-end text-center">
                            @can('delete', $comment)
                                <form action="{{ route('rooms.comments.destroy', [$room, $comment]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="削除" onclick="if(!confirm('削除しますか？')){return false};"
                                        class="text-sm bg-red-400 hover:bg-red-600 text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline w-20">
                                </form>
                            @endcan
                        </div>
                    </div>

                </div>
                <hr>
            @endforeach
        </section>
        <form action="{{ route('rooms.comments.store', $room) }}" method="POST" class="rounded pt-3 pb-8 mb-4">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="body">
                    コメント
                </label>
                <textarea name="body" rows="1"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                    required placeholder="本文">{{ old('body') }}</textarea>
            </div>
            <input type="submit" value="登録"
                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        </form>
    </div>
    {{-- @section('js')
        <script src="{{ asset('js/comment.js') }}"></script>
    @endsection --}}
</x-app-layout>
