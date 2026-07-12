@php
    $categories = \App\Models\Category::orderBy('name')->get();
    $activeCategoryId = request()->routeIs('post.byCategory')
        ? optional(request()->route('category'))->id
        : null;
    $base = 'inline-block px-4 py-2 rounded-lg';
    $active = 'text-white bg-blue-600 active';
    $idle = 'hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white';
@endphp

<ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 dark:text-gray-400 justify-center">
    <li class="me-2">
        <a href="{{ route('dashboard') }}"
           class="{{ $base }} {{ request()->routeIs('post.byCategory') ? $idle : $active }}">
            All
        </a>
    </li>

    @forelse ($categories as $category)
        <li class="me-2">
            <a href="{{ route('post.byCategory', $category) }}"
               class="{{ $base }} {{ $activeCategoryId === $category->id ? $active : $idle }}">
                {{ $category->name }}
            </a>
        </li>
    @empty
        <li class="py-2 px-4 me-2">No Categories</li>
    @endforelse
</ul>
