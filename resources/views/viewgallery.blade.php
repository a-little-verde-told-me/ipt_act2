@extends('headerfooter')

@section('title', 'Event Gallery | FLEUR')

@section('content')
<div class="gallery-container">
    @php
        $eventGalleries = [
            'rustic-wedding' => [
                'title' => 'Rustic Wedding',
                // Replace the filenames with your images in public/images
                'images' => ['rustic1.jpg', 'rustic2.jpg', 'rustic3.jpg'],
            ],
            '18th-birthday' => [
                'title' => '18th Birthday',
                'images' => ['birthday1.jpg', 'birthday2.jpg', 'birthday3.jpg'],
            ],
            'corporate-gala' => [
                'title' => 'Corporate Gala',
                'images' => ['corporate1.jpg', 'corporate2.jpg', 'corporate3.jpg'],
            ],
            'garden-wedding' => [
                'title' => 'Garden Wedding',
                'images' => ['garden1.jpg', 'garden2.jpg', 'garden3.jpg'],
            ],
            'debut-celebration' => [
                'title' => 'Debut Celebration',
                'images' => ['debut1.jpg', 'debut2.jpg', 'debut3.jpg'],
            ],
            'anniversary-party' => [
                'title' => 'Anniversary Party',
                'images' => ['anniv1.jpg', 'anniv2.jpg', 'anniv3.jpg'],
            ],
        ];

        $selected = $eventGalleries[$event] ?? null;
    @endphp

    <h1 class="page-title">
        {{ $selected ? strtoupper($selected['title']).' GALLERY' : 'EVENT GALLERY' }}
    </h1>

    <div class="filter-section">
        <a class="filter-btn active" href="{{ route('gallery') }}">Back to Gallery</a>
    </div>

    @if($selected)
        <div class="gallery-grid">
            @foreach($selected['images'] as $image)
                <div class="event-card">
                    <img class="event-image" src="{{ asset('images/'.$image) }}" alt="{{ $selected['title'] }} photo">
                </div>
            @endforeach
        </div>
    @else
        <p style="text-align:center; margin-top: 18px;">
            No gallery found for this event.
        </p>
    @endif
</div>
@endsection
