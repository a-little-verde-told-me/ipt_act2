@extends('headerfooter') {{-- No need for layouts. prefix if it's in the main views folder --}}

@section('title', 'About Us | FLEUR')

@section('content')
<div class="about-container">
    <section class="about-content">
        <div class="about-text">
            <h1>OUR STORY</h1>
            <p>Lorem ipsum dolor sit amet...</p>
        </div>
        <div class="about-image">
            <div class="image-placeholder">
                <span>Image our team/founder</span>
            </div>
        </div>
    </section>
</div>
@endsection