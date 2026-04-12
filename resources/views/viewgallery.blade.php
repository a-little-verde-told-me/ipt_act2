@extends('headerfooter')

@section('title', 'Event Gallery | FLEUR')

@section('content')
<div class="gallery-container">
    <h1 class="page-title" style="color: #8a3a45; font-size: 2.5rem;">
        {{ $event ? strtoupper($event->name).' GALLERY' : 'EVENT GALLERY' }}
    </h1>

    <div class="filter-section">
        <a class="filter-btn active" href="{{ route('gallery') }}">Back to Gallery</a>
    </div>

    @if($event && $images)
        <div class="gallery-grid">
            @foreach($images as $image)
                <div class="event-card">
                    <button class="event-link" type="button" data-image="{{ asset('images/gallery/'.$image->image) }}" data-title="{{ $event->name }}">
                        <img class="event-image" src="{{ asset('images/gallery/'.$image->image) }}" alt="{{ $event->name }} photo">
                    </button>
                </div>
            @endforeach
        </div>

        @if ($images->hasPages())
            <div class="pagination-wrapper">
                {{ $images->links('pagination::custom') }}
            </div>
        @endif
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
