<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us Email</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; background-color: #f4f4f4; padding: 20px;">

<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <tr>
        <td style="padding: 40px;">
            <h2 style="font-size: 24px; margin-bottom: 20px; color: #333333;">Contact Us Message</h2>
            <p style="font-size: 16px; margin-bottom: 10px; color: #666666;"><strong>Name:</strong> {{ $data['name'] }}</p>
            <p style="font-size: 16px; margin-bottom: 10px; color: #666666;"><strong>Email:</strong> {{ $data['email'] }}</p>
            <p style="font-size: 16px; margin-bottom: 20px; color: #666666;"><strong>Message:</strong><br>{{ $data['message'] }}</p>
        </td>
    </tr>
</table>

</body>
</html>
