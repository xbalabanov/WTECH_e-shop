<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile · Wishlist</title>
    @vite(['resources/css/style.css', 'resources/css/profile.css', 'resources/js/app.js'])

  </head>
  <body class="page-layout">
    <div data-site-header></div>

    <main class="page-main">
      <div class="profile-container">
        <div class="profile-icon">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="32"
            height="32"
            viewBox="0 0 32 32"
            fill="none"
          >
            <path
              d="M25.3337 28V25.3333C25.3337 23.9188 24.7718 22.5623 23.7716 21.5621C22.7714 20.5619 21.4148 20 20.0003 20H12.0003C10.5858 20 9.22928 20.5619 8.22909 21.5621C7.2289 22.5623 6.66699 23.9188 6.66699 25.3333V28"
              stroke="white"
              stroke-width="2.4"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
            <path
              d="M16.0003 14.6667C18.9458 14.6667 21.3337 12.2789 21.3337 9.33333C21.3337 6.38781 18.9458 4 16.0003 4C13.0548 4 10.667 6.38781 10.667 9.33333C10.667 12.2789 13.0548 14.6667 16.0003 14.6667Z"
              stroke="white"
              stroke-width="2.4"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
        </div>
        <div class="profile-info">
          <div class="profile-name-block">
            <h1 class="profile-prename">Hello,</h1>
            <h1 class="profile-name">Name Surname</h1>
          </div>
        </div>
      </div>

      <section class="profile-dashboard" aria-label="Profile orders overview">
        <div class="profile-dashboard-inner">
          <aside class="profile-sidebar" aria-label="Profile menu">
            <a class="profile-sidebar-item" href="profile.html">
              <span class="sidebar-item-icon" aria-hidden="true"
                ><svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="18"
                  height="18"
                  viewBox="0 0 18 18"
                  fill="none"
                >
                  <path
                    d="M8.25 16.2974C8.47803 16.4291 8.7367 16.4984 9 16.4984C9.2633 16.4984 9.52197 16.4291 9.75 16.2974L15 13.2974C15.2278 13.1659 15.417 12.9768 15.5487 12.7491C15.6803 12.5213 15.7497 12.263 15.75 11.9999V5.99993C15.7497 5.73688 15.6803 5.47853 15.5487 5.2508C15.417 5.02306 15.2278 4.83395 15 4.70243L9.75 1.70243C9.52197 1.57077 9.2633 1.50146 9 1.50146C8.7367 1.50146 8.47803 1.57077 8.25 1.70243L3 4.70243C2.7722 4.83395 2.58299 5.02306 2.45135 5.2508C2.31971 5.47853 2.25027 5.73688 2.25 5.99993V11.9999C2.25027 12.263 2.31971 12.5213 2.45135 12.7491C2.58299 12.9768 2.7722 13.1659 3 13.2974L8.25 16.2974Z"
                    stroke="#EC7357"
                    stroke-width="1.35"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                  <path
                    d="M9 16.5V9"
                    stroke="#EC7357"
                    stroke-width="1.35"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                  <path
                    d="M2.46777 5.25L9.00027 9L15.5328 5.25"
                    stroke="#EC7357"
                    stroke-width="1.35"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                  <path
                    d="M5.625 3.20239L12.375 7.06489"
                    stroke="#EC7357"
                    stroke-width="1.35"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
              </span>
              <span>My Orders</span>
            </a>
            <a class="profile-sidebar-item active" href="profile-wishlist.html">
              <span class="sidebar-item-icon" aria-hidden="true"
                ><svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="18"
                  height="18"
                  viewBox="0 0 18 18"
                  fill="none"
                >
                  <path
                    d="M14.25 10.5C15.3675 9.405 16.5 8.0925 16.5 6.375C16.5 5.28098 16.0654 4.23177 15.2918 3.45818C14.5182 2.6846 13.469 2.25 12.375 2.25C11.055 2.25 10.125 2.625 9 3.75C7.875 2.625 6.945 2.25 5.625 2.25C4.53098 2.25 3.48177 2.6846 2.70818 3.45818C1.9346 4.23177 1.5 5.28098 1.5 6.375C1.5 8.1 2.625 9.4125 3.75 10.5L9 15.75L14.25 10.5Z"
                    stroke="#1A1A1A"
                    stroke-opacity="0.4"
                    stroke-width="1.35"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
              </span>
              <span>Wishlist</span>
              <span class="sidebar-item-count">12</span>
            </a>
            <a class="profile-sidebar-item" href="profile-settings.html">
              <span class="sidebar-item-icon" aria-hidden="true"
                ><svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="18"
                  height="18"
                  viewBox="0 0 18 18"
                  fill="none"
                >
                  <path
                    d="M9.16451 1.5H8.83451C8.43669 1.5 8.05516 1.65804 7.77385 1.93934C7.49255 2.22064 7.33451 2.60218 7.33451 3V3.135C7.33424 3.39804 7.26481 3.65639 7.13317 3.88413C7.00153 4.11186 6.81232 4.30098 6.58451 4.4325L6.26201 4.62C6.03398 4.75165 5.77532 4.82096 5.51201 4.82096C5.24871 4.82096 4.99004 4.75165 4.76201 4.62L4.64951 4.56C4.30531 4.36145 3.89639 4.30758 3.51251 4.41023C3.12864 4.51288 2.80118 4.76365 2.60201 5.1075L2.43701 5.3925C2.23846 5.7367 2.1846 6.14562 2.28724 6.5295C2.38989 6.91338 2.64066 7.24084 2.98451 7.44L3.09701 7.515C3.32372 7.64588 3.51223 7.83382 3.6438 8.06012C3.77537 8.28643 3.84543 8.54323 3.84701 8.805V9.1875C3.84806 9.45182 3.77925 9.71171 3.64755 9.94088C3.51584 10.17 3.32592 10.3603 3.09701 10.4925L2.98451 10.56C2.64066 10.7592 2.38989 11.0866 2.28724 11.4705C2.1846 11.8544 2.23846 12.2633 2.43701 12.6075L2.60201 12.8925C2.80118 13.2363 3.12864 13.4871 3.51251 13.5898C3.89639 13.6924 4.30531 13.6386 4.64951 13.44L4.76201 13.38C4.99004 13.2483 5.24871 13.179 5.51201 13.179C5.77532 13.179 6.03398 13.2483 6.26201 13.38L6.58451 13.5675C6.81232 13.699 7.00153 13.8881 7.13317 14.1159C7.26481 14.3436 7.33424 14.602 7.33451 14.865V15C7.33451 15.3978 7.49255 15.7794 7.77385 16.0607C8.05516 16.342 8.43669 16.5 8.83451 16.5H9.16451C9.56234 16.5 9.94387 16.342 10.2252 16.0607C10.5065 15.7794 10.6645 15.3978 10.6645 15V14.865C10.6648 14.602 10.7342 14.3436 10.8659 14.1159C10.9975 13.8881 11.1867 13.699 11.4145 13.5675L11.737 13.38C11.965 13.2483 12.2237 13.179 12.487 13.179C12.7503 13.179 13.009 13.2483 13.237 13.38L13.3495 13.44C13.6937 13.6386 14.1026 13.6924 14.4865 13.5898C14.8704 13.4871 15.1979 13.2363 15.397 12.8925L15.562 12.6C15.7606 12.2558 15.8144 11.8469 15.7118 11.463C15.6091 11.0791 15.3584 10.7517 15.0145 10.5525L14.902 10.4925C14.6731 10.3603 14.4832 10.17 14.3515 9.94088C14.2198 9.71171 14.151 9.45182 14.152 9.1875V8.8125C14.151 8.54818 14.2198 8.28829 14.3515 8.05912C14.4832 7.82995 14.6731 7.63966 14.902 7.5075L15.0145 7.44C15.3584 7.24084 15.6091 6.91338 15.7118 6.5295C15.8144 6.14562 15.7606 5.7367 15.562 5.3925L15.397 5.1075C15.1979 4.76365 14.8704 4.51288 14.4865 4.41023C14.1026 4.30758 13.6937 4.36145 13.3495 4.56L13.237 4.62C13.009 4.75165 12.7503 4.82096 12.487 4.82096C12.2237 4.82096 11.965 4.75165 11.737 4.62L11.4145 4.4325C11.1867 4.30098 10.9975 4.11186 10.8659 3.88413C10.7342 3.65639 10.6648 3.39804 10.6645 3.135V3C10.6645 2.60218 10.5065 2.22064 10.2252 1.93934C9.94387 1.65804 9.56234 1.5 9.16451 1.5Z"
                    stroke="#1A1A1A"
                    stroke-opacity="0.4"
                    stroke-width="1.35"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                  <path
                    d="M9 11.25C10.2426 11.25 11.25 10.2426 11.25 9C11.25 7.75736 10.2426 6.75 9 6.75C7.75736 6.75 6.75 7.75736 6.75 9C6.75 10.2426 7.75736 11.25 9 11.25Z"
                    stroke="#1A1A1A"
                    stroke-opacity="0.4"
                    stroke-width="1.35"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
              </span>
              <span>Edit Profile</span>
            </a>
            <a class="profile-sidebar-item signout" href="login.html">
              <span class="sidebar-item-icon" aria-hidden="true"
                ><svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="18"
                  height="18"
                  viewBox="0 0 18 18"
                  fill="none"
                >
                  <path
                    d="M6.75 15.75H3.75C3.35218 15.75 2.97064 15.592 2.68934 15.3107C2.40804 15.0294 2.25 14.6478 2.25 14.25V3.75C2.25 3.35218 2.40804 2.97064 2.68934 2.68934C2.97064 2.40804 3.35218 2.25 3.75 2.25H6.75"
                    stroke="#FF6467"
                    stroke-width="1.35"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                  <path
                    d="M12 12.75L15.75 9L12 5.25"
                    stroke="#FF6467"
                    stroke-width="1.35"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                  <path
                    d="M15.75 9H6.75"
                    stroke="#FF6467"
                    stroke-width="1.35"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
              </span>
              <span>Sign Out</span>
            </a>
          </aside>

          <div class="profile-main">
            <section
              class="profile-subpage-section"
              aria-labelledby="wishlist-title"
            >
              <h2 id="wishlist-title" class="profile-subpage-title">
                Wishlist
              </h2>

              <div class="wishlist-grid">
                <article class="wishlist-card" role="group">
                  <div class="wishlist-cover" aria-hidden="true"></div>
                  <div class="wishlist-card-content">
                    <h3 class="wishlist-card-title">The Silent Echo</h3>
                    <p class="wishlist-card-author">Elena Morris</p>
                    <p class="wishlist-card-meta">Fantasy</p>
                    <p class="wishlist-card-price">€22.99</p>
                    <div class="wishlist-card-actions">
                      <button class="wishlist-cart-btn" type="button">
                        Add to Cart
                      </button>
                      <button class="wishlist-remove-btn" type="button">
                        Remove
                      </button>
                    </div>
                  </div>
                </article>

                <article class="wishlist-card" role="group">
                  <div class="wishlist-cover" aria-hidden="true"></div>
                  <div class="wishlist-card-content">
                    <h3 class="wishlist-card-title">Red Horizon</h3>
                    <p class="wishlist-card-author">Alex Reed</p>
                    <p class="wishlist-card-meta">Sci-Fi</p>
                    <p class="wishlist-card-price">€14.50</p>
                    <div class="wishlist-card-actions">
                      <button class="wishlist-cart-btn" type="button">
                        Add to Cart
                      </button>
                      <button class="wishlist-remove-btn" type="button">
                        Remove
                      </button>
                    </div>
                  </div>
                </article>

                <article class="wishlist-card" role="group">
                  <div class="wishlist-cover" aria-hidden="true"></div>
                  <div class="wishlist-card-content">
                    <h3 class="wishlist-card-title">Sea of Glass</h3>
                    <p class="wishlist-card-author">Liam Porter</p>
                    <p class="wishlist-card-meta">Mystery</p>
                    <p class="wishlist-card-price">€27.40</p>
                    <div class="wishlist-card-actions">
                      <button class="wishlist-cart-btn" type="button">
                        Add to Cart
                      </button>
                      <button class="wishlist-remove-btn" type="button">
                        Remove
                      </button>
                    </div>
                  </div>
                </article>
              </div>
            </section>
          </div>
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
