<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status Update</title>
    {{-- <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
        }

        .content {
            margin-top: 20px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
        }
    </style> --}}
</head>

<body>
    <div class="container" style="max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; background-color: #ffffff;">
        <div class="header" style="background-color: rgb(2, 16, 2); padding: 20px; text-align: start; color: white;">
            <h1 style="margin: 0; font-size: 24px;">Payment Confirmation</h1>
        </div>
        <div class="content" style="padding: 20px; line-height: 1.6;">
            <p>Hello {{ $paymentDetails['name'] }},</p>
            @if($paymentDetails['payment_status'] == 'approved')
                <p>Your {{ $paymentDetails['payment_type'] == 'wallet_fund' ? 'Wallet Funding' : ($paymentDetails['payment_type'] == 'debt_pyt' ? 'Debt' : $paymentDetails['payment_type']) }} payment was submitted and confirmed successful.</p>
                <p>Here are the details regarding the transaction:</p>
            @elseif($paymentDetails['payment_status'] == 'pending')
                <p>Your {{ $paymentDetails['payment_type'] == 'wallet_fund' ? 'Wallet Funding' : ($paymentDetails['payment_type'] == 'debt_pyt' ? 'Debt' : $paymentDetails['payment_type']) }} payment was submitted and is pending confirmation. Expect payment confirmation soon as our team confirms your payment.</p>
                <p>Here are the details regarding the transaction:</p>
            @else
                <p>Your {{ $paymentDetails['payment_type'] == 'wallet_fund' ? 'Wallet Funding' : ($paymentDetails['payment_type'] == 'debt_pyt' ? 'Debt' : $paymentDetails['payment_type']) }} payment was unsuccessful.</p>
                <p>Here are the details regarding the transaction:</p>
            @endif
            <ul style="list-style-type: none; padding: 0;">
                <li style="margin-bottom: 10px;"><strong>Amount Paid:</strong> NGN {{ number_format($paymentDetails['amount'], 2) }}</li>
                <li style="margin-bottom: 10px; text-transform: capitalize;"><strong>Payment Method:</strong> {{ $paymentDetails['payment_method'] == 'gluto_transfer' ? 'Bank Transfer' : ($paymentDetails['payment_method'] == 'wallet_balance' ? 'Wallet Balance' : $paymentDetails['payment_method']) }}</li>
                <li style="margin-bottom: 10px;"><strong>Payment Status:</strong> {{ $paymentDetails['payment_status'] == 'pending' ? 'Pending Approval' : ($paymentDetails['payment_status'] == 'approved' ? 'Approved' : 'Failed') }}</li>
                <li style="margin-bottom: 10px;"><strong>Transaction Reference:</strong> {{ $paymentDetails['transaction_reference'] }}</li>
                @if($paymentDetails['payment_status'] == 'approved')
                    <li style="margin-bottom: 10px;"><strong>Receipt:</strong> {{ $paymentDetails['receipt'] }}</li>
                @endif
                <li style="margin-bottom: 10px; text-transform: capitalize;"><strong>Payment Purpose:</strong> {{ $paymentDetails['payment_type'] == 'wallet_fund' ? 'Wallet Funding' : ($paymentDetails['payment_type'] == 'debt_pyt' ? 'Debt Payment' : $paymentDetails['payment_type']) }}</li>
            </ul>
            <p>Thank you for your payment!</p>
        </div>
        <div class="footer" style="background-color: #f1f1f1; padding: 10px; text-align: center; font-size: 12px; color: #555;">
            <p>&copy; {{ date('Y') }} Gluto International. All rights reserved.</p>
        </div>
    </div>

</body>

</html>
