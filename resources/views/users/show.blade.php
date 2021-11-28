<x-app-layout>
    {{-- {{ dd($user) }} --}}
    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-8 py-4 bg-white shadow-md">


        @if (session('notice'))
            <div class="bg-blue-100 border-blue-500 text-blue-700 border-l-4 p-4 my-2">
                {{ session('notice') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-2" role="alert">
                <p>
                    <b>{{ count($errors) }}件のエラーがあります。</b>
                </p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif



        <article class="mb-2">
            <h2 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-1 text-3xl md:text-4xl">
                {{ $user->title }}</h2>
            <h3> Name:{{ $user->name }}</h3>
            <br>
            <img src="{{ $user->image_url }}" alt="" class="img-circle" width="200" height="200">
            <br>
            <p class="text-sm mb-2 md:text-base font-normal text-gray-600">
                <span
                    class="text-red-400 font-bold">{{ date('Y-m-d H:i:s', strtotime('-1 day')) < $user->created_at ? 'NEW' : '' }}</span>
                好きなゲーム:{{ $user->likeGame }}
            </p>
            <h3>自己紹介</h3>
            <br>
            <p class="text-gray-700 text-base">{!! nl2br(e($user->profile)) !!}</p>
        </article>

        {{-- {{ dd($user->id, Auth::user()->id)}} --}}
        @if($user->id == Auth::user()->id)
            <div class="flex flex-row text-center my-4">
                <a href="{{ route('users.edit', $user) }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">編集</a>
            </div>
        @endcan
    </div>
</x-app-layout>
