<?php 
include_once('getConnection.php');
include_once('TopBar.php');
?>

<!-- Testimonials Section -->
<section id="testimonials" class="testimonials section light-background">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>TESTIMONIALS</h2>
        <p>What Are They <span class="description-title">Saying About Us</span></p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="swiper init-swiper">
            <script type="application/json" class="swiper-config">
                {
                    "loop": true,
                    "speed": 600,
                    "autoplay": {
                        "delay": 5000
                    },
                    "slidesPerView": "auto",
                    "pagination": {
                        "el": ".swiper-pagination",
                        "type": "bullets",
                        "clickable": true
                    }
                }
            </script>
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <div class="row gy-4 justify-content-center">
                            <div class="col-lg-6">
                                <div class="testimonial-content">
                                    <p>
                                        <i class="bi bi-quote quote-icon-left"></i>
                                        <span>The cakes from Velmora Patisserie are absolutely divine! The attention to detail and quality of ingredients is unmatched. They made my daughter's birthday truly special with their custom chocolate cake.</span>
                                        <i class="bi bi-quote quote-icon-right"></i>
                                    </p>
                                    <h3>Sarah Johnson</h3>
                                    <h4>Happy Customer</h4>
                                    <div class="stars">
                                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 text-center">
                                <img src="assets/img/testimonials/testimonials-1.jpg" class="img-fluid testimonial-img" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <div class="row gy-4 justify-content-center">
                            <div class="col-lg-6">
                                <div class="testimonial-content">
                                    <p>
                                        <i class="bi bi-quote quote-icon-left"></i>
                                        <span>I ordered a wedding cake from Velmora and it exceeded all expectations! Not only was it beautiful, but it tasted incredible. All our guests were asking where we got it from. Highly recommend!</span>
                                        <i class="bi bi-quote quote-icon-right"></i>
                                    </p>
                                    <h3>Michael & Emma</h3>
                                    <h4>Newlyweds</h4>
                                    <div class="stars">
                                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 text-center">
                                <img src="assets/img/testimonials/testimonials-2.jpg" class="img-fluid testimonial-img" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <div class="row gy-4 justify-content-center">
                            <div class="col-lg-6">
                                <div class="testimonial-content">
                                    <p>
                                        <i class="bi bi-quote quote-icon-left"></i>
                                        <span>Best bakery in town! Their red velvet cupcakes are to die for. I'm a regular customer now and always amazed by the freshness and flavor. The staff is friendly and service is excellent.</span>
                                        <i class="bi bi-quote quote-icon-right"></i>
                                    </p>
                                    <h3>David Martinez</h3>
                                    <h4>Regular Customer</h4>
                                    <div class="stars">
                                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 text-center">
                                <img src="assets/img/testimonials/testimonials-3.jpg" class="img-fluid testimonial-img" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <div class="row gy-4 justify-content-center">
                            <div class="col-lg-6">
                                <div class="testimonial-content">
                                    <p>
                                        <i class="bi bi-quote quote-icon-left"></i>
                                        <span>Velmora Patisserie delivered exactly what I wanted for my corporate event. Professional, delicious, and beautifully presented. They handle large orders with ease and maintain quality throughout.</span>
                                        <i class="bi bi-quote quote-icon-right"></i>
                                    </p>
                                    <h3>Jennifer Lee</h3>
                                    <h4>Event Planner</h4>
                                    <div class="stars">
                                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 text-center">
                                <img src="assets/img/testimonials/testimonials-4.jpg" class="img-fluid testimonial-img" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

<?php include_once('Footer.php') ?>
