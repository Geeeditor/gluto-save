@extends('layouts.app')
@section('title', 'Home')
@section('description', 'Gluto HEP: Transforming Lives through Financial Responsibility')
@section('content')
    <!-- BANNER STARTS -->
		<div class="d-flex home-banner align-center">
			<div class="home-banner-text" data-aos="zoom-in-left">
				<h1 class="banner-title">Save Smarter,<br> Easy Payout & More.</h1>
				<p class="banner-subtitle">
					Gluto Humanitarian Empowerment Project (HEP) helps members reach financial goals by assisting them
					build a responsible saving culture that will empower them to be responsible in their family
					frontline
					and in the general society.
					<!-- Gluto HEP enables members to reach financial goals by assisting them build a responsible saving culture that will empower them to be responsible in their family frontline and in the general society. -->
				</p>

				<a class="btn banner-btn" href="{{route('register')}}">Get Started</a>

				<div class="d-flex banner-list">
					<div class="banner-list-text">
						<h3>5000<span class="text-colored">+</span></h3>
						<p class="text-blur-md">Registered Users</p>
					</div>

					<div class="banner-list-text">
						<h3>42<span class="text-colored">+</span></h3>
						<p class="text-blur-md">Events</p>
					</div>

					<div class="banner-list-text">
						<h3>11<span class="text-colored">+</span></h3>
						<p class="text-blur-md">Team</p>
					</div>
				</div>

			</div>
			<div class="d-flex flex-col home-banner-image">

				<div class="home-banner-image-wrapper" data-aos="zoom-in-right">
					<img class="banner-image" src="{{ asset('images/jarsave.png') }}">
				</div>

			</div>
		</div>

		<!-- BANNER ENDS -->


		<!-- OUR VISION STARTS  -->
		<div class="container vision">
			<div class="top-desc">
				<h1 class="top-title">Our Vision</h1>
				<p class="top-subtitle">The Gluto HEP vision is to guarantee food security and everything else that
					makes every family happy at home.</p>
			</div>

			<div class="vision-grid-list">
				<div class="swiper mySwiper" data-aos="fade-right">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<div class="vision-icon">
								<img src="{{ asset('images/users.png') }}">
							</div>
							<div class="vision-icon-body">
								<p>Members First</p>
								<p class="text-blur-md">
									Our goal is to offer our members outstanding services that enables them to expand
									their business
									and present themselves in the best possible height.

								</p>
							</div>
						</div>

						<div class="swiper-slide">
							<div class="vision-icon">
								<img src="{{ asset('images/safeguard.png') }}">
							</div>
							<div class="vision-icon-body">
								<p>Security</p>
								<p class="text-blur-md">
									Maintaining the safety and security of your money is our top priority. Our entire
									services is designed to safeguard and increase the value of your money!.
								</p>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="vision-icon">
								<img src="{{ asset('images/heart.png') }}">
							</div>
							<div class="vision-icon-body">
								<p>Passion and Pedigree</p>
								<p class="text-blur-md">
									We look for people that are passionate about what they do since they can conquer any
									challenge and learn anything.
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- OUR VISION ENDS -->

		<!-- TEAM STARTS -->
		<div class="container-fluid mainbg team">
			<div class="top-desc">
				<h1 class="top-title">Meet Our Team</h1>
				<p class="top-subtitle">The Gluto HEP team comprises of Excellent and Qualified individuals
					that have the necessary skills to give our members the best services.</p>
			</div>

			<div class="container-body">
				<div class="swiper teamSwiper" data-aos="fade-left">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<div class="team-img">
								<img src="{{ asset('images/DUMMYY.png') }}">
							</div>
							<div class="team-slide-body">
								<p class="team-slide-text">John Doe</p>
								<p class="text-blur-md" style="font-size: 14px;">(MD/CEO)</p>
							</div>

						</div>








					</div>
				</div>
			</div>
		</div>
		<!-- TEAM ENDS -->


		<!-- TESTIMONIAL STARTS -->
		<div class="testimonials container-fluid">
			<div class="top-desc">
				<h1 class="top-title">Client Testimonial</h1>
				<p class="top-subtitle">Below is an excerpt of what some of our esteemed members have to say with
					regards to the service and value system of Gluto HEP</p>
			</div>

			<div class="container-body">
				<div>
					<img class="img-round" src="{{ asset('images/81bb081f815f15d8122ebd90bd11fa08.jpeg') }}">
					<img class="img-round" src="{{ asset('images/d5082117c608d1c060402d900deccb56.png') }}">
					<img class="img-round" src="{{ asset('images/02c19e3fc2b491bde0f85bee81468101.jpeg') }}">
					<img class="img-round" src="{{ asset('images/1d2066f0a54680b0c593b148c114058b.jpeg') }}">
					<img class="img-round" src="{{ asset('images/f23dc12c5c48464c7ed6904aba333832.jpeg') }}">
					<img class="img-round" src="{{ asset('images/1026e0c7b5c5a5c8f8561b91f29601f5.jpeg') }}">
					<img class="img-round" src="{{ asset('images/ce3d2f6f64d62f7f54cc36a8fe821341.jpeg') }}">
					<img class="img-round" src="{{ asset('images/3415b9bbd4d6af186e32f0364906d4c0.jpeg') }}">
				</div>

				<div class="testimonial-slides-wrapper">
					<div class="swiper testimonialSwiper">
						<div class="swiper-wrapper">
							<div class="swiper-slide" data-aos="zoom-out">
								<img class="testimonial-slides-img" src="{{ asset('images/37f89a80a2f0e44850266e70e882beb7.jpeg') }}">

								<div class="testimonial-slides-box">
									<p class="quote">
										Gluto HEP is the best as you continue to touch lifes, yours is already secured
										in God's hand, am so so happy, thank you once again our able ceo and her able
										admins...
									</p>
								</div>

								<div>
									<p class="team-slide-text">Bankole Yusuf</p>
									<p class="text-blur-md">Lagos Nigeria</p>
								</div>
							</div>

							<div class="swiper-slide">
								<img class="testimonial-slides-img" src="{{ asset('images/acf3ae3a9a052ba9d97ff9831faa947e.jpeg') }}">

								<div class="testimonial-slides-box">
									<p class="quote">
										Here i found honest and sincere people, God bless you, our ceo and all of you
										who makes it happen to here. My special thanks to akpachukwu loveth who made me
										to know Gluto HEP.
									</p>
								</div>

								<div>
									<p class="team-slide-text">Aishat</p>
									<p class="text-blur-md">Lagos Nigeria</p>
								</div>
							</div>

							<div class="swiper-slide">
								<img class="testimonial-slides-img" src="{{ asset('images/37f89a80a2f0e44850266e70e882beb7.jpeg') }}">

								<div class="testimonial-slides-box">
									<p class="quote">
										I just want to say thank you ma. I gave my provisions and foodstuff to my aunt
										because she needed it more than me and she so so happy. thank you for making a
										family happy. May this system last for us all.
									</p>
								</div>

								<div>
									<p class="team-slide-text">Titilope Bankole</p>
									<p class="text-blur-md">Lagos Nigeria</p>
								</div>
							</div>

							<div class="swiper-slide">
								<img class="testimonial-slides-img" src="{{ asset('images/37f89a80a2f0e44850266e70e882beb7.jpeg') }}">

								<div class="testimonial-slides-box">
									<p class="quote">
										My june Empowerment alerts thank God for this very day. God keep our Gluto HEP
										moving
									</p>
								</div>

								<div>
									<p class="team-slide-text">Pamilerin Yusuf</p>
									<p class="text-blur-md">Lagos Nigeria</p>
								</div>
							</div>

							<div class="swiper-slide">
								<img class="testimonial-slides-img" src="{{ asset('images/37f89a80a2f0e44850266e70e882beb7.jpeg') }}">

								<div class="testimonial-slides-box">
									<p class="quote">
										Thank so much our unique CEO, alert received. Gluto HEP keeps getting higher,
										bigger and unstoppable.

									</p>
								</div>

								<div>
									<p class="team-slide-text">Abimbola Bankole</p>
									<p class="text-blur-md">FCT Abuja</p>
								</div>
							</div>
						</div>
						<div class="">
							<span class="pagination-box prev-pagination">
								<i class="ri-arrow-left-line"></i>
							</span>

							<span class="pagination-box next-pagination">
								<i class="ri-arrow-right-line"></i>
							</span>
						</div>

					</div>
				</div>

			</div>
		</div>
		<!-- TESTIMONIAL ENDS -->

		<!-- NOBLEMARIAN STARTS -->
		<div class="d-flex noblemerian">

			<div class="d-flex flex-col justify-center noblemerian-text">
				<div data-aos="fade-right">
					<h1 class="top-title">Meet our Noblemerrian of the month!</h1>

					<p class="text">
						Every month, we recognize one saver and interview them about their savings habits and how using
						the product has helped them change how they spend and save for future obligations.
					</p>

					<p class="team-slide-text">Meet Aishat <span class="arrow-icon-box"><i
								class="ri-arrow-right-line"></i></span></p>
				</div>

			</div>

			<div class="d-flex noblemerian-img">
				<img src="{{ asset('images/lady-smile.jpg') }}">
			</div>

		</div>
		<!-- NOBLEMARIAN ENDS -->


		<!-- HOW TO SIGN UP STARTS  -->
		<div class="container signup">
			<div class="top-desc">
				<h1 class="top-title">How to signup</h1>
			</div>

			<div class="grid-lists vision-grid-list" style="align-items: stretch;" data-aos="slide-up">
				<div class="col-3 signup-col bg1" data-attr="1">
					<p class="text-md">
						To get started as a new user, kindly click on the Sign Up button on the homepage header navbar
						section and this will redirect you to the registration page.
						<!-- <br><br> <span style="color: red; font-weight: bold;">NB: </span> -->


						<br><br> <span style="color: white; font-weight: bold;">NB: IF YOU UPLOADED A FAKE PAYMENT
							PROOF,
							YOUR ACCOUNT WOULD BE FLAGGED AND WOULD NOT HAVE ACCESS TO LOGIN USING YOUR CREDENTIALS.
						</span>
					</p>
				</div>
				<div class="col-3 signup-col bg1" data-attr="2">
					<p class="text-md">
						On the registration page, input your correct informations on each provided fields but take note
						that the <b>referral id field</b> in the registration form page is optional.<br><br>
						After a successful registration, you would be redirected to the payment option page where you
						would have to select your preferred payment option (manual transfer to Gluto HEP Bank Account
						or Automated Online Payment) to pay for the sum of ₦3,000 FOR REGISTRATION FEE.
					</p>
				</div>
				<div class="col-3 signup-col bg1" data-attr="3">
					<p class="text-md">
						If you transferred to our bank account manually, you would need to upload a proof of payment and
						this payment proof would be reviewed and your Gluto HEP member account would be activated
						within 24-48hrs, that is when you can now have access to login to your dashboard.<br><br> But if
						you're using/used the flutterwave online payment gateway option, your Gluto HEP member account
						would be activated instantly after successful payment and you would be redirected to your noble
						merry dashboard from the payment gateway.</p>
				</div>
			</div>
		</div>

		<!-- HOW TO SIGN UP ENDS -->


		<!-- BRIDGING GAP STARTS  -->
		<div class="d-flex container-fluid bridging space-between align-center" data-aos="zoom-in-up"
			style="margin-top: 100px;">

			<div class="d-flex">
				<img src="{{ asset('images/5044b4fffff489e4480435015f9c0cf5.png') }}">
			</div>

			<div class="bridging-text">
				<h2 class="top-title-md">
					Bridging the gap between the poor and the rich
				</h2>

				<p class="text-md">We have successfully end the issues of hunger amongst our members, using our best
					savings practices.</p>

				<a href="{{route('register')}}" class="btn">Get Started</a>
			</div>
		</div>
		<!-- BRIDGING GAP STARTS  -->



		<!-- SUBSCRIBE STARTS -->
		<div class="subscribe" data-aos="zoom-in">
			<h3>Subscribe to our newsletter to get the latest news about us</h3>
			<p class="text">
				For immediate access to essential information, enter a valid email address below.
			</p>

			<form action="" class="create_mailchimp_subscription" method="POST">
				<div class="subscribe-form">
					<input type="email" name="mailchimp_subscribe_member_email_address"
						class="mailchimp_subscribe_member_email_address" placeholder="Enter your Email address"
						required="">
					<button class="btn_submit_subscribe_to_mailchimp">Subscribe</button>
				</div>
			</form>

		</div>
		<br>
		<br>
		<br>
		<br>
		<!-- SUBSCRIBE ENDS -->
@endsection
