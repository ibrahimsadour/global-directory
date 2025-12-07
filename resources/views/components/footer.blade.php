<footer>
    <div class="container">
        <div class="footer-bottom row">
            <div class="col-lg-3 col-md-6 cvb">
                <div class="footer-card">
                    <h2  class="fabh">العنوان</h2>

                    <div class="loca-ro">
                        <div class="icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div class="detail">
                            <p>{{ setting('site_address', 'هولندا') }}</p>
                        </div>
                    </div>

                    <div class="loca-ro">
                        <div class="icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="detail">
                            <p>{{ setting('site_email', 'info@ibowebsolutions.com') }}</p>
                        </div>
                    </div>

                    <div class="loca-ro">
                        <div class="icon">
                            <i class="bi bi-telephone-forward"></i>
                        </div>
                        <div class="detail">
                            <p>{{ setting('site_mobile', '00963944513168') }}</p>
                        </div>
                    </div>

                </div>
            </div>

                <div class="col-lg-3 col-md-6 cvb">
                    <div class="footer-card">
                        <h2 class="fabh">التصنيفات</h2>

                        <ul class="topc">
                            @foreach($categories as $category)
                                @if(is_null($category->parent_id))
                                    <li>
                                        <a href="{{ route('categories.show', $category->slug) }}">
                                            <i class="bi bi-stop-circle"></i> {{ $category->name }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 cvb">
                    <div class="footer-card">
                    <h2 class="fabh">معلومات</h2>

                    <ul class="topc">
                        <li><a href="{{ route('pages.show', 'about') }}"><i class="bi bi-stop-circle"></i>من نحن</a></li>
                        <li><a href="{{ route('pages.show', 'contact') }}"><i class="bi bi-stop-circle"></i>اتصل بنا</a></li>
                        <li><a href="{{ route('pages.show', 'help') }}"><i class="bi bi-stop-circle"></i>الأسئلة الشائعة</a></li>
                        <li><a href="{{ route('pages.show', 'privacy-policy') }}"><i class="bi bi-stop-circle"></i>سياسة الخصوصية</a></li>
                        <li><a href="{{ route('pages.show', 'terms-and-conditions') }}"><i class="bi bi-stop-circle"></i>الشروط والأحكام</a></li>
                        <li><a href="{{ url('/blog') }}"><i class="bi bi-stop-circle"></i>المدونة</a></li>
                    </ul>

                    <h2 class="fabh mt-3">حسابي</h2>
                    <ul class="topc">
                        <li><a href="{{ route('login') }}"><i class="bi bi-stop-circle"></i> معلومات حسابي</a></li>
                        <li><a href="#"><i class="bi bi-stop-circle"></i> قائمتي</a></li>
                    </ul>

                    </div>
                </div>

                <div class="col-lg-3 col-md-6 br-o cvb subcrib">
                    <div class="footer-card">
                        <h2 class="fabh">تابعنا</h2>
                        <div class="row no-margin">
                            <ul class="soc-link">
                            <li><a rel="nofollow" href="http://instagram.com/"><i class="bi bi-instagram"></i></a></li>
                            <li><a rel="nofollow" href="https://facebook.com/"><i class="bi bi-facebook"></i></a></li>
                            <li><a rel="nofollow" href="http://twitter.com/"><i class="bi bi-twitter"></i></a></li>
                            <li><a rel="nofollow" href="http://pinterest.com/"><i class="bi bi-pinterest"></i></a></li>
                            <li><a rel="nofollow" href="https://linkedin.com/"><i class="bi bi-linkedin"></i></a></li>
                            <li><a rel="nofollow" href="https://youtube.com/"><i class="bi bi-youtube"></i></a></li>
                            </ul>
                        </div>


                        <h2 class="fabh mt-3">اشترك الان</h2>
                        <form method="post" action="">
                            <input type="hidden" name="_token" value="" autocomplete="off">                            
                            <div class="input-group mt-3">
                                <input  name="email" type="email" required class="form-control mb-0" placeholder="بريدك الإلكتروني" aria-label="بريدك الإلكتروني" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="input-group-text" id="basic-addon2"><i class="bi bi-send"></i></button>
                                </div>
                            </div>
                        </form>
                        <p class="sdfg">اشترك في النشرات الإخبارية لدينا واحصل على الأخبار مباشرة في صندوق الوارد الخاص بك</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ################### Copyright Starts Here #####################-->
    <div class="copy">
        <div class="container">
        <div class="row copy-row">
            <p>{!! setting('footer_copyright', ' جميع الحقوق محفوظة لشركة ibowebsolutions.com © ٢٠٢٤') !!}</p>
        </div>
        </div>
    </div>
</footer>
