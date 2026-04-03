@extends('headerfooter')

@section('title', 'Event Gallery | FLEUR')

@section('content')
<div class="gallery-container">
    @php
        $eventGalleries = [
            'rustic-wedding' => [
                'title' => 'Rustic Wedding',
                'images' => ['slide1.png', 'slide4.png', 'slide6.png'],
            ],
            '18th-birthday' => [
                'title' => '18th Birthday',
                'images' => ['slide2.png', 'slide5.png', 'slide3.png'],
            ],
            'corporate-gala' => [
                'title' => 'Corporate Gala',
                'images' => ['slide3.png', 'slide6.png', 'slide1.png'],
            ],
            'garden-wedding' => [
                'title' => 'Garden Wedding',
                'images' => ['slide4.png', 'slide1.png', 'slide5.png'],
            ],
            'debut-celebration' => [
                'title' => 'Debut Celebration',
                'images' => ['slide5.png', 'slide2.png', 'slide4.png'],
            ],
            'anniversary-party' => [
                'title' => 'Anniversary Party',
                'images' => ['slide6.png', 'slide3.png', 'slide2.png'],
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
            Walang nahanap na gallery para sa event na ito.
        </p>
    @endif
</div>
@endsection
