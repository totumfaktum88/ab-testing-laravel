<!-- Hero Section -->
<section id="hero" class="hero section">

    <div class="container d-flex flex-column justify-content-center align-items-center text-center position-relative" data-aos="zoom-out">
        @if( isset($hero) && $hero == 'millennium-falcon' )
            <img src="assets/img/millennium-falcon.svg" class="img-fluid animated" alt="" width="300">
        @elseif( isset($hero) && $hero == 'delorean')
            <img src="assets/img/delorean.svg" class="img-fluid animated" alt="" width="300">
        @else
            <img src="assets/img/hero-img.svg" class="img-fluid animated" alt="">
        @endif
        <h1>Welcome to <span>HeroBiz</span></h1>
        <p>Et voluptate esse accusantium accusamus natus reiciendis quidem voluptates similique aut.</p>
        <div class="d-flex">
            <a href="#about" class="btn-get-started scrollto">Get Started</a>
            <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Watch Video</span></a>
        </div>
    </div>

</section><!-- /Hero Section -->
