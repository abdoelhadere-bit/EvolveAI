    <aside id="app-sidebar" class="hidden md:flex flex-col w-64 bg-white border-r border-gray-200 text-gray-600 transition-all duration-300 md:relative fixed inset-y-0 left-0 z-50 h-full shadow-xl md:shadow-none">
        
        <div class="h-16 flex items-center px-6 border-b border-gray-100 justify-between">
            <span class="text-xl font-bold tracking-tight text-gray-900">
                Evolve<span class="text-blue-600">AI</span>
            </span>
            <button id="close-sidebar" class="md:hidden text-gray-500 hover:text-gray-700">
                <i class="ph ph-x text-xl"></i>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1">
            <a href="/EvolveAI/public/index.php?url=dashboard/view" 
               class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg <?= strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?> transition-colors">
                <i class="ph ph-squares-four text-lg mr-3"></i>
                Dashboard
            </a>
            <a href="/EvolveAI/public/index.php?url=feedback/index" 
               class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg <?= strpos($_SERVER['REQUEST_URI'], 'feedback') !== false ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?> transition-colors">
                <i class="ph ph-chat-centered-text text-lg mr-3"></i>
                Feedback
            </a>
            <a href="/EvolveAI/public/index.php?url=articles/index" 
               class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg <?= strpos($_SERVER['REQUEST_URI'], 'article') !== false ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?> transition-colors">
                <i class="ph ph-article text-lg mr-3"></i>
                AI Articles
            </a>
            <a href="/EvolveAI/public/index.php?url=community/index" 
               class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg <?= strpos($_SERVER['REQUEST_URI'], 'community') !== false ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?> transition-colors">
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
                    <a href="/EvolveAI/public/index.php?url=auth/logout" class="text-xs text-red-500 hover:text-red-700">Logout</a>
                </div>
            </div>
        </div>
    </aside>

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-gray-900/50 z-40 hidden md:hidden glass-overlay"></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('app-sidebar');
            const openBtn = document.getElementById('open-sidebar'); // Needs to be added to layouts
            const closeBtn = document.getElementById('close-sidebar');
            const overlay = document.getElementById('mobile-overlay');

            function toggleSidebar(show) {
                if (show) {
                    sidebar.classList.remove('hidden');
                    sidebar.classList.add('flex');
                    overlay.classList.remove('hidden');
                } else {
                    sidebar.classList.add('hidden');
                    sidebar.classList.remove('flex');
                    overlay.classList.add('hidden');
                }
            }

            // Find the trigger button in the main layout (it's outside this file usually)
            // We'll use event delegation or expect the ID to exist globally
            document.body.addEventListener('click', (e) => {
                if (e.target.closest('#open-sidebar')) {
                    toggleSidebar(true);
                }
            });

            closeBtn?.addEventListener('click', () => toggleSidebar(false));
            overlay?.addEventListener('click', () => toggleSidebar(false));
        });
    </script>
