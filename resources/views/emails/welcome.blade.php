<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to Vaishvik Welfare Foundation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .logo {
            max-width: 200px;
            height: auto;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 0 0 5px 5px;
        }
        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('assets/images/users/logo.png') }}" alt="Vaishvik Welfare Foundation Logo" class="logo">
        <h1>Welcome to Vaishvik Welfare Foundation!</h1>
    </div>
    
    <div class="content">
        <p>Hello {{ $user->name }}!</p>
        
        <p>Thank you for registering with Vaishvik Welfare Foundation. Your account has been successfully created with the following details:</p>
        
        <ul>
            <li><strong>Name:</strong> {{ $user->name }}</li>
            <li><strong>Email:</strong> {{ $user->email }}</li>
            <li><strong>Registration Date:</strong> {{ $user->created_at->format('F j, Y \a\t g:i A') }}</li>
        </ul>
        
        <p>You can now log in to your account and explore our platform.</p>
        
        <a href="{{ route('login') }}" class="button">Login to Your Account</a>
        
        <p>If you have any questions, please feel free to contact us.</p>
        
        <p>Best regards,<br>
        Vaishvik Welfare Foundation Team</p>
    </div>
    
    <div class="footer">
        <p>This email was sent to {{ $user->email }}. If you did not register for an account, please ignore this email.</p>
    </div>
</body>
</html>
