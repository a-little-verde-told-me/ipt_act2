@extends('headerfooter')

@section('title', 'Customize Bouquet | FLEUR')

@section('content')
<div class="customize-page">
    <section class="customize-hero">
        <h1>Customize Your Bouquet</h1>
        <p>Pick the mood, flowers, and budget — we’ll handle the arrangement and delivery.</p>
    </section>

    <form class="customize-form" action="{{ route('customize.submit') }}" method="post" novalidate>
        @csrf
        <label for="occasion">Occasion</label>
        <select id="occasion" name="occasion" required>
            <option value="">Select an occasion</option>
            <option value="Birthday">Birthday</option>
            <option value="Anniversary">Anniversary</option>
            <option value="Wedding">Wedding</option>
            <option value="Graduation">Graduation</option>
            <option value="Just Because">Just Because</option>
        </select>

        <label for="budget">Budget Range (PHP)</label>
        <select id="budget" name="budget" required>
            <option value="">Choose budget</option>
            <option value="1000-2000">₱1,000 - ₱2,000</option>
            <option value="2000-3500">₱2,000 - ₱3,500</option>
            <option value="3500-5000">₱3,500 - ₱5,000</option>
            <option value="5000+">₱5,000+</option>
        </select>

        <label for="flowers">Preferred Flowers</label>
        <input id="flowers" type="text" name="flowers" placeholder="Rose, tulips, sunflower">

        <label for="colors">Color Palette</label>
        <input id="colors" type="text" name="colors" placeholder="Blush, white, sage">

        <label for="notes">Notes / Theme</label>
        <textarea id="notes" name="notes" rows="4" placeholder="Describe the style you want"></textarea>

        <button type="submit" class="submit-btn">Send Custom Request</button>
    </form>

    @if(!empty($success))
        <p style="margin-top:16px; font-weight:600; color:#2f5d50;">Custom request submitted successfully.</p>
    @endif
</div>
@endsection
