<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Profile - AI Revenue Platform</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 700px;
            width: 100%;
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .header p {
            opacity: 0.9;
            font-size: 14px;
        }

        .progress-container {
            background: #f0f0f0;
            height: 6px;
            position: relative;
        }

        .progress-bar {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            height: 100%;
            width: 0%;
            transition: width 0.3s ease;
        }

        .form-container {
            padding: 40px;
        }

        .step {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .step.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .question-title {
            font-size: 22px;
            color: #333;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .question-subtitle {
            font-size: 14px;
            color: #666;
            margin-top: -15px;
            margin-bottom: 20px;
        }

        .options {
            display: grid;
            gap: 12px;
        }

        .option {
            position: relative;
        }

        .option input[type="radio"],
        .option input[type="checkbox"] {
            position: absolute;
            opacity: 0;
        }

        .option label {
            display: block;
            padding: 16px 20px;
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 15px;
        }

        .option label:hover {
            background: #e9ecef;
            border-color: #667eea;
        }

        .option input:checked + label {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
            font-weight: 500;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 14px 28px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #e9ecef;
            color: #333;
        }

        .btn-secondary:hover {
            background: #dee2e6;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .step-indicator {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .error-message {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            display: none;
        }

        .success-message {
            background: #efe;
            color: #3c3;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            display: none;
        }

        .loading {
            text-align: center;
            padding: 40px;
            display: none;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 600px) {
            .form-container {
                padding: 25px;
            }

            .question-title {
                font-size: 18px;
            }

            .header h1 {
                font-size: 22px;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 Let's Get to Know You!</h1>
            <p>Help us personalize your journey to financial success</p>
        </div>
        
        <div class="progress-container">
            <div class="progress-bar" id="progressBar"></div>
        </div>

        <div class="form-container">
            <div class="error-message" id="errorMessage"></div>
            <div class="success-message" id="successMessage"></div>
            
            <form id="questionnaireForm">
                <!-- Step 1 -->
                <div class="step active" data-step="1">
                    <div class="step-indicator">Step 1 of 20</div>
                    <h2 class="question-title">What's your age?</h2>
                    <div class="options">
                        <div class="option">
                            <input type="radio" id="age1" name="age" value="18-24" required>
                            <label for="age1">18-24</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="age2" name="age" value="25-34">
                            <label for="age2">25-34</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="age3" name="age" value="35-44">
                            <label for="age3">35-44</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="age4" name="age" value="45+">
                            <label for="age4">45+</label>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="step" data-step="2">
                    <div class="step-indicator">Step 2 of 20</div>
                    <h2 class="question-title">What's your main goal?</h2>
                    <div class="options">
                        <div class="option">
                            <input type="radio" id="goal1" name="main_goal" value="Run my own business" required>
                            <label for="goal1">Run my own business</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="goal2" name="main_goal" value="Grow my career">
                            <label for="goal2">Grow my career</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="goal3" name="main_goal" value="Retire early">
                            <label for="goal3">Retire early</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="goal4" name="main_goal" value="Level up myself">
                            <label for="goal4">Level up myself</label>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="step" data-step="3">
                    <div class="step-indicator">Step 3 of 20</div>
                    <h2 class="question-title">Which best describes you?</h2>
                    <div class="options">
                        <div class="option">
                            <input type="radio" id="desc1" name="user_description" value="Full-time employee" required>
                            <label for="desc1">Full-time employee</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="desc2" name="user_description" value="Business owner">
                            <label for="desc2">Business owner</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="desc3" name="user_description" value="Service staff">
                            <label for="desc3">Service staff</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="desc4" name="user_description" value="Freelancer">
                            <label for="desc4">Freelancer</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="desc5" name="user_description" value="Unemployed">
                            <label for="desc5">Unemployed</label>
                        </div>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="step" data-step="4">
                    <div class="step-indicator">Step 4 of 20</div>
                    <h2 class="question-title">Which income stream are you most familiar with?</h2>
                    <div class="options">
                        <div class="option">
                            <input type="radio" id="income1" name="income_stream" value="Working a full-time job" required>
                            <label for="income1">Working a full-time job</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="income2" name="income_stream" value="Earning passive income">
                            <label for="income2">Earning passive income</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="income3" name="income_stream" value="Something else">
                            <label for="income3">Something else</label>
                        </div>
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="step" data-step="5">
                    <div class="step-indicator">Step 5 of 20</div>
                    <h2 class="question-title">What's your current work schedule?</h2>
                    <div class="options">
                        <div class="option">
                            <input type="radio" id="schedule1" name="work_schedule" value="Standard 9-5" required>
                            <label for="schedule1">Standard 9-5</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="schedule2" name="work_schedule" value="Night shifts">
                            <label for="schedule2">Night shifts</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="schedule3" name="work_schedule" value="Flexible hours">
                            <label for="schedule3">Flexible hours</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="schedule4" name="work_schedule" value="I'm retired">
                            <label for="schedule4">I'm retired</label>
                        </div>
                    </div>
                </div>

                <!-- Step 6 -->
                <div class="step" data-step="6">
                    <div class="step-indicator">Step 6 of 20</div>
                    <h2 class="question-title">What issues are you facing at work?</h2>
                    <p class="question-subtitle">Select all that apply</p>
                    <div class="options">
                        <div class="option">
                            <input type="checkbox" id="issue1" name="work_issues[]" value="Low pay">
                            <label for="issue1">Low pay</label>
                        </div>
                        <div class="option">
                            <input type="checkbox" id="issue2" name="work_issues[]" value="Financial pressure">
                            <label for="issue2">Financial pressure</label>
                        </div>
                        <div class="option">
                            <input type="checkbox" id="issue3" name="work_issues[]" value="No free time">
                            <label for="issue3">No free time</label>
                        </div>
                        <div class="option">
                            <input type="checkbox" id="issue4" name="work_issues[]" value="Same routine every day">
                            <label for="issue4">Same routine every day</label>
                        </div>
                        <div class="option">
                            <input type="checkbox" id="issue5" name="work_issues[]" value="Constant stress">
                            <label for="issue5">Constant stress</label>
                        </div>
                        <div class="option">
                            <input type="checkbox" id="issue6" name="work_issues[]" value="Toxic environment">
                            <label for="issue6">Toxic environment</label>
                        </div>
                        <div class="option">
                            <input type="checkbox" id="issue7" name="work_issues[]" value="Something else">
                            <label for="issue7">Something else</label>
                        </div>
                    </div>
                </div>

                <!-- Step 7 -->
                <div class="step" data-step="7">
                    <div class="step-indicator">Step 7 of 20</div>
                    <h2 class="question-title">How many hours do you usually work each day?</h2>
                    <div class="options">
                        <div class="option">
                            <input type="radio" id="hours1" name="current_work_hours" value="Less than 4 hours" required>
                            <label for="hours1">Less than 4 hours</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="hours2" name="current_work_hours" value="4–6 hours">
                            <label for="hours2">4–6 hours</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="hours3" name="current_work_hours" value="6–8 hours">
                            <label for="hours3">6–8 hours</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="hours4" name="current_work_hours" value="Over 8 hours">
                            <label for="hours4">Over 8 hours</label>
                        </div>
                    </div>
                </div>

                <!-- Step 8 -->
                <div class="step" data-step="8">
                    <div class="step-indicator">Step 8 of 20</div>
                    <h2 class="question-title">How many hours would you like to work each day?</h2>
                    <div class="options">
                        <div class="option">
                            <input type="radio" id="desired1" name="desired_work_hours" value="Less than 4 hours" required>
                            <label for="desired1">Less than 4 hours</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="desired2" name="desired_work_hours" value="4–6 hours">
                            <label for="desired2">4–6 hours</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="desired3" name="desired_work_hours" value="6–8 hours">
                            <label for="desired3">6–8 hours</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="desired4" name="desired_work_hours" value="Over 8 hours">
                            <label for="desired4">Over 8 hours</label>
                        </div>
                    </div>
                </div>

                <!-- Step 9 -->
                <div class="step" data-step="9">
                    <div class="step-indicator">Step 9 of 20</div>
                    <h2 class="question-title">How do you feel about your money right now?</h2>
                    <div class="options">
                        <div class="option">
                            <input type="radio" id="money1" name="financial_status" value="I'm financially stable" required>
                            <label for="money1">I'm financially stable</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="money2" name="financial_status" value="I'm managing, but it's tight">
                            <label for="money2">I'm managing, but it's tight</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="money3" name="financial_status" value="I'm falling behind">
                            <label for="money3">I'm falling behind</label>
                        </div>
                    </div>
                </div>

                <!-- Step 10 -->
                <div class="step" data-step="10">
                    <div class="step-indicator">Step 10 of 20</div>
                    <h2 class="question-title">Have you ever tried making money outside your main job?</h2>
                    <div class="options">
                        <div class="option">
                            <input type="radio" id="side1" name="side_hustle_experience" value="Yes, I've done side gigs" required>
                            <label for="side1">Yes, I've done side gigs</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="side2" name="side_hustle_experience" value="No, I stick to my job">
                            <label for="side2">No, I stick to my job</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="side3" name="side_hustle_experience" value="I've freelanced for extra cash">
                            <label for="side3">I've freelanced for extra cash</label>
                        </div>
                    </div>
                </div>

                <!-- Step 11 -->
                <div class="step" data-step="11">
                    <div class="step-indicator">Step 11 of 20</div>
                    <h2 class="question-title">How confident are you with AI tools?</h2>
                    <div class="options">
                        <div class="option">
                            <input type="radio" id="ai1" name="ai_confidence" value="Not confident at all" required>
                            <label for="ai1">Not confident at all</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="ai2" name="ai_confidence" value="Slightly confident">
                            <label for="ai2">Slightly confident</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="ai3" name="ai_confidence" value="Confident enough">
                            <label for="ai3">Confident enough</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="ai4" name="ai_confidence" value="Very confident">
                            <label for="ai4">Very confident</label>
                        </div>
                    </div>
                </div>

                <!-- Step 12 -->
                <div class="step" data-step="12">
                    <div class="step-indicator">Step 12 of 20</div>
                    <h2 class="question-title">Have you used any of these AI tools before?</h2>
                    <p class="question-subtitle">Select all that apply</p>
                    <div class="options">
                        <div class="option">
                            <input type="checkbox" id="tool1" name="ai_tools[]" value="ChatGPT">
                            <label for="tool1">ChatGPT</label>
                        </div>
                        <div class="option">
                            <input type="checkbox" id="tool2" name="ai_tools[]" value="Google Gemini">
                            <label for="tool2">Google Gemini</label>
                        </div>
                        <div class="option">
                            <input type="checkbox" id="tool3" name="ai_tools[]" value="DALL-E">
                            <label for="tool3">DALL-E</label>
                        </div>
                        <div class="option">
                            <input type="checkbox" id="tool4" name="ai_tools[]" value="Midjourney">
                            <label for="tool4">Midjourney</label>
                        </div>
                        <div class="option">
                            <input type="checkbox" id="tool5" name="ai_tools[]" value="Claude">
                            <label for="tool5">Claude</label>
                        </div>
                        <div class="option">
                            <input type="checkbox" id="tool6" name="ai_tools[]" value="Runway">
                            <label for="tool6">Runway</label>
                        </div>
                        <div class="option">
                            <input type="checkbox" id="tool7" name="ai_tools[]" value="Eleven Labs">
                            <label for="tool7">Eleven Labs</label>
                        </div>
                        <div class="option">
                            <input type="checkbox" id="tool8" name="ai_tools[]" value="I have no experience">
                            <label for="tool8">I have no experience</label>
                        </div>
                    </div>
                </div>

                <!-- Step 13 -->
                <div class="step" data-step="13">
                    <div class="step-indicator">Step 13 of 20</div>
                    <h2 class="question-title">What areas would you love to explore?</h2>
                    <p class="question-subtitle">Select all that apply</p>
                    <div class="options">
                        <div class="option">
                            <input type="checkbox" id="area1" name="interest_areas[]" value="Design & Creativity">
                            <label for="area1">Design & Creativity</label>
                        </div>
                        <div class="option">
                            <input type="checkbox" id="area2" name="interest_areas[]" value="Writing & Blogging">
                            <label for="area2">Writing & Blogging</label>
                        </div>
                        <div class="option">
                            <input type="checkbox" id="area3" name="interest_areas[]" value="Web Projects">
                            <label for="area3">Web Projects</label>
                        </div>
                        <div class="option">
                            <input type="checkbox" id="area4" name="interest_areas[]" value="AI & Automation">
                            <label for="area4">AI & Automation</label>
                        </div>
                        <div class="option">
                            <input type="checkbox" id="area5" name="interest_areas[]" value="Marketing & Ads">
                            <label for="area5">Marketing & Ads</label>
                        </div>
                        <div class="option">
                            <input type="checkbox" id="area6" name="interest_areas[]" value="Social Media Tasks">
                            <label for="area6">Social Media Tasks</label>
                        </div>
                        <div class="option">
                            <input type="checkbox" id="area7" name="interest_areas[]" value="Video Projects">
                            <label for="area7">Video Projects</label>
                        </div>
                        <div class="option">
                            <input type="checkbox" id="area8" name="interest_areas[]" value="Photography">
                            <label for="area8">Photography</label>
                        </div>
                        <div class="option">
                            <input type="checkbox" id="area9" name="interest_areas[]" value="E-commerce">
                            <label for="area9">E-commerce</label>
                        </div>
                        <div class="option">
                            <input type="checkbox" id="area10" name="interest_areas[]" value="Consulting & Strategy">
                            <label for="area10">Consulting & Strategy</label>
                        </div>
                    </div>
                </div>

                <!-- Step 14 -->
                <div class="step" data-step="14">
                    <div class="step-indicator">Step 14 of 20</div>
                    <h2 class="question-title">Are you open to picking up new skills?</h2>
                    <div class="options">
                        <div class="option">
                            <input type="radio" id="skill1" name="learning_willingness" value="Absolutely! Let's go!" required>
                            <label for="skill1">Absolutely! Let's go!</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="skill2" name="learning_willingness" value="Not really">
                            <label for="skill2">Not really</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="skill3" name="learning_willingness" value="Still thinking about it">
                            <label for="skill3">Still thinking about it</label>
                        </div>
                    </div>
                </div>

                <!-- Step 15 -->
                <div class="step" data-step="15">
                    <div class="step-indicator">Step 15 of 20</div>
                    <h2 class="question-title">How ready are you to dive into AI?</h2>
                    <div class="options">
                        <div class="option">
                            <input type="radio" id="ready1" name="ai_readiness" value="Totally ready" required>
                            <label for="ready1">Totally ready</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="ready2" name="ai_readiness" value="Let's give it a go">
                            <label for="ready2">Let's give it a go</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="ready3" name="ai_readiness" value="Kind of ready">
                            <label for="ready3">Kind of ready</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="ready4" name="ai_readiness" value="Not really... yet">
                            <label for="ready4">Not really... yet</label>
                        </div>
                    </div>
                </div>

                <!-- Step 16 -->
                <div class="step" data-step="16">
                    <div class="step-indicator">Step 16 of 20</div>
                    <h2 class="question-title">Do you have a dream goal you're working toward?</h2>
                    <p class="question-subtitle">It's easier to stay motivated when you've got something exciting in mind.</p>
                    <div class="options">
                        <div class="option">
                            <input type="radio" id="dream1" name="dream_goal" value="Own my dream home" required>
                            <label for="dream1">Own my dream home</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="dream2" name="dream_goal" value="Throw the perfect wedding">
                            <label for="dream2">Throw the perfect wedding</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="dream3" name="dream_goal" value="Take a big vacation">
                            <label for="dream3">Take a big vacation</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="dream4" name="dream_goal" value="Get a new car">
                            <label for="dream4">Get a new car</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="dream5" name="dream_goal" value="Retire stress-free">
                            <label for="dream5">Retire stress-free</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="dream6" name="dream_goal" value="Something else">
                            <label for="dream6">Something else</label>
                        </div>
                    </div>
                </div>

                <!-- Step 17 -->
                <div class="step" data-step="17">
                    <div class="step-indicator">Step 17 of 20</div>
                    <h2 class="question-title">How much time can you invest in your goals daily?</h2>
                    <div class="options">
                        <div class="option">
                            <input type="radio" id="time1" name="daily_time_commitment" value="5 min a day" required>
                            <label for="time1">5 min a day</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="time2" name="daily_time_commitment" value="10 min a day">
                            <label for="time2">10 min a day</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="time3" name="daily_time_commitment" value="15 min a day">
                            <label for="time3">15 min a day</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="time4" name="daily_time_commitment" value="20 min a day">
                            <label for="time4">20 min a day</label>
                        </div>
                    </div>
                </div>

                <!-- Step 18 -->
                <div class="step" data-step="18">
                    <div class="step-indicator">Step 18 of 20</div>
                    <h2 class="question-title">How well can you stay focused?</h2>
                    <div class="options">
                        <div class="option">
                            <input type="radio" id="focus1" name="focus_ability" value="I'm good at staying focused" required>
                            <label for="focus1">I'm good at staying focused</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="focus2" name="focus_ability" value="I try, but get distracted sometimes">
                            <label for="focus2">I try, but get distracted sometimes</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="focus3" name="focus_ability" value="It's hard for me to stay on track">
                            <label for="focus3">It's hard for me to stay on track</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="focus4" name="focus_ability" value="I procrastinate a lot">
                            <label for="focus4">I procrastinate a lot</label>
                        </div>
                    </div>
                </div>

                <!-- Step 19 -->
                <div class="step" data-step="19">
                    <div class="step-indicator">Step 19 of 20</div>
                    <h2 class="question-title">Which device will you use for learning?</h2>
                    <div class="options">
                        <div class="option">
                            <input type="radio" id="device1" name="preferred_device" value="Phone" required>
                            <label for="device1">Phone</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="device2" name="preferred_device" value="Desktop">
                            <label for="device2">Desktop</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="device3" name="preferred_device" value="Tablet">
                            <label for="device3">Tablet</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="device4" name="preferred_device" value="Multiple devices">
                            <label for="device4">Multiple devices</label>
                        </div>
                    </div>
                </div>

                <!-- Step 20 -->
                <div class="step" data-step="20">
                    <div class="step-indicator">Step 20 of 20</div>
                    <h2 class="question-title">What type of lesson format do you prefer?</h2>
                    <div class="options">
                        <div class="option">
                            <input type="radio" id="format1" name="preferred_format" value="Text" required>
                            <label for="format1">Text</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="format2" name="preferred_format" value="Video">
                            <label for="format2">Video</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="format3" name="preferred_format" value="Interactive lessons">
                            <label for="format3">Interactive lessons</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="format4" name="preferred_format" value="Doesn't matter">
                            <label for="format4">Doesn't matter</label>
                        </div>
                    </div>
                </div>

                <div class="button-group">
                    <button type="button" class="btn btn-secondary" id="prevBtn" onclick="changeStep(-1)">Previous</button>
                    <button type="button" class="btn btn-primary" id="nextBtn" onclick="changeStep(1)">Next</button>
                </div>
            </form>

            <div class="loading" id="loadingDiv">
                <div class="spinner"></div>
                <p>Saving your profile...</p>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 20;

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateButtons();
            updateProgress();
        });

        function changeStep(direction) {
            const currentStepElement = document.querySelector(`.step[data-step="${currentStep}"]`);
            
            // Validate current step before moving forward
            if (direction === 1 && !validateStep(currentStepElement)) {
                showError('Please answer the question before continuing.');
                return;
            }

            hideError();

            // Hide current step
            currentStepElement.classList.remove('active');

            // Update step number
            currentStep += direction;

            // Show new step
            const newStepElement = document.querySelector(`.step[data-step="${currentStep}"]`);
            newStepElement.classList.add('active');

            // Update UI
            updateButtons();
            updateProgress();

            // Scroll to top
            document.querySelector('.form-container').scrollTop = 0;
        }

        function validateStep(stepElement) {
            const radios = stepElement.querySelectorAll('input[type="radio"]');
            const checkboxes = stepElement.querySelectorAll('input[type="checkbox"]');

            // Check if it's a radio question
            if (radios.length > 0) {
                const name = radios[0].name;
                return document.querySelector(`input[name="${name}"]:checked`) !== null;
            }

            // For checkbox questions, at least one should be checked (optional validation)
            // You can make this required by uncommenting the line below
            // if (checkboxes.length > 0) {
            //     return Array.from(checkboxes).some(cb => cb.checked);
            // }

            return true;
        }

        function updateButtons() {
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            // Hide/show previous button
            prevBtn.style.display = currentStep === 1 ? 'none' : 'block';

            // Change next button text on last step
            if (currentStep === totalSteps) {
                nextBtn.textContent = 'Complete Profile';
                nextBtn.onclick = submitForm;
            } else {
                nextBtn.textContent = 'Next';
                nextBtn.onclick = () => changeStep(1);
            }
        }

        function updateProgress() {
            const progress = (currentStep / totalSteps) * 100;
            document.getElementById('progressBar').style.width = progress + '%';
        }

        function showError(message) {
            const errorDiv = document.getElementById('errorMessage');
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
            setTimeout(() => {
                errorDiv.style.display = 'none';
            }, 3000);
        }

        function hideError() {
            document.getElementById('errorMessage').style.display = 'none';
        }

        function showSuccess(message) {
            const successDiv = document.getElementById('successMessage');
            successDiv.textContent = message;
            successDiv.style.display = 'block';
        }

        function submitForm() {
            const form = document.getElementById('questionnaireForm');
            const formData = new FormData(form);

            // Show loading
            document.querySelector('.form-container').style.display = 'none';
            document.getElementById('loadingDiv').style.display = 'block';

            // Add user_id from session (you'll need to pass this from your PHP session)
            // For now, we'll use a placeholder - replace this with actual session user_id
            formData.append('user_id', getUserId());

            // Send to PHP backend
            fetch('save_profile.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirect to dashboard
                    window.location.href = 'dashboard.php';
                } else {
                    // Show error
                    document.querySelector('.form-container').style.display = 'block';
                    document.getElementById('loadingDiv').style.display = 'none';
                    showError(data.message || 'Failed to save profile. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.querySelector('.form-container').style.display = 'block';
                document.getElementById('loadingDiv').style.display = 'none';
                showError('An error occurred. Please try again.');
            });
        }

        // Helper function to get user_id - you should implement this based on your session
        function getUserId() {
            // This is a placeholder - you should get the actual user_id from your PHP session
            // You can pass it via a hidden input or data attribute in the HTML
            return document.body.dataset.userId || 1; // Default to 1 for testing
        }
    </script>
</body>
</html>