<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register</title>
    @vite(['resources/css/style.css', 'resources/css/login-register.css', 'resources/js/app.js'])
  </head>

  <body class="page-layout">
    <div data-site-header></div>
    <main class="page-main">
      <section class="register-section">
        <div class="register-container">
          <form class="register-card" action="{{ route('register.store') }}" method="post" novalidate>
            @csrf
            <h2 class="register-title">Register</h2>

            @if ($errors->any())
              <div class="form-alert form-alert-error" role="alert" aria-live="polite">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <label class="form-label"
              >Email
              <input
                type="email"
                name="email"
                placeholder="you@example.com"
                value="{{ old('email') }}"
                required
              />
            </label>

            <label class="form-label"
              >Password
              <input
                type="password"
                name="password"
                placeholder="Enter your password"
                required
              />
            </label>
            <button class="register-btn" type="submit">Register</button>
          </form>
        </div>
      </section>
    </main>

    <footer class="site-footer">
      <div class="footer-inner">
        <div class="footer-top">
          <div class="footer-brand">
            <div class="brand-logo" aria-hidden="true">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
              >
                <path
                  d="M10 5.83325V17.4999"
                  stroke="white"
                  stroke-width="1.66667"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
                <path
                  d="M2.50008 15C2.27907 15 2.06711 14.9122 1.91083 14.7559C1.75455 14.5996 1.66675 14.3877 1.66675 14.1667V3.33333C1.66675 3.11232 1.75455 2.90036 1.91083 2.74408C2.06711 2.5878 2.27907 2.5 2.50008 2.5H6.66675C7.5508 2.5 8.39865 2.85119 9.02377 3.47631C9.64889 4.10143 10.0001 4.94928 10.0001 5.83333C10.0001 4.94928 10.3513 4.10143 10.9764 3.47631C11.6015 2.85119 12.4494 2.5 13.3334 2.5H17.5001C17.7211 2.5 17.9331 2.5878 18.0893 2.74408C18.2456 2.90036 18.3334 3.11232 18.3334 3.33333V14.1667C18.3334 14.3877 18.2456 14.5996 18.0893 14.7559C17.9331 14.9122 17.7211 15 17.5001 15H12.5001C11.837 15 11.2012 15.2634 10.7323 15.7322C10.2635 16.2011 10.0001 16.837 10.0001 17.5C10.0001 16.837 9.73669 16.2011 9.26785 15.7322C8.79901 15.2634 8.16312 15 7.50008 15H2.50008Z"
                  stroke="white"
                  stroke-width="1.66667"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </div>
            <div class="brand-copy">
              <div class="brand-name">Eunoia</div>
              <p>
                Your destination for discovering stories that matter. Curated
                with care since 2020.
              </p>
            </div>
          </div>

          <div class="footer-nav">
            <div class="nav-col">
              <div class="nav-heading">Shop</div>
              <ul>
                <li><a href="category-template.html">Categories</a></li>
                <li><a href="#">Bestsellers</a></li>
                <li><a href="#">New Arrivals</a></li>
                <li><a href="#">Sale</a></li>
              </ul>
            </div>

            <div class="nav-col">
              <div class="nav-heading">Company</div>
              <ul>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">Careers</a></li>
                <li><a href="#">Blog</a></li>
              </ul>
            </div>

            <div class="nav-col">
              <div class="nav-heading">Support</div>
              <ul>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Shipping</a></li>
                <li><a href="#">Returns</a></li>
                <li><a href="#">Privacy</a></li>
              </ul>
            </div>
          </div>
        </div>

        <div class="footer-bottom">
          <div class="copyright">© 2026 Eunoia. All rights reserved.</div>
          <div class="made-with">Made with care for book lovers everywhere</div>
        </div>
      </div>
    </footer>
  </body>
</html>
