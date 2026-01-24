<?php

namespace App\Services;

use RuntimeException;

final class ResponseService
{
    private const MODEL = 'gemini-3-flash-preview'; // Ensure you use a valid model name
    private static string $apiKey = 'AIzaSyD9sr3yPAhpd_-f_-Z0AnR_-akwMBTrDQM';

    private static function buildUrl(): string
    {
        return sprintf(
            'https://generativelanguage.googleapis.com/v1beta/models/%s:generateContent?key=%s',
            self::MODEL,
            self::$apiKey
        );
    }

    private static function makeApiCall(string $prompt): string
    {
        $payload = [
            'contents' => [['parts' => [['text' => $prompt]]]]
        ];

        $ch = curl_init(self::buildUrl());
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_TIMEOUT => 60
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            throw new RuntimeException('Curl error: ' . curl_error($ch));
        }
        
        curl_close($ch);
        $data = json_decode($response, true);

        if (isset($data['error'])) {
            throw new RuntimeException('Gemini API Error: ' . ($data['error']['message'] ?? 'Unknown error'));
        }

        if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            throw new RuntimeException('Invalid API response structure.');
        }

        $html = $data['candidates'][0]['content']['parts'][0]['text'];

        // Clean up Markdown and tags
        $html = preg_replace('/^```html/i', '', $html);
        $html = preg_replace('/^```/', '', $html);
        $html = preg_replace('/```$/', '', $html);
        $html = preg_replace('/<!DOCTYPE html>/i', '', $html);
        $html = preg_replace('/<\/?html[^>]*>/i', '', $html);
        $html = preg_replace('/<\/?body[^>]*>/i', '', $html);
        $html = preg_replace('/<\/?head[^>]*>.*?<\/head>/si', '', $html); 

        return trim($html);
    }

    // =========================================================================
    // METHOD 1: GENERATE OPPORTUNITIES
    // =========================================================================
    public static function generateOpportunities(array $userProfile): string
    {
        $inputJson = json_encode($userProfile, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);

        $prompt = <<<PROMPT
You are an Elite Career Strategist. Analyze these user skills:
$inputJson

Identify 4 HIGH-VALUE, CONCRETE income opportunities.

OUTPUT REQUIREMENTS:
- **Output ONLY HTML content (divs).**
- **Design:** Modern Grid layout (Tailwind CSS).
- **Cards:** White bg, shadow-sm, rounded-xl, padding-6.
- **Content:** Title, Earnings Potential, and "Why it fits".
- **Action:**
  <form action="/EvolveAi/response/plan" method="POST">
      <input type="hidden" name="opportunity_title" value="...">
      <input type="hidden" name="opportunity_desc" value="...">
      <input type="hidden" name="opportunity_context" value="...">
      <button type="submit" class="w-full mt-4 bg-blue-600 text-white font-medium py-2 rounded-lg hover:bg-blue-700 transition-colors">
          Generate Action Plan
      </button>
  </form>
PROMPT;

        return self::makeApiCall($prompt);
    }

    // =========================================================================
    // METHOD 2: GENERATE EXECUTION PLAN (Dynamic & Interactive)
    // =========================================================================
    public static function generateExecutionPlan(array $selectedData, int $dayNumber = 1): string
    {
        $opportunityJson = json_encode($selectedData, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);

        $prompt = <<<PROMPT
You are an expert Productivity Coach.
The user is on **DAY $dayNumber** of their journey.

Selected Opportunity:
$opportunityJson

Create a **Dynamic Action Plan Dashboard** for **DAY $dayNumber**.

### CONTEXT & DIFFICULTY:
- **If Day 1:** Focus on setup, research, and quick wins.
- **If Day 2-7:** Focus on skill acquisition and first outreach.
- **If Day 8+:** Focus on scaling, optimization, and monetization.
- **Tone:** highly motivational but strict.

### STRUCTURE:
1.  **Header:** Title "DAY $dayNumber", Motivational Quote, and a **Progress Bar** (id="progress-fill").
2.  **Monthly Goal:** The big picture.
3.  **Weekly Sprint:** This week's specific focus.
4.  **Daily Tasks (The Core):**
    - Create 4-6 actionable tasks.
    - **HTML Structure per Task:**
      <div class="flex items-start p-3 bg-white border rounded-lg mb-2">
         <input type="checkbox" class="task-checkbox h-5 w-5 text-blue-600 mt-1 mr-3 rounded" />
         <div class="flex-1">
             <h4 class="font-medium text-gray-900">[Task Title]</h4>
             <p class="text-xs text-gray-500">[Skill Tag] • [Est. Time]</p>
         </div>
         <button class="text-xs bg-gray-100 px-2 py-1 rounded text-gray-600 hover:bg-gray-200">Verify</button>
      </div>

### REQUIREMENTS:
- **Output ONLY HTML.**
- **Use Tailwind CSS.**
- **Include this Script at the end:**
<script>
  (function(){
      const boxes = document.querySelectorAll('.task-checkbox');
      const bar = document.getElementById('progress-fill');
      const text = document.getElementById('progress-text');
      
      function update() {
          const total = boxes.length;
          const checked = document.querySelectorAll('.task-checkbox:checked').length;
          const pct = total ? Math.round((checked/total)*100) : 0;
          if(bar) bar.style.width = pct + '%';
          if(text) text.innerText = pct + '% Completed';
          localStorage.setItem('plan_progress_day_$dayNumber', pct);
      }
      
      boxes.forEach(b => b.addEventListener('change', update));
      // Load saved state
      const saved = localStorage.getItem('plan_progress_day_$dayNumber');
      if(saved && bar) { 
          bar.style.width = saved + '%'; 
          if(text) text.innerText = saved + '% Completed';
      }
  })();
</script>
PROMPT;

        return self::makeApiCall($prompt);
    }

    // =========================================================================
    // METHOD 3: GENERATE EDUCATIONAL ARTICLES (JSON Output)
    // =========================================================================
    public static function generateArticlesContext(string $currentPlanHtml): array
    {
        // We strip tags to save tokens, the AI just needs the text context
        $planText = strip_tags($currentPlanHtml);

        $prompt = <<<PROMPT
You are an AI Learning Assistant.
Based on the user's daily plan below, generate 2 SHORT educational articles to help them achieve these specific tasks.

USER PLAN CONTEXT:
$planText

REQUIREMENTS:
- Return ONLY valid JSON.
- The JSON must be an array of objects.
- Each object must have: "title", "content" (2-3 paragraphs, simple formatting), and "links" (a list of 2 relevant URL suggestions).
- DO NOT use Markdown formatting in the response (no ```json).
- Example format:
[
  {
    "title": "Understanding MVC",
    "content": "MVC stands for...",
    "links": "https://wikipedia.org, https://youtube.com"
  }
]
PROMPT;

        $jsonStr = self::makeApiCall($prompt);

        // Sanitize if AI adds markdown fences despite instructions
        $jsonStr = preg_replace('/^```json/i', '', $jsonStr);
        $jsonStr = preg_replace('/^```/', '', $jsonStr);
        $jsonStr = preg_replace('/```$/', '', $jsonStr);

        $data = json_decode($jsonStr, true);

        if (!is_array($data)) {
            // Fallback if AI fails to give JSON
            return [];
        }
        

        return $data;
    }
    // ... (Keep existing methods) ...

    // =========================================================================
    // METHOD 4: ANALYZE TASK SUBMISSION (Feedback Loop)
    // =========================================================================
    public static function analyzeTaskSubmission(string $planContext, string $taskTitle, string $userWork): array
    {
        // Strip tags to give AI just the text context of the plan
        $contextClean = strip_tags($planContext);

        $prompt = <<<PROMPT
You are a strict but encouraging AI Mentor.
The user is submitting work for a task from their Daily Plan.

CONTEXT (The User's Plan):
$contextClean

THE TASK BEING SUBMITTED:
"$taskTitle"

THE USER'S WORK/SUBMISSION:
"$userWork"

YOUR GOAL:
1. Evaluate if the work satisfies the task.
2. Provide a score (0-100).
3. Give specific, constructive feedback.

OUTPUT JSON ONLY:
{
    "score": 85,
    "feedback": "Great start! You correctly identified X, but you missed Y...",
    "status": "approved" (or "needs_revision")
}
PROMPT;

        $jsonStr = self::makeApiCall($prompt);

        // Sanitize JSON
        $jsonStr = preg_replace('/^```json/i', '', $jsonStr);
        $jsonStr = preg_replace('/^```/', '', $jsonStr);
        $jsonStr = preg_replace('/```$/', '', $jsonStr);

        $data = json_decode($jsonStr, true);

        return is_array($data) ? $data : [
            'score' => 0, 
            'feedback' => 'AI could not process this submission.', 
            'status' => 'error'
        ];
    }
}
