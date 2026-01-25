<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Articles | EvolveAI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="h-full overflow-hidden flex">

    <?php require __DIR__ . '/../partials/sidebar.php'; ?>

    <div class="flex-1 flex flex-col h-full bg-gray-50 overflow-hidden">
        <header class="bg-white border-b border-gray-200 h-16 flex items-center px-8 justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Knowledge Base</h1>
        </header>

        <main class="flex-1 overflow-y-auto p-8">
            
            <?php if (empty($articles)): ?>
                <div class="text-center py-20">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 mb-4">
                        <i class="ph ph-books text-3xl text-blue-600"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No articles yet</h3>
                    <p class="text-gray-500 mt-1">Generate a Daily Plan first, and AI will curate content for you.</p>
                </div>
            <?php else: ?>

                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    <?php foreach ($articles as $article): ?>
                        <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow flex flex-col overflow-hidden">
                            
                            <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                                <div class="flex justify-between items-start">
                                    <span class="text-xs font-semibold uppercase tracking-wider text-blue-600">
                                        <?= date('M d, Y', strtotime($article['created_at'])) ?>
                                    </span>
                                    
                                    <form action="/EvolveAI/public/index.php?url=articles/delete" method="POST" onsubmit="return confirm('Delete this article?');">
                                        <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
                                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">
                                            <i class="ph ph-trash text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                                <h2 class="mt-2 text-lg font-bold text-gray-900 leading-snug">
                                    <?= htmlspecialchars($article['title']) ?>
                                </h2>
                            </div>

                            <div class="p-5 flex-1">
                                <p class="text-sm text-gray-600 leading-relaxed mb-4">
                                    <?= nl2br(htmlspecialchars(substr($article['content'], 0, 300))) ?>...
                                </p>

                                <?php if (!empty($article['links'])): ?>
                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <span class="text-xs font-bold text-gray-400 uppercase block mb-2">Recommended Resources</span>
                                        <div class="flex flex-wrap gap-2">
                                            <a href="#" class="inline-flex items-center text-xs text-blue-600 hover:underline">
                                                <i class="ph ph-link mr-1"></i> External Link
                                            </a>
                                            </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="bg-gray-50 p-3 text-center border-t border-gray-100">
                                <button class="text-sm font-medium text-gray-600 hover:text-blue-600">Read Full Article</button>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>

            <?php endif; ?>
        </main>
    </div>
</body>
</html>