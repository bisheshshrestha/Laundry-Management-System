<?php include 'assets/header.php'?>

    <!-- =============== Banner Section===================================-->

    <section class="banner" id="banner">
        <div class="content">
            <h2>Let's Hurt Your Dirt</h2>
            <p>Pickup <span>.</span> Wash <span>.</span> Deliver <span>.</span></p>
            <a href="#" class="btn1">Place Order</a>
        </div>
    </section>

    <!-- =============== About Section ===================================-->


    <section class="about" id="about">
        <div class="row">
            <div class="col50">
                <h2 class="titleText"><span>A</span>bout US</h2>
                <p>We are professionals in the laundry and dry cleaning business, which means we always stay up to date on the latest technologies, cleaning methods, and solutions for dealing with stains or delicate fabrics. Plus, we maintain the highest standards of business integrity by following local and national regulations and environmental safety rules. We are passionate about changing the way you think about laundry!<br><br>Laundry isn't your main business, but it is ours and we love it! For more information about our commercial laundry services and pricing and to schedule your first pick up, call us at
                     +977 9800000000</p>
            </div>
            <div class="col50">
                <div class="imgBox">
                    <img src="./images/about.jpg" alt="">
                </div>
            </div>
        </div>
    </section>
    <!-- =============== About Section End===================================-->


    <!-- =============== Service Section===================================-->
    <section class="service" id="service">
        <div class="title">
            <h2 class="titleText">Our<span>S</span>ervice</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
        </div>

        <div class="content">
            <div class="box">
                <div class="imgBox">
                    <img src="./images/images-icon1.png" alt="">
                </div>
                <div class="text">
                    <h3>Pickup</h3>
                    <p>Once we get your order, we pickup your clothes from your home.</p>
                </div>
            </div>

            <div class="box">
                <div class="imgBox">
                    <img src="./images/images-icon2.png" alt="">
                </div>
                <div class="text">
                    <h3>Wash</h3>
                    <p>We wash your clothes using our advanced washing machines.</p>
                </div>
            </div>

            <div class="box">
                <div class="imgBox">
                    <img src="./images/images-icon3.png" alt="">
                </div>
                <div class="text">
                    <h3>Deliver</h3>
                    <p>We fold and pack your clothes and deliver to your home safely.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- =============== Service Section End===================================-->

     <!-- =============== Pricing Section ===================================-->
     <?php
      include 'connect.php';
      $sql = "SELECT * FROM tbl_items";
      $result = mysqli_query($conn, $sql);
     ?>

     <section class="price" id="price">
        <div class="title">
            <h2 class="titleText">Our<span>P</span>ricing</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
        </div>
        <div class="content">
        <?php foreach ($result as $clothes) { ?>
        <div class="box">
                <div class="imgBox">
                    <img src="../backend/<?=$clothes['item_image'];?>" alt="">
                </div>
                <div class="text">
                    <h3><?=$clothes['item_name'];?></h3>
                    <p>Rs. <?=$clothes['price'];?> per <?=$clothes['unit'];?></p>
                    <a href="signin.php" class="btn1">Order</a>
                </div>
            </div>
            <?php } ?>
       
        </div>
        <div class="title">
            <a href="#" class="btn">View All</a>
        </div>

    </section>

    <!-- =============== Pricing Section End===================================-->


    <!-- =============== Testimonials Section ===================================-->

    <section class="testimonials" id="testimonials">
        <div class="title white">
            <h2 class="titleText">They<span>S</span>aid About Us</h2>
            <p>We are passionate about changing the way you think about laundry! </p>
        </div>
        <div class="content">
            <div class="box">
                <div class="imgBox">
                    <img src="./images/testi1.jpg" alt="">
                </div>
                <div class="text">
                    <p>I've been using the laundry management system for my business, and it has made a world of difference! Our customers are delighted with the efficient service, and I couldn't be happier with the results. Highly recommended!</p>
                    <h3>Robert Anderson</h3>
                </div>
            </div>

            <div class="box">
                <div class="imgBox">
                    <img src="./images/testi2.jpg" alt="">
                </div>
                <div class="text">
                    <p>I can't say enough good things about the laundry management system provided by this website. It has made managing my laundry business a breeze. The system's intuitive design and comprehensive features have made our day-to-day operations smoother and more efficient.</p>
                    <h3>David Brown</h3>
                </div>
            </div>

            <div class="box">
                <div class="imgBox">
                    <img src="./images/testi3.jpg" alt="">
                </div>
                <div class="text">
                    <p>The system's intelligent algorithms and advanced tracking capabilities have helped us optimize our resources and minimize wastage. The seamless integration with our existing processes made the transition smooth, and our customers have noticed the improved efficiency. This system is a game-changer!</p>
                    <h3>James Green</h3>
                </div>
            </div>
        </div>
    </section>
    <!-- =============== Testimonial Section End===================================-->
    <!-- =============== Contact Section ===================================-->

    <section class="contact" id="contact">
        <div class="row">
            <div class="contact-col">
                <div>
                    <i class=" fa fa-solid fa-house"></i>
                    <span>
                        <h5>Peanut Building</h5>
                        <p>Newroad, Kathmandu, NEPAL</p>
                    </span>
                </div>

                <div>
                    <i class=" fa fa-solid fa-phone"></i>
                    <span>
                        <h5>+977 9860106998</h5>
                        <p>Sunday to Saturday, 10AM to 8PM</p>
                    </span>
                </div>

                <div>
                    <i class=" fa fa-solid fa-envelope"></i>
                    <span>
                        <h5>onlinelaundryktm@gmail.com</h5>
                        <p>Email us your query</p>
                    </span>
                </div>

            </div>

            <div class="contact-col">
                <form action="" method="">
                    <input type="text" placeholder="Enter Your Name" required>
                    <input type="email" placeholder="Enter Email Address" required>
                    <input type="text" placeholder="Enter Your Subject" required>
                    <textarea rows="8" placeholder="Message" required></textarea>
                    <button type="submit" class="send_btn">Send Message</button>
                </form>
            </div>
        </div>
    </section>
    <!-- =============== Contact Section End===================================-->


<?php include 'assets/footer.php'?>