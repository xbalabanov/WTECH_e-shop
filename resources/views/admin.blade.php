<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Inventory — Eunoia</title>
    @vite(['resources/css/style.css', 'resources/css/admin.css', 'resources/js/app.js'])
  </head>

  <body class="admin-body">
    <header class="site-header" aria-label="Admin header">
      <div class="header-inner admin-header-inner">
        <a class="logo" href="{{ route('admin.index') }}" aria-label="Eunoia logo">
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

        <div class="admin-actions" aria-label="Admin actions">
          <a class="header-icon-btn" href="{{ route('admin.profile') }}" aria-label="Profile">
            <svg
              width="18"
              height="20"
              viewBox="0 0 18 20"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M16.75 19C16.75 16.2386 13.2242 14 8.875 14C4.52576 14 1 16.2386 1 19M8.875 11C6.15672 11 3.95312 8.76142 3.95312 6C3.95312 3.23858 6.15672 1 8.875 1C11.5933 1 13.7969 3.23858 13.7969 6C13.7969 8.76142 11.5933 11 8.875 11Z"
                stroke="#0A0A0A"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
          </a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="header-icon-btn" aria-label="Log out">
              <svg
                width="18"
                height="18"
                viewBox="0 0 18 18"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M6.75 15.75H4.5C3.67157 15.75 3 15.0784 3 14.25V3.75C3 2.92157 3.67157 2.25 4.5 2.25H6.75"
                  stroke="#0A0A0A"
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
                <path
                  d="M10.5 12.75L13.5 9.75L10.5 6.75"
                  stroke="#0A0A0A"
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
                <path
                  d="M13.5 9.75H7.5"
                  stroke="#0A0A0A"
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </button>
          </form>
        </div>
      </div>
    </header>

    <main class="admin-main">
      @if (session('success'))
        <div class="admin-flash" role="status">{{ session('success') }}</div>
      @endif

      <section class="inventory-wrapper" aria-labelledby="inventory-heading">
        <div class="inventory-head">
          <div class="inventory-title-wrap">
            <div class="inventory-icon" aria-hidden="true">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
              >
                <path
                  d="M10 5.83325V17.4999"
                  stroke="#305252"
                  stroke-width="1.66667"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
                <path
                  d="M2.50008 15C2.27907 15 2.06711 14.9122 1.91083 14.7559C1.75455 14.5996 1.66675 14.3877 1.66675 14.1667V3.33333C1.66675 3.11232 1.75455 2.90036 1.91083 2.74408C2.06711 2.5878 2.27907 2.5 2.50008 2.5H6.66675C7.5508 2.5 8.39865 2.85119 9.02377 3.47631C9.64889 4.10143 10.0001 4.94928 10.0001 5.83333C10.0001 4.94928 10.3513 4.10143 10.9764 3.47631C11.6015 2.85119 12.4494 2.5 13.3334 2.5H17.5001C17.7211 2.5 17.9331 2.5878 18.0893 2.74408C18.2456 2.90036 18.3334 3.11232 18.3334 3.33333V14.1667C18.3334 14.3877 18.2456 14.5996 18.0893 14.7559C17.9331 14.9122 17.7211 15 17.5001 15H12.5001C11.837 15 11.2012 15.2634 10.7323 15.7322C10.2635 16.2011 10.0001 16.837 10.0001 17.5C10.0001 16.837 9.73669 16.2011 9.26785 15.7322C8.79901 15.2634 8.16312 15 7.50008 15H2.50008Z"
                  stroke="#305252"
                  stroke-width="1.66667"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </div>
            <div>
              <h1 id="inventory-heading">Book Inventory</h1>
              <p>{{ $totalCount }} {{ Str::plural('title', $totalCount) }} in catalog</p>
            </div>
          </div>

          <div class="inventory-controls" aria-label="Inventory controls">
            <form
              class="inventory-search"
              method="GET"
              action="{{ route('admin.index') }}"
              role="search"
              aria-label="Search inventory"
            >
              <button
                class="inventory-search-btn"
                type="submit"
                aria-label="Search inventory"
              >
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
                class="inventory-search-input"
                type="search"
                name="q"
                value="{{ $search }}"
                placeholder="Search by title or author"
                aria-label="Search by title or author"
              />
            </form>
            <a class="add-book-btn" href="{{ route('admin.product.create') }}">+ Add a book</a>
          </div>
        </div>

        <div
          class="inventory-table"
          role="table"
          aria-label="Book inventory table"
        >
          <div class="table-head" role="rowgroup">
            <div role="row" class="table-row table-row-head">
              <div role="columnheader" class="col-book">Book</div>
              <div role="columnheader" class="col-author">Author</div>
              <div role="columnheader" class="col-price">Price</div>
              <div role="columnheader" class="col-stock">Stock</div>
              <div role="columnheader" class="col-actions">Actions</div>
            </div>
          </div>

          <div class="table-body" role="rowgroup">
            @forelse ($books as $book)
              <div role="row" class="table-row">
                <div role="cell" class="col-book book-cell">
                  @if ($book->cover_image_url)
                    <img
                      class="admin-cover"
                      src="{{ $book->cover_image_url }}"
                      alt="{{ $book->title }} cover"
                      loading="lazy"
                    />
                  @else
                    <div class="cover admin-cover" aria-hidden="true"></div>
                  @endif
                  <span class="book-name">{{ $book->title }}</span>
                </div>
                <div role="cell" class="col-author">
                  {{ $book->authors->pluck('full_name')->join(', ') ?: '—' }}
                </div>
                <div role="cell" class="col-price">
                  {{ number_format($book->price, 2, ',', '.') }}€
                  @if ($book->discount > 0)
                    <span class="admin-discount-badge">-{{ (int) $book->discount }}%</span>
                  @endif
                </div>
                <div role="cell" class="col-stock">
                  <span class="stock-pill {{ $book->stock === 0 ? 'stock-pill-out' : '' }}">
                    {{ $book->stock }} in stock
                  </span>
                </div>
                <div role="cell" class="col-actions action-cell">
                  <a
                    class="action-btn"
                    aria-label="Edit {{ $book->title }}"
                    href="{{ route('admin.product.edit', $book) }}"
                  >
                    <svg
                      width="14"
                      height="14"
                      viewBox="0 0 14 14"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M7 1.75H2.91667C2.60725 1.75 2.3105 1.87292 2.09171 2.09171C1.87292 2.3105 1.75 2.60725 1.75 2.91667V11.0833C1.75 11.3928 1.87292 11.6895 2.09171 11.9083C2.3105 12.1271 2.60725 12.25 2.91667 12.25H11.0833C11.3928 12.25 11.6895 12.1271 11.9083 11.9083C12.1271 11.6895 12.25 11.3928 12.25 11.0833V7"
                        stroke="#848383"
                        stroke-width="1.16667"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                      <path
                        d="M10.7187 1.53126C10.9508 1.2992 11.2655 1.16882 11.5937 1.16882C11.9219 1.16882 12.2367 1.2992 12.4687 1.53126C12.7008 1.76332 12.8312 2.07807 12.8312 2.40626C12.8312 2.73445 12.7008 3.0492 12.4687 3.28126L7.21114 8.53943C7.07263 8.67782 6.90151 8.77913 6.71356 8.83401L5.03764 9.32401C4.98744 9.33865 4.93424 9.33953 4.88359 9.32655C4.83294 9.31357 4.78671 9.28722 4.74973 9.25025C4.71276 9.21328 4.68641 9.16705 4.67343 9.1164C4.66046 9.06575 4.66133 9.01254 4.67597 8.96234L5.16597 7.28643C5.22111 7.09862 5.32262 6.92771 5.46114 6.78943L10.7187 1.53126Z"
                        stroke="#848383"
                        stroke-width="1.16667"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                  </a>
                  <form
                    method="POST"
                    action="{{ route('admin.product.destroy', $book) }}"
                    onsubmit="return confirm('Delete {{ addslashes($book->title) }}?')"
                  >
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-btn" aria-label="Delete {{ $book->title }}">
                      <svg
                        width="14"
                        height="14"
                        viewBox="0 0 14 14"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M1.75 3.5H12.25"
                          stroke="#848383"
                          stroke-width="1.16667"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        />
                        <path
                          d="M11.0834 3.5V11.6667C11.0834 12.25 10.5001 12.8333 9.91675 12.8333H4.08341C3.50008 12.8333 2.91675 12.25 2.91675 11.6667V3.5"
                          stroke="#848383"
                          stroke-width="1.16667"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        />
                        <path
                          d="M4.66675 3.50002V2.33335C4.66675 1.75002 5.25008 1.16669 5.83341 1.16669H8.16675C8.75008 1.16669 9.33341 1.75002 9.33341 2.33335V3.50002"
                          stroke="#848383"
                          stroke-width="1.16667"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        />
                        <path
                          d="M5.83325 6.41669V9.91669"
                          stroke="#848383"
                          stroke-width="1.16667"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        />
                        <path
                          d="M8.16675 6.41669V9.91669"
                          stroke="#848383"
                          stroke-width="1.16667"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        />
                      </svg>
                    </button>
                  </form>
                </div>
              </div>
            @empty
              <div class="table-empty" role="row">
                <p>No books found{{ $search !== '' ? ' matching "' . e($search) . '"' : '' }}.</p>
              </div>
            @endforelse
          </div>
        </div>

        @if ($books->hasPages())
          <div class="inventory-pager" aria-label="Pagination">
            @if ($books->onFirstPage())
              <span class="inventory-pager-btn" aria-disabled="true">‹</span>
            @else
              <a class="inventory-pager-btn" href="{{ $books->previousPageUrl() }}" aria-label="Previous page">‹</a>
            @endif
            <span class="inventory-pager-info">{{ $books->currentPage() }} of {{ $books->lastPage() }}</span>
            @if ($books->hasMorePages())
              <a class="inventory-pager-btn" href="{{ $books->nextPageUrl() }}" aria-label="Next page">›</a>
            @else
              <span class="inventory-pager-btn" aria-disabled="true">›</span>
            @endif
          </div>
        @endif
      </section>
    </main>

    <footer class="site-footer admin-footer-minimal" aria-label="Footer">
      <div class="footer-inner">
        <div class="footer-bottom">
          <div class="copyright">© 2026 Eunoia. All rights reserved.</div>
          <div class="made-with">Made with care for book lovers everywhere</div>
        </div>
      </div>
    </footer>
  </body>
</html>
