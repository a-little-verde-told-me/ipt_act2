<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FLEUR – Contact Us</title>
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
  <header>
    <div class="logo"><span class="logo-circle"></span>FLEUR</div>
    <nav class="nav-links">
      <a href="home.php">Home</a>
      <a href="flowers.php">Flowers</a>
      <a href="about.php">About</a>
      <a href="gallery.php">Gallery</a>
      <a href="/contact">Contact Us</a>
      <a href="login.php" class="btn-login">Login</a>
    </nav>
  </header>

  <main class="contact-page">
    <h1>GET IN TOUCH</h1>

    <div class="contact-grid">
      <form class="contact-form" action="#" method="post">
        <label for="name">Name</label>
        <input id="name" name="name" type="text" placeholder="Your name" required>

        <label for="email">Email</label>
        <input id="email" name="email" type="email" placeholder="Your email" required>

        <label for="subject">Subject</label>
        <input id="subject" name="subject" type="text" placeholder="Subject" required>

        <label for="message">Message</label>
        <textarea id="message" name="message" rows="6" placeholder="Write your message" required></textarea>

        <button type="submit" class="submit-btn">Submit</button>
      </form>

      <aside class="contact-info">
        <div class="store-image">Store Image</div>
        <ul>
          <li><span class="icon">📍</span> Lingayen, Pangasinan</li>
          <li><span class="icon">📞</span> 0912-345-6789</li>
          <li><span class="icon">✉️</span> fleur@gmail.com</li>
          <li><span class="icon">🔵</span> Fleur Shop</li>
        </ul>
      </aside>
    </div>
  </main>

  <footer>&copy; 2026 Fleur. All rights reserved.</footer>
</body>
</html>
