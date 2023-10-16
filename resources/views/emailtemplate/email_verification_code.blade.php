<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <div>
        <span>Dear {{$user_data->full_name}}, </span>
    </div>
    <br>
    <div>
        <span>Please use the verification code below to access your account.</span>
    </div>
    <br>
    <span>{{ $otp_code }}</span>
    <br><br>
    <span>Please do not share this OTP with anyone. If you have not requested this verification code, change your account password as soon as possible. </span>
    <br><br>
    <span>Thank you.</span>
</body>
</html>
