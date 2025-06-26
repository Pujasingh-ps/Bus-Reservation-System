<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUS RESERVATION</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <?php require"inc/links.php";?>
    <style>
        .custom-bg{
            background-color: #2ec1ac;
        }
        .custom-bg:hover{
            background-color: #279e8c;
        }
        .availability-form{
            margin-top: -50px;
            z-index: 2;
            position: relative;
        }

    </style>
</head>
<body class="bg-light">
    <?php require("inc/header.php");?>
    <!-- Carousel -->
    <div class="container-fluid px-lg-4 mt-4">
    <div class="swiper swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="images\img1.jpg" class="h-70 w-100 d-block"/>
            </div>
            <div class="swiper-slide">
                <img src="images\bus2.jpg" class="h-70 w-100 d-block"/>
            </div>
            <div class="swiper-slide">
                <img src="images\bus3.jpg" class="h-70 w-100 d-block"/>
            </div>
            <div class="swiper-slide">
                <img src="images\bus4.jpg" class="w-100 d-block" />
            </div>
            <div class="swiper-slide">
                <img src="images\bus5.jpg" class="w-100 d-block" />
            </div>
        </div>
        
    </div>
    </div>
    
    <!-- Check Buses Availabily -->
     <div class="container availability-form">
    <div class="row">
        <div class="col-lg-12 bg-white shadow p-4 rounded">
            <h5 class="mb-4">Check Booking Availability</h5>
            <form method="POST" action="check_availability.php">
                <div class="row align-items-end">
                    <div class="col-lg-3 mb-3">
                        <label class="form-label" style="font-weight: 500;"><img src="images/icon_F.jpg" alt="From"></label>
                        <input name="from" placeholder="From" type="text" class="form-control shadow-none" required>
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label class="form-label" style="font-weight: 500;"><img src="images/icon_T.jpg" alt="To"></label>
                        <input name="to" placeholder="To" type="text" class="form-control shadow-none" required>
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label class="form-label" style="font-weight: 500;"><i class="bi bi-calendar3"></i>&nbsp;Date</label>
                        <input name="date" type="date" class="form-control shadow-none" required>
                    </div>
                    <div id="contactUs" class="col-lg-1 mb-lg-3 mt-2">
                        <button type="submit" class="btn text-white shadow-none custom-bg">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Contact Us -->

    <div class="container">
        <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">📞CONTACT US</h2>
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
                <iframe class="w-100 rounded" height="320px" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d467686.70212809776!2d86.40316176420116!3d23.68302488017421!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f71f0ea1022529%3A0xf888f7e7fd11cefe!2sAsansol%2C%20West%20Bengal!5e0!3m2!1sen!2sin!4v1749307501545!5m2!1sen!2sin" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="bg-white p-4 rounded mb-4">
                    <div class="bg-white">
                        <h5>Contact Us</h5>
                        <a href="tel:+1234567890" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-telephone-fill"></i>+1234567890</a><br>
                        <a href="" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-envelope-at-fill"></i>&nbsp;reservebus@gmail.com</a>
                    </div>
                    
                </div>
                <div class="bg-white p-4 rounded mb-4">
                    <h5>Follow us</h5>
                    <a href="#" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                        <i class="bi bi-twitter me-1"></i> Twitter
                        </span>
                    </a>
                    <br>
                    <a href="#" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                        <i class="bi bi-facebook me-1"></i> Facebook
                        </span>
                    </a>
                    <br>
                    <a href="#" class="d-inline-block">
                        <span class="badge bg-light text-dark fs-6 p-2">
                        <i class="bi bi-instagram me-1"></i> Instagram
                        </span> 
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php require "inc/footer.php";?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".swiper-container", {
            spaceBetween: 30,
            effect: "fade",
            loop: true,
            autoplay: {
                 delay: 3500,
                 disableOnInteraction: false,
            }
        });
    </script>
</body>
</html>
