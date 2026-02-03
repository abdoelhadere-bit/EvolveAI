<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        /* Shared CSS */
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; }
        body { background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }

        .auth-card {
            background-color: #ffffff;
            padding: 2.5rem;
            width: 100%;
            max-width: 400px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .auth-header { text-align: center; margin-bottom: 2rem; }
        .auth-header h2 { color: #333; font-size: 1.75rem; margin-bottom: 0.5rem; }
        .auth-header p { color: #666; font-size: 0.9rem; line-height: 1.5; }

        .form-group { margin-bottom: 1.25rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: #333; font-size: 0.9rem; font-weight: 500; }
        
        .form-group input {
            width: 100%; padding: 0.75rem; border: 1px solid #ddd;
            border-radius: 6px; font-size: 1rem; transition: border-color 0.2s;
        }
        .form-group input:focus { outline: none; border-color: #007bff; box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1); }

        .submit-btn {
            width: 100%; padding: 0.85rem; background-color: #007bff; color: white;
            border: none; border-radius: 6px; font-size: 1rem; font-weight: 600;
            cursor: pointer; transition: background-color 0.2s; margin-top: 10px;
        }
        .submit-btn:hover { background-color: #0056b3; }

        .cancel-btn {
            background-color: transparent; border: 1px solid #e1e4e8; color: #666; margin-top: 10px;
        }
        .cancel-btn:hover { background-color: #f8f9fa; color: #333; }

        .form-footer { text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: #666; }
        .form-footer a { color: #007bff; text-decoration: none; }
        .form-footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="auth-card">
    <div class="auth-header">
        <h2>Reset Password</h2>
        <p>Enter the email address associated with your account and we'll send you a link to reset your password.</p>
    </div>

    <form action="/EvolveAI/auth/forgot" method="POST">
        
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="you@example.com" required>
        </div>

        <button type="submit" class="submit-btn">Send Reset Link</button>
        
        <a href="/EvolveAI/auth/login" style="text-decoration: none;">
            <button type="button" class="submit-btn cancel-btn">Back to Login</button>
        </a>
    </form>
</div>

</body>
</html>