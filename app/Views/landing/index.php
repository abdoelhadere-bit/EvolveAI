<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EvolveAI - Transform Your Daily Hustle</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="#" class="text-2xl font-bold tracking-tighter text-gray-900">
                        Evolve<span class="text-blue-600">AI</span>
                    </a>
                </div>
                
                <!-- Buttons -->
                <div class="flex items-center space-x-4">
                    <a href="/EvolveAI/public/index.php?url=auth/login" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Log In</a>
                    <a href="/EvolveAI/public/index.php?url=auth/signup" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700 transition-all hover:shadow-lg shadow-blue-600/20">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-20 pb-32 overflow-hidden">
        <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-blue-100 via-white to-white opacity-50"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
           
            
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-gray-900 mb-6 max-w-4xl mx-auto leading-tight">
                Turn Your Potential Into <br class="hidden md:block"/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Daily Revenue</span>
            </h1>
            
            <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
                EvolveAI gives you a personalized, actionable daily plan to build skills and generate income. Stop guessing, start evolving.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="/EvolveAI/public/index.php?url=auth/signup" class="px-8 py-4 text-lg font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-all hover:scale-105 shadow-xl shadow-blue-600/20 flex items-center justify-center">
                    Start Your Evolution
                    <i class="ph ph-arrow-right ml-2 text-xl"></i>
                </a>
                <a href="#how-it-works" class="px-8 py-4 text-lg font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors flex items-center justify-center">
                    <i class="ph ph-play-circle mr-2 text-xl"></i>
                    See How It Works
                </a>
            </div>
        </div>
    </section>

    <!-- Features / How it works -->
    <section id="how-it-works" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900">Your path to success is generated daily.</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">We don't give you generic advice. We give you a checklist.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 text-2xl mb-6">
                        <i class="ph ph-target"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">1. Define Your Goal</h3>
                    <p class="text-gray-600">Tell us your skills, time availability, and income targets. Our AI builds a profile tailored to you.</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 text-2xl mb-6">
                        <i class="ph ph-lightning"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">2. Get Daily Plans</h3>
                    <p class="text-gray-600">Wake up to a fresh, actionable checklist. Tasks are broken down into small, manageable wins.</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-green-600 text-2xl mb-6">
                        <i class="ph ph-chart-line-up"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">3. Track & Evolve</h3>
                    <p class="text-gray-600">Mark tasks as done, get feedback, and watch your skills (and income) grow over time.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white py-12 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                <span class="text-xl font-bold tracking-tighter text-gray-900">
                    Evolve<span class="text-blue-600">AI</span>
                </span>
                <p class="text-sm text-gray-500 mt-2">© 2024 EvolveAI Inc.</p>
            </div>
            <div class="flex gap-6 text-gray-600">
                <a href="#" class="hover:text-blue-600 transition-colors">Privacy</a>
                <a href="#" class="hover:text-blue-600 transition-colors">Terms</a>
                <a href="#" class="hover:text-blue-600 transition-colors">Support</a>
            </div>
        </div>
    </footer>

</body>
</html>
