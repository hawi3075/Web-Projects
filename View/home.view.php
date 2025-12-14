<?php
require_once 'View/components/brainstorming.view.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Chat Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none; /* IE and Edge */
            scrollbar-width: none; /* Firefox */
        }

        /* Style for alternating chat bubbles */
        #chats li:nth-child(odd) {
            /* This is a CSS-only solution, usually better to handle roles in JS/PHP */
            text-align: right; 
        }

        /* Responsive Footer Positioning */
        .chat-footer {
            /* Use fixed or absolute relative to the body/viewport */
            position: fixed; 
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            width: 90%; /* Default width for small screens */
            max-width: 650px; /* Maximum width for the chat input */
            z-index: 50; /* Ensure it is above main content */
        }
        
        /* Ensure the main content doesn't get covered by the footer */
        .chat-content-padding {
            padding-bottom: 12rem; /* Add sufficient padding to avoid footer overlap */
        }
    </style>
</head>
<body class="bg-gradient-to-br from-black to-[#16254b] text-white min-h-screen flex no-scrollbar">

<aside id="sidebar"
    class="w-72 h-screen bg-[#000000] transition-transform duration-500 ease-in-out transform -translate-x-full 
           fixed md:relative md:translate-x-0 z-50 flex flex-col">
    
    <div class="flex justify-between items-center p-4 border-b border-gray-600">
        <h2 class="text-xl font-bold">Menu</h2>
        <button id="toggleSidebar" class="text-white text-2xl focus:outline-none md:hidden">
            ✕
        </button>
    </div>

    <div class="flex flex-col items-center gap-4 w-full my-5 ">
        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-500 ">
            <h1 class="text-2xl font-semibold"><?= htmlspecialchars($username[0] ?? '?') ?></h1>
        </div>
        <p class="text-xl font-semibold "><?= htmlspecialchars($username ?? 'User') ?></p>
    </div>

    <div class="overflow-y-auto px-4 py-2 flex-grow">
        <h3 class="text-lg font-semibold mb-2">Chat History</h3>
        <ul class="space-y-2">
            <?= $chatItemsHtml ?? '' ?>
        </ul>
    </div>

    <div class="p-4 border-t border-gray-600">
        <button class="w-full bg-red-600 hover:bg-red-700 py-2 rounded-md text-white font-medium">
            Logout
        </button>
    </div>
</aside>

<main class="flex flex-col flex-grow h-screen relative no-scrollbar">
    
    <header class="p-4 flex justify-start gap-4 items-center border-b border-gray-800">
        <button id="openSidebar" class="text-white text-2xl focus:outline-none md:hidden">
            ☰
        </button>
        <h1 class="text-2xl font-bold">ASTU ChatBot</h1>
    </header>

    <div class="overflow-y-auto flex-grow chat-content-padding px-4"> 
        
        <section id="greeting" class="flex flex-col items-center mt-10">
            <h2 class="text-3xl font-semibold mb-8">Hello, Ask Me Anything...</h2>
            
            <?php
            // Ensure $ideas is defined if it's not coming from a guaranteed source
            $ideas = [
                // ... (your existing $ideas array)
                [
                    "icon" => '☀️',
                    "idea1" => "Explain quantum computing in simple terms",
                    "idea2" => "How do I make HTTP in JavaScript",
                    "color" => "bg-purple-700"
                ],
                [
                    "icon" => '💻',
                    "idea1" => "What is an API?",
                    "idea2" => "How to use async/await",
                    "color" => "bg-blue-500"
                ],
                [
                    "icon" => '🧠',
                    "idea1" => "Basics of AI",
                    "idea2" => "How machine learning works",
                    "color" => "bg-pink-600"
                ],
            ];
            
            echo "<div class='grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-4xl w-full px-4'>";
            foreach ($ideas as $idea) {
                // Ensure Brainstorming class exists and has a render method
                if (class_exists('Brainstorming')) {
                    $brainstorming = new Brainstorming(
                        $idea['icon'],
                        $idea['idea1'],
                        $idea['idea2'],
                        $idea['color']
                    );
                    echo $brainstorming->render();
                }
            }
            echo '</div>';
            ?>
        </section>

        <section id="chatBox" class="w-full max-w-4xl hidden mx-auto">
            <ul id="chats" class="flex flex-col gap-6 p-4">
                </ul>
        </section>

    </div> <footer class="chat-footer h-auto bg-black py-4 px-2 flex flex-col border border-gray-600 items-center gap-4 rounded-3xl">
        <textarea
            id="dynamicInput"
            class="w-full bg-transparent text-white px-4 py-2 outline-none placeholder-gray-100 max-h-[220px] overflow-y-auto resize-none no-scrollbar"
            placeholder="Ask me anything..."
        ></textarea>

        <div class="flex justify-between items-center w-full gap-4 px-2">
            <div class="flex gap-2 sm:gap-4">
                <div class="flex items-center gap-2 border border-gray-600 px-3 py-1 sm:px-4 sm:py-2 rounded-full text-white cursor-pointer hover:bg-[#111111]">
                    <img src="/icons/star.svg" alt="star" class="w-4 h-4 sm:w-5 sm:h-5"/>
                    <span class="text-xs sm:text-sm text-gray-300 hidden sm:inline">Save</span>
                </div>

                <div class="flex items-center gap-2 border border-gray-600 px-3 py-1 sm:px-4 sm:py-2 rounded-full text-white cursor-pointer hover:bg-[#111111]">
                    <i class="text-sm sm:text-lg">🖼️</i>
                    <span class="text-xs sm:text-sm text-gray-300 hidden sm:inline">Image</span>
                </div>

                <div class="flex items-center gap-2 border border-gray-600 px-3 py-1 sm:px-4 sm:py-2 rounded-full text-white cursor-pointer hover:bg-[#111111]">
                    <i class="text-sm sm:text-lg">🎤</i>
                    <span class="text-xs sm:text-sm text-gray-300 hidden sm:inline">Voice</span>
                </div>
            </div>

            <div onclick="askGemini()"
                class="flex items-center gap-2 border border-blue-600 bg-blue-600 px-4 py-2 rounded-full text-white cursor-pointer hover:bg-blue-700 hover:border-blue-700">
                <i class="text-lg">📤</i>
                <span class="text-sm text-white">Send</span>
            </div>
        </div>
    </footer>


</main>

</body>

<script>
    // JavaScript for Sidebar Toggle
    const sidebar = document.getElementById('sidebar');
    const toggleSidebarButton = document.getElementById('toggleSidebar');
    const openSidebarButton = document.getElementById('openSidebar');
    const mainContent = document.querySelector('main');

    // Function to close sidebar
    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
    }

    // Toggle logic
    toggleSidebarButton.addEventListener('click', closeSidebar);

    openSidebarButton.addEventListener('click', () => {
        sidebar.classList.remove('-translate-x-full');
    });

    // Close sidebar when clicking outside on mobile (optional, but good UX)
    mainContent.addEventListener('click', (e) => {
        // Only close if screen size is small (less than md breakpoint)
        if (window.innerWidth < 768 && !sidebar.contains(e.target) && !openSidebarButton.contains(e.target) && !sidebar.classList.contains('-translate-x-full')) {
            closeSidebar();
        }
    });

    // You will need to keep your main.js file for AJAX logic:
    // <script src="/main.js"></script> 
</script>
<script src="/main.js"></script>

</html>