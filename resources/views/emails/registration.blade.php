<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ config('app.name') }}</title>
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
    <div class="container" style="max-width: 600px; margin: 0 auto; font-family: 'Helvetica Neue', Arial, sans-serif; border: 1px solid #e1e1e1; border-radius: 6px; overflow: hidden; background-color: #ffffff;">
        <!-- Header with Logo Placeholder -->
        <div class="header" style=" padding: 25px; text-align: center; color: white;">
            <img src="{{ asset('images/logo.jpg') }}" alt="Company logo with brand name in white text on blue background" style="max-width: 150px; height: auto;">
        </div>

        <!-- Main Content -->
        <div class="content" style="padding: 30px; line-height: 1.6; color: #333;">
            <h2 style="color: #0c0d0e; margin-top: 0;">Welcome to {{ config('app.name') }}!</h2>

            <p style="margin-bottom: 20px;">Hello {{ $userData['name'] }},</p>

            <p>Thank you for creating an account with us. We're excited to have you on board!</p>

            <div style="background-color: #f8fafc; border-left: 4px solid #0c0d0e; padding: 15px; margin: 20px 0;">
                <h3 style="margin-top: 0; color: #1a1a1b;">Your Account Details:</h3>
                <p><strong>Email:</strong> {{ $userData['email'] }}</p>
                <p><strong>Referral ID:</strong> {{ $userData['referral_code'] }}</p>
                <p><strong>Registered on:</strong> {{ $userData['created_at']->format('M d, Y H:i A') }}</p>
            </div>

            <p>To get started with your new account, you can:</p>
            <ul style="padding-left: 20px;">
                <li style="margin-bottom: 8px;">Complete your profile setup</li>
                <li style="margin-bottom: 8px;">Explore our features and services</li>
                <li style="margin-bottom: 8px;">Start your first your first step to financial freedom</li>
            </ul>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('login') }}" style="display: inline-block; background-color: #823b00; color: white; text-decoration: none; padding: 12px 25px; border-radius: 4px; font-weight: bold;">Login to Your Account</a>
            </div>

            <p>If you did not create this account, please contact our support team immediately.</p>

            <p>Best regards,<br>
            The {{ config('app.name') }} Team</p>
        </div>

        <!-- Footer -->
        <div class="footer" style="background-color: #f1f9f1; padding: 20px; text-align: center; font-size: 12px; color: #64748b; border-top: 1px solid #e1e1e1;">
            <p style="margin: 5px 0;">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            {{-- <p style="margin: 5px 0;">
                <a href="{{ $privacyPolicyLink }}" style="color: #2563eb; text-decoration: none;">Privacy Policy</a> |
                <a href="{{ $termsLink }}" style="color: #2563eb; text-decoration: none;">Terms of Service</a>
            </p> --}}
            <p style="margin: 5px 0; font-size: 11px;">
                10, Bristol Road, GRA, Apapa,<br> Lagos State, Nigeria .
            </p>
        </div>
    </div>


</body>

</html>
