<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        /* Base Reset & Fonts */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Card Container */
        .signup-container {
            background-color: #ffffff;
            padding: 2.5rem;
            width: 100%;
            max-width: 400px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .signup-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .signup-header h2 {
            color: #333;
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }

        .signup-header p {
            color: #666;
            font-size: 0.9rem;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 1.25rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }

        /* Validation Message */
        .error-message {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 0.25rem;
            display: none; /* Hidden by default */
        }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            padding: 0.85rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }

        /* Footer Links */
        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #666;
        }

        .form-footer a {
            color: #007bff;
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="signup-container">
    <div class="signup-header">
        <h2>Create Account</h2>
        <p>Get started with your free account today</p>
    </div>

    <form id="signupForm" action="auth/login" method="POST">
        <div class="form-group">
            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="full_name" placeholder="John Doe" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="you@example.com" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="••••••••" required>
            <div class="error-message" id="passwordError">Passwords do not match</div>
        </div>

        <button type="submit" class="submit-btn">Sign Up</button>
    </form>

    <div class="form-footer">
        Already have an account? <a href="#">Log In</a>
    </div>
</div>

<script>
    const form = document.getElementById('signupForm');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const errorMsg = document.getElementById('passwordError');

    form.addEventListener('submit', function(e) {
        if (password.value !== confirmPassword.value) {
            e.preventDefault(); // Stop form submission
            errorMsg.style.display = 'block';
            confirmPassword.style.borderColor = '#dc3545';
        } else {
            errorMsg.style.display = 'none';
            confirmPassword.style.borderColor = '#ddd';
            // Form is valid, proceed with submission
            alert('Form submitted successfully!');
        }
    });

    // Clear error when user starts typing again
    confirmPassword.addEventListener('input', () => {
        errorMsg.style.display = 'none';
        confirmPassword.style.borderColor = '#ddd';
    });
</script>

</body>
</html>