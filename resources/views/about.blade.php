@extends('layouts.app')
@section('title', 'About')
@section('description', 'Gluto HEP: Transforming Lives through Financial Responsibility')
@section('content')
    <div class="page-desc">
        <h1 class="page-title">About Us</h1>
    </div>

    <!-- ABOUT STARTS  -->
    <div class="about-top-desc d-flex container-fluid space-between">
        <div class="about-text" data-aos="slide-right">
            <p class="text-md">
                GLUTO HUMANITARIAN EMPOWERMENT PROJECT (HEP) is a food network marketing company that offers a great
                opportunity to help you put food on your table and at the same time become financially stable
            </p>
            <!-- <a class="text about-link" href="javascript:void();">Read More</a> -->
        </div>

        <div class="about-image" data-aos="slide-left" style="display: none;">
            <div class="d-flex flex-col about-image-box">
                <img src="{{ asset('images/DUMMYY.png') }}">
            </div>
            <p>Mrs. Oge Anthony-Iwunze</p>
            <h4>C.E.O</h4>
        </div>

    </div>

    <!-- ABOUT ENDS  -->


    <!-- ABOUT VENTURES STARTS -->
    <div class="container-fluid mainbg">

        <div class="top-desc">
            <h1 class="top-title-md">GLUTO HUMANITARIAN EMPOWERMENT PROJECT (HEP)</h1>
        </div>

        <div class="d-flex container-body about-ventures space-between align-center">
            <div class="d-flex flex-col about-ventures-lists" data-aos="zoom-in-right">
                <div class="about-ventures-text">
                    <h4 class="about-ventures-heading">About GLUTO HUMANITARIAN EMPOWERMENT PROJECT (HEP)</h4>
                    <p class="text-blur">
                        GLUTO HUMANITARIAN EMPOWERMENT PROJECT (HEP) is a food network marketing company that offers a great
                        opportunity to help you put food on your table and at the same time become financially stable
                    </p>
                </div>

                <div class="about-ventures-text">
                    <h4 class="about-ventures-heading">Is GLUTO HUMANITARIAN EMPOWERMENT PROJECT (HEP) a registered Company?
                    </h4>
                    <p class="text-blur">
                        We are duly registered with the Coporate Affairs Commission Of Nigeria (CAC)
                    </p>
                </div>

                <div class="about-ventures-text">
                    <h4 class="about-ventures-heading">How do we generate funds?</h4>
                    <p class="text-blur">
                        We are into diverse kinds of businesses such as agricultural food storage, production and packaging,
                        distributorship, sales and projects partnership, we hope to expand our scope of business as time
                        goes on
                    </p>
                </div>

                <div class="about-ventures-text">
                    <h4 class="about-ventures-heading">How we operate</h4>
                    <p class="text-blur">
                        When you join with the sum of N4,600, it qualifies you to become a member of our community, here is
                        the breakdown of the money you will pay.<br><br>

                        <span> ₦2,000 is a non refundable registration fee while ₦2,600 is for two weeks contribution
                            payment.</span>
                    </p>
                </div>

            </div>

            <div class="ventures-slides" data-aos="zoom-in-left">
                <img src="{{ asset('images/ladytab.jpg') }}">
                <img src="{{ asset('images/ladytab.jpg') }}">
                <img src="{{ asset('images/ladytab.jpg') }}">
            </div>
        </div>

    </div>

    <!-- ABOUT VENTURES ENDS -->


    <!-- ABOUT JOIN STARTS -->
    <div class="container-fluid about-join">
        <div class="top-desc">
            <h1 class="top-title-md">Join GLUTO HUMANITARIAN EMPOWERMENT PROJECT (HEP) Today!</h1>
        </div>

        <div class="container-body">
            <div class="grid-lists" style="align-items:stretch;" data-aos="zoom-in-left">
                <div class="col-3">
                    <div class="vision-icon">
                        <img src="{{ asset('images/heart.png') }}">
                    </div>
                    <div class="vision-icon-body">
                        <p>Our Mission</p>
                        <ul class="text-blur-md" style="padding: 0 10px; text-align: justify;">
                            <li>To see everyone and every home happy</li>
                            <li>To see everyone and every home satisfied</li>
                            <li>To inculcate good saving habits on everyone and every home </li>
                            <li>To deliver the services of quality food empowerment at no cost</li>
                        </ul>
                    </div>
                </div>

                <div class="col-3">
                    <div class="vision-icon">
                        <img src="{{ asset('images/heart.png') }}">
                    </div>
                    <div class="vision-icon-body">
                        <p>Our Vision</p>
                        <p class="text-blur-md">
                            To help at least a minimum of 5 million families meet their financial needs and most importantly
                            put food on their tables.
                        </p>
                    </div>
                </div>


                <div class="col-3">
                    <div class="vision-icon">
                        <img src="{{ asset('images/heart.png') }}">
                    </div>
                    <div class="vision-icon-body">
                        <p>Our Aims & Objectives</p>
                        <p class="text-blur-md">
                            Having been in the act of touching lives and taking happiness to every family over the years, we
                            have discovered the best tool to fulfill this purpose by using the best innovations, standards,
                            and structure of human management professionalism.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- ABOUT JOIN ENDS -->


    <!-- ABOUT GALLERY STARTS -->
    <div class="container-fluid about-gallery">

        <div class="top-desc">
            <h1 class="top-title-md">Our Gallery</h1>
        </div>

        <div class="container-body">
            <div class="grid-lists" data-aos="zoom-in">
                <div class="col-3">
                    <img src="{{ asset('images/DUMMYY.png') }}">
                </div>

                <div class="col-3">
                    <img src="{{ asset('images/DUMMYY.png') }}">
                </div>

                <div class="col-3">
                    <img src="{{ asset('images/DUMMYY.png') }}">
                </div>

                <div class="col-3">
                    <img src="{{ asset('images/DUMMYY.png') }}">
                </div>

                <div class="col-3">
                    <img src="{{ asset('images/DUMMYY.png') }}">
                </div>

                <a href="gallery" class="col-3">
                    <img src="{{ asset('images/DUMMYY.png') }}">
                </a>
            </div>
        </div>
    </div>
    <!-- ABOUT GALLERY ENDS -->



    <!-- SUBSCRIBE STARTS -->
    <div class="subscribe" data-aos="zoom-in">
        <h3>Subscribe to our newsletter to get the latest news about us</h3>
        <p class="text">
            For immediate access to essential information, enter a valid email address below.
        </p>

        <form action="includes/phpfiles" class="create_mailchimp_subscription" method="POST">
            <div class="subscribe-form">
                <input type="email" name="mailchimp_subscribe_member_email_address"
                    class="mailchimp_subscribe_member_email_address" placeholder="Enter your Email address" required="">
                <button class="btn_submit_subscribe_to_mailchimp">Subscribe</button>
            </div>
        </form>

    </div>


@endsection
