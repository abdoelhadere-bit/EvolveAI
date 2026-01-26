
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Profile - AI Revenue Platform</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex; justify-content: center; align-items: center; padding: 20px;
        }
        .container {
            background: white; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 700px; width: 100%; overflow: hidden;
        }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; }
        .progress-container { background: #f0f0f0; height: 8px; position: relative; }
        .progress-bar { background: #4ade80; height: 100%; width: 5%; transition: width 0.4s ease; }
        .form-container { padding: 40px; min-height: 480px; position: relative; }
        .step { display: none; animation: fadeIn 0.4s ease; }
        .step.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }
        
        .question-title { font-size: 22px; color: #1a202c; margin-bottom: 10px; font-weight: 700; }
        .options { display: grid; gap: 10px; }
        .option { position: relative; }
        .option input[type="radio"] { position: absolute; opacity: 0; width: 100%; height: 100%; cursor: pointer; z-index: 2; }
        .option label {
            display: block; padding: 14px 20px; background: #f7fafc; border: 2px solid #edf2f7;
            border-radius: 12px; transition: all 0.2s ease; font-size: 15px; color: #4a5568;
        }
        .option input:checked + label {
            background: #ebf4ff; border-color: #5a67d8; color: #5a67d8; font-weight: 600;
        }

        .other-input-container { margin-top: 10px; display: none; animation: fadeIn 0.3s ease; }
        .custom-text-input {
            width: 100%; padding: 12px; border: 2px solid #5a67d8; border-radius: 10px;
            font-size: 15px; outline: none; background: #fff;
        }

        .button-group { display: flex; gap: 15px; margin-top: 30px; }
        .btn { flex: 1; padding: 16px; border: none; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer; transition: 0.2s; }
        .btn-primary { background: #5a67d8; color: white; }
        .btn-primary:hover { background: #434190; }
        .btn-secondary { background: #edf2f7; color: #4a5568; }
        .error-message { background: #fff5f5; color: #c53030; padding: 12px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #feb2b2; display: none; }
        .step-indicator { color: #a0aec0; font-weight: 600; text-transform: uppercase; margin-bottom: 10px; display: block; font-size: 12px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header"><h1>EvolveAI Analysis</h1><p>Phase 1: Profile Discovery</p></div>
    <div class="progress-container"><div class="progress-bar" id="progressBar"></div></div>

    <div class="form-container">
        <div class="error-message" id="errorMessage">⚠️ Please select an option or specify your own.</div>
        
        <form id="questionnaireForm" method="POST" action="/EvolveAI/public/index.php?url=questionaire/store">

<!-- STEP 1 -->
<div class="step active" data-step="1">
    <span class="step-indicator">Step 1 / 20</span>
    <h2 class="question-title">What is your age range?</h2>
    <div class="options">
        <div class="option"><input type="radio" name="age_range" value="18-24" required><label>18–24</label></div>
        <div class="option"><input type="radio" name="age_range" value="25-34"><label>25–34</label></div>
        <div class="option"><input type="radio" name="age_range" value="35+"><label>35+</label></div>
    </div>
</div>

<!-- STEP 2 -->
<div class="step" data-step="2">
    <span class="step-indicator">Step 2 / 20</span>
    <h2 class="question-title">Where are you currently based?</h2>
    <input type="text" name="location" class="custom-text-input" placeholder="Country / City" required>
</div>

<!-- STEP 3 -->
<div class="step" data-step="3">
    <span class="step-indicator">Step 3 / 20</span>
    <h2 class="question-title">What is your main goal right now?</h2>
    <div class="options">
        <div class="option"><input type="radio" name="main_goal" value="first_income" required><label>Make my first online income</label></div>
        <div class="option"><input type="radio" name="main_goal" value="scale_income"><label>Scale existing income</label></div>
        <div class="option"><input type="radio" name="main_goal" value="learn_skills"><label>Learn high-value skills</label></div>
        <div class="option"><input type="radio" name="main_goal" value="build_business"><label>Build a long-term business</label></div>
    </div>
</div>

<!-- STEP 4 -->
<div class="step" data-step="4">
    <span class="step-indicator">Step 4 / 20</span>
    <h2 class="question-title">How urgent is making money for you?</h2>
    <div class="options">
        <div class="option"><input type="radio" name="income_urgency" value="immediate" required><label>Very urgent (0–30 days)</label></div>
        <div class="option"><input type="radio" name="income_urgency" value="short_term"><label>1–3 months</label></div>
        <div class="option"><input type="radio" name="income_urgency" value="medium_term"><label>3–6 months</label></div>
        <div class="option"><input type="radio" name="income_urgency" value="long_term"><label>Long term</label></div>
    </div>
</div>

<!-- STEP 5 -->
<div class="step" data-step="5">
    <span class="step-indicator">Step 5 / 20</span>
    <h2 class="question-title">What skills do you already have?</h2>
    <div class="options">
        <div class="option"><input type="checkbox" name="skills[]" value="writing"><label>Writing / Copywriting</label></div>
        <div class="option"><input type="checkbox" name="skills[]" value="design"><label>Design / Canva / UI</label></div>
        <div class="option"><input type="checkbox" name="skills[]" value="coding"><label>Coding / Tech</label></div>
        <div class="option"><input type="checkbox" name="skills[]" value="marketing"><label>Marketing / Ads</label></div>
        <div class="option"><input type="checkbox" name="skills[]" value="none"><label>None yet</label></div>
        <div class="option">
            <input type="checkbox" name="skills[]" value="other" onchange="toggleOther(this, 'checkbox')">
            <label>Other (please specify)</label>
        </div>
    </div>
    <div class="other-input-container" id="skills_other_container">
        <input type="text" name="skills_other" class="custom-text-input" placeholder="e.g. Video Editing, Sales...">
    </div>
</div>

<!-- STEP 6 -->
<div class="step" data-step="6">
    <span class="step-indicator">Step 6 / 20</span>
    <h2 class="question-title">Overall skill level?</h2>
    <div class="options">
        <div class="option"><input type="radio" name="skill_level" value="beginner" required><label>Beginner</label></div>
        <div class="option"><input type="radio" name="skill_level" value="intermediate"><label>Intermediate</label></div>
        <div class="option"><input type="radio" name="skill_level" value="advanced"><label>Advanced</label></div>
    </div>
</div>

<!-- STEP 7 -->
<div class="step" data-step="7">
    <span class="step-indicator">Step 7 / 20</span>
    <h2 class="question-title">How much time can you realistically work per day?</h2>
    <div class="options">
        <div class="option"><input type="radio" name="daily_time" value="30min" required><label>30 minutes</label></div>
        <div class="option"><input type="radio" name="daily_time" value="1h"><label>1 hour</label></div>
        <div class="option"><input type="radio" name="daily_time" value="2-3h"><label>2–3 hours</label></div>
        <div class="option"><input type="radio" name="daily_time" value="4h+"><label>4+ hours</label></div>
    </div>
</div>

<!-- STEP 8 -->
<div class="step" data-step="8">
    <span class="step-indicator">Step 8 / 20</span>
    <h2 class="question-title">When are you most productive?</h2>
    <div class="options">
        <div class="option"><input type="radio" name="energy_time" value="morning" required><label>Morning</label></div>
        <div class="option"><input type="radio" name="energy_time" value="afternoon"><label>Afternoon</label></div>
        <div class="option"><input type="radio" name="energy_time" value="evening"><label>Evening</label></div>
        <div class="option"><input type="radio" name="energy_time" value="random"><label>It varies</label></div>
    </div>
</div>

<!-- STEP 9 -->
<div class="step" data-step="9">
    <span class="step-indicator">Step 9 / 20</span>
    <h2 class="question-title">Monthly budget you can invest?</h2>
    <div class="options">
        <div class="option"><input type="radio" name="budget" value="0" required><label>$0</label></div>
        <div class="option"><input type="radio" name="budget" value="10-50"><label>$10–$50</label></div>
        <div class="option"><input type="radio" name="budget" value="50-200"><label>$50–$200</label></div>
        <div class="option"><input type="radio" name="budget" value="200+"><label>$200+</label></div>
    </div>
</div>

<!-- STEP 10 -->
<div class="step" data-step="10">
    <span class="step-indicator">Step 10 / 20</span>
    <h2 class="question-title">How do you prefer to make money?</h2>
    <div class="options">
        <div class="option"><input type="radio" name="monetization" value="services" required><label>Freelancing / Services</label></div>
        <div class="option"><input type="radio" name="monetization" value="products"><label>Digital products</label></div>
        <div class="option"><input type="radio" name="monetization" value="content"><label>Content / Audience</label></div>
        <div class="option"><input type="radio" name="monetization" value="automation"><label>AI / Automation</label></div>
        <div class="option">
             <input type="radio" name="monetization" value="other" onchange="toggleOther(this, 'radio')">
             <label>Other</label>
        </div>
    </div>
    <div class="other-input-container" id="monetization_other_container">
        <input type="text" name="monetization_other" class="custom-text-input" placeholder="Please specify...">
    </div>
</div>

<!-- STEP 11 -->
<div class="step" data-step="11">
    <span class="step-indicator">Step 11 / 20</span>
    <h2 class="question-title">Do you already have any assets?</h2>
    <div class="options">
        <div class="option"><input type="checkbox" name="assets[]" value="audience"><label>Social media audience</label></div>
        <div class="option"><input type="checkbox" name="assets[]" value="portfolio"><label>Portfolio / past work</label></div>
        <div class="option"><input type="checkbox" name="assets[]" value="clients"><label>Clients</label></div>
        <div class="option"><input type="checkbox" name="assets[]" value="none"><label>None</label></div>
    </div>
</div>

<!-- STEP 12 -->
<div class="step" data-step="12">
    <span class="step-indicator">Step 12 / 20</span>
    <h2 class="question-title">What usually blocks you?</h2>
    <div class="options">
        <div class="option"><input type="radio" name="blocker" value="clarity" required><label>Lack of clarity</label></div>
        <div class="option"><input type="radio" name="blocker" value="fear"><label>Fear of failure</label></div>
        <div class="option"><input type="radio" name="blocker" value="discipline"><label>Lack of discipline</label></div>
        <div class="option"><input type="radio" name="blocker" value="skills"><label>Lack of skills</label></div>
    </div>
</div>

<!-- STEP 13 -->
<div class="step" data-step="13">
    <span class="step-indicator">Step 13 / 20</span>
    <h2 class="question-title">How should the AI guide you?</h2>
    <div class="options">
        <div class="option"><input type="radio" name="guidance" value="daily_tasks" required><label>Daily step-by-step tasks</label></div>
        <div class="option"><input type="radio" name="guidance" value="weekly_goals"><label>Weekly goals</label></div>
        <div class="option"><input type="radio" name="guidance" value="challenges"><label>Challenges</label></div>
    </div>
</div>

<!-- STEP 14 -->
<div class="step" data-step="14">
    <span class="step-indicator">Step 14 / 20</span>
    <h2 class="question-title">Are you ready to commit to a daily plan?</h2>
    <div class="options">
        <div class="option"><input type="radio" name="commitment" value="yes" required><label>Yes, fully</label></div>
        <div class="option"><input type="radio" name="commitment" value="try"><label>I’ll try</label></div>
        <div class="option"><input type="radio" name="commitment" value="not_sure"><label>Not sure yet</label></div>
    </div>
</div>

<div class="button-group">
    <button type="button" class="btn btn-secondary" id="prevBtn" onclick="moveStep(-1)" disabled>Previous</button>
    <button type="button" class="btn btn-primary" id="nextBtn" onclick="moveStep(1)">Next Step</button>
</div>

</form>

    </div>
</div>

<script>
  let currentStep = 1;
  const totalSteps = document.querySelectorAll('.step').length;

  function toggleOther(input, type) {
    // Determine the container ID based on the input name
    // For arrays like skills[], name is skills[], so we strip []
    const baseName = input.name.replace('[]', '');
    const container = document.getElementById(baseName + '_other_container');
    
    if (!container) return;

    if (input.checked) {
      container.style.display = 'block';
      const textInput = container.querySelector('input, textarea');
      if (textInput) textInput.focus();
    } else if (type === 'checkbox') {
       container.style.display = 'none';
    }
  }

  // Hide other when a regular radio option is chosen
  document.querySelectorAll('input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', function () {
      if (this.value !== 'other') {
        const baseName = this.name;
        const container = document.getElementById(baseName + '_other_container');
        if (container) container.style.display = 'none';
      }
    });
  });

  // ✅ New: validate step depending on what inputs exist inside it
  function isStepValid(stepEl) {
    // 1) RADIO steps
    const radios = stepEl.querySelectorAll('input[type="radio"]');
    if (radios.length > 0) {
      const selected = stepEl.querySelector('input[type="radio"]:checked');
      if (!selected) return false;

      // if "other" selected -> custom text required
      if (selected.value === 'other') {
        const container = document.getElementById(selected.name + '_other_container');
        if (!container) return false;

        const custom = container.querySelector('input, textarea');
        if (!custom || !custom.value.trim()) return false;
      }
      return true;
    }

    // 2) CHECKBOX steps (at least one checked)
    const checkboxes = stepEl.querySelectorAll('input[type="checkbox"]');
    if (checkboxes.length > 0) {
      return [...checkboxes].some(cb => cb.checked);
    }

    // 3) TEXT / TEXTAREA steps (at least one filled)
    const texts = stepEl.querySelectorAll('input[type="text"], textarea');
    if (texts.length > 0) {
      return [...texts].some(t => t.value.trim() !== '');
    }

    // 4) If step has no inputs, consider it valid
    return true;
  }

  function moveStep(n) {
    const activeStep = document.querySelector('.step.active');

    // ✅ validate only when going NEXT
    if (n === 1) {
      if (!isStepValid(activeStep)) {
        showError(true);
        return;
      }
    }

    showError(false);

    currentStep += n;

    if (currentStep > totalSteps) {
      document.getElementById('questionnaireForm').submit();
      return;
    }

    updateUI();
  }

  function showError(visible) {
    const el = document.getElementById('errorMessage');
    if (!el) return; // safety
    el.style.display = visible ? 'block' : 'none';
  }

  function updateUI() {
    document.querySelectorAll('.step').forEach((s, i) =>
      s.classList.toggle('active', (i + 1) === currentStep)
    );

    const progress = document.getElementById('progressBar');
    if (progress) progress.style.width = (currentStep / totalSteps * 100) + '%';

    const prevBtn = document.getElementById('prevBtn');
    if (prevBtn) prevBtn.disabled = (currentStep === 1);

    const nextBtn = document.getElementById('nextBtn');
    if (nextBtn) nextBtn.textContent = (currentStep === totalSteps) ? "Generate My Plan" : "Next Step";

    // Optional: auto focus on text input if exists in current step
    const current = document.querySelector('.step.active');
    const focusInput = current?.querySelector('input[type="text"], textarea');
    if (focusInput) focusInput.focus();

    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
</script>

</body>
</html>