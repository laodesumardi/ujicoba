<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Real-Time Messaging</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Test Real-Time Messaging</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Tab 1 - Simulate Teacher -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4 text-blue-600">
                    <i class="fas fa-chalkboard-teacher mr-2"></i>
                    Tab 1 - Simulate Teacher
                </h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pesan untuk Siswa:</label>
                        <input type="text" id="teacherMessage" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ketik pesan untuk siswa...">
                    </div>
                    
                    <button onclick="sendTeacherMessage()" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition-colors">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim ke Siswa
                    </button>
                    
                    <button onclick="checkStudentMessages()" class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Check Pesan Siswa
                    </button>
                </div>
                
                <div class="mt-6">
                    <h3 class="font-semibold mb-2">Pesan yang Diterima:</h3>
                    <div id="teacherMessages" class="bg-gray-50 p-4 rounded-md min-h-[200px] max-h-[300px] overflow-y-auto">
                        <p class="text-gray-500 text-sm">Belum ada pesan...</p>
                    </div>
                </div>
            </div>
            
            <!-- Tab 2 - Simulate Student -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4 text-green-600">
                    <i class="fas fa-user-graduate mr-2"></i>
                    Tab 2 - Simulate Student
                </h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pesan untuk Guru:</label>
                        <input type="text" id="studentMessage" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Ketik pesan untuk guru...">
                    </div>
                    
                    <button onclick="sendStudentMessage()" class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition-colors">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim ke Guru
                    </button>
                    
                    <button onclick="checkTeacherMessages()" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Check Pesan Guru
                    </button>
                </div>
                
                <div class="mt-6">
                    <h3 class="font-semibold mb-2">Pesan yang Diterima:</h3>
                    <div id="studentMessages" class="bg-gray-50 p-4 rounded-md min-h-[200px] max-h-[300px] overflow-y-auto">
                        <p class="text-gray-500 text-sm">Belum ada pesan...</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Debug Information</h2>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="font-medium">localStorage Keys:</span>
                    <span id="localStorageKeys" class="text-sm text-gray-600">Loading...</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Storage Events:</span>
                    <span id="storageEvents" class="text-sm text-gray-600">0</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        const courseId = 6;
        const forumId = 1;
        let storageEventCount = 0;

        // Listen for storage events
        window.addEventListener('storage', function(event) {
            storageEventCount++;
            document.getElementById('storageEvents').textContent = storageEventCount;
            
            console.log('Storage event detected:', event.key, event.newValue);
            
            if (event.key === 'forum_trigger_' + courseId + '_' + forumId) {
                if (event.newValue) {
                    const triggerData = JSON.parse(event.newValue);
                    console.log('Trigger data received:', triggerData);
                    
                    if (triggerData.type === 'teacher_message') {
                        addMessageToStudentUI(triggerData.message);
                    } else if (triggerData.type === 'student_message') {
                        addMessageToTeacherUI(triggerData.message);
                    }
                }
            }
        });

        function sendTeacherMessage() {
            const message = document.getElementById('teacherMessage').value.trim();
            if (!message) return;
            
            const messageObj = {
                message: message,
                author: 'Guru Test',
                isOwn: false,
                timestamp: new Date().toISOString(),
                fromTeacher: true,
                id: Date.now() + '_teacher'
            };
            
            // Save to shared storage
            const sharedKey = 'forum_messages_' + courseId + '_' + forumId;
            const sharedMessages = JSON.parse(localStorage.getItem(sharedKey) || '[]');
            sharedMessages.push(messageObj);
            localStorage.setItem(sharedKey, JSON.stringify(sharedMessages));
            
            // Set trigger
            const triggerKey = 'forum_trigger_' + courseId + '_' + forumId;
            localStorage.setItem(triggerKey, JSON.stringify({
                type: 'teacher_message',
                message: messageObj,
                timestamp: Date.now()
            }));
            
            console.log('Teacher message sent:', messageObj);
            document.getElementById('teacherMessage').value = '';
            updateLocalStorageKeys();
        }

        function sendStudentMessage() {
            const message = document.getElementById('studentMessage').value.trim();
            if (!message) return;
            
            const messageObj = {
                message: message,
                author: 'Siswa Test',
                isOwn: false,
                timestamp: new Date().toISOString(),
                fromStudent: true,
                id: Date.now() + '_student'
            };
            
            // Save to shared storage
            const sharedKey = 'forum_messages_' + courseId + '_' + forumId;
            const sharedMessages = JSON.parse(localStorage.getItem(sharedKey) || '[]');
            sharedMessages.push(messageObj);
            localStorage.setItem(sharedKey, JSON.stringify(sharedMessages));
            
            // Set trigger
            const triggerKey = 'forum_trigger_' + courseId + '_' + forumId;
            localStorage.setItem(triggerKey, JSON.stringify({
                type: 'student_message',
                message: messageObj,
                timestamp: Date.now()
            }));
            
            console.log('Student message sent:', messageObj);
            document.getElementById('studentMessage').value = '';
            updateLocalStorageKeys();
        }

        function addMessageToTeacherUI(messageObj) {
            const container = document.getElementById('teacherMessages');
            if (container.querySelector('.text-gray-500')) {
                container.innerHTML = '';
            }
            
            const messageDiv = document.createElement('div');
            messageDiv.className = 'mb-3 p-3 bg-blue-50 border-l-4 border-blue-400 rounded';
            messageDiv.innerHTML = `
                <div class="flex justify-between items-start">
                    <div>
                        <div class="font-semibold text-blue-800">${messageObj.author}</div>
                        <div class="text-gray-700">${messageObj.message}</div>
                    </div>
                    <div class="text-xs text-gray-500">${new Date(messageObj.timestamp).toLocaleTimeString()}</div>
                </div>
            `;
            container.appendChild(messageDiv);
            container.scrollTop = container.scrollHeight;
        }

        function addMessageToStudentUI(messageObj) {
            const container = document.getElementById('studentMessages');
            if (container.querySelector('.text-gray-500')) {
                container.innerHTML = '';
            }
            
            const messageDiv = document.createElement('div');
            messageDiv.className = 'mb-3 p-3 bg-green-50 border-l-4 border-green-400 rounded';
            messageDiv.innerHTML = `
                <div class="flex justify-between items-start">
                    <div>
                        <div class="font-semibold text-green-800">${messageObj.author}</div>
                        <div class="text-gray-700">${messageObj.message}</div>
                    </div>
                    <div class="text-xs text-gray-500">${new Date(messageObj.timestamp).toLocaleTimeString()}</div>
                </div>
            `;
            container.appendChild(messageDiv);
            container.scrollTop = container.scrollHeight;
        }

        function checkStudentMessages() {
            const triggerKey = 'forum_trigger_' + courseId + '_' + forumId;
            const triggerData = localStorage.getItem(triggerKey);
            
            console.log('Checking for student messages:', triggerKey, triggerData);
            
            if (triggerData) {
                const data = JSON.parse(triggerData);
                if (data.type === 'student_message') {
                    addMessageToTeacherUI(data.message);
                    alert('Pesan siswa ditemukan!');
                } else {
                    alert('Trigger data bukan dari siswa: ' + data.type);
                }
            } else {
                alert('Tidak ada trigger data dari siswa');
            }
        }

        function checkTeacherMessages() {
            const triggerKey = 'forum_trigger_' + courseId + '_' + forumId;
            const triggerData = localStorage.getItem(triggerKey);
            
            console.log('Checking for teacher messages:', triggerKey, triggerData);
            
            if (triggerData) {
                const data = JSON.parse(triggerData);
                if (data.type === 'teacher_message') {
                    addMessageToStudentUI(data.message);
                    alert('Pesan guru ditemukan!');
                } else {
                    alert('Trigger data bukan dari guru: ' + data.type);
                }
            } else {
                alert('Tidak ada trigger data dari guru');
            }
        }

        function updateLocalStorageKeys() {
            const keys = Object.keys(localStorage).filter(key => key.includes('forum'));
            document.getElementById('localStorageKeys').textContent = keys.join(', ') || 'None';
        }

        // Initialize
        updateLocalStorageKeys();
        setInterval(updateLocalStorageKeys, 2000);
    </script>
</body>
</html>
