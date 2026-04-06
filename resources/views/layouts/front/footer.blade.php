<!--===== FOOTER STARTS =======-->
    <div class="footer6-section-area">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="footer-all-section-area sp5">
            <div class="row">
              <div class="col-lg-3 col-md-6">
                <div class="footer-last-section">
                  <div class="footer-imgage">
                    <img src="{{ asset('storage/' . optional($organisation)->picOr) }}" alt="">
                  </div>
                  <div class="footer-text-area">
                    <p>Include any additional information that may be relevant or helpful for visitors, such as FAQs, pricing options.</p>
                    <div class="social-list-area">
                      <ul>
                        <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-2 col-md-6">
                <div class="about-links-area">
                  <h3>About Link</h3>
                  <ul>
                    <li><a href="blog1.html">Our Blog</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="service1.html">Practice Areas</a></li>
                    <li><a href="testimonial1.html">Testimonials </a></li>
                    <li><a href="contact1.html">Contact Us</a></li>

                  </ul>
                </div>
              </div>

              <div class="col-lg-3 col-md-6">
                <div class="get-links-area">
                  <h3>Get In Touch</h3>
                  <ul>
                    <li><img src="{{ asset('front/assets/img/icons/footer-email2.svg') }}" alt=""><a href="maito:demolawsy@gmail.com">demolawsy@gmail.com</a></li>
                    <li><img src="{{ asset('front/assets/img/icons/footer-location1.svg') }}" alt=""><a href="#">8708 Technology Forest <br> Pl Suite 125 -G, The <br> Woodlands, TX 77381</a></li>
                    <li><img src="{{ asset('front/assets/img/icons/footer-phn.svg') }}" alt=""><a href="tel:123-456-7890">123-456-7890</a></li>
                  </ul>
                </div>
              </div>
              {{-- <div class="col-lg-4 col-md-6">
                <div class="footer-contact-area">
                  <h3>Subscribe Our Newsletter</h3>
                  <div class="footer-form-area">
                    <form>
                      <input type="email" placeholder=" Email">
                      <div class="footer-btn">
                        <button type="submit">Subscribe <i class="fa-light fa-arrow-right"></i></button>
                      </div>
                    </form>
                  </div>
                </div>
              </div> --}}

            </div>
          </div>
          <div class="copyright-pera">
            <p>© Copyright {{ date('Y') }} {{ optional($organisation)->name }}</p>
            <a href="#">Privacy Policy</a>
          </div>
          </div>
        </div>
      </div>
    </div>
<!--===== FOOTER ENDS =======-->

