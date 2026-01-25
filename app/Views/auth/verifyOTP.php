<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
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

        /* OTP Input Styling */
        .otp-input-group {
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .otp-input {
            width: 100%;
            padding: 0.75rem;
            font-size: 2rem; /* Large text for OTP */
            text-align: center;
            letter-spacing: 0.5rem; /* Space out the digits */
            border: 1px solid #ddd;
            border-radius: 6px;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-weight: 600;
            color: #333;
        }

        .otp-input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }

        /* Hide number spinner arrows in Chrome, Safari, Edge, Opera */
        .otp-input::-webkit-outer-spin-button,
        .otp-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        /* Hide number spinner arrows in Firefox */
        .otp-input[type=number] {
            -moz-appearance: textfield;
        }

        .submit-btn {
            width: 100%; padding: 0.85rem; background-color: #007bff; color: white;
            border: none; border-radius: 6px; font-size: 1rem; font-weight: 600;
            cursor: pointer; transition: background-color 0.2s;
        }
        .submit-btn:hover { background-color: #0056b3; }

        .resend-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #666;
        }
        .resend-link a { color: #007bff; text-decoration: none; }
        .resend-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="auth-card">
    <div class="auth-header">
        <h2>Verify Your Email</h2>
        <p>We've sent a 6-digit code to your email. Please enter it below to confirm your identity.</p>
    </div>

    <?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div style="background-color: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; border: 1px solid #fecaca;">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div style="background-color: #d1fae5; color: #047857; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; border: 1px solid #a7f3d0;">
            <?= htmlspecialchars($_SESSION['success']) ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <form action="/EvolveAI/auth/verifyOTP" method="POST">
        
        <div class="otp-input-group">
            <input 
                type="text" 
                name="otp" 
                id="otp" 
                class="otp-input" 
                maxlength="6" 
                pattern="\d{6}" 
                inputmode="numeric" 
                placeholder="000000" 
                autocomplete="one-time-code"
                required
                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
            >
        </div>

        <button type="submit" class="submit-btn">Verify Code</button>
    </form>

    <div class="resend-link">
        Didn't receive a code? <a href="/EvolveAI/auth/passwordreset">Resend</a>
    </div>
</div>

<script>
    // Optional: Auto-submit when 6 digits are entered
    const otpInput = document.getElementById('otp');
    
    otpInput.addEventListener('input', function() {
        if (this.value.length === 6) {
            // Uncomment the line below if you want auto-submit
            // this.form.submit();
        }
    });
</script>

</body>
</html>