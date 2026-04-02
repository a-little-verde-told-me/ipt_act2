@extends('headerfooter')

@section('title', 'Contact Us | FLEUR')

@section('content')
<div class="contact-container">
    <div class="contact-wrapper">
        
        <div class="contact-form-section">
            <h1>GET IN TOUCH</h1>
            <form action="#" method="POST" class="contact-form">
                @csrf {{-- Laravel security token --}}
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" required>
                </div>

                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="8" required></textarea>
                </div>

                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>

        <div class="contact-info-section">
            <div class="store-image-placeholder">
                <span>Store Image</span>
            </div>
            
            <div class="info-details">
                <p class="location">Lingayen, Pangasinan</p>
                
                <div class="info-item">
                    <span class="icon">📞</span>
                    <p>0912-345-6789</p>
                </div>

                <div class="info-item">
                    <span class="icon">✉️</span>
                    <p>fleur@gmail.com</p>
                </div>

                <div class="info-item">
                    <span class="icon">👤</span>
                    <p>Fleur Shop</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection