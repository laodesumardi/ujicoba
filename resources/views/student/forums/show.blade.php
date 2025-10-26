@extends('layouts.student')

@section('title', 'Detail Forum Diskusi')
@section('page-title', 'Detail Forum Diskusi')

@section('content')
<div class="space-y-6">
    <!-- Forum Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-start justify-between mb-4">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-3">
                    <h1 class="text-2xl font-bold text-gray-900">Diskusi Materi Pertama</h1>
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Aktif</span>
                </div>
                <p class="text-gray-700 mb-4">Mari kita diskusikan materi yang baru saja dipelajari. Silakan ajukan pertanyaan atau berbagi pendapat tentang topik ini.</p>
                
                <div class="flex items-center space-x-4 text-sm text-gray-500">
                    <span class="flex items-center">
                        <i class="fas fa-user mr-2"></i>
                        Oleh: {{ auth()->user()->name ?? 'Guru' }}
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-clock mr-2"></i>
                        {{ \Carbon\Carbon::now()->subHours(2)->diffForHumans() }}
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-comments mr-2"></i>
                        {{ rand(3, 8) }} balasan
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-eye mr-2"></i>
                        {{ rand(10, 25) }} dilihat
                    </span>
                </div>
            </div>
            
            <div class="flex items-center space-x-2">
                <a href="{{ route('student.courses.show', 6) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Kelas
                </a>
            </div>
        </div>
    </div>

    <!-- Forum Content -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Diskusi</h3>
        
        <!-- Original Post -->
        <div class="border border-gray-200 rounded-lg p-4 mb-6 bg-gradient-to-br from-blue-50 to-white">
            <div class="flex items-start space-x-3">
                <img src="{{ auth()->user()->photo_url }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm">
                <div class="flex-1">
                    <div class="flex items-center space-x-2 mb-2">
                        <h4 class="font-semibold text-gray-900">{{ auth()->user()->name ?? 'Guru' }}</h4>
                        <span class="text-xs text-gray-500">{{ \Carbon\Carbon::now()->subHours(2)->diffForHumans() }}</span>
                        <span class="px-2 py-1 bg-primary-100 text-primary-800 rounded-full text-xs">Guru</span>
                    </div>
                    <p class="text-gray-700">Mulai diskusi dengan menulis pesan pertama...</p>
                </div>
            </div>
        </div>

        <!-- Replies -->
        <div class="space-y-4">
            @if(isset($replies) && $replies->count() > 0)
                @foreach($replies as $reply)
                <div class="border border-gray-200 rounded-lg p-4 bg-white">
                    <div class="flex items-start space-x-3">
                        <img src="{{ $reply->user->photo_url }}" alt="{{ $reply->user->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-2">
                                <h4 class="font-semibold text-gray-900">{{ $reply->user->name }}</h4>
                                <span class="text-xs text-gray-500">{{ $reply->time_ago }}</span>
                                <span class="px-2 py-1 bg-{{ $reply->user->role === 'teacher' ? 'primary' : 'green' }}-100 text-{{ $reply->user->role === 'teacher' ? 'primary' : 'green' }}-800 rounded-full text-xs">
                                    {{ $reply->user->role === 'teacher' ? 'Guru' : 'Siswa' }}
                                </span>
                            </div>
                            <p class="text-gray-700">{{ $reply->content }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="text-center py-12">
                    <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-comments text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada balasan</h3>
                    <p class="text-gray-500">Jadilah yang pertama untuk berpartisipasi dalam diskusi ini.</p>
                </div>
            @endif
        </div>

        <!-- Reply Form -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <h4 class="text-lg font-semibold text-gray-900 mb-4">Tulis Balasan</h4>
            <form id="replyForm" class="space-y-4" action="{{ route('student.courses.forums.replies.store', [$courseId, $forumId]) }}" method="POST">
                @csrf
                <div>
                    <textarea name="reply" id="replyText" rows="4" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                              placeholder="Tulis balasan Anda di sini..." required></textarea>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center">
                            <input type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Beritahu saya jika ada balasan</span>
                        </label>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button type="submit" id="sendReplyBtn" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Balasan
                        </button>
                        <!-- Tombol untuk testing (hanya untuk guru yang login sebagai siswa) -->
                        @if(auth()->user()->role === 'teacher')
                        <button type="button" onclick="clearAllMessages()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                            <i class="fas fa-trash mr-2"></i>
                            Hapus Semua Pesan
                        </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@if(session('broadcast_script'))
    {!! session('broadcast_script') !!}
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const replyForm = document.getElementById('replyForm');
    const replyText = document.getElementById('replyText');
    const sendBtn = document.getElementById('sendReplyBtn');
    const repliesContainer = document.querySelector('.space-y-4');
    const emptyState = document.querySelector('.text-center.py-12');
    
    // Real-time messaging
    let messageId = 1;
    let isConnected = true;
    
    // Load messages from localStorage on page load
    loadMessagesFromStorage();
    
    // Clear any existing auto-generated messages (for debugging)
    clearAutoMessages();
    
    // Start real-time message checking
    startRealTimeMessaging();
    
    // Load messages from database on page load
    loadMessagesFromDatabase();
    
    // Handle form submission
    replyForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const message = replyText.value.trim();
        if (!message) {
            alert('Pesan tidak boleh kosong!');
            return;
        }
        
        // Show loading state
        const submitBtn = document.getElementById('sendReplyBtn');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
        }
        
        // Add message to UI immediately for real-time experience
        const author = '{{ auth()->user()->name ?? "Siswa" }}';
        addMessageToUI(message, author, true);
        saveMessageToStorage(message, author, true);
        
        // Broadcast message to teacher page
        broadcastMessageToTeacher(message, author);
        
        // Send to server
        sendMessageToServer(message, author);
        
        // Clear form
        replyText.value = '';
        
        // Reset button
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Kirim Balasan';
        }
        
        // Ensure scroll stays at bottom
        setTimeout(function() {
            const repliesContainer = document.querySelector('.space-y-4');
            if (repliesContainer) {
                repliesContainer.scrollTop = repliesContainer.scrollHeight;
            }
        }, 100);
    });
    
    function addMessageToUI(message, author, isOwn = false) {
        // Hide empty state if it exists
        if (emptyState) {
            emptyState.style.display = 'none';
        }
        
        // Create message element
        const messageDiv = document.createElement('div');
        messageDiv.className = 'border border-gray-200 rounded-lg p-4 bg-white';
        messageDiv.innerHTML = `
            <div class="flex items-start space-x-3">
                <div class="w-10 h-10 bg-${isOwn ? 'green' : 'primary'}-500 rounded-full flex items-center justify-center text-white font-semibold">
                    ${author.charAt(0).toUpperCase()}
                </div>
                <div class="flex-1">
                    <div class="flex items-center space-x-2 mb-2">
                        <h4 class="font-semibold text-gray-900">${author}</h4>
                        <span class="text-xs text-gray-500">Baru saja</span>
                        <span class="px-2 py-1 bg-${isOwn ? 'green' : 'primary'}-100 text-${isOwn ? 'green' : 'primary'}-800 rounded-full text-xs">${isOwn ? 'Siswa' : 'Guru'}</span>
                    </div>
                    <p class="text-gray-700">${message}</p>
                    <div class="flex items-center space-x-4 mt-3 text-sm text-gray-500">
                        <button class="flex items-center hover:text-primary-600 transition-colors">
                            <i class="fas fa-thumbs-up mr-1"></i>
                            Suka (0)
                        </button>
                        <button class="flex items-center hover:text-primary-600 transition-colors">
                            <i class="fas fa-reply mr-1"></i>
                            Balas
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        // Add to container
        repliesContainer.appendChild(messageDiv);
        
        // Scroll to bottom
        messageDiv.scrollIntoView({ behavior: 'smooth' });
    }
    
    function loadMessagesFromStorage() {
        const messages = JSON.parse(localStorage.getItem('forum_messages_' + {{ $courseId }} + '_' + {{ $forumId }}) || '[]');
        console.log('Loading messages from storage:', messages);
        messages.forEach(function(msg) {
            // Tampilkan semua pesan, baik dari guru maupun siswa
            addMessageToUI(msg.message, msg.author, msg.isOwn);
        });
    }
    
    function saveMessageToStorage(message, author, isOwn) {
        const messages = JSON.parse(localStorage.getItem('forum_messages_' + {{ $courseId }} + '_' + {{ $forumId }}) || '[]');
        messages.push({
            message: message,
            author: author,
            isOwn: isOwn,
            timestamp: new Date().toISOString()
        });
        localStorage.setItem('forum_messages_' + {{ $courseId }} + '_' + {{ $forumId }}, JSON.stringify(messages));
    }
    
    function clearAutoMessages() {
        // Clear any auto-generated messages from previous testing
        const messages = JSON.parse(localStorage.getItem('forum_messages_' + {{ $courseId }} + '_' + {{ $forumId }}) || '[]');
        const filteredMessages = messages.filter(function(msg) {
            // Keep all messages, don't filter by isOwn
            return true;
        });
        localStorage.setItem('forum_messages_' + {{ $courseId }} + '_' + {{ $forumId }}, JSON.stringify(filteredMessages));
        
        // Clear the UI and reload all messages
        const repliesContainer = document.querySelector('.space-y-4');
        if (repliesContainer) {
            repliesContainer.innerHTML = '';
        }
        loadMessagesFromStorage();
    }
    
    function startRealTimeMessaging() {
        // Check for new messages every 1 second for better responsiveness
        setInterval(function() {
            console.log('Student - Interval check running...');
            checkForNewMessages();
        }, 1000);
        
        // Show real-time indicator
        showRealTimeIndicator();
        
        // Listen for custom events from teacher pages
        window.addEventListener('teacherMessage', function(event) {
            const messageObj = event.detail;
            addMessageToUI(messageObj.message, messageObj.author, false);
            saveMessageToStorage(messageObj.message, messageObj.author, false);
        });
        
        // Listen for storage events (cross-tab communication)
        window.addEventListener('storage', function(event) {
            console.log('Student - Storage event detected:', event.key, event.newValue);
            console.log('Student - Looking for trigger key: forum_trigger_' + {{ $courseId }} + '_' + {{ $forumId }});
            
            if (event.key === 'forum_trigger_' + {{ $courseId }} + '_' + {{ $forumId }}) {
                console.log('Student - Trigger key match found!');
                if (event.newValue) {
                    const triggerData = JSON.parse(event.newValue);
                    console.log('Student - Parsed trigger data:', triggerData);
                    if (triggerData.type === 'teacher_message') {
                        console.log('Student - Received teacher message:', triggerData.message);
                        addMessageToUI(triggerData.message.message, triggerData.message.author, false);
                        saveMessageToStorage(triggerData.message.message, triggerData.message.author, false);
                        showNewMessageNotification('Pesan baru dari guru: ' + triggerData.message.author);
                    }
                }
            }
        });
        
        
        // Also check for messages on page load
        checkTeacherBroadcast();
    }
    
    function showRealTimeIndicator() {
        // Add a small indicator that real-time messaging is active
        const indicator = document.createElement('div');
        indicator.id = 'realtime-indicator';
        indicator.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-xs flex items-center space-x-2 z-50';
        indicator.innerHTML = '<div class="w-2 h-2 bg-white rounded-full animate-pulse"></div><span>Siswa - Real-time Active</span>';
        document.body.appendChild(indicator);
        
        // Hide indicator after 3 seconds
        setTimeout(function() {
            if (indicator) {
                indicator.style.opacity = '0.5';
            }
        }, 3000);
    }
    
    function showNewMessageNotification(message) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 transform transition-all duration-300';
        notification.innerHTML = '<i class="fas fa-bell mr-2"></i>' + message;
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(function() {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(function() {
            notification.style.transform = 'translateX(100%)';
            setTimeout(function() {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
    
    function checkForNewMessages() {
        console.log('Student - checkForNewMessages called');
        
        // Check for new messages by monitoring localStorage changes
        const currentMessages = JSON.parse(localStorage.getItem('forum_messages_' + {{ $courseId }} + '_' + {{ $forumId }}) || '[]');
        const lastMessageCount = parseInt(localStorage.getItem('last_message_count_student_' + {{ $courseId }} + '_' + {{ $forumId }}) || '0');
        
        console.log('Student - Checking for new messages:', currentMessages.length, 'vs', lastMessageCount);
        
        // Check if there are new messages
        if (currentMessages.length > lastMessageCount) {
            // Find new messages
            const newMessages = currentMessages.slice(lastMessageCount);
            console.log('Student - Found new messages:', newMessages);
            
            newMessages.forEach(function(msg) {
                // Tampilkan semua pesan baru, baik dari guru maupun siswa
                addMessageToUI(msg.message, msg.author, msg.isOwn);
            });
            
            // Update message count
            localStorage.setItem('last_message_count_student_' + {{ $courseId }} + '_' + {{ $forumId }}, currentMessages.length);
        }
        
        // Check for broadcast messages from teacher
        checkTeacherBroadcast();
    }
    
    
    function checkTeacherBroadcast() {
        console.log('Student - checkTeacherBroadcast called');
        
        // Check for trigger key from teacher
        const triggerKey = 'forum_trigger_' + {{ $courseId }} + '_' + {{ $forumId }};
        const triggerMessage = localStorage.getItem(triggerKey);
        
        console.log('Student - Checking for teacher broadcast:', triggerKey, triggerMessage);
        
        if (triggerMessage) {
            const triggerData = JSON.parse(triggerMessage);
            console.log('Student - Found teacher trigger:', triggerData);
            
            if (triggerData.type === 'teacher_message') {
                // Add teacher message to UI
                addMessageToUI(triggerData.message.message, triggerData.message.author, false);
                saveMessageToStorage(triggerData.message.message, triggerData.message.author, false);
                
                // Show notification
                showNewMessageNotification('Pesan baru dari guru: ' + triggerData.message.author);
                
                // Clear the trigger message
                localStorage.removeItem(triggerKey);
            }
        }
    }
    
    function broadcastMessageToTeacher(message, author) {
        // Create a message object for broadcasting to teacher
        const messageObj = {
            message: message,
            author: author,
            isOwn: false, // This is from student, so not own for teacher
            timestamp: new Date().toISOString(),
            fromStudent: true,
            id: Date.now() + '_student'
        };
        
        // Use a single shared key for all messages
        const sharedKey = 'forum_messages_' + {{ $courseId }} + '_' + {{ $forumId }};
        const sharedMessages = JSON.parse(localStorage.getItem(sharedKey) || '[]');
        sharedMessages.push(messageObj);
        localStorage.setItem(sharedKey, JSON.stringify(sharedMessages));
        
        // Also set a trigger key for immediate notification
        const triggerKey = 'forum_trigger_' + {{ $courseId }} + '_' + {{ $forumId }};
        localStorage.setItem(triggerKey, JSON.stringify({
            type: 'student_message',
            message: messageObj,
            timestamp: Date.now()
        }));
        
        console.log('Message broadcasted to teacher:', messageObj);
        console.log('Shared key:', sharedKey);
        console.log('Trigger key:', triggerKey);
    }
    
    
    
    function loadMessagesFromDatabase() {
        // Load messages from database and sync with localStorage
        console.log('Loading messages from database...');
        
        // Get messages from PHP (passed from controller)
        @if(isset($replies) && $replies->count() > 0)
            const dbMessages = {!! json_encode($replies->map(function($reply) {
                return [
                    'message' => $reply->content,
                    'author' => $reply->user->name,
                    'isOwn' => $reply->user_id == auth()->id(),
                    'timestamp' => $reply->created_at->toISOString(),
                    'fromTeacher' => $reply->user->role === 'teacher',
                    'fromStudent' => $reply->user->role === 'student',
                    'id' => $reply->id
                ];
            })) !!};
            
            console.log('Database messages:', dbMessages);
            
            // Save to localStorage
            localStorage.setItem('forum_messages_' + {{ $courseId }} + '_' + {{ $forumId }}, JSON.stringify(dbMessages));
            
            // Clear UI and reload
            const repliesContainer = document.querySelector('.space-y-4');
            if (repliesContainer) {
                repliesContainer.innerHTML = '';
            }
            loadMessagesFromStorage();
        @endif
    }
    
    function sendMessageToServer(message, author) {
        // Send message to server via AJAX
        fetch('{{ route("student.courses.forums.replies.store", [$courseId, $forumId]) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                reply: message
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Message sent to server:', data);
            if (data.success) {
                // Show success notification
                showNewMessageNotification('Pesan berhasil dikirim!');
            }
        })
        .catch(error => {
            console.error('Error sending message:', error);
            alert('Error mengirim pesan: ' + error.message);
        });
    }
    
    // Auto-scroll to bottom when new messages arrive
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length > 0) {
                console.log('Student - New message added, scrolling to bottom');
                const lastMessage = repliesContainer.lastElementChild;
                if (lastMessage) {
                    lastMessage.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    });
    
    observer.observe(repliesContainer, { childList: true });
    
    function clearAllMessages() {
        // Konfirmasi sebelum menghapus
        if (!confirm('Apakah Anda yakin ingin menghapus semua pesan? Tindakan ini tidak dapat dibatalkan!')) {
            return;
        }
        
        console.log('Student - Deleting all messages...');
        
        // Kirim request ke server untuk menghapus dari database
        fetch('{{ route("teacher.courses.forums.replies.delete-all", [$courseId, $forumId]) }}', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Delete response:', data);
            
            if (data.success) {
                // Clear all messages from localStorage
                localStorage.removeItem('forum_messages_' + {{ $courseId }} + '_' + {{ $forumId }});
                localStorage.removeItem('last_message_count_student_' + {{ $courseId }} + '_' + {{ $forumId }});
                localStorage.removeItem('forum_trigger_' + {{ $courseId }} + '_' + {{ $forumId }});
                
                // Clear the UI
                const repliesContainer = document.querySelector('.space-y-4');
                if (repliesContainer) {
                    repliesContainer.innerHTML = '';
                }
                
                // Show empty state
                const emptyState = document.querySelector('.text-center.py-12');
                if (emptyState) {
                    emptyState.style.display = 'block';
                }
                
                // Show success message
                alert(data.message);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error deleting messages:', error);
            alert('Error menghapus pesan: ' + error.message);
        });
    }
});
</script>