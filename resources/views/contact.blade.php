@extends('layouts.app')
@section('title', 'Contact US')
@section('description', 'Gluto HEP: Transforming Lives through Financial Responsibility')
@section('content')
    <div class="page-desc">
        <h1 class="page-title">Contact Us</h1>
    </div>

    <div class="container-fluid contact-us">
        <div class="d-flex contact-box-wrapper">
            <div class="d-flex flex-col bg-default contact-us-box">

                <h2>Contact Information</h2>


                <div class="d-flex flex-col contact-desc-list">

                    <!--	<div class="d-flex contact-desc-text align-center">
                        <i class="ri-map-pin-2-fill"></i>
                        <p class="text-md">74 Ailegun road, Bucknor Ejigbo, Lagos Nigeria</p>
                    </div>-->

                    <div class="d-flex contact-desc-text align-center">

                        <p class="text-md"><i class="ri-phone-fill"></i><a href="tel:+234 80 867 782 87">+234 80 867
                                782 87</a></p>


                    </div>

                    <div class="d-flex contact-desc-text align-center">
                        <i class="ri-mail-fill"></i>
                        <p class="text-md"><a
                                href="mailto:info@glutointernational.com
                        ">info@glutointernational.com
                            </a></p>
                    </div>

                    <!--<div class="d-flex contact-desc-text align-center">
                        <p>To speak with an admin on update related issues, call.... <a href="tel:07025060073">07025060073</a> OR <a href="tel:07025060074">07025060074</a></p>
                    </div>-->
                </div>

                <div class="d-flex justify-center contact-list-icon">
                    <a href="javascript:void()" class="contact-icon"><i class="ri-instagram-line"></i></a>
                    <a href="javascript:void()" class="contact-icon"><i class="ri-linkedin-fill"></i></a>
                    <a href="javascript:void()" class="contact-icon"><i class="ri-facebook-line"></i></a>
                    <a href="javascript:void()" class="contact-icon"><i class="ri-twitter-fill"></i></a>
                    <a href="javascript:void()" class="contact-icon"><i class="ri-youtube-fill"></i></a>
                </div>



            </div>
            <div class="contact-us-box">
                <h2 class="blur">Got any questions or remark for us? Write us a message!</h2>

                <div class="container-body">
                    <form class="form">

                        <div class="form-group-sm">
                            <input type="text" class="form-control-sm" placeholder="Full Name" name=""
                                required="">
                        </div>


                        <div class="form-group-sm">
                            <input type="email" class="form-control-sm" placeholder="Email Address" name=""
                                required="">
                        </div>

                        <div class="form-group-sm">
                            <input type="number" class="form-control-sm" placeholder="Phone Number" name=""
                                required="">
                        </div>

                        <div class="form-group-sm">
                            <textarea class="form-control-sm" placeholder="Type your message here" rows="10" required=""></textarea>
                        </div>

                        <div class="form-group-sm d-flex justify-center">
                            <button class="form-btn-sm">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>




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
        <br>
        <br>
        <br>
        <br>

    </div>
    <!-- SUBSCRIBE ENDS -->
@endsection
