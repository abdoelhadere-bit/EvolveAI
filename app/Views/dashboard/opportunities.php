<?php
/** @var array $opportunities */
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Opportunity | EvolveAI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen p-8">

    <div class="max-w-6xl mx-auto">
        <header class="mb-10 text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Identify Your Path</h1>
            <p class="text-gray-500">Based on your profile, here are the top opportunities for you.</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($opportunities as $opp): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow flex flex-col h-full">
                    <h3 class="text-xl font-bold text-gray-900 mb-2"><?= htmlspecialchars($opp['title'] ?? 'Opportunity') ?></h3>
                    
                    <div class="mb-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <?= htmlspecialchars($opp['estimated_earnings'] ?? 'Earnings TBD') ?>
                        </span>
                    </div>

                    <p class="text-gray-600 text-sm mb-4 flex-1">
                        <?= htmlspecialchars($opp['description'] ?? '') ?>
                    </p>

                    <div class="bg-blue-50 p-3 rounded-lg mb-6">
                        <p class="text-xs text-blue-700">
                            <strong>Why it fits:</strong> <?= htmlspecialchars($opp['why_fit'] ?? '') ?>
                        </p>
                    </div>

                    <form action="/EvolveAI/public/index.php?url=response/plan" method="POST" class="mt-auto">
                        <input type="hidden" name="opportunity_title" value="<?= htmlspecialchars($opp['title'] ?? '') ?>">
                        <input type="hidden" name="opportunity_desc" value="<?= htmlspecialchars($opp['description'] ?? '') ?>">
                        <input type="hidden" name="opportunity_earnings" value="<?= htmlspecialchars($opp['estimated_earnings'] ?? '') ?>">
                        
                        <button type="submit" class="w-full bg-blue-600 text-white font-medium py-2.5 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center">
                            Select & Generate Plan
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-12">
            <a href="/EvolveAI/public/index.php?url=dashboard/view" class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                &larr; Back to Dashboard
            </a>
        </div>
    </div>

</body>
</html>
