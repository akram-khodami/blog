      <!-- footer section start -->
      <div class="footer_section layout_padding mt-5">
          <div class="container">
              <div class="footer_logo">
                  <a href="{{ url('/') }}">
                      <img src="{{ url('images/footer-logo.png', []) }}">
                  </a>
              </div>
              <div class="footer_menu">
                  <ul>
                      <li><a href="{{ url('/', []) }}">خانه</a></li>
                      <li><a href="{{ url('post', []) }}">درباره ما</a></li>
                      <li><a href="{{ url('post', []) }}">بلاگ</a></li>
                      <li><a href="{{ url('post', []) }}">ارتباط با ما</a></li>
                  </ul>
              </div>
              <div class="contact_menu">
                  <ul>
                      <li><a href="#"><img src="{{ url('images/call-icon.png') }}"></a></li>
                      <li><a href="#">Call : +01 1234567890</a></li>
                      <li><a href="blog.html"><img src="{{ url('images/mail-icon.png') }}"></a></li>
                      <li><a href="features.html">demo@gmail.com</a></li>
                  </ul>
              </div>
          </div>
      </div>
      <!-- footer section end -->
      <!-- copyright section start -->
      <div class="copyright_section">
          <div class="container">
              <p class="copyright_text">Copyright 2020 All Right Reserved By.<a href="https://html.design"> Free html
                      Templates
                  </a>
              </p>
          </div>
      </div>
      <!-- copyright section end -->
      <!-- Javascript files-->
      <script src="{{ url('js/theme/jquery.min.js') }}"></script>
      <script src="{{ url('js/theme/popper.min.js') }}"></script>
      <script src="{{ url('js/theme/bootstrap.bundle.min.js') }}"></script>
      {{-- <script src="{{ url('js/theme/jquery-3.0.0.min.js') }}"></script> --}}
      <script src="{{ url('js/theme/plugin.js') }}"></script>
      <!-- sidebar -->
      <script src="{{ url('js/theme/jquery.mCustomScrollbar.concat.min.js') }}"></script>
      <script src="{{ url('js/theme/custom.js') }}"></script>
      <!-- javascript -->
      <script src="{{ url('js/theme/owl.carousel.js') }}"></script>
      <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
      @yield('external_script')
      @yield('internal_script')
      </body>

      </html>
