<x-app-layout>
    
    <link href="{{ asset('css/view.css') }}" rel="stylesheet">
    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-8 py-4 bg-white shadow-md">
        <x-flash-message :message="session('notice')" />
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

        {{-- @auth
            <hr class="my-4">

            <div class="flex justify-end">
                <a href="{{ route('rooms.comments.create', $room) }}"
                    class="bg-indigo-400 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline block">コメント登録</a>
            </div>
        @endauth --}}
        {{-- コメント部分 --}}
        {{-- @extends('layouts.app')

        @section('content')
            <div class="chat-container row justify-content-center">
                <div class="chat-area">
                    <div class="card">
                        <div class="card-header">Comment</div>
                        <div class="card-body chat-card">
                            <div id="comment-data"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body chat-card">
                @foreach ($comments as $item)
                    @include('components.comment', ['item' => $item])
                @endforeach
            </div>

            <form method="POST" action="{{ route('add') }}">
                @csrf
                <div class="comment-container row justify-content-center">
                    <div class="input-group comment-area">
                        <textarea class="form-control" id="comment" name="comment"
                            placeholder="push massage (shift Enter)" aria-label="With textarea"
                            onkeydown="if(event.shiftKey&&event.keyCode==13){document.getElementById('submit').click();return false};"></textarea>
                        <button type="submit" id="submit" class="btn btn-outline-primary comment-btn">Submit</button>
                    </div>
                </div>
            </form>

        @endsection --}}

        {{-- コメントここまで --}}

        {{-- コメント2 --}}
        <section class="font-sans break-normal text-gray-900 ">
            @foreach ($comments as $comment)
            {{-- {{ dd($comment) }} --}}
                <div class="my-2">
                    {{-- {{ dd($user) }} --}}
                    <span class="font-bold mr-3">{{ $comment->name }}</span>
                    <span class="text-sm">{{ $comment->created_at }}</span>
                    <p>{!! nl2br(e($comment->body)) !!}</p>
                    <div class="flex justify-end text-center">
                        {{-- @can('update', $comment)
                            <a href="{{ route('rooms.comments.edit', [$room, $comment]) }}"
                                class="text-sm bg-green-400 hover:bg-green-600 text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline w-20 mr-2">編集</a>
                        @endcan --}}
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
