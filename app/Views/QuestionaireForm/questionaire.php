
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
        
        <form id="questionnaireForm" method="POST" action="/EvolveAi/questionaire/store">
            
            <div class="step active" data-step="1">
                <span class="step-indicator">Step 1 / 20</span>
                <h2 class="question-title">What is your age group?</h2>
                <div class="options">
                    <div class="option"><input type="radio" name="age" id="a1" value="18-24" required><label for="a1">18-24</label></div>
                    <div class="option"><input type="radio" name="age" id="a2" value="25-34"><label for="a2">25-34</label></div>
                    <div class="option"><input type="radio" name="age" id="a_other" value="other" onchange="toggleOther(this)"><label for="a_other">Other (Specify)</label></div>
                </div>
                <div class="other-input-container" id="age_other_container"><input type="text" name="age_custom" class="custom-text-input" placeholder="Enter age..."></div>
            </div>

            <div class="step" data-step="2">
                <span class="step-indicator">Step 2 / 20</span>
                <h2 class="question-title">What is your primary goal?</h2>
                <div class="options">
                    <div class="option"><input type="radio" name="main_goal" id="g1" value="Business" required><label for="g1">Scaling a Business</label></div>
                    <div class="option"><input type="radio" name="main_goal" id="g2" value="Freelance"><label for="g2">Freelancing / Side Hustle</label></div>
                    <div class="option"><input type="radio" name="main_goal" id="g_other" value="other" onchange="toggleOther(this)"><label for="g_other">Other...</label></div>
                </div>
                <div class="other-input-container" id="main_goal_other_container"><input type="text" name="main_goal_custom" class="custom-text-input" placeholder="Enter goal..."></div>
            </div>

            <div class="step" data-step="3">
                <span class="step-indicator">Step 3 / 20</span>
                <h2 class="question-title">Current monthly revenue?</h2>
                <div class="options">
                    <div class="option"><input type="radio" name="income" id="r1" value="0" required><label for="r1">$0 (Just starting)</label></div>
                    <div class="option"><input type="radio" name="income" id="r2" value="1k-5k"><label for="r2">$1k - $5k</label></div>
                    <div class="option"><input type="radio" name="income" id="r_other" value="other" onchange="toggleOther(this)"><label for="r_other">Other...</label></div>
                </div>
                <div class="other-input-container" id="income_other_container"><input type="text" name="income_custom" class="custom-text-input" placeholder="Enter amount..."></div>
            </div>

            <div class="step" data-step="4">
                <span class="step-indicator">Step 4 / 20</span>
                <h2 class="question-title">AI Knowledge Level?</h2>
                <div class="options">
                    <div class="option"><input type="radio" name="ai_exp" id="e1" value="Beginner" required><label for="e1">Beginner</label></div>
                    <div class="option"><input type="radio" name="ai_exp" id="e2" value="Intermediate"><label for="e2">Intermediate</label></div>
                    <div class="option"><input type="radio" name="ai_exp" id="e_other" value="other" onchange="toggleOther(this)"><label for="e_other">Other...</label></div>
                </div>
                <div class="other-input-container" id="ai_exp_other_container"><input type="text" name="ai_exp_custom" class="custom-text-input" placeholder="Describe level..."></div>
            </div>

            <div class="step" data-step="5">
                <span class="step-indicator">Step 5 / 20</span>
                <h2 class="question-title">Target Industry?</h2>
                <div class="options">
                    <div class="option"><input type="radio" name="industry" id="i1" value="Ecom" required><label for="i1">E-commerce</label></div>
                    <div class="option"><input type="radio" name="industry" id="i2" value="SaaS"><label for="i2">Software / SaaS</label></div>
                    <div class="option"><input type="radio" name="industry" id="i_other" value="other" onchange="toggleOther(this)"><label for="i_other">Other Industry...</label></div>
                </div>
                <div class="other-input-container" id="industry_other_container"><input type="text" name="industry_custom" class="custom-text-input" placeholder="Enter industry..."></div>
            </div>

            <div class="step" data-step="6">
                <span class="step-indicator">Step 6 / 20</span>
                <h2 class="question-title">Do you use automation?</h2>
                <div class="options">
                    <div class="option"><input type="radio" name="automation" id="at1" value="Yes" required><label for="at1">Yes, extensively</label></div>
                    <div class="option"><input type="radio" name="automation" id="at2" value="No"><label for="at2">No, manually</label></div>
                    <div class="option"><input type="radio" name="automation" id="at_other" value="other" onchange="toggleOther(this)"><label for="at_other">Other...</label></div>
                </div>
                <div class="other-input-container" id="automation_other_container"><input type="text" name="automation_custom" class="custom-text-input" placeholder="Describe usage..."></div>
            </div>

            <div class="step" data-step="7">
                <span class="step-indicator">Step 7 / 20</span>
                <h2 class="question-title">Biggest bottleneck?</h2>
                <div class="options">
                    <div class="option"><input type="radio" name="bottleneck" id="b1" value="Time" required><label for="b1">Lack of Time</label></div>
                    <div class="option"><input type="radio" name="bottleneck" id="b2" value="Leads"><label for="b2">Lead Generation</label></div>
                    <div class="option"><input type="radio" name="bottleneck" id="b_other" value="other" onchange="toggleOther(this)"><label for="b_other">Other...</label></div>
                </div>
                <div class="other-input-container" id="bottleneck_other_container"><input type="text" name="bottleneck_custom" class="custom-text-input" placeholder="Enter bottleneck..."></div>
            </div>

            <div class="step" data-step="8">
                <span class="step-indicator">Step 8 / 20</span>
                <h2 class="question-title">Team Structure?</h2>
                <div class="options">
                    <div class="option"><input type="radio" name="team" id="t1" value="Solo" required><label for="t1">Solopreneur</label></div>
                    <div class="option"><input type="radio" name="team" id="t2" value="Small"><label for="t2">Small Team</label></div>
                    <div class="option"><input type="radio" name="team" id="t_other" value="other" onchange="toggleOther(this)"><label for="t_other">Other...</label></div>
                </div>
                <div class="other-input-container" id="team_other_container"><input type="text" name="team_custom" class="custom-text-input" placeholder="Describe team..."></div>
            </div>

            <div class="step" data-step="9">
                <span class="step-indicator">Step 9 / 20</span>
                <h2 class="question-title">Monthly Ads Budget?</h2>
                <div class="options">
                    <div class="option"><input type="radio" name="budget" id="bd1" value="Low" required><label for="bd1">$0 - $500</label></div>
                    <div class="option"><input type="radio" name="budget" id="bd2" value="High"><label for="bd2">$500+</label></div>
                    <div class="option"><input type="radio" name="budget" id="bd_other" value="other" onchange="toggleOther(this)"><label for="bd_other">Other...</label></div>
                </div>
                <div class="other-input-container" id="budget_other_container"><input type="text" name="budget_custom" class="custom-text-input" placeholder="Enter budget..."></div>
            </div>

            <div class="step" data-step="10">
                <span class="step-indicator">Step 10 / 20</span>
                <h2 class="question-title">Interest in Chatbots?</h2>
                <div class="options">
                    <div class="option"><input type="radio" name="chatbots" id="cb1" value="High" required><label for="cb1">Very Interested</label></div>
                    <div class="option"><input type="radio" name="chatbots" id="cb2" value="Low"><label for="cb2">Not a priority</label></div>
                    <div class="option"><input type="radio" name="chatbots" id="cb_other" value="other" onchange="toggleOther(this)"><label for="cb_other">Other...</label></div>
                </div>
                <div class="other-input-container" id="chatbots_other_container"><input type="text" name="chatbots_custom" class="custom-text-input" placeholder="Specify interest..."></div>
            </div>

            <div class="step" data-step="11">
                <span class="step-indicator">Step 11 / 20</span>
                <h2 class="question-title">Content creation frequency?</h2>
                <div class="options">
                    <div class="option"><input type="radio" name="content" id="ct1" value="Daily" required><label for="ct1">Daily</label></div>
                    <div class="option"><input type="radio" name="content" id="ct2" value="Weekly"><label for="ct2">Weekly</label></div>
                    <div class="option"><input type="radio" name="content" id="ct_other" value="other" onchange="toggleOther(this)"><label for="ct_other">Other...</label></div>
                </div>
                <div class="other-input-container" id="content_other_container"><input type="text" name="content_custom" class="custom-text-input" placeholder="Specify frequency..."></div>
            </div>

            <div class="step" data-step="12">
                <span class="step-indicator">Step 12 / 20</span>
                <h2 class="question-title">Primary sales channel?</h2>
                <div class="options">
                    <div class="option"><input type="radio" name="sales" id="s1" value="Inbound" required><label for="s1">Inbound (Organic)</label></div>
                    <div class="option"><input type="radio" name="sales" id="s2" value="Outbound"><label for="s2">Outbound (Cold)</label></div>
                    <div class="option"><input type="radio" name="sales" id="s_other" value="other" onchange="toggleOther(this)"><label for="s_other">Other...</label></div>
                </div>
                <div class="other-input-container" id="sales_other_container"><input type="text" name="sales_custom" class="custom-text-input" placeholder="Enter channel..."></div>
            </div>

            <div class="step" data-step="13">
                <span class="step-indicator">Step 13 / 20</span>
                <h2 class="question-title">Coding knowledge?</h2>
                <div class="options">
                    <div class="option"><input type="radio" name="coding" id="cd1" value="Yes" required><label for="cd1">I can code</label></div>
                    <div class="option"><input type="radio" name="coding" id="cd2" value="No"><label for="cd2">No-code only</label></div>
                    <div class="option"><input type="radio" name="coding" id="cd_other" value="other" onchange="toggleOther(this)"><label for="cd_other">Other...</label></div>
                </div>
                <div class="other-input-container" id="coding_other_container"><input type="text" name="coding_custom" class="custom-text-input" placeholder="Enter skills..."></div>
            </div>

            <div class="step" data-step="14">
                <span class="step-indicator">Step 14 / 20</span>
                <h2 class="question-title">Growth strategy?</h2>
                <div class="options">
                    <div class="option"><input type="radio" name="growth" id="gr1" value="Fast" required><label for="gr1">Aggressive</label></div>
                    <div class="option"><input type="radio" name="growth" id="gr2" value="Slow"><label for="gr2">Organic</label></div>
                    <div class="option"><input type="radio" name="growth" id="gr_other" value="other" onchange="toggleOther(this)"><label for="gr_other">Other...</label></div>
                </div>
                <div class="other-input-container" id="growth_other_container"><input type="text" name="growth_custom" class="custom-text-input" placeholder="Describe strategy..."></div>
            </div>

            <div class="step" data-step="15">
                <span class="step-indicator">Step 15 / 20</span>
                <h2 class="question-title">Work Device?</h2>
                <div class="options">
                    <div class="option"><input type="radio" name="device" id="dv1" value="Laptop" required><label for="dv1">Laptop / Desktop</label></div>
                    <div class="option"><input type="radio" name="device" id="dv2" value="Mobile"><label for="dv2">Mobile / Tablet</label></div>
                    <div class="option"><input type="radio" name="device" id="dv_other" value="other" onchange="toggleOther(this)"><label for="dv_other">Other...</label></div>
                </div>
                <div class="other-input-container" id="device_other_container"><input type="text" name="device_custom" class="custom-text-input" placeholder="Specify device..."></div>
            </div>

            <div class="step" data-step="16">
                <span class="step-indicator">Step 16 / 20</span>
                <h2 class="question-title">Learning Style?</h2>
                <div class="options">
                    <div class="option"><input type="radio" name="learning" id="l1" value="Video" required><label for="l1">Video Lessons</label></div>
                    <div class="option"><input type="radio" name="learning" id="l2" value="Text"><label for="l2">Reading / Docs</label></div>
                    <div class="option"><input type="radio" name="learning" id="l_other" value="other" onchange="toggleOther(this)"><label for="l_other">Other...</label></div>
                </div>
                <div class="other-input-container" id="learning_other_container"><input type="text" name="learning_custom" class="custom-text-input" placeholder="Specify style..."></div>
            </div>

            <div class="step" data-step="17">
                <span class="step-indicator">Step 17 / 20</span>
                <h2 class="question-title">Favorite platform?</h2>
                <div class="options">
                    <div class="option"><input type="radio" name="platform" id="p1" value="LinkedIn" required><label for="p1">LinkedIn</label></div>
                    <div class="option"><input type="radio" name="platform" id="p2" value="X"><label for="p2">X (Twitter)</label></div>
                    <div class="option"><input type="radio" name="platform" id="p_other" value="other" onchange="toggleOther(this)"><label for="p_other">Other...</label></div>
                </div>
                <div class="other-input-container" id="platform_other_container"><input type="text" name="platform_custom" class="custom-text-input" placeholder="Specify platform..."></div>
            </div>

            <div class="step" data-step="18">
                <span class="step-indicator">Step 18 / 20</span>
                <h2 class="question-title">Networking preference?</h2>
                <div class="options">
                    <div class="option"><input type="radio" name="networking" id="nw1" value="Community" required><label for="nw1">I love communities</label></div>
                    <div class="option"><input type="radio" name="networking" id="nw2" value="Solo"><label for="nw2">Working solo</label></div>
                    <div class="option"><input type="radio" name="networking" id="nw_other" value="other" onchange="toggleOther(this)"><label for="nw_other">Other...</label></div>
                </div>
                <div class="other-input-container" id="networking_other_container"><input type="text" name="networking_custom" class="custom-text-input" placeholder="Specify pref..."></div>
            </div>

            <div class="step" data-step="19">
                <span class="step-indicator">Step 19 / 20</span>
                <h2 class="question-title">Future outlook?</h2>
                <div class="options">
                    <div class="option"><input type="radio" name="vision" id="v1" value="Exit" required><label for="v1">Build to sell</label></div>
                    <div class="option"><input type="radio" name="vision" id="v2" value="Lifestyle"><label for="v2">Long-term cashflow</label></div>
                    <div class="option"><input type="radio" name="vision" id="v_other" value="other" onchange="toggleOther(this)"><label for="v_other">Other...</label></div>
                </div>
                <div class="other-input-container" id="vision_other_container"><input type="text" name="vision_custom" class="custom-text-input" placeholder="Describe vision..."></div>
            </div>

            <div class="step" data-step="20">
                <span class="step-indicator">Step 20 / 20</span>
                <h2 class="question-title">Daily Time Commitment?</h2>
                <div class="options">
                    <div class="option"><input type="radio" name="daily_time" id="dt1" value="1hr" required><label for="dt1">1 Hour</label></div>
                    <div class="option"><input type="radio" name="daily_time" id="dt2" value="Full"><label for="dt2">Full Time</label></div>
                    <div class="option"><input type="radio" name="daily_time" id="dt_other" value="other" onchange="toggleOther(this)"><label for="dt_other">Other...</label></div>
                </div>
                <div class="other-input-container" id="daily_time_other_container"><input type="text" name="daily_time_custom" class="custom-text-input" placeholder="Specify time..."></div>
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
    const totalSteps = 20;

    function toggleOther(radio) {
        const stepDiv = radio.closest('.step');
        const container = document.getElementById(radio.name + '_other_container');
        if (radio.checked) {
            container.style.display = 'block';
            container.querySelector('input').focus();
        }
    }

    // Hide other when a regular option is chosen
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value !== 'other') {
                const container = document.getElementById(this.name + '_other_container');
                if (container) container.style.display = 'none';
            }
        });
    });

    function moveStep(n) {
        const activeStep = document.querySelector('.step.active');
        if (n === 1) {
            const selected = activeStep.querySelector('input[type="radio"]:checked');
            if (!selected) { showError(true); return; }
            if (selected.value === 'other') {
                const custom = document.getElementById(selected.name + '_other_container').querySelector('input');
                if (!custom.value.trim()) { showError(true); return; }
            }
        }

        showError(false);
        currentStep += n;
        if (currentStep > totalSteps) { document.getElementById('questionnaireForm').submit(); return; }
        updateUI();
    }

    function showError(visible) { document.getElementById('errorMessage').style.display = visible ? 'block' : 'none'; }

    function updateUI() {
        document.querySelectorAll('.step').forEach((s, i) => s.classList.toggle('active', (i + 1) === currentStep));
        document.getElementById('progressBar').style.width = (currentStep / totalSteps * 100) + '%';
        document.getElementById('prevBtn').disabled = (currentStep === 1);
        document.getElementById('nextBtn').textContent = (currentStep === totalSteps) ? "Generate My Plan" : "Next Step";
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
</body>
</html>