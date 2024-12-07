<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Email</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">

<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; margin: auto; padding: 20px; border-collapse: collapse;">
    <tr>
        <td style="background-color: #f8f9fa; padding: 20px; text-align: center;">
            <h2 style="font-size: 24px; margin-bottom: 20px;">Password Reset Request</h2>
            <p style="font-size: 16px; margin-bottom: 20px;">We noticed that you recently requested to reset your password for your Blooming account. To complete the process, please click the link below.</p>
            <a href="{{ route('resetPassword',['token' => $token]) }}" style="display: inline-block; background-color: #007bff; color: #ffffff; text-decoration: none; font-size: 16px; padding: 10px 20px; border-radius: 4px;">Reset Password</a>
            <p style="font-size: 16px; margin-top: 20px;">If you did not request this change, please ignore this email. Your password will remain unchanged.</p>
            <p style="font-size: 16px;">Thank you,<br><strong>Blooming Team</strong></p>
        </td>
    </tr>
</table>

</body>
</html>
