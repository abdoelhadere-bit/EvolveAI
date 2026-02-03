<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Feedback | EvolveAI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Smooth fade in for new elements */
        .fade-in { animation: fadeIn 0.5s ease-in; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="h-full overflow-hidden flex">

    <?php require __DIR__ . '/../partials/sidebar.php'; ?>

    <div class="flex-1 flex flex-col h-full bg-gray-50 overflow-hidden">
        
        <header class="md:hidden bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4">
            <span class="font-bold text-gray-900">EvolveAI</span>
            <button class="text-gray-500"><i class="ph ph-list text-2xl"></i></button>
        </header>

        <header class="hidden md:flex bg-white border-b border-gray-200 h-16 items-center px-8 justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Task Verification Center</h1>
        </header>

        <main class="flex-1 overflow-y-auto p-4 sm:p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 h-full">
                
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 flex flex-col h-fit fade-in">
                    <div class="mb-6">
                        <h2 class="text-lg font-bold text-gray-900 flex items-center">
                            <i class="ph ph-paper-plane-right text-blue-600 mr-2"></i> Submit Your Work
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">Get instant AI feedback on your daily tasks.</p>
                    </div>
                    
                    <form action="/EvolveAI/public/index.php?url=feedback/submit" method="POST" class="flex-1 flex flex-col space-y-4">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Task Title</label>
                            <input type="text" name="task_title" required 
                                placeholder="e.g. Set up Database Schema"
                                class="w-full rounded-lg border-gray-300 border px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        </div>

                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Your Submission</label>
                            <textarea name="user_work" required rows="10" 
                                placeholder="Paste your code snippet, a link to your project, or a summary of what you accomplished..."
                                class="w-full rounded-lg border-gray-300 border px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all resize-none font-mono bg-gray-50"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white font-medium py-3 rounded-lg hover:bg-blue-700 transition-all shadow-md hover:shadow-lg flex items-center justify-center group">
                            <i class="ph ph-sparkle mr-2 text-xl group-hover:animate-pulse"></i> 
                            Analyze with AI
                        </button>
                    </form>
                </div>

                <div class="flex flex-col h-full overflow-hidden">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center px-1">
                        <i class="ph ph-clock-counter-clockwise text-gray-400 mr-2"></i> Recent Analysis
                    </h2>

                    <div class="flex-1 overflow-y-auto space-y-4 pr-2 pb-10">
                        <?php if (empty($history)): ?>
                            <div class="text-center py-12 bg-white rounded-xl border border-dashed border-gray-300 fade-in">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 mb-3">
                                    <i class="ph ph-tray text-2xl text-gray-400"></i>
                                </div>
                                <h3 class="text-sm font-medium text-gray-900">No submissions yet</h3>
                                <p class="text-xs text-gray-500 mt-1">Submit your first task to see the AI grade.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($history as $item): ?>
                                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 relative overflow-hidden fade-in hover:shadow-md transition-shadow">
                                    
                                    <div class="absolute top-5 right-5 h-10 w-10 rounded-full flex items-center justify-center font-bold text-sm shadow-sm
                                        <?= $item['score'] >= 80 ? 'bg-green-100 text-green-700 ring-4 ring-green-50' : ($item['score'] >= 50 ? 'bg-yellow-100 text-yellow-700 ring-4 ring-yellow-50' : 'bg-red-100 text-red-700 ring-4 ring-red-50') ?>">
                                        <?= $item['score'] ?>
                                    </div>

                                    <div class="pr-12">
                                        <h3 class="font-bold text-gray-900 text-base mb-1"><?= htmlspecialchars($item['task_title']) ?></h3>
                                        <p class="text-xs text-gray-400 mb-4 flex items-center">
                                            <i class="ph ph-calendar-blank mr-1"></i>
                                            <?= date('M d, H:i', strtotime($item['reviewed_at'])) ?>
                                        </p>
                                    </div>
                                    
                                    <div class="bg-blue-50/50 rounded-lg p-3 border border-blue-100">
                                        <p class="text-xs text-blue-500 uppercase font-bold mb-1 tracking-wide flex items-center">
                                            <i class="ph ph-robot mr-1"></i> AI Feedback
                                        </p>
                                        <p class="text-sm text-gray-700 leading-relaxed">
                                            <?= nl2br(htmlspecialchars($item['feedback'])) ?>
                                        </p>
                                    </div>

                                    <details class="mt-3 group">
                                        <summary class="text-xs text-gray-400 cursor-pointer hover:text-blue-600 list-none flex items-center">
                                            <i class="ph ph-caret-right group-open:rotate-90 transition-transform mr-1"></i>
                                            View your submission
                                        </summary>
                                        <div class="mt-2 p-2 bg-gray-50 rounded text-xs font-mono text-gray-600 border border-gray-200 overflow-x-auto">
                                            <?= htmlspecialchars($item['content']) ?>
                                        </div>
                                    </details>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>