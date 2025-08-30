<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New User Registration - Vaishvik Welfare Foundation</title>
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
            background-color: #2196F3;
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
        .user-details {
            background-color: #e3f2fd;
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
        }
        .button {
            display: inline-block;
            background-color: #2196F3;
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
        <h1>New User Registration</h1>
    </div>
    
    <div class="content">
        <p>Hello Admin!</p>
        
        <p>A new user has successfully registered on the Vaishvik Welfare Foundation website.</p>
        
        <div class="user-details">
            <h3>User Details:</h3>
            <ul>
                <li><strong>Name:</strong> {{ $user->name }}</li>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Registration Date:</strong> {{ $user->created_at->format('F j, Y \a\t g:i A') }}</li>
                <li><strong>User ID:</strong> {{ $user->id }}</li>
            </ul>
        </div>
        
        <p>Please review the new registration and take any necessary actions.</p>
        
        <a href="{{ route('dashboard') }}" class="button">View User Dashboard</a>
        
        <p>Best regards,<br>
        Vaishvik Welfare Foundation System</p>
    </div>
    
    <div class="footer">
        <p>This is an automated notification from the Vaishvik Welfare Foundation system.</p>
    </div>
</body>
</html>
