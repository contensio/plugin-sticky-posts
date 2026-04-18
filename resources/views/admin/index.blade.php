@extends('contensio::admin.layout')
@section('title', 'Sticky Posts')
@section('breadcrumb')
<a href="{{ route('contensio.settings') }}" class="text-gray-500 hover:text-gray-700">Settings</a>
<span class="mx-2 text-gray-300">/</span>
<span class="font-medium text-gray-700">Sticky Posts</span>
@endsection
@section('content')

@if(session('success'))
<div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm">
    <svg class="w-4 h-4 shrink-0 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl border border-gray-200 divide-y divide-gray-100">

    <div class="px-6 py-4 flex items-center justify-between">
        <div>
            <h2 class="text-base font-bold text-gray-900">Sticky Posts</h2>
            <p class="text-sm text-gray-500 mt-0.5">Pinned posts float to the top of archive and homepage listings.</p>
        </div>
        @php $pinnedCount = $items->where('sticky', true)->count(); @endphp
        @if($pinnedCount > 0)
        <span class="inline-flex items-center gap-1.5 bg-amber-50 border border-amber-200 text-amber-700 text-xs font-semibold px-3 py-1.5 rounded-lg">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            {{ $pinnedCount }} pinned
        </span>
        @endif
    </div>

    @forelse($items as $item)
    <div class="px-6 py-4 flex items-center gap-4">

        {{-- Sticky indicator --}}
        <div class="shrink-0 w-6 flex items-center justify-center">
            @if($item['sticky'])
            <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
            @else
            <svg class="w-4 h-4 text-gray-200" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
            @endif
        </div>

        {{-- Info --}}
        <div class="flex-1 min-w-0">
            <div class="text-sm font-medium text-gray-900 truncate">{{ $item['title'] }}</div>
            <div class="text-xs text-gray-400 mt-0.5">{{ $item['type'] }} &middot; Published {{ $item['published']?->diffForHumans() }}</div>
        </div>

        {{-- Toggle --}}
        @if($item['sticky'])
        <form method="POST" action="{{ route('sticky-posts.unpin', $item['id']) }}" class="shrink-0">
            @csrf
            <button type="submit" class="text-sm text-amber-600 hover:text-red-600 font-medium transition-colors px-3 py-1.5 rounded-lg border border-amber-200 hover:border-red-200 bg-amber-50 hover:bg-red-50">
                Unpin
            </button>
        </form>
        @else
        <form method="POST" action="{{ route('sticky-posts.pin', $item['id']) }}" class="shrink-0">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors px-3 py-1.5 rounded-lg border border-gray-200 hover:border-gray-300 bg-white hover:bg-gray-50">
                Pin to top
            </button>
        </form>
        @endif

    </div>
    @empty
    <div class="px-6 py-10 text-center text-sm text-gray-400">
        No published posts found.
    </div>
    @endforelse

</div>

@endsection
