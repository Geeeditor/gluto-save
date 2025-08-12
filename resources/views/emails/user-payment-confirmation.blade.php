<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} Payment Notification</title>
</head>

<body style="font-family: 'Helvetica Neue', Arial, sans-serif;">
    <div class="container" style="max-width: 600px; margin: 0 auto; border: 1px solid #e1e1e1; border-radius: 6px; overflow: hidden; background-color: #ffffff;">
        <!-- Header -->
        <div class="header" style="background-color: #f8fafc; padding: 25px; text-align: center;">
            <img src="{{ asset('images/logo.png') }}" alt="Gluto HEP Logo" style="max-width: 200px; height: auto;">
        </div>

        <!-- Main Content -->
        <div class="content" style="padding: 30px; line-height: 1.6; color: #333;">
            <h2 style="color: #010409; margin-top: 0;">Payment Confirmation</h2>

            <p>Hello {{ $paymentDetails['name'] }},</p>
            @if($paymentDetails['payment_status'] == 'approved')
                <p>Your {{ $paymentDetails['payment_type'] == 'wallet_fund' ? 'Wallet Funding' : ($paymentDetails['payment_type'] == 'debt_pyt' ? 'Debt' : $paymentDetails['payment_type']) }} payment was submitted and confirmed successful.</p>
            @elseif($paymentDetails['payment_status'] == 'pending')
                <p>Your {{ $paymentDetails['payment_type'] == 'wallet_fund' ? 'Wallet Funding' : ($paymentDetails['payment_type'] == 'debt_pyt' ? 'Debt' : $paymentDetails['payment_type']) }} payment was submitted and is pending confirmation. Expect payment confirmation soon as our team confirms your payment.</p>
            @else
                <p>Your {{ $paymentDetails['payment_type'] == 'wallet_fund' ? 'Wallet Funding' : ($paymentDetails['payment_type'] == 'debt_pyt' ? 'Debt' : $paymentDetails['payment_type']) }} payment was unsuccessful.</p>
            @endif

            <p>Here are the details regarding the transaction:</p>
            <div style="background-color: #f8fafc; border-left: 4px solid #823b00; padding: 15px; margin: 20px 0;">
                <ul style="list-style-type: none; padding: 0;">
                    <li style="margin-bottom: 10px;"><strong>Amount Paid:</strong> NGN {{ number_format($paymentDetails['amount'], 2) }}</li>
                    <li style="margin-bottom: 10px; text-transform: capitalize;"><strong>Payment Method:</strong> {{ $paymentDetails['payment_method'] == 'gluto_transfer' ? 'Bank Transfer' : ($paymentDetails['payment_method'] == 'wallet_balance' ? 'Wallet Balance' : $paymentDetails['payment_method']) }}</li>
                    <li style="margin-bottom: 10px;"><strong>Payment Status:</strong> {{ ucfirst($paymentDetails['payment_status']) }}</li>
                    <li style="margin-bottom: 10px;"><strong>Transaction Reference:</strong> {{ $paymentDetails['transaction_reference'] }}</li>
                    @if($paymentDetails['payment_status'] == 'approved')
                        <li style="margin-bottom: 10px;"><strong>Receipt:</strong> {{ $paymentDetails['receipt'] }}</li>
                    @endif
                    <li style="margin-bottom: 10px; text-transform: capitalize;"><strong>Payment Purpose:</strong> {{ $paymentDetails['payment_type'] == 'wallet_fund' ? 'Wallet Funding' : ($paymentDetails['payment_type'] == 'debt_pyt' ? 'Debt Payment' : $paymentDetails['payment_type']) }}</li>
                </ul>
            </div>

            <p>Thank you for your payment!</p>
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
