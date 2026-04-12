@extends('headerfooter')

@section('title', 'Contact Us | FLEUR')

@section('content')
<main class="contact-page">
  <h1 class="page-title" style="color: #8a3a45; font-size: 2.5rem;">GET IN TOUCH</h1>

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

<div class="message-overlay" id="messageSentOverlay" style="display: none;">
    <div class="message-card">
        <div class="message-icon">✓</div>
        <h2>Message Sent</h2>
        <p>Your message has been successfully sent. We will get back to you soon.</p>
        <button type="button" class="success-btn" id="messageSentCloseBtn">OK</button>
    </div>
</div>

<script>
  const contactForm = document.querySelector('.contact-form');
  const messageOverlay = document.getElementById('messageSentOverlay');
  const messageSentCloseBtn = document.getElementById('messageSentCloseBtn');

  function showMessageOverlay() {
    if (messageOverlay) {
      messageOverlay.style.display = 'flex';
    }
  }

  function hideMessageOverlay() {
    if (messageOverlay) {
      messageOverlay.style.display = 'none';
    }
  }

  contactForm.addEventListener('submit', (e) => {
    e.preventDefault();
    if (!contactForm.reportValidity()) return;
    showMessageOverlay();
    contactForm.reset();
  });

  if (messageSentCloseBtn) {
    messageSentCloseBtn.addEventListener('click', hideMessageOverlay);
  }

  if (messageOverlay) {
    messageOverlay.addEventListener('click', (e) => {
      if (e.target === messageOverlay) {
        hideMessageOverlay();
      }
    });
  }
</script>
@endsection
