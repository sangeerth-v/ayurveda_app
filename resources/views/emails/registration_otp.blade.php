<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registration OTP</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7f5; margin: 0; padding: 20px; color: #2d6a4f; }
        .container { max-width: 500px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 12px; border: 1px solid #d8f3dc; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .header { text-align: center; border-bottom: 2px solid #e8f3ec; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { color: #1a4d2e; font-size: 22px; margin: 0; }
        .otp-box { background: #e8f5e9; font-size: 32px; font-weight: bold; color: #1a4d2e; text-align: center; letter-spacing: 8px; padding: 15px; border-radius: 8px; margin: 25px 0; border: 1px dashed #2d6a4f; }
        .footer { font-size: 12px; color: #888888; text-align: center; margin-top: 25px; border-top: 1px solid #eeeeee; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🌿 Ayurveda App</h1>
        </div>
        <p>Hello <strong>{{ $name }}</strong>,</p>
        <p>Thank you for registering with Ayurveda. Please use the One-Time Password (OTP) below to verify your email address and complete your registration:</p>
        
        <div class="otp-box">
            {{ $otp }}
        </div>
        
        <p style="font-size: 0.9rem; color: #555555;">This OTP is valid for <strong>10 minutes</strong>. Do not share this code with anyone for security reasons.</p>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Ayurveda App. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
