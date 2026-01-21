<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <style>
        /* Shared CSS from previous forms */
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
        .auth-header p { color: #666; font-size: 0.9rem; }

        .form-group { margin-bottom: 1.25rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: #333; font-size: 0.9rem; font-weight: 500; }
        
        /* Flex container for label + forgot link */
        .label-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; }
        .label-row label { margin-bottom: 0; }
        .forgot-link { font-size: 0.85rem; color: #007bff; text-decoration: none; }
        .forgot-link:hover { text-decoration: underline; }

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

        .form-footer { text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: #666; }
        .form-footer a { color: #007bff; text-decoration: none; }
        .form-footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="auth-card">
    <div class="auth-header">
        <h2>Welcome Back</h2>
        <p>Please log in to your account</p>
    </div>

    <form action="/EvolveAI/auth/login" method="POST">
        
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="you@example.com" required>
        </div>

        <div class="form-group">
            <div class="label-row">
                <label for="password">Password</label>
                <a href="/EvolveAI/auth/forgot" class="forgot-link">Forgot Password?</a>
            </div>
            <input type="password" id="password" name="password" placeholder="••••••••" required>
        </div>

        <button type="submit" class="submit-btn">Log In</button>
    </form>

    <div class="form-footer">
        Don't have an account? <a href="/EvolveAI/auth/signup">Sign Up</a>
    </div>
</div>

</body>
</html>