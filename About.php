<?php 
include_once('getConnection.php');
include_once('TopBar.php');
?>

<!-- About Section -->
<section id="about" class="about section light-background">
    <div class="container section-title" data-aos="fade-up">
        <h2>About Us</h2>
        <p><span>Learn More</span> <span class="description-title">About Velmora Patisserie</span></p>
    </div>

    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <img src="assets/img/about.jpg" class="img-fluid rounded-4 mb-4" alt="About Velmora Patisserie">
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                <h3>Why Choose Velmora Patisserie</h3>
                <p class="fst-italic">
                    Velmora Patisserie offers premium, handcrafted cakes made with the finest ingredients, exquisite designs, and rich flavors. Perfect for every occasion, our cakes guarantee freshness, quality, and an unforgettable taste experience.
                </p>
                <ul>
                    <li><i class="bi bi-check-circle-fill"></i> <span><strong>Premium Quality Ingredients</strong> - We use only the finest, freshest ingredients in all our products.</span></li>
                    <li><i class="bi bi-check-circle-fill"></i> <span><strong>Handcrafted with Love</strong> - Every cake is made by our talented team of bakers and designers.</span></li>
                    <li><i class="bi bi-check-circle-fill"></i> <span><strong>Custom Designs</strong> - We create personalized cakes tailored to your special occasions.</span></li>
                    <li><i class="bi bi-check-circle-fill"></i> <span><strong>Fresh Daily</strong> - All our products are baked fresh daily to ensure the best taste.</span></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Why Us Section -->
<section id="why-us" class="why-us section">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="why-box">
                    <h3>Our Story</h3>
                    <p>
                        Founded with a passion for creating memorable dessert experiences, Velmora Patisserie has been serving delightful cakes and pastries to our community. Our commitment to excellence and attention to detail sets us apart.
                    </p>
                </div>
            </div>

            <div class="col-lg-8 d-flex align-items-stretch">
                <div class="row gy-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="col-xl-4">
                        <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-clipboard-data"></i>
                            <h4>Variety of Products 🍰</h4>
                            <p>Endless variety, one sweet destination.</p>
                        </div>
                    </div>

                    <div class="col-xl-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-gem"></i>
                            <h4>Premium Quality ✅</h4>
                            <p>From classic to custom quality is our promise.</p>
                        </div>
                    </div>

                    <div class="col-xl-4" data-aos="fade-up" data-aos-delay="400">
                        <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-inboxes"></i>
                            <h4>Custom Creations ⭐</h4>
                            <p>From sketch to slice every cake tells your story</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section id="stats" class="stats section dark-background">
    <img src="assets/img/stats-bg.jpg" alt="" data-aos="fade-in">
    <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                    <span data-purecounter-start="0" data-purecounter-end="70" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Types Cakes</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                    <span data-purecounter-start="0" data-purecounter-end="41" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Todays Sales</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                    <span data-purecounter-start="0" data-purecounter-end="1453" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Total Sales</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                    <span data-purecounter-start="0" data-purecounter-end="32" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Workers</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once('Footer.php') ?>
