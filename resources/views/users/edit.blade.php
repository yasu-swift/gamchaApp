<x-app-layout>
    <div class="container lg:w-1/2 md:w-4/5 w-11/12 mx-auto mt-8 px-8 bg-white shadow-md">
        <h2 class="text-center text-lg font-bold pt-6 tracking-widest">ブログ編集</h2>

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mx-8 my-2" role="alert">
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

        <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data"
            class="rounded pt-3 pb-8 mb-4">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="name">
                    名前
                </label>
                <input type="text" name="name" id="name" 
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                    required placeholder="タイトル" value="{{ old('name', $user->name) }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="likeGame">
                    好きなゲーム
                </label>
                <input type="text" name="likeGame" id="likeGame" 
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                    required placeholder="好きなゲーム" value="{{ old('likeGame', $user->likeGame) }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="profile">
                    自己紹介
                </label>
                <textarea name="profile" rows="10" id="profile"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                    required placeholder="本文">{{ old('profile', $user->profile) }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="avatar">
                    ブログ用画像
                </label>
                <img src="{{ $user->image_url }}" alt="" class="mb-4 md:w-2/5 sm:auto">
                <input type="file" name="avatar" class="border-gray-300">
            </div>
            {{-- @can('update', $user) --}}
            <input type="submit" value="更新"
                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                
            {{-- @endcan --}}
        </form>
    </div>
</x-app-layout>
