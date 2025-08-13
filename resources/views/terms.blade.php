@extends('layouts.app')
@section('title', 'How it works')
@section('description', 'Gluto HEP: Transforming Lives through Financial Responsibility')
@section('content')

    <div class="container-fluid">
        <div class="page-desc">
            <h1 class="page-title">Terms and Conditions</h1>
        </div>

        <ol class="lists">
            <li>You are expected to pay a non refundable registration sum of ₦3,500 only.</li>
            <li>You must pay into your virtual account before 11:59pm every Friday if you are paying every week.
            </li>
            {{-- <li>If you fail to pay into your virtual account before 11:59 on a Particular Friday, it will attract a
                100% fine.</li> --}}
            {{-- <li>Every member must introduce atleast one person under a particular account who must be up to 5months
                on the system before the account can be empowered with ₦130,000 and foodstuff.</li> --}}
            <li>Any account on fast track must introduce five downlines under the account within 40 days of it’s
                registration or it will no longer be termed fast track.</li>
            <li>Fast track account downlines must be nothing less than 6 months on the system while the 5 downlines
                must be nothing less than 5months before the fast track account will be empowered.</li>
            <li>Uploading of fake proof of payment will lead to cancellation of an account.</li>
            <li>Every account must contribute the sum of ₦65,000 before it can be empowered </li>
            {{-- <li>Every account holder in Noble merry must buy the company branded T.shirt before the person will get
                his/her food empowerment </li> --}}
            <li>We respect user privacy so termination of account can be done from your profile </li>
            <li>No KYC section, no food on the table.</li>
            <li>{{config('app.name')}} Payment is within 3 working days from the date of withdrawal application.
            </li>
            {{-- <li>For account change of ownership, the new owner must pay the sum of ₦5,000 before the details would
                be changed to the new owners.</li> --}}
            <li>Any account taken over by a new owner will no longer be the downline of the old owner and would require a new KYC.</li>
            {{-- <li>A member is advised to provide a trusted next of kin, that will get his or her contribution refund
                in case the member dies.</li> --}}
            {{-- <li>Noble Merry will not pay a dead member 50% benefit if the member dies before his or her 50 weeks
                thrift maturity date.</li> --}}
            <li>{{config('app.name')}} contribution empowerment is after 52wks.</li>
            <li>After making payment for your registration, you have 48hrs to pay into your virtual account for your
                contribution payment or else your account will be deactivated and you will have to pay another
                registration money to activate your account.</li>
            <li>Note that any mistake made during your registration is at your cost, {{config('app.name')}} will not be held
                responsible for any of such mistakes.</li>
            <li>Any payment made in the name of {{config('app.name')}},that is not confirmed will require further
                investigation from the depositor which will require the depositor providing his or her statement of
                account and any other information that will be required by {{config('app.name')}} to further
                investigate the transaction.</li>
            <li>All manually uploaded transaction will take within 24 to 48 hours before the transactions will be
                confirmed.</li>
            <!--<li>Any wallet funding upload after 11:59pm on friday will attract a 100% fine payment, you are hereby advised to fund your wallet latest by 4pm every saturday</li>-->
            <li>Any account with 4 weeks+ defaults will be suspended.
            </li>
            <li>No Active Downline within six (6) months of registration, No Incentive</li>

        </ol>
    </div>





    <br>
    <br>
    <br>

<!-- SUBSCRIBE STARTS -->
<div class="subscribe" data-aos="zoom-in">
    <h3>Subscribe to our newsletter to get the latest news about us</h3>
    <p class="text">
        For immediate access to essential information, enter a valid email address below.
    </p>

    <form action="includes/phpfiles" class="create_mailchimp_subscription" method="POST">
        <div class="subscribe-form">
            <input type="email" name="mailchimp_subscribe_member_email_address"
                class="mailchimp_subscribe_member_email_address" placeholder="Enter your Email address" required>
            <button class="btn_submit_subscribe_to_mailchimp">Subscribe</button>
        </div>
    </form>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

</div>
<!-- SUBSCRIBE ENDS -->
@endsection
