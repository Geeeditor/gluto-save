<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} KYC Verification</title>
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

<div class="container" style="max-width: 600px; margin: 0 auto; font-family: 'Helvetica Neue', Arial, sans-serif; border: 1px solid #e1e1e1; border-radius: 6px; overflow: hidden; background-color: #ffffff;">
    <!-- Header -->
    <div class="header" style="background-color: #f8fafc; padding: 25px; text-align: center; color: white;">
        <img src="{{ asset('images/logo.png') }}" alt="Gluto HEP Logo" style="max-width: 200px; height: auto;">
    </div>

    <!-- Main Content -->
    <div class="content" style="padding: 30px; line-height: 1.6; color: #333;">
        <h2 style="color: #010409; margin-top: 0;">KYC Application Notification</h2>

        <p>Hello {{ $kycData['name'] }},</p>

        @if($kycData['application_status'] == 'pending_approval')
            <p>Thank you for your application with Gluto HEP. We are currently processing your KYC (Know Your Customer) application.</p>

            <p>We will notify you via email once your KYC application has been processed. If you have any questions or need further assistance, please do not hesitate to contact our support team.</p>
        @elseif ($kycData['application_status'] == 'approved')
            <p>Thank you for your application with Gluto HEP. Your KYC (Know Your Customer) application status has been updated to verified.</p>
        @else
            <p>Thank you for your application with Gluto HEP. Your KYC (Know Your Customer) application status was rejected, please contact support for more enquires or reapply using a different document.</p>
        @endif

        <div style="background-color: #f8fafc; border-left: 4px solid #823b00; padding: 15px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #010409;">Your Application Details:</h3>
            <p><strong>Email:</strong> {{ $kycData['email'] }}</p>
            <p><strong>KYC Document Type:</strong> {{ $kycData['document_type'] == 'passport' ? 'Passport' : ($kycData['document_type'] == 'driver_license' ? 'Driver\'s  License' : ($kycData['document_type'] == 'national_id' ? 'NIMC' : ($kycData['document_type'] == 'voter_card' ? 'Voter\'s Card' : 'Unknown'))) }}</p>
            <p><strong>Document ID:</strong> {{ $kycData['document_id'] }}</p>
            <p><strong>Application Status:</strong> {{ $kycData['application_status'] == 'pending_approval' ? 'Pending Approval' : ($kycData['application_status'] == 'Approved' ? 'Verified' : 'Rejected' ) }}</p>

        </div>



        <p>Thank you for choosing Gluto HEP!</p>

        <p>Best regards,<br>
        The Gluto HEP Team</p>
    </div>

    <!-- Footer -->
    <div class="footer" style="background-color: #f1f9f1; padding: 20px; text-align: center; font-size: 12px; color: #64748b; border-top: 1px solid #e1e1e1;">
        <p style="margin: 5px 0;">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>

        <p style="margin: 5px 0; font-size: 11px;">
            10, Bristol Road, GRA, Apapa,<br> Lagos State, Nigeria .
        </p>
    </div>
</div>


</html>
