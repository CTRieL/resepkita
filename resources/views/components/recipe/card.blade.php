@props(['recipe'])
@php $user = auth()->user(); @endphp
<div class=" recipe-card relative slide-in-up bg-white rounded-3xl cursor-pointer shadow border border-gray-100 flex flex-col gap-2 p-4 w-full transition hover:bg-primary/5 hover:shadow-lg hover:scale-[1.015] focus:bg-primary/10 focus:outline-none">
    {{-- modifier btn --}}
    @if($user && $user->id === $recipe->user_id)
        <div class="absolute top-4 right-4 flex gap-1 z-10">
            <a href="{{ route('recipe.edit', $recipe->id) }}" class="bg-primary/80 hover:bg-primary hover:scale-105 text-white rounded-full p-1.5 shadow transition" title="Edit">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.1 2.1 0 1 1 2.97 2.97L7.5 19.788l-4 1 1-4 13.362-13.3Z" /></svg>
            </a>
            <button type="button" onclick="showDeletePopup({{ $recipe->id }}, '{{ addslashes($recipe->title) }}')" class="bg-danger/80 hover:bg-danger hover:scale-105 text-white rounded-full p-1.5 shadow transition" title="Hapus">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
    @endif
    
    {{-- Profil uploader --}}
    <a href="{{ route('profile.user', $recipe->user->id) }}" class="flex items-center gap-2 group">
        <p class="flex items-center gap-2 px-3 py-1 transition-all">
            @if($recipe->user && $recipe->user->photo_path)
                <img src="{{ asset('storage/' . $recipe->user->photo_path) }}" alt="Foto Profil" class="w-9 h-9 rounded-full object-cover border border-gray-300">
            @else
                <span class="w-9 h-9 rounded-full bg-gray-400 font-bold text-gray-600 flex items-center justify-center">
                    {{ $recipe->user ? strtoupper(substr($recipe->user->name,0,1)) : '' }}
                </span>
            @endif
            <div class="flex flex-col">
                <span class="font-semibold text-sm p-0 group-hover:underline">{{ $recipe->user ? $recipe->user->name : '' }}</span>
                <span class="text-gray-600 text-xs p-0">{{ $recipe->created_at->diffForHumans() }}</span>
            </div>
        </p>
    </a>

    <div class="grid grid-cols-7 gap-2 relative items-center">

        {{-- img section --}}
        <div onclick="window.location='{{ route('recipe.show', $recipe->id) }}'" class="col-span-2 w-full aspect-square rounded-lg overflow-hidden flex flex-col items-center justify-center">
            @if($recipe->photo_path)
                <img src="{{ asset('storage/' . $recipe->photo_path) }}" alt="{{ $recipe->title }}" class="object-cover w-full h-full rounded-xl">
            @else
                <span class="text-6xl text-gray-300 font-bold flex items-center justify-center w-full h-full rounded-xl">?</span>
            @endif
        </div>

        {{-- content section --}}
        <div class="col-span-5 w-full h-full pl-3 pr-5 flex flex-col gap-2">
            <div onclick="window.location='{{ route('recipe.show', $recipe->id) }}'">
                <h3 class="font-bold text-xl text-gray-800 line-clamp-3">{{ $recipe->title }}</h3>
                <p class="text-sm text-gray-800 line-clamp-3">{{ $recipe->description }}</p>
                
                <div>
                    <label class="text-sm text-gray-800 font-semibold">Bahan-bahan</label>
                    <p class="text-sm text-gray-800 line-clamp-3">
                        {{ str_replace(["\r\n", "\n", "\r"], ', ', $recipe->ingredients) }}
                    </p>
                </div>
            </div>

            {{-- resep popularity --}}
            <div onclick="window.location='{{ route('recipe.show', $recipe->id) }}'" class="flex-auto"></div>
            <div class="flex items-center gap-2 mt-1 text-primary justify-end z-10">
                @php
                    $user = auth()->user();
                    $likedType = $user ? $recipe->likedTypeByUser($user->id) : null;
                @endphp

                {{-- thumbs up --}}
                <button class="like-btn flex flex-row gap-1 items-center transition px-2 py-1 rounded-full border border-primary/30 hover:bg-primary/10 focus:outline-none {{ $likedType === 'thumbs_up' ? 'liked bg-primary/10' : '' }}" data-recipe-id="{{ $recipe->id }}" data-type="thumbs_up" aria-label="Like Thumbs Up">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" width="20" height="20"><path d="M2 21h4V9H2v12zM22 9c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L13.17 1 6.59 7.59C6.22 7.95 6 8.45 6 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-1.91l-.01-.01L22 9z"/></svg>
                    <span id="like-count-thumbs_up-{{ $recipe->id }}" class="font-semibold">{{ $recipe->likeCount('thumbs_up') }}</span>
                </button>
        
                {{-- love --}}
                <button class="like-btn text-danger/80 flex flex-row gap-1 items-center transition px-2 py-1 rounded-full border border-danger/30 hover:bg-danger/10 focus:outline-none {{ $likedType === 'love' ? 'liked bg-danger/10' : '' }}" data-recipe-id="{{ $recipe->id }}" data-type="love" aria-label="Like Love">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" width="20" height="20"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    <span id="like-count-love-{{ $recipe->id }}" class="font-semibold">{{ $recipe->likeCount('love') }}</span>
                </button>
        
                {{-- tasty --}}
                <button class="like-btn text-accent flex flex-row gap-1 items-center transition px-2 py-1 rounded-full border border-accent/50 hover:bg-accent/20 focus:outline-none {{ $likedType === 'tasty' ? 'liked bg-accent/20' : '' }}" data-recipe-id="{{ $recipe->id }}" data-type="tasty" aria-label="Like Tasty">
                    <img src="{{ asset('images/tasty.png') }}" alt="" width="24" height="24">
                    <span id="like-count-tasty-{{ $recipe->id }}" class="font-semibold">{{ $recipe->likeCount('tasty') }}</span>
                </button>

                {{-- comment --}}
                <span class="flex items-center gap-1 bg-gray-100 text-gray-500 px-2 py-1 rounded-full border border-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor"><path d="M240-400h320v-80H240v80Zm0-120h480v-80H240v80Zm0-120h480v-80H240v80ZM80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Zm126-240h594v-480H160v525l46-45Zm-46 0v-480 480Z"/></svg>
                    <span>{{ $recipe->comments()->count() }} komentar</span>
                </span>
            </div>
        </div>
    </div>
</div>