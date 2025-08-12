<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} Withdrawal Notification</title>
</head>

<body style="font-family: 'Helvetica Neue', Arial, sans-serif;">
    <div class="container" style="max-width: 600px; margin: 0 auto; border: 1px solid #e1e1e1; border-radius: 6px; overflow: hidden; background-color: #ffffff;">
        <!-- Header -->
        <div class="header" style="background-color: #f8fafc; padding: 25px; text-align: center;">
            <img src="{{ asset('images/logo.png') }}" alt="Gluto HEP Logo" style="max-width: 200px; height: auto;">
        </div>

        <!-- Main Content -->
        <div class="content" style="padding: 30px; line-height: 1.6; color: #333;">
            <h2 style="color: #010409; margin-top: 0;">Withdrawal Notification</h2>

            <p>Hello {{ $withdrawalData['name'] }},</p>

            @if ($withdrawalData['withdrawal_status'] == 'pending')
                <p>Thank you for your withdrawal request with Gluto HEP. We are currently processing your request. Please check your dashboard for more information.</p>

                <p>We will notify you via email once your withdrawal has been processed. If you have any questions or need further assistance, please do not hesitate to contact our support team.</p>
            @elseif ($withdrawalData['withdrawal_status'] == 'approved')
            <p>Thank you for your withdrawal request with Gluto HEP. Your withdrawal was processed successfully. Please check your dashboard for more information.</p>
            @else
            <p>There was an issue with processing your withdrawal request. please try again or contact support if your balance was deducted</p>
            @endif



            <p>Here are the details of your withdrawal:</p>
            <div style="background-color: #f8fafc; border-left: 4px solid #823b00; padding: 15px; margin: 20px 0;">
                <p><strong>Amount:</strong> {{ number_format($withdrawalData['amount'], 2) }} </p>
                <p><strong>Transaction Reference:</strong> {{ $withdrawalData['transaction_reference'] }}</p>
                <p><strong>Status:</strong> {{ ucfirst($withdrawalData['withdrawal_status']) }}</p>
            </div>



            <p>Thank you for choosing Gluto HEP!</p>

            <p>Best regards,<br>
            The Gluto HEP Team</p>
        </div>

        <!-- Footer -->
        <div class="footer" style="background-color: #f1f9f1; padding: 20px; text-align: center; font-size: 12px; color: #64748b; border-top: 1px solid #e1e1e1;">
            <p style="margin: 5px 0;">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p style="margin: 5px 0; font-size: 11px;">
                10, Bristol Road, GRA, Apapa,<br> Lagos State, Nigeria.
            </p>
        </div>
    </div>
</body>

</html>
