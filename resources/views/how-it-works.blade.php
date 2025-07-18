@extends('layouts.app')
@section('title', 'How it works')
@section('description', 'Gluto HEP: Transforming Lives through Financial Responsibility')
@section('content')
    <div class="d-flex home-banner how-it-works-banner align-center">

        <div class="how-it-works-banner-text" data-aos="zoom-in-left">
            <h1 class="banner-title">How it works</h1>
            <p class="text-lg">
                Our goal as an organization is to make sure our members are well equiped with the knowledge of how
                to fully enjoy features that are meant for them.
            </p>
            <p class="text-lg">Find out more on how this works below</p>

        </div>

        <img src="{{ asset('images/curve-arrow.png') }}" class="curve-arrow">

        <div class="how-it-works-banner-img" data-aos="zoom-in-right">
            <img src="{{ asset('images/jarsave.png') }}">
            <img src="{{ asset('images/jarsave.png') }}">
            <img src="{{ asset('images/jarsave.png') }}">
        </div>

    </div>

    <div class="container-fluid how-it-works">
        <div class="how-it-works-tabs swiper howItWorksSwiper">
            <div class="swiper-wrapper">
                <span class="swiper-slide tabs-active" data-id="tab1">Register Your Account</span>
                <span class="swiper-slide" data-id="tab2">Fund Your Account</span>
                <span class="swiper-slide" data-id="tab3">Activate Fast-track</span>
                <span class="swiper-slide" data-id="tab4">Withdraw your funds</span>
                <span class="swiper-slide" data-id="tab5">Use Multiple Accounts</span>
            </div>
        </div>

        <div class="tabs-wrapper">
            <!-- TAB ONE STARTS -->
            <div class="grid-lists how-it-works-grid-list how-it-works-grid-list-active" id="tab1">
                <div class="col-3" data-aos="slide-up">
                    <div class="d-flex flex-col align-center how-it-works-heading-wrapper">
                        <div class="how-it-works-no-box">1</div>
                        <h3 class="text-center how-it-works-heading">Access Registration Page</h3>
                    </div>

                    <div class="how-it-works-list">
                        <p class="text-md">To get started as a new user, kindly click on the Sign Up button on the
                            homepage header navbar section and this will redirect you to the registration page.
                            <br><br> <span style="color: red; font-weight: bold;">NB: YOU NEED TO PAY THE SUM OF
                                ₦3,000 FOR REGISTRATION FEE ONCE YOU'RE REDIRECTED TO THE PAYMENT SECTION AFTER A
                                SUCCESSFUL REGISTRATION</span>


                            <br><br> <span style="color: red; font-weight: bold;">NB: IF YOU UPLOADED A FAKE PAYMENT
                                PROOF, YOUR ACCOUNT WOULD BE FLAGGED AND WOULD NOT HAVE ACCESS TO LOGIN USING YOUR
                                CREDENTIALS.
                                <!-- To regain access to your account, contact our support via support@GLUTO (HEP) company.com or use the livechat on our website. --></span>
                        </p>
                    </div>
                </div>

                <div class="col-3" data-aos="slide-up" data-aos-delay="100">

                    <div class="d-flex flex-col align-center how-it-works-heading-wrapper">
                        <div class="how-it-works-no-box">2</div>
                        <h3 class="text-center how-it-works-heading">Input correct details & Submit</h3>
                    </div>
                    <div class="how-it-works-list">
                        <p class="text-md">
                            On the registration page, input your correct informations on each provided fields but
                            take note that the <b>referral id field</b> in the registration form page is
                            optional.<br><br>
                            After a successful registration, you would be redirected to the payment option page
                            where you would have to select your preferred payment option (manual transfer to Noble
                            Merry Bank Account or Automated Online Payment) to pay for the sum of ₦3,000 FOR
                            REGISTRATION FEE.
                        </p>
                    </div>


                </div>


                <div class="col-3" data-aos="slide-up" data-aos-delay="200">

                    <div class="d-flex flex-col align-center how-it-works-heading-wrapper">
                        <div class="how-it-works-no-box">3</div>
                        <h3 class="text-center how-it-works-heading">Account Activation Processes</h3>

                    </div>

                    <div class="how-it-works-list">
                        <p class="text-md">If you transferred to our bank account manually, you would need to upload
                            a proof of payment and this payment proof would be reviewed and your GLUTO (HEP) member
                            account would be activated within 24-48hrs, that is when you can now have access to
                            login to your dashboard.<br><br> But if you're using/used the flutterwave online payment
                            gateway option, your GLUTO (HEP) member account would be activated instantly after
                            successful payment and you would be redirected to your GLUTO (HEP) dashboard from the
                            payment gateway.</p>
                    </div>

                </div>
            </div>
            <!-- TAB ONE ENDS -->


            <!-- TAB TWO STARTS -->
            <div class="grid-lists how-it-works-grid-list" id="tab2">
                <div class="col-3" data-aos="slide-up">
                    <div class="d-flex flex-col align-center how-it-works-heading-wrapper">
                        <div class="how-it-works-no-box">1</div>
                        <h3 class="text-center how-it-works-heading">Login to Dashboard</h3>
                    </div>

                    <div class="how-it-works-list">
                        <p class="text-md">On the login page, input your valid login credentials before you will be
                            redirected to your dashboard.</p>
                    </div>
                </div>

                <div class="col-3" data-aos="slide-up">
                    <div class="d-flex flex-col align-center how-it-works-heading-wrapper">
                        <div class="how-it-works-no-box">2</div>
                        <h3 class="text-center how-it-works-heading">Activate your account</h3>
                    </div>

                    <div class="how-it-works-list">
                        <p class="text-md">After login, fill up your next of kin data information under the profile
                            section before your account can be activated.</p>
                    </div>
                </div>

                <div class="col-3" data-aos="slide-up">
                    <div class="d-flex flex-col align-center how-it-works-heading-wrapper">
                        <div class="how-it-works-no-box">3</div>
                        <h3 class="text-center how-it-works-heading">Fund your wallet</h3>
                    </div>

                    <div class="how-it-works-list">
                        <p class="text-md">After account has been activated, you can now go to the fund wallet
                            section of your dashboard sidebar to fund your account.</p>
                    </div>
                </div>
            </div>
            <!-- TAB TWO ENDS -->

            <!-- TAB THREE STARTS -->
            <div class="grid-lists how-it-works-grid-list" id="tab3">
                <div class="col-3" data-aos="slide-up">
                    <div class="d-flex flex-col align-center how-it-works-heading-wrapper">
                        <div class="how-it-works-no-box">1</div>
                        <h3 class="text-center how-it-works-heading">Subscribe for a thrift package</h3>
                    </div>

                    <div class="how-it-works-list">
                        <p class="text-md">Subscribe for any thrift package of your choice on your dashboard.</p>
                    </div>
                </div>

                <div class="col-3" data-aos="slide-up">
                    <div class="d-flex flex-col align-center how-it-works-heading-wrapper">
                        <div class="how-it-works-no-box">2</div>
                        <h3 class="text-center how-it-works-heading">Refer five people</h3>
                    </div>

                    <div class="how-it-works-list">
                        <p class="text-md">Refer atleast five people with a certain account referral id and each of
                            them must have an active thrift package running before you can be able to fast track
                            your thrift.</p>
                    </div>
                </div>


                <div class="col-3" data-aos="slide-up">
                    <div class="d-flex flex-col align-center how-it-works-heading-wrapper">
                        <div class="how-it-works-no-box">3</div>
                        <h3 class="text-center how-it-works-heading">Activate fast-track</h3>
                    </div>

                    <div class="how-it-works-list">
                        <p class="text-md">You can then activate fast track on your current running thrift which the
                            maturity date will be reduced by five months(22 weeks).<br><br>

                            <span style="color: red;">NOTE: Your five (5) referred people must be nothing less than
                                5 months on the platform before your 6 months maturity date.</span>
                        </p>
                    </div>
                </div>
            </div>
            <!-- TAB THREE ENDS -->

            <!-- TAB FOUR STARTS -->
            <div class="grid-lists how-it-works-grid-list" id="tab4">
                <div class="col-3" data-aos="slide-up">
                    <div class="d-flex flex-col align-center how-it-works-heading-wrapper">
                        <div class="how-it-works-no-box">1</div>
                        <h3 class="text-center how-it-works-heading">Add Your account details</h3>
                    </div>

                    <div class="how-it-works-list">
                        <p class="text-md">You need to add your bank account details on your dashboard section.</p>
                    </div>
                </div>

                <div class="col-3" data-aos="slide-up">
                    <div class="d-flex flex-col align-center how-it-works-heading-wrapper">
                        <div class="how-it-works-no-box">2</div>
                        <h3 class="text-center how-it-works-heading">Request for withdraw</h3>
                    </div>

                    <div class="how-it-works-list">
                        <p class="text-md">Clear any outstanding thrift and fine if any before requesting for
                            withdrawal. Admin will then review and fund your bank account within 24 - 48 hours.</p>
                    </div>
                </div>
            </div>
            <!-- TAB FOUR ENDS -->


            <!-- TAB FIVE STARTS -->
            <div class="grid-lists how-it-works-grid-list" id="tab5">
                <div class="col-3" data-aos="slide-up">
                    <div class="d-flex flex-col align-center how-it-works-heading-wrapper">
                        <div class="how-it-works-no-box">1</div>
                        <h3 class="text-center how-it-works-heading">Create multiple account</h3>
                    </div>

                    <div class="how-it-works-list">
                        <p class="text-md">You can create multiple accounts from the profile section on your
                            dashboard.</p>
                    </div>
                </div>


                <div class="col-3" data-aos="slide-up">
                    <div class="d-flex flex-col align-center how-it-works-heading-wrapper">
                        <div class="how-it-works-no-box">2</div>
                        <h3 class="text-center how-it-works-heading">Switch account</h3>
                    </div>

                    <div class="how-it-works-list">
                        <p class="text-md">You can switch to any account of your choice with the top toggle button
                            on your dashboard.</p>
                    </div>
                </div>

            </div>
            <!-- TAB FIVE ENDS -->






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
                    class="mailchimp_subscribe_member_email_address" placeholder="Enter your Email address"
                    required="">
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
