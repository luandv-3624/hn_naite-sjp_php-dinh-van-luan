@php
    $types = [
        'success' => 'bg-green-100 text-green-800',
        'error' => 'bg-red-100 text-red-800',
        'warning' => 'bg-yellow-100 text-yellow-800',
        'info' => 'bg-blue-100 text-blue-800',
    ];
@endphp

@foreach ($types as $type => $class)
    @if (session($type))
        <div class="mb-4 px-4 py-2 rounded {{ $class }}">
            {{ session($type) }}
        </div>
    @endif
@endforeach
