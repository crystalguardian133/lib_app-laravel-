<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request</title>
</head>
<body style="font-family: 'Outfit', Arial, sans-serif; background-color: #f8fafc; color: #334155; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #2fb9eb; margin: 0;">Julita Public Library</h1>
            <p style="color: #94a3b8; margin: 10px 0 0 0;">Password Reset Request</p>
        </div>

        <p style="margin-bottom: 20px;">Hello <strong>{{ $user->name }}</strong>,</p>

        <p style="margin-bottom: 20px;">We received a request to reset the password for your account. To verify your identity and reset your password, please click the button below:</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $verificationUrl }}" style="display: inline-block; padding: 12px 40px; background-color: #2fb9eb; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600; transition: background-color 0.3s;">
                Verify and Reset Password
            </a>
        </div>

        <p style="margin-bottom: 20px;">Or copy and paste this link in your browser:</p>
        <p style="background-color: #f1f5f9; padding: 12px; border-radius: 6px; word-break: break-all; color: #64748b; font-size: 12px; margin-bottom: 20px;">{{ $verificationUrl }}</p>

        <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 6px; margin: 30px 0;">
            <p style="margin: 0; color: #92400e; font-size: 14px;">
                <strong>⏰ This link will expire in 1 hour.</strong> If you don't reset your password within this time, you'll need to request a new reset link.
            </p>
        </div>

        <div style="background-color: #fecaca; border-left: 4px solid #ef4444; padding: 15px; border-radius: 6px; margin: 30px 0;">
            <p style="margin: 0; color: #7f1d1d; font-size: 14px;">
                <strong>🔒 If you didn't request this,</strong> someone may have entered your email by mistake. You can safely ignore this email, and your password will remain unchanged.
            </p>
        </div>

        <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 30px 0;">

        <p style="color: #94a3b8; font-size: 12px; text-align: center; margin: 0;">
            © 2026 Julita Public Library. All rights reserved.<br>
            This is an automated email. Please do not reply directly to this message.
        </p>
    </div>
</body>
</html>
