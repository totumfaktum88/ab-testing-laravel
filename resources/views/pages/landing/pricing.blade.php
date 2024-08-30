@php
    $buttonLabel = $pricingButtonLabel ?? 'Buy now';
@endphp
<!-- Pricing Section -->
<section id="pricing" class="pricing section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Our Pricing</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

            <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="pricing-item">

                    <div class="pricing-header">
                        <h3>Free Plan</h3>
                        <h4><sup>$</sup>0<span> / month</span></h4>
                    </div>

                    <ul>
                        <li><i class="bi bi-dot"></i> <span>Quam adipiscing vitae proin</span></li>
                        <li><i class="bi bi-dot"></i> <span>Nec feugiat nisl pretium</span></li>
                        <li><i class="bi bi-dot"></i> <span>Nulla at volutpat diam uteera</span></li>
                        <li class="na"><i class="bi bi-x"></i> <span>Pharetra massa massa ultricies</span></li>
                        <li class="na"><i class="bi bi-x"></i> <span>Massa ultricies mi quis hendrerit</span></li>
                    </ul>

                    <div class="text-center mt-auto">
                        <a href="#" class="buy-btn">{{$buttonLabel}}</a>
                    </div>

                </div>
            </div><!-- End Pricing Item -->

            <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="400">
                <div class="pricing-item featured">

                    <div class="pricing-header">
                        <h3>Business Plan</h3>
                        <h4><sup>$</sup>29<span> / month</span></h4>
                    </div>

                    <ul>
                        <li><i class="bi bi-dot"></i> <span>Quam adipiscing vitae proin</span></li>
                        <li><i class="bi bi-dot"></i> <span>Nec feugiat nisl pretium</span></li>
                        <li><i class="bi bi-dot"></i> <span>Nulla at volutpat diam uteera</span></li>
                        <li><i class="bi bi-dot"></i> <span>Pharetra massa massa ultricies</span></li>
                        <li><i class="bi bi-dot"></i> <span>Massa ultricies mi quis hendrerit</span></li>
                    </ul>

                    <div class="text-center mt-auto">
                        <a href="#" class="buy-btn">{{$buttonLabel}}</a>
                    </div>

                </div>
            </div><!-- End Pricing Item -->

            <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="600">
                <div class="pricing-item">

                    <div class="pricing-header">
                        <h3>Developer Plan</h3>
                        <h4><sup>$</sup>49<span> / month</span></h4>
                    </div>

                    <ul>
                        <li><i class="bi bi-dot"></i> <span>Quam adipiscing vitae proin</span></li>
                        <li><i class="bi bi-dot"></i> <span>Nec feugiat nisl pretium</span></li>
                        <li><i class="bi bi-dot"></i> <span>Nulla at volutpat diam uteera</span></li>
                        <li><i class="bi bi-dot"></i> <span>Pharetra massa massa ultricies</span></li>
                        <li><i class="bi bi-dot"></i> <span>Massa ultricies mi quis hendrerit</span></li>
                    </ul>

                    <div class="text-center mt-auto">
                        <a href="#" class="buy-btn">{{$buttonLabel}}</a>
                    </div>

                </div>
            </div><!-- End Pricing Item -->

        </div>

    </div>

</section><!-- /Pricing Section -->
