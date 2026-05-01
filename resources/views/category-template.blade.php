<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Category Template</title>
    @vite(['resources/css/style.css', 'resources/css/category-template.css', 'resources/js/app.js'])
  </head>
  <body class="page-layout">
    <div data-site-header></div>

    <main class="page-main">
      <section class="category-main">
        @php
          $languages = $languages ?? collect();
          $authors = $authors ?? collect();
          $categories = $categories ?? collect();
          $genres = $genres ?? collect();
          $selectedLanguages = $selectedLanguages ?? [];
          $selectedAuthorIds = $selectedAuthorIds ?? [];
          $selectedCategoryIds = $selectedCategoryIds ?? [];
          $selectedGenres = $selectedGenres ?? [];
          $sort = $sort ?? 'newest';
          $priceFloor = $priceFloor ?? 0;
          $priceCeil = $priceCeil ?? 100;
          $selectedMinPrice = $selectedMinPrice ?? $priceFloor;
          $selectedMaxPrice = $selectedMaxPrice ?? $priceCeil;
          $cartQuantities = $cartQuantities ?? [];
          $searchQuery = trim((string) ($searchQuery ?? request('q', '')));
        @endphp

        <aside class="category-filter" aria-label="Filters">
          <form method="GET" action="{{ route('categories.index') }}" id="category-filter-form">
            @if(request('category'))
              <input type="hidden" name="category" value="{{ request('category') }}" />
            @endif
            @if($searchQuery !== '')
              <input type="hidden" name="q" value="{{ $searchQuery }}" />
            @endif
            <input type="hidden" name="sort" value="{{ $sort }}" />

          <h2 class="filter-title">Filters</h2>
          <button
            class="filter-reset-btn"
            type="button"
            aria-label="Remove all filters"
            onclick="window.location.href='{{ route('categories.index', array_filter(['category' => request('category'), 'q' => $searchQuery])) }}'"
          >
            <span aria-hidden="true">×</span>
            <span>Remove all filters</span>
          </button>

          <section class="filter-group" aria-labelledby="filter-language-title">
            <button class="filter-group-header" type="button">
              <h3 id="filter-language-title" class="filter-group-title">
                Language
              </h3>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="22"
                height="22"
                viewBox="0 0 22 22"
                fill="none"
                aria-hidden="true"
              >
                <path
                  d="M4.58301 8.25L11.0001 14.6667L17.4163 8.25"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </button>
            @forelse ($languages as $language)
              <label class="filter-option"
                ><input type="checkbox" name="languages[]" value="{{ $language }}" @checked(in_array($language, $selectedLanguages, true)) /> <span>{{ $language }}</span></label
              >
            @empty
              <p class="filter-more">No languages</p>
            @endforelse
          </section>

          <hr class="filter-divider" />

          <section class="filter-group" aria-labelledby="filter-category-title">
            <button class="filter-group-header" type="button">
              <h3 id="filter-category-title" class="filter-group-title">
                Category
              </h3>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="22"
                height="22"
                viewBox="0 0 22 22"
                fill="none"
                aria-hidden="true"
              >
                <path
                  d="M4.58301 8.25L11.0001 14.6667L17.4163 8.25"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </button>
            @forelse ($categories as $categoryItem)
              <label class="filter-option"
                ><input type="checkbox" name="categories[]" value="{{ $categoryItem->id }}" @checked(in_array($categoryItem->id, $selectedCategoryIds, true)) /> <span>{{ $categoryItem->name }}</span></label
              >
            @empty
              <p class="filter-more">No categories</p>
            @endforelse
          </section>

          <hr class="filter-divider" />

          <section class="filter-group" aria-labelledby="filter-author-title">
            <button class="filter-group-header" type="button">
              <h3 id="filter-author-title" class="filter-group-title">
                Author
              </h3>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="22"
                height="22"
                viewBox="0 0 22 22"
                fill="none"
                aria-hidden="true"
              >
                <path
                  d="M4.58301 8.25L11.0001 14.6667L17.4163 8.25"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </button>
            @forelse ($authors as $author)
              <label class="filter-option"
                ><input type="checkbox" name="authors[]" value="{{ $author->id }}" @checked(in_array($author->id, $selectedAuthorIds, true)) /> <span>{{ $author->full_name }}</span></label
              >
            @empty
              <p class="filter-more">No authors</p>
            @endforelse
          </section>

          <hr class="filter-divider" />

          <section class="filter-group" aria-labelledby="filter-genre-title">
            <button class="filter-group-header" type="button">
              <h3 id="filter-genre-title" class="filter-group-title">Genre</h3>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="22"
                height="22"
                viewBox="0 0 22 22"
                fill="none"
                aria-hidden="true"
              >
                <path
                  d="M4.58301 8.25L11.0001 14.6667L17.4163 8.25"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </button>
            @forelse ($genres as $genre)
              <label class="filter-option"
                ><input type="checkbox" name="genres[]" value="{{ $genre }}" @checked(in_array($genre, $selectedGenres, true)) /> <span>{{ $genre }}</span></label
              >
            @empty
              <p class="filter-more">No genres</p>
            @endforelse
          </section>

          <hr class="filter-divider" />

          <section
            class="filter-group filter-price"
            aria-labelledby="filter-price-title"
          >
            <h3 id="filter-price-title" class="filter-group-title">
              Price range
            </h3>
            <div class="filter-price-values">
              <span id="price-min-label">{{ (int) $selectedMinPrice }}€</span>
              <span id="price-max-label">{{ (int) $selectedMaxPrice }}€</span>
            </div>
            <div class="filter-price-track">
              <input
                class="filter-range filter-range-min"
                id="filter-min-price"
                name="min_price"
                type="range"
                min="{{ $priceFloor }}"
                max="{{ $priceCeil }}"
                value="{{ (int) $selectedMinPrice }}"
              />
              <input
                class="filter-range filter-range-max"
                id="filter-max-price"
                name="max_price"
                type="range"
                min="{{ $priceFloor }}"
                max="{{ $priceCeil }}"
                value="{{ (int) $selectedMaxPrice }}"
              />
            </div>
            <button type="button" class="filter-price-reset-btn" id="filter-price-reset-btn">Reset price</button>
          </section>
          </form>
        </aside>
        <div class="category-main-content">
          @php
            $bookRows = method_exists($books ?? null, 'getCollection')
                ? ($books->getCollection()->chunk(2))
                : collect($books ?? [])->chunk(2);

            $categoryTitle = $categoryTitle ?? 'Books';
            $categorySubtitle = $categorySubtitle ?? 'Browse books from the database.';
          @endphp

          <div class="category-main-title-container">
            <h1 class="category-main-title">{{ $categoryTitle }}</h1>
            <p class="category-main-subtitle">{{ $categorySubtitle }}</p>
          </div>

          <div class="category-main-sort-container">
            <form method="GET" action="{{ route('categories.index') }}">
              @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}" />
              @endif
              @if($searchQuery !== '')
                <input type="hidden" name="q" value="{{ $searchQuery }}" />
              @endif
              @foreach ($selectedLanguages as $language)
                <input type="hidden" name="languages[]" value="{{ $language }}" />
              @endforeach
              @foreach ($selectedAuthorIds as $authorId)
                <input type="hidden" name="authors[]" value="{{ $authorId }}" />
              @endforeach
              @foreach ($selectedCategoryIds as $categoryId)
                <input type="hidden" name="categories[]" value="{{ $categoryId }}" />
              @endforeach
              @foreach ($selectedGenres as $genre)
                <input type="hidden" name="genres[]" value="{{ $genre }}" />
              @endforeach
              <input type="hidden" name="min_price" value="{{ (int) $selectedMinPrice }}" />
              <input type="hidden" name="max_price" value="{{ (int) $selectedMaxPrice }}" />

              <label for="sort-select" class="sort-label">Sort by:</label>
              <select id="sort-select" class="sort-select" name="sort" onchange="this.form.submit()">
                <option value="newest" @selected($sort === 'newest')>Newest Arrivals</option>
                <option value="oldest" @selected($sort === 'oldest')>Oldest Arrivals</option>
                <option value="price-low-high" @selected($sort === 'price-low-high')>Price: Low to High</option>
                <option value="price-high-low" @selected($sort === 'price-high-low')>Price: High to Low</option>
              </select>
            </form>
          </div>

          <div class="category-main-products-container" id="category-products-container">
            @forelse ($bookRows as $row)
              <div class="category-main-products-row">
                @foreach ($row as $book)
                  <article class="category-card" role="group">
                    <a class="category-cover-link" href="{{ route('products.show', $book) }}" aria-label="Open {{ $book->title }} details">
                      <div
                        class="category-cover"
                        aria-hidden="true"
                        @if ($book->cover_image_url)
                          style="background-image: url('{{ $book->cover_image_url }}'); background-size: cover; background-position: center;"
                        @endif
                      ></div>
                    </a>
                    <div class="category-card-elements">
                      <a class="category-title-link" href="{{ route('products.show', $book) }}">
                        <div class="category-card-title">
                          <h3 class="category-title">{{ $book->title }}</h3>
                          <p class="category-author">
                            {{ $book->authors?->pluck('full_name')->join(', ') ?: 'Unknown author' }}
                          </p>
                        </div>
                      </a>
                      <p class="category-description">
                        {{ \Illuminate\Support\Str::limit($book->description ?? '', 180) }}
                      </p>
                      <div class="category-card-info-container">
                        <p class="category-card-book-genre">{{ $book->genre ?? '—' }}</p>

                        <div class="category-card-price-container">
                          <p class="category-card-book-price">{{ number_format((float) $book->price, 2, ',', '.') }}€</p>
                          <span class="category-badge">-{{ (int) ($book->discount ?? 0) }}%</span>
                        </div>
                      </div>
                      <p class="category-author">{{ (int) ($book->stock ?? 0) }} in stock</p>

                      <div class="category-card-actions">
                        @php
                          $cartQty = (int) ($cartQuantities[$book->id] ?? 0);
                          $stock = (int) ($book->stock ?? 0);
                        @endphp

                        @if ($stock <= 0)
                          <button class="category-card-cart-button" type="button" disabled aria-disabled="true">
                            Out of stock
                          </button>
                        @elseif ($cartQty > 0)
                          <div class="category-card-qty" aria-label="Cart quantity controls">
                            <form method="POST" action="{{ route('cart.update') }}">
                              @csrf
                              <input type="hidden" name="book_id" value="{{ $book->id }}" />
                              <input type="hidden" name="quantity" value="{{ max(0, $cartQty - 1) }}" />
                              <button type="submit" class="category-card-qty-btn" aria-label="Decrease quantity">−</button>
                            </form>

                            <span class="category-card-qty-count" aria-live="polite">{{ $cartQty }}</span>

                            @if ($cartQty < $stock)
                              <form method="POST" action="{{ route('cart.update') }}">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}" />
                                <input type="hidden" name="quantity" value="{{ min($stock, $cartQty + 1) }}" />
                                <button type="submit" class="category-card-qty-btn" aria-label="Increase quantity">+</button>
                              </form>
                            @else
                              <button type="button" class="category-card-qty-btn" aria-label="Maximum stock reached" disabled>+</button>
                            @endif
                          </div>
                        @else
                          <form method="POST" action="{{ route('cart.add') }}">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}" />
                            <input type="hidden" name="quantity" value="1" />
                            <button class="category-card-cart-button" type="submit">
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
                          </form>
                        @endif

                        <button class="category-card-favourite-button" type="button">
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
                @endforeach
              </div>
            @empty
              <p>No books found.</p>
            @endforelse
          </div>

          <div class="category-pager">
            <button class="category-to-top-btn" type="button" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="12"
                height="14"
                viewBox="0 0 12 14"
                fill="none"
              >
                <path
                  d="M6 13V1M6 1L1 6.14286M6 1L11 6.14286"
                  stroke="black"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
              Go Up
            </button>

            @if (method_exists($books ?? null, 'lastPage'))
              <button
                class="category-more-btn"
                type="button"
                id="category-more-btn"
                data-next-url="{{ $books->hasMorePages() ? $books->nextPageUrl() : '' }}"
                @if (!$books->hasMorePages()) style="display: none;" @endif
              >
                More
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="12"
                  height="14"
                  viewBox="0 0 12 14"
                  fill="none"
                  aria-hidden="true"
                >
                  <path
                    d="M6 1L6 13M6 13L11 7.85714M6 13L1 7.85714"
                    stroke="black"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
              </button>

              <div class="category-pager-pages" id="category-pager-pages">
                @if ($books->onFirstPage())
                  <span class="category-pager-page" aria-disabled="true">‹</span>
                @else
                  <a class="category-pager-page" href="{{ $books->previousPageUrl() }}" aria-label="Previous page">‹</a>
                @endif

                @for ($page = 1; $page <= $books->lastPage(); $page++)
                  <a
                    class="category-pager-page {{ $books->currentPage() === $page ? 'category-pager-page-active' : '' }}"
                    href="{{ $books->url($page) }}"
                    aria-label="Page {{ $page }}"
                    @if ($books->currentPage() === $page) aria-current="page" @endif
                  >
                    {{ $page }}
                  </a>
                @endfor

                @if ($books->hasMorePages())
                  <a class="category-pager-page" href="{{ $books->nextPageUrl() }}" aria-label="Next page">›</a>
                @else
                  <span class="category-pager-page" aria-disabled="true">›</span>
                @endif
              </div>
            @endif
          </div>
        </div>
      </section>
    </main>

    <script>
      (() => {
        const filterForm = document.getElementById('category-filter-form');
        const minRange = document.getElementById('filter-min-price');
        const maxRange = document.getElementById('filter-max-price');
        const minLabel = document.getElementById('price-min-label');
        const maxLabel = document.getElementById('price-max-label');
        const resetPriceBtn = document.getElementById('filter-price-reset-btn');

        const collapsibleGroups = Array.from(document.querySelectorAll('.filter-group'))
          .filter((group) => group.querySelector('.filter-group-header'));

        const applyCollapseState = (group, collapsed) => {
          group.classList.toggle('is-collapsed', collapsed);

          Array.from(group.children).forEach((child) => {
            if (!child.classList.contains('filter-group-header')) {
              child.hidden = collapsed;
            }
          });

          group.querySelector('.filter-group-header')?.setAttribute('aria-expanded', String(!collapsed));
        };

        if (collapsibleGroups.length) {
          collapsibleGroups.forEach((group, index) => {
            const header = group.querySelector('.filter-group-header');
            const hasSelectedOption = !!group.querySelector('input[type="checkbox"]:checked');
            const startsCollapsed = !hasSelectedOption && index !== 0;

            applyCollapseState(group, startsCollapsed);

            header?.addEventListener('click', () => {
              const isCollapsed = group.classList.contains('is-collapsed');

              collapsibleGroups.forEach((otherGroup) => {
                if (otherGroup !== group) {
                  applyCollapseState(otherGroup, true);
                }
              });

              applyCollapseState(group, !isCollapsed);
            });
          });
        }

        if (filterForm) {
          filterForm.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
            checkbox.addEventListener('change', () => filterForm.submit());
          });
        }

        if (minRange && maxRange && minLabel && maxLabel && filterForm) {
          const syncLabels = () => {
            let min = Number(minRange.value);
            let max = Number(maxRange.value);

            if (min > max) {
              [min, max] = [max, min];
              minRange.value = String(min);
              maxRange.value = String(max);
            }

            minLabel.textContent = `${min}€`;
            maxLabel.textContent = `${max}€`;
          };

          minRange.addEventListener('input', syncLabels);
          maxRange.addEventListener('input', syncLabels);
          minRange.addEventListener('change', () => filterForm.submit());
          maxRange.addEventListener('change', () => filterForm.submit());

          resetPriceBtn?.addEventListener('click', () => {
            minRange.value = minRange.min;
            maxRange.value = maxRange.max;
            syncLabels();
            filterForm.submit();
          });

          syncLabels();
        }

        const moreBtn = document.getElementById('category-more-btn');
        const productsContainer = document.getElementById('category-products-container');
        const pagerPages = document.getElementById('category-pager-pages');

        if (!moreBtn || !productsContainer || !pagerPages) {
          return;
        }

        moreBtn.addEventListener('click', async () => {
          const nextUrl = moreBtn.dataset.nextUrl;

          if (!nextUrl) {
            return;
          }

          moreBtn.disabled = true;

          try {
            const response = await fetch(nextUrl, {
              headers: {
                'X-Requested-With': 'XMLHttpRequest',
              },
            });

            if (!response.ok) {
              throw new Error('Failed to load next page');
            }

            const html = await response.text();
            const doc = new DOMParser().parseFromString(html, 'text/html');

            const newRows = doc.querySelectorAll('#category-products-container .category-main-products-row');
            newRows.forEach((row) => productsContainer.appendChild(row));

            const newPagerPages = doc.getElementById('category-pager-pages');
            if (newPagerPages) {
              pagerPages.innerHTML = newPagerPages.innerHTML;
            }

            const newMoreBtn = doc.getElementById('category-more-btn');
            const newNextUrl = newMoreBtn?.dataset?.nextUrl ?? '';

            if (newNextUrl) {
              moreBtn.dataset.nextUrl = newNextUrl;
              moreBtn.disabled = false;
            } else {
              moreBtn.dataset.nextUrl = '';
              moreBtn.style.display = 'none';
            }
          } catch (error) {
            console.error(error);
            moreBtn.disabled = false;
          }
        });
      })();
    </script>

    <div data-site-footer></div>
    
  </body>
</html>
