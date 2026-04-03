@extends('headerfooter')

@section('title', 'Event Gallery | FLEUR')

@section('content')
<div class="gallery-container">
    @php
        $eventGalleries = [
            'rustic-wedding' => [
                'title' => 'Rustic Wedding',
                // Replace the filenames with your images in public/images
                'images' => ['rustic_wedding1.jpg', 'rustic_wedding2.jpg', 'rustic_wedding3.jpg'],
            ],
            '18th-birthday' => [
                'title' => '18th Birthday',
                'images' => ['18th_birthday1.jpg', '18th_birthday2.jpg', '18th_birthday3.jpg'],
            ],
            'corporate-gala' => [
                'title' => 'Corporate Gala',
                'images' => ['corporate_gala1.jpg', 'corporate_gala2.jpg', 'corporate_gala3.jpg'],
            ],
            'garden-wedding' => [
                'title' => 'Garden Wedding',
                'images' => ['garden_wedding1.jpg', 'garden_wedding2.jpg', 'garden_wedding3.jpg'],
            ],
            'debut-celebration' => [
                'title' => 'Debut Celebration',
                'images' => ['debut_celebration1.jpg', 'debut_celebration2.jpg', 'debut_celebration3.jpg'],
            ],
            'anniversary-party' => [
                'title' => 'Anniversary Party',
                'images' => ['anniversary_party1.jpg', 'anniversary_party2.jpg', 'anniversary_party3.jpg'],
            ],
        ];

        $eventKey = is_string($event ?? null) ? $event : '';
        $selected = $eventGalleries[$eventKey] ?? null;
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
                    <button class="event-link" type="button" data-image="{{ asset('images/'.$image) }}" data-title="{{ $selected['title'] }}">
                        <img class="event-image" src="{{ asset('images/'.$image) }}" alt="{{ $selected['title'] }} photo">
                    </button>
                </div>
            @endforeach
        </div>
    @else
        <p style="text-align:center; margin-top: 18px;">
            No gallery found for this event.
        </p>
    @endif
</div>

<div class="lightbox" id="eventLightbox" aria-hidden="true">
    <div class="lightbox-content" role="dialog" aria-modal="true">
        <button class="lightbox-close" type="button" aria-label="Close">&times;</button>
        <img id="eventLightboxImage" src="" alt="">
        <p id="eventLightboxTitle"></p>
    </div>
</div>

<script>
    const eventLightbox = document.getElementById('eventLightbox');
    const eventLightboxImage = document.getElementById('eventLightboxImage');
    const eventLightboxTitle = document.getElementById('eventLightboxTitle');
    const eventCloseBtn = eventLightbox.querySelector('.lightbox-close');

    document.querySelectorAll('.event-link').forEach(btn => {
        btn.addEventListener('click', () => {
            eventLightboxImage.src = btn.dataset.image;
            eventLightboxImage.alt = btn.dataset.title || 'Event image';
            eventLightboxTitle.textContent = btn.dataset.title || '';
            eventLightbox.classList.add('open');
            eventLightbox.setAttribute('aria-hidden', 'false');
        });
    });

    function closeEventLightbox() {
        eventLightbox.classList.remove('open');
        eventLightbox.setAttribute('aria-hidden', 'true');
        eventLightboxImage.src = '';
    }

    eventCloseBtn.addEventListener('click', closeEventLightbox);
    eventLightbox.addEventListener('click', (e) => {
        if (e.target === eventLightbox) closeEventLightbox();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && eventLightbox.classList.contains('open')) {
            closeEventLightbox();
        }
    });
</script>
@endsection
