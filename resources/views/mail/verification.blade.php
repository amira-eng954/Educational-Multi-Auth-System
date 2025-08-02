<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
        }

        .logo {
            max-width: 150px;
            height: auto;
        }

        .content {
            padding: 20px;
        }

        .verification-code {
            background-color: #f8f9fa;
            border: 1px dashed #ccc;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            margin: 20px 0;
            color: #2c3e50;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 10px 0;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #eee;
        }

        .social-icons {
            margin: 20px 0;
        }

        .social-icon {
            margin: 0 10px;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Verify Your Email Address</h1>
        </div>

        <div class="content">
            <p>Hello</p>

            <p>Thank you for registering with El Molium. To complete your registration, please verify your email address
                by entering the following verification code:</p>

            <div class="verification-code">
                {{ $code }}
            </div>

            <p>This code will expire in 60 minutes. If you didn't request this code, you can safely ignore this email.
            </p>

        </div>

        <div class="footer">
            <p>© 2025 Elmullim. All rights reserved.</p>
            <p>You're receiving this email because you signed up for an account with Elmullim.</p>
        </div>
    </div>
</body>

</html>
