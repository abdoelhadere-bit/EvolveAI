<?php
/** * @var string|null $dailyPlanHtml 
 */
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | EvolveAI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="h-full overflow-hidden flex">

    <aside class="hidden md:flex flex-col w-64 bg-white border-r border-gray-200 text-gray-600 transition-all duration-300">
        
        <div class="h-16 flex items-center px-6 border-b border-gray-100">
            <span class="text-xl font-bold tracking-tight text-gray-900">
                Evolve<span class="text-blue-600">AI</span>
            </span>
        </div>

        <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1">
            <a href="/EvolveAi/dashboard/view" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg bg-blue-50 text-blue-700">
                <i class="ph ph-squares-four text-lg mr-3"></i>
                Dashboard
            </a>

            <a href="/EvolveAi/feedback" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                <i class="ph ph-chat-centered-text text-lg mr-3"></i>
                Feedback
            </a>

            <a href="/EvolveAi/articles" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                <i class="ph ph-article text-lg mr-3"></i>
                AI Articles
                <span class="ml-auto bg-gray-100 text-xs py-0.5 px-2 rounded-full text-gray-600 group-hover:bg-gray-200">New</span>
            </a>

            <a href="/EvolveAi/community" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                <i class="ph ph-users text-lg mr-3"></i>
                Community
            </a>
        </nav>

        <div class="p-4 border-t border-gray-100 bg-gray-50">
            <div class="flex items-center gap-3">
                <div class="h-9 w-9 rounded-full bg-white border border-gray-200 flex items-center justify-center text-xs font-bold text-blue-600 shadow-sm">
                    ME
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">My Account</p>
                    <p class="text-xs text-gray-500 truncate">Free Plan</p>
                </div>
                <a href="/EvolveAi/logout" class="text-gray-400 hover:text-red-600 transition-colors">
                    <i class="ph ph-sign-out text-lg"></i>
                </a>
            </div>
        </div>
    </aside>

    <div class="flex-1 flex flex-col h-full bg-gray-50 overflow-hidden">
        
        <header class="md:hidden bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4 sticky top-0 z-10">
            <span class="text-lg font-bold text-gray-900">EvolveAI</span>
            <button class="text-gray-500 p-2 hover:bg-gray-100 rounded-md">
                <i class="ph ph-list text-2xl"></i>
            </button>
        </header>

        <main class="flex-1 overflow-y-auto p-4 sm:p-8 relative">
            
            <?php if (!empty($dailyPlanHtml)): ?>
                
                <div class="max-w-7xl mx-auto animate-fade-in-up">
                    <?= $dailyPlanHtml ?>
                </div>

            <?php else: ?>

                <div class="h-full flex flex-col items-center justify-center text-center">
                    <div class="w-20 h-20 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-6 border border-gray-100">
                        <i class="ph ph-rocket-launch text-4xl text-blue-600"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Let's plan your success</h2>
                    <p class="text-gray-500 max-w-md mb-8">
                        Your dashboard is waiting. Generate a personalized daily plan to unlock your potential.
                    </p>
                    <a href="/EvolveAi/questionaire/view" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl shadow-lg shadow-blue-600/20 transition-all hover:scale-105">
                        <i class="ph ph-magic-wand mr-2 text-lg"></i>
                        Generate Today's Plan
                    </a>
                </div>

            <?php endif; ?>

        </main>

        <footer class="bg-white border-t border-gray-200 py-4 px-8">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center text-xs text-gray-400">
                <p>&copy; <?= date('Y') ?> EvolveAI. All rights reserved.</p>
                <div class="flex gap-4 mt-2 md:mt-0">
                    <a href="#" class="hover:text-gray-600 transition-colors">Privacy</a>
                    <a href="#" class="hover:text-gray-600 transition-colors">Terms</a>
                    <a href="#" class="hover:text-gray-600 transition-colors">Help</a>
                </div>
            </div>
        </footer>

    </div>

</body>
</html>