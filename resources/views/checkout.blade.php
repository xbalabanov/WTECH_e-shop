<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Checkout</title>
    @vite(['resources/css/style.css', 'resources/css/checkout.css', 'resources/js/app.js'])
  </head>

  <body class="page-layout">
    <div data-site-header></div>
    <main class="page-main">
      <section class="checkout-page">
        <div class="checkout-inner">
          <h1 class="checkout-title">Checkout</h1>

          <div class="checkout-layout">
            <div class="checkout-forms">
              <section
                class="checkout-section"
                aria-labelledby="billing-details-heading"
              >
                <h2 id="billing-details-heading" class="section-title">
                  Billing Details
                </h2>
                <div class="form-grid two-col">
                  <label class="field-label">
                    Full name
                    <input
                      type="text"
                      class="field-input"
                      placeholder="John Doe"
                      required
                    />
                  </label>

                  <label class="field-label">
                    Email address
                    <input
                      type="email"
                      class="field-input"
                      placeholder="name@example.com"
                      required
                    />
                  </label>

                  <label class="field-label full-width">
                    Phone number
                    <input
                      type="tel"
                      class="field-input"
                      placeholder="+421 900 000 000"
                      required
                    />
                  </label>

                  <label class="field-label full-width">
                    Street address
                    <input
                      type="text"
                      class="field-input"
                      placeholder="Street and house number"
                      required
                    />
                  </label>

                  <label class="field-label">
                    City
                    <input
                      type="text"
                      class="field-input"
                      placeholder="Bratislava"
                      required
                    />
                  </label>

                  <label class="field-label">
                    Postal code
                    <input
                      type="text"
                      class="field-input"
                      placeholder="811 01"
                      required
                    />
                  </label>

                  <label class="field-label full-width">
                    Country
                    <select class="field-input" required>
                      <option value="">Select country</option>
                      <option value="sk">Slovakia</option>
                      <option value="cz">Czech Republic</option>
                      <option value="at">Austria</option>
                      <option value="hu">Hungary</option>
                    </select>
                  </label>
                </div>
              </section>

              <section
                class="checkout-section"
                aria-labelledby="delivery-details-heading"
              >
                <h2 id="delivery-details-heading" class="section-title">
                  Delivery Details
                </h2>

                <h3 class="section-subtitle">Delivery Option</h3>
                <div
                  class="radio-group"
                  role="radiogroup"
                  aria-label="Shipping methods"
                >
                  <label class="radio-option">
                    <input type="radio" name="shipping" checked />
                    <span
                      >Standard Delivery
                      <small class="option-meta"
                        >2-4 business days | 3,99EUR</small
                      ></span
                    >
                  </label>
                  <label class="radio-option">
                    <input type="radio" name="shipping" />
                    <span
                      >Express Delivery
                      <small class="option-meta"
                        >1-2 business days | 6,99EUR</small
                      ></span
                    >
                  </label>
                </div>

                <div class="delivery-address-block">
                  <input
                    type="checkbox"
                    id="same-delivery-address"
                    class="same-address-checkbox"
                    name="same_delivery_address"
                    checked
                  />
                  <label
                    class="same-address-toggle"
                    for="same-delivery-address"
                  >
                    Use the same delivery address as billing address
                  </label>

                  <div
                    id="delivery-address-fields"
                    class="form-grid two-col delivery-address-fields"
                  >
                    <label class="field-label full-width">
                      Delivery street address
                      <input
                        type="text"
                        class="field-input"
                        placeholder="Street and house number"
                      />
                    </label>

                    <label class="field-label">
                      Delivery city
                      <input
                        type="text"
                        class="field-input"
                        placeholder="Bratislava"
                      />
                    </label>

                    <label class="field-label">
                      Delivery postal code
                      <input
                        type="text"
                        class="field-input"
                        placeholder="811 01"
                      />
                    </label>

                    <label class="field-label full-width">
                      Delivery country
                      <select class="field-input">
                        <option value="">Select country</option>
                        <option value="sk">Slovakia</option>
                        <option value="cz">Czech Republic</option>
                        <option value="at">Austria</option>
                        <option value="hu">Hungary</option>
                      </select>
                    </label>
                  </div>
                </div>
              </section>

              <section
                class="checkout-section"
                aria-labelledby="payment-method-heading"
              >
                <h2 id="payment-method-heading" class="section-title">
                  Payment Method
                </h2>

                <div
                  class="radio-group"
                  role="radiogroup"
                  aria-label="Payment methods"
                >
                  <label class="radio-option">
                    <input type="radio" name="payment" checked />
                    <span>Credit or Debit Card</span>
                  </label>
                  <label class="radio-option">
                    <input type="radio" name="payment" />
                    <span>PayPal</span>
                  </label>
                  <label class="radio-option">
                    <input type="radio" name="payment" />
                    <span>Cash on Delivery</span>
                  </label>
                </div>

                <p class="payment-note">
                  Card and wallet payments are completed securely on the
                  external payment gateway after clicking Place Order.
                </p>
              </section>
            </div>

            <aside
              class="checkout-summary"
              aria-labelledby="order-summary-heading"
            >
              <h2 id="order-summary-heading" class="summary-title">
                Order Summary
              </h2>

              <div class="summary-item">
                <span>Book 1 </span>
                <span>20,00€</span>
              </div>
              <div class="summary-item">
                <span>Book 2</span>
                <span>14,00€</span>
              </div>
              <div class="summary-item">
                <span>Shipping</span>
                <span>3,99€</span>
              </div>

              <div class="summary-divider"></div>

              <div class="summary-total">
                <span>Total</span>
                <span>39,99€</span>
              </div>

              <button class="place-order-btn" type="button">Place Order</button>
            </aside>
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
