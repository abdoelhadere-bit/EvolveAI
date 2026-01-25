<?php
$tasks = $plan['tasks'] ?? [];
$completedTasks = count(array_filter($tasks, fn($t) => $t['status'] === 'done'));
$totalTasks = count($tasks);
$progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
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
        .strike-through { text-decoration: line-through; color: #9CA3AF; }
    </style>
</head>
<body class="h-full overflow-hidden flex">

    <?php require __DIR__ . '/../partials/sidebar.php'; ?>

    <div class="flex-1 flex flex-col h-full bg-gray-50 overflow-hidden">
        
        <header class="md:hidden bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4 sticky top-0 z-10">
            <span class="text-lg font-bold text-gray-900">EvolveAI</span>
            <button id="open-sidebar" class="text-gray-500 hover:text-gray-700">
                <i class="ph ph-list text-2xl"></i>
            </button>
        </header>

        <main class="flex-1 overflow-y-auto p-4 sm:p-8 relative">
            
            <div class="max-w-4xl mx-auto">
                
                <?php if (!empty($tasks)): ?>
                <!-- Progress Header -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Today's Plan</h2>
                            <p class="text-gray-500 text-sm"><?= date('l, F j, Y', strtotime($plan['plan_date'])) ?></p>
                        </div>
                        <div class="text-right">
                            <span class="text-3xl font-bold text-blue-600" id="progress-text"><?= $progress ?>%</span>
                            <p class="text-xs text-gray-400">Completed</p>
                        </div>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-3">
                        <div class="bg-blue-600 h-3 rounded-full transition-all duration-500" 
                             id="progress-bar"
                             style="width: <?= $progress ?>%"></div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Task List -->
                <div class="space-y-4">
                    <?php foreach ($tasks as $task): ?>
                        <?php $isDone = $task['status'] === 'done'; ?>
                        <div class="bg-white rounded-xl border border-gray-200 p-5 transition-all hover:shadow-md group task-item <?= $isDone ? 'opacity-75' : '' ?>" data-id="<?= $task['id'] ?>">
                            <div class="flex items-start gap-4">
                                <div class="pt-1">
                                    <input type="checkbox" 
                                           class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer task-checkbox"
                                           <?= $isDone ? 'checked' : '' ?>>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 task-title <?= $isDone ? 'strike-through' : '' ?>">
                                        <?= htmlspecialchars($task['title']) ?>
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-1"><?= htmlspecialchars($task['description']) ?></p>
                                    
                                    <?php if(!empty($task['deadline'])): ?>
                                        <div class="mt-3 flex items-center text-xs text-gray-400">
                                            <i class="ph ph-clock mr-1"></i>
                                            <?= htmlspecialchars($task['deadline']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                 <!-- Verification Action (Simulated) -->
                                <button class="invisible group-hover:visible text-xs bg-gray-50 hover:bg-gray-100 text-gray-600 px-3 py-1.5 rounded-lg border border-gray-200 transition-colors">
                                    Analyze
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (empty($tasks)): ?>
                    <div class="text-center py-16">
                        <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <i class="ph ph-rocket-launch text-4xl text-blue-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Ready to Evolve?</h3>
                        <p class="text-gray-500 max-w-sm mx-auto mb-8">
                            You haven't generated a plan for today yet. Create your path to success now.
                        </p>
                        <a href="/EvolveAI/public/index.php?url=questionaire/view" 
                           class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-all shadow-lg shadow-blue-600/20 hover:scale-105">
                            <i class="ph ph-magic-wand mr-2 text-lg"></i>
                            Generate Daily Plan
                        </a>
                    </div>
                <?php endif; ?>

            </div>

        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const checkboxes = document.querySelectorAll('.task-checkbox');
            const progressBar = document.getElementById('progress-bar');
            const progressText = document.getElementById('progress-text');
            const totalTasks = checkboxes.length;

            checkboxes.forEach(cb => {
                cb.addEventListener('change', async (e) => {
                    const taskItem = e.target.closest('.task-item');
                    const taskId = taskItem.dataset.id;
                    const isChecked = e.target.checked;
                    const status = isChecked ? 'done' : 'todo';
                    const title = taskItem.querySelector('.task-title');

                    // Optimistic UI Update
                    if (isChecked) {
                        taskItem.classList.add('opacity-75');
                        title.classList.add('strike-through');
                    } else {
                        taskItem.classList.remove('opacity-75');
                        title.classList.remove('strike-through');
                    }
                    updateProgress();

                    // API Call
                    try {
                        const response = await fetch('/EvolveAI/public/index.php?url=dashboard/updateTask', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ taskId, status })
                        });
                        
                        if (!response.ok) throw new Error('Failed');

                    } catch (error) {
                        console.error(error);
                        // Revert on failure
                        e.target.checked = !isChecked;
                        updateProgress();
                        alert('Could not update task. Please try again.');
                    }
                });
            });

            function updateProgress() {
                const checkedCount = document.querySelectorAll('.task-checkbox:checked').length;
                const percent = totalTasks > 0 ? Math.round((checkedCount / totalTasks) * 100) : 0;
                
                progressBar.style.width = percent + '%';
                progressText.innerText = percent + '%';
            }
        });
    </script>
</body>
</html>