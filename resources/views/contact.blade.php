@extends('headerfooter')

@section('title', 'Contact Us | FLEUR')

@section('content')
<main class="contact-page">
  <h1 class="page-title">GET IN TOUCH</h1>

  <div class="contact-grid">
    <form class="contact-form" action="#" method="post">
      <h3>Send us a Message</h3>
      
      <label for="name">Name</label>
      <input id="name" name="name" type="text" required>

      <label for="email">Email</label>
      <input id="email" name="email" type="email" required>

      <label for="subject">Subject</label>
      <input id="subject" name="subject" type="text" required>

      <label for="message">Message</label>
      <textarea id="message" name="message" rows="5" required></textarea>

      <button type="submit" class="submit-btn">Send Message</button>
    </form>

    <aside class="contact-info">
      <div class="store-image">
        <img src="{{ asset('images/store_image.jpg') }}" alt="Store Image">
      </div>
      <div class="info-section">
        <h3>Contact Information</h3>
        <ul class="contact-list">
          <li>
            <span class="icon" aria-hidden="true"><i class="fa-solid fa-location-dot"></i></span>
            <span>Lingayen, Pangasinan</span>
          </li>
          <li>
            <span class="icon" aria-hidden="true"><i class="fa-solid fa-phone"></i></span>
            <span>0912-345-6789</span>
          </li>
          <li>
            <span class="icon" aria-hidden="true"><i class="fa-solid fa-envelope"></i></span>
            <span>fleur@gmail.com</span>
          </li>
          <li>
            <span class="icon" aria-hidden="true"><i class="fa-brands fa-facebook-f"></i></span>
            <span>Fleur Shop</span>
          </li>
        </ul>
      </div>
    </aside>
  </div>
</main>

<script>
  const contactForm = document.querySelector('.contact-form');
  contactForm.addEventListener('submit', (e) => {
    e.preventDefault();
    if (!contactForm.reportValidity()) return;
    alert('Message sent! We will get back to you soon.');
    contactForm.reset();
  });
</script>
@endsection
