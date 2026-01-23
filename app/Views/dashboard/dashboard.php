<?php
/** * @var string|null $dailyPlanHtml 
 */

if (!empty($dailyPlanHtml)) {
    // 1. If the AI generated content exists, display it.
    echo $dailyPlanHtml;

} else {
    // 2. Professional "Empty State" Fallback
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard | EvolveAI</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="bg-gray-50 h-screen flex flex-col">
        
        <nav class="bg-white border-b border-gray-200 px-4 py-3">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <span class="text-xl font-bold text-gray-900 tracking-tight">Evolve<span class="text-blue-600">AI</span></span>
            </div>
        </nav>

        <div class="flex-1 flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full text-center">
                
                <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-blue-50 mb-6">
                    <svg class="h-12 w-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>

                <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-3">
                    Ready to start your day?
                </h2>
                
                <p class="text-base text-gray-500 mb-8 max-w-sm mx-auto">
                    You haven't generated a plan for today yet. Tell us about your goals, and let AI build your schedule.
                </p>

                <div class="flex justify-center gap-4">
                    <a href="/EvolveAi/questionaire/view" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5">
                        <svg class="mr-2 -ml-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Generate New Plan
                    </a>
                </div>

                <p class="mt-8 text-xs text-gray-400 uppercase tracking-widest">
                    Powered by Gemini 2.5 Flash
                </p>
            </div>
        </div>
    </body>
    </html>
<?php 
} 
?>