<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Password</title>
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

        .error-text { color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem; display: none; }
    </style>
</head>
<body>

<div class="auth-card">
    <div class="auth-header">
        <h2>Set New Password</h2>
        <p>Please create a strong password for your account.</p>
    </div>

    <form action="/EvolveAI/auth/newpassword" method="POST" id="newPasswordForm">
        
        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required minlength="8">
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="••••••••" required>
            <div class="error-text" id="matchError">Passwords do not match</div>
        </div>

        <button type="submit" class="submit-btn">Reset Password</button>
    </form>
</div>

<script>
    // Simple client-side check to prevent submission if passwords don't match
    const form = document.getElementById('newPasswordForm');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const matchError = document.getElementById('matchError');

    form.addEventListener('submit', function(e) {
        if (password.value !== confirmPassword.value) {
            e.preventDefault(); // Stop form submission
            confirmPassword.style.borderColor = '#dc3545';
            matchError.style.display = 'block';
        } else {
            confirmPassword.style.borderColor = '#ddd';
            matchError.style.display = 'none';
        }
    });
</script>

</body>
</html>