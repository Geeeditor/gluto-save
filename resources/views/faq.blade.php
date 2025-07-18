@extends('layouts.app')
@section('title', 'FAQ')
@section('description', 'Gluto HEP: Transforming Lives through Financial Responsibility')
@section('content')
    <!-- FAQS SEARCH STARTS -->
		<div class="d-flex justify-center faqs-search align-center mainbg">

			<div class="faqs-search-inner" data-aos="zoom-in">
				<h1 class="top-title">Frequently Asked Question(FAQs)</h1>
				<!-- <div class="search-form">
				<form>
					<input type="text" class="search-input" placeholder="Search for a question" name="">
				</form>
			</div> -->
			</div>

		</div>
		<!-- FAQS SEARCH ENDS -->


		<!-- FAQS COLLAPSE STARTS -->


		<div class="faqs-panel-container">

			<div class="d-flex flex-col faqs-panel">

				<div class="faqs-panel-list" data-aos="zoom-in-up">

					<div class="faqs-panel-top d-flex">
						<div><span class="faqs-icon-box"><i class="ri-arrow-right-line"></i></span></div>
						<div class="faqs-panel-top-heading d-flex space-between">
							<p class="faqs-panel-text">What's Gluto (HEP) all about?</p>

							<i class="ri-arrow-down-s-line panel-icon"></i>

						</div>
					</div>

					<div class="faqs-panel-body">
						<div class="faqs-panel-body-inner">
							<p class="text">
								GLUTO HUMANITARIAN EMPOWERMENT PROJECT (HEP) is a food network marketing company that
								offers you a great
								opportunity to help you put food on your table and at the same time become financially
								stable.
							</p>
						</div>
					</div>

				</div>

				<div class="faqs-panel-list" data-aos="zoom-in-up">

					<div class="faqs-panel-top d-flex">
						<div><span class="faqs-icon-box"><i class="ri-arrow-right-line"></i></span></div>
						<div class="faqs-panel-top-heading d-flex space-between">
							<p class="faqs-panel-text">How does it work / How do i Join?</p>

							<i class="ri-arrow-down-s-line panel-icon"></i>

						</div>
					</div>

					<div class="faqs-panel-body">
						<div class="faqs-panel-body-inner">
							<p class="text">
								Contribute ₦1,300 every week for 50weeks, bring one person who would have stayed up to
								5months on the platform on or before your 50weeks completes, you will get back the sum
								of ₦130,000 and foodstuff incentives worth ₦30,000 as benefit for the ₦65,000 naira you
								have contributed.
								<br><br>
								Click on the sign up button, pay the sum of ₦2,000 into the registration account number,
								upload proof of payment on the platform and the adminstrator will review it within
								24-48hrs.
							</p>
						</div>
					</div>

				</div>


				<div class="faqs-panel-list" data-aos="zoom-in-up">

					<div class="faqs-panel-top d-flex">
						<div><span class="faqs-icon-box"><i class="ri-arrow-right-line"></i></span></div>
						<div class="faqs-panel-top-heading d-flex space-between">
							<p class="faqs-panel-text">How do I resolve issues if I have any?</p>

							<i class="ri-arrow-down-s-line panel-icon"></i>

						</div>
					</div>

					<div class="faqs-panel-body">
						<div class="faqs-panel-body-inner">
							<p class="text">Use the live chat icon on the website or send WhatsApp message to
								+2347025060073 or +2347025060074
							</p>
						</div>
					</div>

				</div>




				<div class="faqs-panel-list" data-aos="zoom-in-up">

					<div class="faqs-panel-top d-flex">
						<div><span class="faqs-icon-box"><i class="ri-arrow-right-line"></i></span></div>
						<div class="faqs-panel-top-heading d-flex space-between">
							<p class="faqs-panel-text">How many Accounts can a member register in Gluto (HEP) in a
								particular month or batch?</p>

							<i class="ri-arrow-down-s-line panel-icon"></i>

						</div>
					</div>

					<div class="faqs-panel-body">
						<div class="faqs-panel-body-inner">
							<p class="text">
								Not more than 100 accounts, if a member wants to register more than 100 accounts in a
								particular month, the member must pay off outrightly and not contributing it
								instalmentally.
							</p>
						</div>
					</div>

				</div>

			</div>

		</div>


		<!-- FAQS COLLAPSE ENDS -->

		<!-- NOBLEMARIAN STARTS -->
		<div class="d-flex noblemerian">

			<div class="d-flex flex-col justify-center noblemerian-text">
				<div data-aos="slide-right">
					<h1 class="top-title">Meet our Saver of the month!</h1>

					<p class="text">
						Every month, we recognize one saver and interview them about their savings habits and how using
						the product has helped them change how they spend and save for future obligations.
					</p>

					<p class="team-slide-text">Meet Aishat <span class="arrow-icon-box"><i
								class="ri-arrow-right-line"></i></span></p>
				</div>

			</div>

			<div class="d-flex noblemerian-img">
				<img src="images/lady-smile.jpg">
			</div>

		</div>
		<!-- NOBLEMARIAN ENDS -->



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
				<br>
				<br>
				<br>
				<br>
			</form>

		</div>
		<br>
		<br>
		<br>
		<br>
@endsection
