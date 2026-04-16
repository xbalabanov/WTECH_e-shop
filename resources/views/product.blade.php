<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $book->title ?? 'Product' }}</title>
    @vite(['resources/css/style.css', 'resources/css/product.css', 'resources/js/app.js'])
  </head>
  <body>
    <header class="site-header">
      <input
        type="checkbox"
        id="nav-toggle"
        class="nav-toggle"
        aria-hidden="true"
      />
      <div class="header-inner">
        <a href="/homepage.html" class="logo" aria-label="Eunoia home">
          <div class="logo-icon" aria-hidden="true">
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
          <div class="logo-text">Eunoia</div>
        </a>

        <div class="center">
          <nav class="main-nav" aria-label="Main navigation">
            <ul>
              <li><a href="/category-template.html">Categories</a></li>
              <li><a href="/homepage.html">Trending</a></li>
              <li><a href="/homepage.html">New Arrivals</a></li>
              <li><a href="/homepage.html">Coming Soon</a></li>
              <li><a href="/category-template.html">Sale</a></li>
            </ul>
          </nav>

          <form class="header-search" role="search" aria-label="Search books" method="GET" action="/category-template.html">
            <button class="search-icon" type="submit" aria-label="Search">
              <svg
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M11 4a7 7 0 1 0 0 14 7 7 0 0 0 0-14zm8.707 15.293-4.386-4.386"
                  stroke="#777"
                  stroke-width="1.6"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </button>
            <input
              class="search-input"
              type="search"
              name="q"
              placeholder="Search books..."
              aria-label="Search books"
              value="{{ request('q', '') }}"
            />
          </form>
        </div>

        <div class="header-actions">
          <a class="icon" href="/profile.html" aria-label="Profile">
            <svg
              width="18"
              height="20"
              viewBox="0 0 18 20"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M16.75 19C16.75 16.2386 13.2242 14 8.875 14C4.52576 14 1 16.2386 1 19M8.875 11C6.15672 11 3.95312 8.76142 3.95312 6C3.95312 3.23858 6.15672 1 8.875 1C11.5933 1 13.7969 3.23858 13.7969 6C13.7969 8.76142 11.5933 11 8.875 11Z"
                stroke="black"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
          </a>
          <a class="icon cart-icon" href="/cart.html" aria-label="Cart">
            <svg
              width="20"
              height="20"
              viewBox="0 0 20 20"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M1 1H1.27244C1.75344 1 1.99436 1 2.19054 1.08548C2.36351 1.16085 2.5114 1.28218 2.61804 1.43604C2.7388 1.61026 2.7824 1.8429 2.86944 2.30728L5.06101 14L15.6416 14C16.1017 14 16.3325 14 16.5231 13.9199C16.6914 13.8492 16.8366 13.7346 16.9444 13.5889C17.0664 13.4242 17.118 13.2037 17.2213 12.7631L17.2221 12.76L18.8152 5.95996L18.8155 5.95854C18.9721 5.29016 19.0506 4.95516 18.9644 4.69239C18.8888 4.46183 18.7297 4.26635 18.5186 4.14192C18.2778 4 17.93 4 17.2324 4H3.5381M16.2286 19C15.6679 19 15.2134 18.5523 15.2134 18C15.2134 17.4477 15.6679 17 16.2286 17C16.7893 17 17.2439 17.4477 17.2439 18C17.2439 18.5523 16.7893 19 16.2286 19ZM6.07621 19C5.51551 19 5.06097 18.5523 5.06097 18C5.06097 17.4477 5.51551 17 6.07621 17C6.63691 17 7.09145 17.4477 7.09145 18C7.09145 18.5523 6.63691 19 6.07621 19Z"
                stroke="black"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
            <span class="icon-badge" data-cart-count aria-hidden="true">{{ collect((array) session('cart', []))->sum(fn($q) => max(0, (int) $q)) }}</span>
          </a>
          <label
            for="nav-toggle"
            class="menu-toggle"
            aria-controls="mobile-nav"
            aria-label="Toggle menu"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="20"
              height="20"
              viewBox="0 0 20 20"
              fill="none"
            >
              <path
                d="M3.33252 9.99805H16.6633"
                stroke="#0A0A0A"
                stroke-width="1.66635"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
              <path
                d="M3.33252 4.99902H16.6633"
                stroke="#0A0A0A"
                stroke-width="1.66635"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
              <path
                d="M3.33252 14.9971H16.6633"
                stroke="#0A0A0A"
                stroke-width="1.66635"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
          </label>
        </div>
      </div>

      <div id="mobile-nav" class="mobile-nav-panel" aria-hidden="false">
        <nav class="mobile-nav" aria-label="Mobile navigation">
          <ul>
            <li><a href="/category-template.html">Categories</a></li>
            <li><a href="/homepage.html">Trending</a></li>
            <li><a href="/homepage.html">New Arrivals</a></li>
            <li><a href="/homepage.html">Coming Soon</a></li>
            <li><a href="/category-template.html">Sale</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <main>
      <div class="main-product-section">
        <div
          class="product-image"
          @if (!empty($book?->cover_image_url))
            style="background-image: url('{{ $book->cover_image_url }}'); background-size: cover; background-position: center;"
          @endif
        ></div>
        <div class="product-details">
          <h1 class="product-title">{{ $book->title }}</h1>
          <p class="product-author">{{ $book->authors?->pluck('full_name')->join(', ') ?: 'Unknown author' }}</p>
          <p class="product-description">
            {{ $book->description ?: 'No description available for this book yet.' }}
          </p>
          <p class="product-book-type">{{ $book->genre ?? 'General' }}</p>
          <p class="product-price">
            {{ number_format((float) $book->discounted_price, 2, ',', '.') }}€
            <span class="product-discount-badge">-{{ (int) ($book->discount ?? 0) }}%</span>
          </p>
          <div class="product-actions">
            @if (($cartQty ?? 0) > 0)
              <div class="product-qty" aria-label="Cart quantity controls">
                <form method="POST" action="{{ route('cart.update') }}">
                  @csrf
                  <input type="hidden" name="book_id" value="{{ $book->id }}" />
                  <input type="hidden" name="quantity" value="{{ max(0, (int) $cartQty - 1) }}" />
                  <button type="submit" class="product-qty-btn" aria-label="Decrease quantity">−</button>
                </form>
                <span class="product-qty-count" aria-live="polite">{{ (int) $cartQty }}</span>
                <form method="POST" action="{{ route('cart.update') }}">
                  @csrf
                  <input type="hidden" name="book_id" value="{{ $book->id }}" />
                  <input type="hidden" name="quantity" value="{{ min(99, (int) $cartQty + 1) }}" />
                  <button type="submit" class="product-qty-btn" aria-label="Increase quantity">+</button>
                </form>
              </div>
            @else
              <form method="POST" action="{{ route('cart.add') }}">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}" />
                <input type="hidden" name="quantity" value="1" />
                <button class="add-to-cart" type="submit" aria-label="Add to cart">
                  <svg
                    class="icon"
                    xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                  >
                    <path
                      d="M1 1H1.27244C1.75344 1 1.99436 1 2.19054 1.08548C2.36351 1.16084 2.5114 1.28218 2.61804 1.43604C2.7388 1.61026 2.7824 1.8429 2.86944 2.30727L5.06101 14L15.6416 14C16.1017 14 16.3325 14 16.5231 13.9199C16.6914 13.8492 16.8366 13.7346 16.9444 13.5889C17.0664 13.4242 17.118 13.2037 17.2213 12.7631L17.2221 12.76L18.8152 5.95996L18.8155 5.95854C18.9721 5.29016 19.0506 4.95515 18.9644 4.69238C18.8888 4.46182 18.7297 4.26634 18.5186 4.14192C18.2778 4 17.93 4 17.2324 4H3.5381M16.2286 19C15.6679 19 15.2134 18.5523 15.2134 18C15.2134 17.4477 15.6679 17 16.2286 17C16.7893 17 17.2439 17.4477 17.2439 18C17.2439 18.5523 16.7893 19 16.2286 19ZM6.07621 19C5.51551 19 5.06097 18.5523 5.06097 18C5.06097 17.4477 5.51551 17 6.07621 17C6.63691 17 7.09145 17.4477 7.09145 18C7.09145 18.5523 6.63691 19 6.07621 19Z"
                      stroke="white"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                  Add to Cart
                </button>
              </form>
            @endif
            <button
              class="add-to-favourite"
              type="button"
              aria-label="Add to favourites"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="22"
                height="21"
                viewBox="0 0 22 21"
                fill="none"
              >
                <path
                  d="M1.16211 8.64292C0.848859 8.35324 1.01902 7.82955 1.44271 7.77931L7.44629 7.06722C7.61897 7.04674 7.76896 6.93831 7.8418 6.7804L10.374 1.29061C10.5527 0.903178 11.1035 0.903104 11.2822 1.29054L13.8145 6.78029C13.8873 6.93819 14.0363 7.04692 14.209 7.0674L20.2129 7.77931C20.6366 7.82955 20.8063 8.35339 20.493 8.64308L16.0549 12.7481C15.9272 12.8661 15.8704 13.0419 15.9043 13.2124L17.0822 19.1421C17.1653 19.5606 16.7199 19.8848 16.3476 19.6764L11.0723 16.7228C10.9206 16.6378 10.7362 16.6382 10.5845 16.7232L5.30859 19.6757C4.93628 19.8841 4.49009 19.5606 4.57324 19.1421L5.75129 13.2128C5.78518 13.0422 5.72848 12.8661 5.60082 12.748L1.16211 8.64292Z"
                  stroke="#ec7357"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <section class="reviews-section" aria-labelledby="reviews-title">
        <h2 id="reviews-title" class="reviews-title">Reviews</h2>

        <div class="reviews-list">
          <article class="review-card" aria-label="Review by John Doe">
            <div class="review-top">
              <div class="review-avatar" aria-hidden="true">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="20"
                  height="20"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="lucide lucide-user"
                >
                  <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                  <circle cx="12" cy="7" r="4" />
                </svg>
              </div>
              <div class="review-meta">
                <p class="review-author">Name</p>
                <div class="review-rating" aria-label="Rating 4 out of 5">
                  <span class="stars">★★★★☆</span>
                </div>
              </div>
            </div>
            <blockquote class="review-quote">
              Lorem ipsum dolor sit amet consectetur. Vestibulum consectetur
              viverra in tempus a nisl integer. Euismod adipiscing gravida enim
              venenatis dis ultrices. Nulla lacus ac semper odio sit viverra
              adipiscing facilisis pellentesque. Cras netus elementum urna odio
              pharetra nunc. Tortor sollicitudin viverra in tincidunt bibendum
              consequat leo.
            </blockquote>
          </article>

          <article class="review-card" aria-label="Review by Jane Smith">
            <div class="review-top">
              <div class="review-avatar" aria-hidden="true">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="20"
                  height="20"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="lucide lucide-user"
                >
                  <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                  <circle cx="12" cy="7" r="4" />
                </svg>
              </div>
              <div class="review-meta">
                <p class="review-author">Name</p>
                <div class="review-rating" aria-label="Rating 5 out of 5">
                  <span class="stars">★★★★★</span>
                </div>
              </div>
            </div>
            <blockquote class="review-quote">
              Lorem ipsum dolor sit amet consectetur. Vestibulum consectetur
              viverra in tempus a nisl integer. Euismod adipiscing gravida enim
              venenatis dis ultrices.
            </blockquote>
          </article>
        </div>
      </section>

      <section class="recomended" aria-labelledby="recommended-title">
        <h2 id="recommended-title" class="recomended-title">Recommended</h2>

        <div class="recomended-cards">
          <article class="card" role="group">
            <div class="cover" aria-hidden="true"></div>
            <div class="card-elements">
              <div class="card-title">
                <h3 class="title">Book Name</h3>
                <p class="author">Author</p>
              </div>
              <p class="card-description">
                Lorem ipsum dolor sit amet consectetur. Ut at tellus aenean
                tristique. Parturient pharetra id vitae ut volutpat mattis...
              </p>
              <div class="card-info-container">
                <p class="card-book-type">Genre</p>
                <div class="price">0,00€ <span class="badge">-0%</span></div>
              </div>
              <div class="card-actions">
                <button class="card-cart-button" type="button">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                  >
                    <path
                      d="M1 1H1.27244C1.75344 1 1.99436 1 2.19054 1.08548C2.36351 1.16084 2.5114 1.28218 2.61804 1.43604C2.7388 1.61026 2.7824 1.8429 2.86944 2.30727L5.06101 14L15.6416 14C16.1017 14 16.3325 14 16.5231 13.9199C16.6914 13.8492 16.8366 13.7346 16.9444 13.5889C17.0664 13.4242 17.118 13.2037 17.2213 12.7631L17.2221 12.76L18.8152 5.95996L18.8155 5.95854C18.9721 5.29016 19.0506 4.95515 18.9644 4.69238C18.8888 4.46182 18.7297 4.26634 18.5186 4.14192C18.2778 4 17.93 4 17.2324 4H3.5381M16.2286 19C15.6679 19 15.2134 18.5523 15.2134 18C15.2134 17.4477 15.6679 17 16.2286 17C16.7893 17 17.2439 17.4477 17.2439 18C17.2439 18.5523 16.7893 19 16.2286 19ZM6.07621 19C5.51551 19 5.06097 18.5523 5.06097 18C5.06097 17.4477 5.51551 17 6.07621 17C6.63691 17 7.09145 17.4477 7.09145 18C7.09145 18.5523 6.63691 19 6.07621 19Z"
                      stroke="white"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                  Add to cart
                </button>
                <button
                  class="card-favourite-button"
                  type="button"
                  aria-label="Add to favourites"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="22"
                    height="21"
                    viewBox="0 0 22 21"
                    fill="none"
                  >
                    <path
                      d="M1.16211 8.64292C0.848859 8.35324 1.01902 7.82955 1.44271 7.77931L7.44629 7.06722C7.61897 7.04674 7.76896 6.93831 7.8418 6.7804L10.374 1.29061C10.5527 0.903178 11.1035 0.903104 11.2822 1.29054L13.8145 6.78029C13.8873 6.93819 14.0363 7.04692 14.209 7.0674L20.2129 7.77931C20.6366 7.82955 20.8063 8.35339 20.493 8.64308L16.0549 12.7481C15.9272 12.8661 15.8704 13.0419 15.9043 13.2124L17.0822 19.1421C17.1653 19.5606 16.7199 19.8848 16.3476 19.6764L11.0723 16.7228C10.9206 16.6378 10.7362 16.6382 10.5845 16.7232L5.30859 19.6757C4.93628 19.8841 4.49009 19.5606 4.57324 19.1421L5.75129 13.2128C5.78518 13.0422 5.72848 12.8661 5.60082 12.748L1.16211 8.64292Z"
                      stroke="#ec7357"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </article>
          <article class="card" role="group">
            <div class="cover" aria-hidden="true"></div>
            <div class="card-elements">
              <div class="card-title">
                <h3 class="title">Book Name</h3>
                <p class="author">Author</p>
              </div>
              <p class="card-description">
                Lorem ipsum dolor sit amet consectetur. Ut at tellus aenean
                tristique. Parturient pharetra id vitae ut volutpat mattis...
              </p>
              <div class="card-info-container">
                <p class="card-book-type">Genre</p>
                <div class="price">0,00€ <span class="badge">-0%</span></div>
              </div>
              <div class="card-actions">
                <button class="card-cart-button" type="button">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                  >
                    <path
                      d="M1 1H1.27244C1.75344 1 1.99436 1 2.19054 1.08548C2.36351 1.16084 2.5114 1.28218 2.61804 1.43604C2.7388 1.61026 2.7824 1.8429 2.86944 2.30727L5.06101 14L15.6416 14C16.1017 14 16.3325 14 16.5231 13.9199C16.6914 13.8492 16.8366 13.7346 16.9444 13.5889C17.0664 13.4242 17.118 13.2037 17.2213 12.7631L17.2221 12.76L18.8152 5.95996L18.8155 5.95854C18.9721 5.29016 19.0506 4.95515 18.9644 4.69238C18.8888 4.46182 18.7297 4.26634 18.5186 4.14192C18.2778 4 17.93 4 17.2324 4H3.5381M16.2286 19C15.6679 19 15.2134 18.5523 15.2134 18C15.2134 17.4477 15.6679 17 16.2286 17C16.7893 17 17.2439 17.4477 17.2439 18C17.2439 18.5523 16.7893 19 16.2286 19ZM6.07621 19C5.51551 19 5.06097 18.5523 5.06097 18C5.06097 17.4477 5.51551 17 6.07621 17C6.63691 17 7.09145 17.4477 7.09145 18C7.09145 18.5523 6.63691 19 6.07621 19Z"
                      stroke="white"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                  Add to cart
                </button>
                <button
                  class="card-favourite-button"
                  type="button"
                  aria-label="Add to favourites"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="22"
                    height="21"
                    viewBox="0 0 22 21"
                    fill="none"
                  >
                    <path
                      d="M1.16211 8.64292C0.848859 8.35324 1.01902 7.82955 1.44271 7.77931L7.44629 7.06722C7.61897 7.04674 7.76896 6.93831 7.8418 6.7804L10.374 1.29061C10.5527 0.903178 11.1035 0.903104 11.2822 1.29054L13.8145 6.78029C13.8873 6.93819 14.0363 7.04692 14.209 7.0674L20.2129 7.77931C20.6366 7.82955 20.8063 8.35339 20.493 8.64308L16.0549 12.7481C15.9272 12.8661 15.8704 13.0419 15.9043 13.2124L17.0822 19.1421C17.1653 19.5606 16.7199 19.8848 16.3476 19.6764L11.0723 16.7228C10.9206 16.6378 10.7362 16.6382 10.5845 16.7232L5.30859 19.6757C4.93628 19.8841 4.49009 19.5606 4.57324 19.1421L5.75129 13.2128C5.78518 13.0422 5.72848 12.8661 5.60082 12.748L1.16211 8.64292Z"
                      stroke="#ec7357"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </article>
          <article class="card" role="group">
            <div class="cover" aria-hidden="true"></div>
            <div class="card-elements">
              <div class="card-title">
                <h3 class="title">Book Name</h3>
                <p class="author">Author</p>
              </div>
              <p class="card-description">
                Lorem ipsum dolor sit amet consectetur. Ut at tellus aenean
                tristique. Parturient pharetra id vitae ut volutpat mattis...
              </p>
              <div class="card-info-container">
                <p class="card-book-type">Genre</p>
                <div class="price">0,00€ <span class="badge">-0%</span></div>
              </div>
              <div class="card-actions">
                <button class="card-cart-button" type="button">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                  >
                    <path
                      d="M1 1H1.27244C1.75344 1 1.99436 1 2.19054 1.08548C2.36351 1.16084 2.5114 1.28218 2.61804 1.43604C2.7388 1.61026 2.7824 1.8429 2.86944 2.30727L5.06101 14L15.6416 14C16.1017 14 16.3325 14 16.5231 13.9199C16.6914 13.8492 16.8366 13.7346 16.9444 13.5889C17.0664 13.4242 17.118 13.2037 17.2213 12.7631L17.2221 12.76L18.8152 5.95996L18.8155 5.95854C18.9721 5.29016 19.0506 4.95515 18.9644 4.69238C18.8888 4.46182 18.7297 4.26634 18.5186 4.14192C18.2778 4 17.93 4 17.2324 4H3.5381M16.2286 19C15.6679 19 15.2134 18.5523 15.2134 18C15.2134 17.4477 15.6679 17 16.2286 17C16.7893 17 17.2439 17.4477 17.2439 18C17.2439 18.5523 16.7893 19 16.2286 19ZM6.07621 19C5.51551 19 5.06097 18.5523 5.06097 18C5.06097 17.4477 5.51551 17 6.07621 17C6.63691 17 7.09145 17.4477 7.09145 18C7.09145 18.5523 6.63691 19 6.07621 19Z"
                      stroke="white"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                  Add to cart
                </button>
                <button
                  class="card-favourite-button"
                  type="button"
                  aria-label="Add to favourites"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="22"
                    height="21"
                    viewBox="0 0 22 21"
                    fill="none"
                  >
                    <path
                      d="M1.16211 8.64292C0.848859 8.35324 1.01902 7.82955 1.44271 7.77931L7.44629 7.06722C7.61897 7.04674 7.76896 6.93831 7.8418 6.7804L10.374 1.29061C10.5527 0.903178 11.1035 0.903104 11.2822 1.29054L13.8145 6.78029C13.8873 6.93819 14.0363 7.04692 14.209 7.0674L20.2129 7.77931C20.6366 7.82955 20.8063 8.35339 20.493 8.64308L16.0549 12.7481C15.9272 12.8661 15.8704 13.0419 15.9043 13.2124L17.0822 19.1421C17.1653 19.5606 16.7199 19.8848 16.3476 19.6764L11.0723 16.7228C10.9206 16.6378 10.7362 16.6382 10.5845 16.7232L5.30859 19.6757C4.93628 19.8841 4.49009 19.5606 4.57324 19.1421L5.75129 13.2128C5.78518 13.0422 5.72848 12.8661 5.60082 12.748L1.16211 8.64292Z"
                      stroke="#ec7357"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </article>
          <article class="card" role="group">
            <div class="cover" aria-hidden="true"></div>
            <div class="card-elements">
              <div class="card-title">
                <h3 class="title">Book Name</h3>
                <p class="author">Author</p>
              </div>
              <p class="card-description">
                Lorem ipsum dolor sit amet consectetur. Ut at tellus aenean
                tristique. Parturient pharetra id vitae ut volutpat mattis...
              </p>
              <div class="card-info-container">
                <p class="card-book-type">Genre</p>
                <div class="price">0,00€ <span class="badge">-0%</span></div>
              </div>
              <div class="card-actions">
                <button class="card-cart-button" type="button">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                  >
                    <path
                      d="M1 1H1.27244C1.75344 1 1.99436 1 2.19054 1.08548C2.36351 1.16084 2.5114 1.28218 2.61804 1.43604C2.7388 1.61026 2.7824 1.8429 2.86944 2.30727L5.06101 14L15.6416 14C16.1017 14 16.3325 14 16.5231 13.9199C16.6914 13.8492 16.8366 13.7346 16.9444 13.5889C17.0664 13.4242 17.118 13.2037 17.2213 12.7631L17.2221 12.76L18.8152 5.95996L18.8155 5.95854C18.9721 5.29016 19.0506 4.95515 18.9644 4.69238C18.8888 4.46182 18.7297 4.26634 18.5186 4.14192C18.2778 4 17.93 4 17.2324 4H3.5381M16.2286 19C15.6679 19 15.2134 18.5523 15.2134 18C15.2134 17.4477 15.6679 17 16.2286 17C16.7893 17 17.2439 17.4477 17.2439 18C17.2439 18.5523 16.7893 19 16.2286 19ZM6.07621 19C5.51551 19 5.06097 18.5523 5.06097 18C5.06097 17.4477 5.51551 17 6.07621 17C6.63691 17 7.09145 17.4477 7.09145 18C7.09145 18.5523 6.63691 19 6.07621 19Z"
                      stroke="white"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                  Add to cart
                </button>
                <button
                  class="card-favourite-button"
                  type="button"
                  aria-label="Add to favourites"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="22"
                    height="21"
                    viewBox="0 0 22 21"
                    fill="none"
                  >
                    <path
                      d="M1.16211 8.64292C0.848859 8.35324 1.01902 7.82955 1.44271 7.77931L7.44629 7.06722C7.61897 7.04674 7.76896 6.93831 7.8418 6.7804L10.374 1.29061C10.5527 0.903178 11.1035 0.903104 11.2822 1.29054L13.8145 6.78029C13.8873 6.93819 14.0363 7.04692 14.209 7.0674L20.2129 7.77931C20.6366 7.82955 20.8063 8.35339 20.493 8.64308L16.0549 12.7481C15.9272 12.8661 15.8704 13.0419 15.9043 13.2124L17.0822 19.1421C17.1653 19.5606 16.7199 19.8848 16.3476 19.6764L11.0723 16.7228C10.9206 16.6378 10.7362 16.6382 10.5845 16.7232L5.30859 19.6757C4.93628 19.8841 4.49009 19.5606 4.57324 19.1421L5.75129 13.2128C5.78518 13.0422 5.72848 12.8661 5.60082 12.748L1.16211 8.64292Z"
                      stroke="#ec7357"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </article>
          <article class="card" role="group">
            <div class="cover" aria-hidden="true"></div>
            <div class="card-elements">
              <div class="card-title">
                <h3 class="title">Book Name</h3>
                <p class="author">Author</p>
              </div>
              <p class="card-description">
                Lorem ipsum dolor sit amet consectetur. Ut at tellus aenean
                tristique. Parturient pharetra id vitae ut volutpat mattis...
              </p>
              <div class="card-info-container">
                <p class="card-book-type">Genre</p>
                <div class="price">0,00€ <span class="badge">-0%</span></div>
              </div>
              <div class="card-actions">
                <button class="card-cart-button" type="button">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                  >
                    <path
                      d="M1 1H1.27244C1.75344 1 1.99436 1 2.19054 1.08548C2.36351 1.16084 2.5114 1.28218 2.61804 1.43604C2.7388 1.61026 2.7824 1.8429 2.86944 2.30727L5.06101 14L15.6416 14C16.1017 14 16.3325 14 16.5231 13.9199C16.6914 13.8492 16.8366 13.7346 16.9444 13.5889C17.0664 13.4242 17.118 13.2037 17.2213 12.7631L17.2221 12.76L18.8152 5.95996L18.8155 5.95854C18.9721 5.29016 19.0506 4.95515 18.9644 4.69238C18.8888 4.46182 18.7297 4.26634 18.5186 4.14192C18.2778 4 17.93 4 17.2324 4H3.5381M16.2286 19C15.6679 19 15.2134 18.5523 15.2134 18C15.2134 17.4477 15.6679 17 16.2286 17C16.7893 17 17.2439 17.4477 17.2439 18C17.2439 18.5523 16.7893 19 16.2286 19ZM6.07621 19C5.51551 19 5.06097 18.5523 5.06097 18C5.06097 17.4477 5.51551 17 6.07621 17C6.63691 17 7.09145 17.4477 7.09145 18C7.09145 18.5523 6.63691 19 6.07621 19Z"
                      stroke="white"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                  Add to cart
                </button>
                <button
                  class="card-favourite-button"
                  type="button"
                  aria-label="Add to favourites"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="22"
                    height="21"
                    viewBox="0 0 22 21"
                    fill="none"
                  >
                    <path
                      d="M1.16211 8.64292C0.848859 8.35324 1.01902 7.82955 1.44271 7.77931L7.44629 7.06722C7.61897 7.04674 7.76896 6.93831 7.8418 6.7804L10.374 1.29061C10.5527 0.903178 11.1035 0.903104 11.2822 1.29054L13.8145 6.78029C13.8873 6.93819 14.0363 7.04692 14.209 7.0674L20.2129 7.77931C20.6366 7.82955 20.8063 8.35339 20.493 8.64308L16.0549 12.7481C15.9272 12.8661 15.8704 13.0419 15.9043 13.2124L17.0822 19.1421C17.1653 19.5606 16.7199 19.8848 16.3476 19.6764L11.0723 16.7228C10.9206 16.6378 10.7362 16.6382 10.5845 16.7232L5.30859 19.6757C4.93628 19.8841 4.49009 19.5606 4.57324 19.1421L5.75129 13.2128C5.78518 13.0422 5.72848 12.8661 5.60082 12.748L1.16211 8.64292Z"
                      stroke="#ec7357"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </article>
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
                <li><a href="/category-template.html">Categories</a></li>
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
