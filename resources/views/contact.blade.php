@extends('headerfooter')

@section('title', 'Contact Us | FLEUR')

@section('content')
<main class="contact-page">
  <h1>GET IN TOUCH</h1>

  <div class="contact-grid">
    <form class="contact-form" action="#" method="post">
      <label for="name">Name</label>
      <input id="name" name="name" type="text" required>

      <label for="email">Email</label>
      <input id="email" name="email" type="email" required>

      <label for="subject">Subject</label>
      <input id="subject" name="subject" type="text" required>

      <label for="message">Message</label>
      <textarea id="message" name="message" rows="6" required></textarea>

      <div class="form-actions">
        <button type="submit" class="submit-btn">Submit</button>
      </div>
    </form>

    <aside class="contact-info">
      <div class="store-image">Store Image</div>
      <ul class="contact-list">
        <li>
          <span class="icon" aria-hidden="true"><i class="fa-solid fa-location-dot"></i></span>
          Lingayen, Pangasinan
        </li>
        <li>
          <span class="icon" aria-hidden="true"><i class="fa-solid fa-phone"></i></span>
          0912-345-6789
        </li>
        <li>
          <span class="icon" aria-hidden="true"><i class="fa-solid fa-envelope"></i></span>
          fleur@gmail.com
        </li>
        <li>
          <span class="icon" aria-hidden="true"><i class="fa-brands fa-facebook-f"></i></span>
          Fleur Shop
        </li>
      </ul>
    </aside>
  </div>
</main>
@endsection
