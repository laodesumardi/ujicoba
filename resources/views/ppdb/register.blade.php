@extends('layouts.app')

@section('title', 'Daftar PPDB - Penerimaan Peserta Didik Baru')

@section('content')
<style>
/* Mobile-specific CSS for PPDB form */
@media (max-width: 768px) {
    .ppdb-form {
        padding: 15px;
        margin: 10px;
    }
    
    .ppdb-form input,
    .ppdb-form textarea,
    .ppdb-form select {
        font-size: 16px !important; /* Prevents zoom on iOS */
        padding: 12px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        width: 100%;
        box-sizing: border-box;
    }
    
    .ppdb-form input:focus,
    .ppdb-form textarea:focus,
    .ppdb-form select:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .csrf-refresh-btn {
        background: #3b82f6;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        margin: 10px 0;
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);
    }
    
    .csrf-refresh-btn:hover {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);
    }
    
    .auto-save-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        left: 20px;
        z-index: 9999;
        padding: 12px 16px;
        border-radius: 8px;
        color: white;
        font-size: 14px;
        font-weight: 500;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        animation: slideIn 0.3s ease;
    }
    
    .auto-save-notification.success {
        background: linear-gradient(135deg, #10b981, #059669);
    }
    
    .auto-save-notification.error {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }
    
    .auto-save-notification.info {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
    }
    
    @keyframes slideIn {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
}
</style>
<div class="bg-white">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary-500 to-primary-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-3 md:mb-4 leading-tight">
                    Formulir Pendaftaran PPDB
                </h1>
                <p class="text-base sm:text-lg lg:text-xl text-white opacity-90 leading-relaxed">
                    SMP Negeri 01 Namrole Tahun Ajaran 2024/2025
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg p-8">
            <!-- CSRF Token Refresh Button -->
            <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <span class="text-sm text-blue-700">Formulir akan otomatis disimpan. Jika terjadi error 419, klik tombol refresh di bawah.</span>
                    </div>
                    <button type="button" onclick="refreshCSRFToken()" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors font-medium">
                        🔄 Refresh Token
                    </button>
                </div>
            </div>
            
            <form method="POST" action="{{ route('ppdb.store') }}" enctype="multipart/form-data" id="ppdbForm">
                @csrf
                <!-- Hidden CSRF token for mobile refresh -->
                <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}">
                
                <!-- Data Siswa -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Data Siswa</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div class="md:col-span-2">
                            <label for="student_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                            <input type="text" name="student_name" id="student_name" value="{{ old('student_name') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('student_name') border-red-500 @enderror" required>
                            @error('student_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tempat Lahir -->
                        <div>
                            <label for="birth_place" class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir *</label>
                            <input type="text" name="birth_place" id="birth_place" value="{{ old('birth_place') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('birth_place') border-red-500 @enderror" required>
                            @error('birth_place')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir *</label>
                            <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('birth_date') border-red-500 @enderror" required>
                            @error('birth_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin *</label>
                            <select name="gender" id="gender" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('gender') border-red-500 @enderror" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Agama -->
                        <div>
                            <label for="religion" class="block text-sm font-medium text-gray-700 mb-2">Agama *</label>
                            <select name="religion" id="religion" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('religion') border-red-500 @enderror" required>
                                <option value="">Pilih Agama</option>
                                <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('religion') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('religion') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('religion') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('religion') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                            @error('religion')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap *</label>
                            <textarea name="address" id="address" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('address') border-red-500 @enderror" required>{{ old('address') }}</textarea>
                            @error('address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor Telepon -->
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon/HP *</label>
                            <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('phone_number') border-red-500 @enderror" required>
                            @error('phone_number')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email (Opsional)</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Data Orang Tua -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Data Orang Tua/Wali</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Orang Tua -->
                        <div>
                            <label for="parent_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Orang Tua/Wali *</label>
                            <input type="text" name="parent_name" id="parent_name" value="{{ old('parent_name') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('parent_name') border-red-500 @enderror" required>
                            @error('parent_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor Telepon Orang Tua -->
                        <div>
                            <label for="parent_phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon Orang Tua *</label>
                            <input type="tel" name="parent_phone" id="parent_phone" value="{{ old('parent_phone') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('parent_phone') border-red-500 @enderror" required>
                            @error('parent_phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pekerjaan Orang Tua -->
                        <div class="md:col-span-2">
                            <label for="parent_occupation" class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan Orang Tua *</label>
                            <input type="text" name="parent_occupation" id="parent_occupation" value="{{ old('parent_occupation') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('parent_occupation') border-red-500 @enderror" required>
                            @error('parent_occupation')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Data Akademik -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Data Akademik</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Sekolah Asal -->
                        <div>
                            <label for="previous_school" class="block text-sm font-medium text-gray-700 mb-2">Sekolah Asal</label>
                            <input type="text" name="previous_school" id="previous_school" value="{{ old('previous_school') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('previous_school') border-red-500 @enderror">
                            @error('previous_school')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Prestasi -->
                        <div>
                            <label for="achievements" class="block text-sm font-medium text-gray-700 mb-2">Prestasi (Opsional)</label>
                            <textarea name="achievements" id="achievements" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('achievements') border-red-500 @enderror">{{ old('achievements') }}</textarea>
                            @error('achievements')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Motivasi -->
                        <div class="md:col-span-2">
                            <label for="motivation" class="block text-sm font-medium text-gray-700 mb-2">Motivasi Masuk Sekolah (Opsional)</label>
                            <textarea name="motivation" id="motivation" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('motivation') border-red-500 @enderror">{{ old('motivation') }}</textarea>
                            @error('motivation')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Upload Dokumen -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Upload Dokumen</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Foto Siswa -->
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Foto Siswa (Max 2MB)</label>
                            <input type="file" name="photo" id="photo" accept="image/*" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('photo') border-red-500 @enderror">
                            @error('photo')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Akte Kelahiran -->
                        <div>
                            <label for="birth_certificate" class="block text-sm font-medium text-gray-700 mb-2">Akte Kelahiran (Max 5MB)</label>
                            <input type="file" name="birth_certificate" id="birth_certificate" accept=".pdf,.jpg,.jpeg,.png" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('birth_certificate') border-red-500 @enderror">
                            @error('birth_certificate')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kartu Keluarga -->
                        <div>
                            <label for="family_card" class="block text-sm font-medium text-gray-700 mb-2">Kartu Keluarga (Max 5MB)</label>
                            <input type="file" name="family_card" id="family_card" accept=".pdf,.jpg,.jpeg,.png" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('family_card') border-red-500 @enderror">
                            @error('family_card')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Raport -->
                        <div>
                            <label for="report_card" class="block text-sm font-medium text-gray-700 mb-2">Raport Terakhir (Max 5MB)</label>
                            <input type="file" name="report_card" id="report_card" accept=".pdf,.jpg,.jpeg,.png" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('report_card') border-red-500 @enderror">
                            @error('report_card')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('ppdb.index') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                        Daftar PPDB
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Auto-save form data every 30 seconds
let autoSaveInterval;
let csrfRefreshInterval;
let formData = {};

// Start auto-save when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Load saved data if exists
    loadSavedData();

    // Start auto-save
    autoSaveInterval = setInterval(autoSave, 30000); // 30 seconds
    
    // Start CSRF token auto-refresh every 5 minutes
    csrfRefreshInterval = setInterval(refreshCSRFToken, 300000); // 5 minutes

    // Save on input change
    document.querySelectorAll('input, textarea, select').forEach(function(element) {
        element.addEventListener('input', function() {
            saveFormData();
        });
    });

    // Save before form submit
    document.getElementById('ppdbForm').addEventListener('submit', function() {
        clearInterval(autoSaveInterval);
        clearInterval(csrfRefreshInterval);
        saveFormData();
        
        // Refresh CSRF token before submit
        refreshCSRFToken();
    });
});

// Auto-save function
function autoSave() {
    saveFormData();
    showNotification('Formulir disimpan otomatis', 'success');
}

// Save form data to localStorage
function saveFormData() {
    const form = document.getElementById('ppdbForm');
    const formData = new FormData(form);
    
    // Convert FormData to object
    const data = {};
    for (let [key, value] of formData.entries()) {
        if (key !== '_token' && key !== 'photo' && key !== 'birth_certificate' && key !== 'family_card' && key !== 'report_card') {
            data[key] = value;
        }
    }
    
    // Save to localStorage
    localStorage.setItem('ppdb_draft', JSON.stringify(data));
}

// Load saved data
function loadSavedData() {
    const savedData = localStorage.getItem('ppdb_draft');
    if (savedData) {
        try {
            const data = JSON.parse(savedData);
            
            // Fill form fields
            Object.keys(data).forEach(function(key) {
                const element = document.querySelector(`[name="${key}"]`);
                if (element && element.type !== 'file') {
                    element.value = data[key];
                }
            });
            
            showNotification('Data sebelumnya dimuat', 'info');
        } catch (e) {
            console.log('No saved data or invalid data');
        }
    }
}

// Refresh CSRF token

// Enhanced mobile CSRF refresh
function refreshCSRFToken() {
    // Show loading indicator
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '🔄 Refreshing...';
    button.disabled = true;
    
    fetch('/ppdb/refresh-token', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        cache: 'no-cache'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success && data.token) {
            // Update CSRF token in all form inputs
            document.querySelectorAll('input[name="_token"]').forEach(input => {
                input.value = data.token;
            });
            document.getElementById('csrf-token').value = data.token;
            
            // Update meta tag
            const metaTag = document.querySelector('meta[name="csrf-token"]');
            if (metaTag) {
                metaTag.setAttribute('content', data.token);
            }
            
            showNotification('Token CSRF diperbarui untuk mobile', 'success');
        } else {
            throw new Error('Invalid response format');
        }
    })
    .catch(error => {
        console.error('Error refreshing CSRF token:', error);
        showNotification('Gagal memperbarui token: ' + error.message, 'error');
    })
    .finally(() => {
        // Restore button
        button.innerHTML = originalText;
        button.disabled = false;
    });
}
    fetch('/ppdb/refresh-token', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success && data.token) {
            // Update CSRF token in all form inputs
            document.querySelectorAll('input[name="_token"]').forEach(input => {
                input.value = data.token;
            });
            document.getElementById('csrf-token').value = data.token;
            showNotification('Token CSRF diperbarui', 'success');
        } else {
            throw new Error('Invalid response format');
        }
    })
    .catch(error => {
        console.error('Error refreshing CSRF token:', error);
        showNotification('Gagal memperbarui token: ' + error.message, 'error');
    });
}

// Show notification
function showNotification(message, type) {
    // Remove existing notification
    const existing = document.querySelector('.auto-save-notification');
    if (existing) {
        existing.remove();
    }
    
    // Create notification
    const notification = document.createElement('div');
    notification.className = `auto-save-notification fixed top-4 right-4 sm:right-4 left-4 sm:left-auto z-50 px-4 py-3 rounded-lg text-white text-sm font-medium max-w-sm ${
        type === 'success' ? 'bg-green-500' : 
        type === 'error' ? 'bg-red-500' : 
        'bg-blue-500'
    }`;
    notification.textContent = message;
    
    // Add mobile-specific styles
    notification.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.15)';
    notification.style.transform = 'translateY(0)';
    notification.style.transition = 'all 0.3s ease';
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.transform = 'translateY(-100%)';
            notification.style.opacity = '0';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }
    }, 3000);
}

// Clear saved data on successful submission
window.addEventListener('beforeunload', function() {
    // Don't clear on page refresh, only on actual navigation
    if (performance.navigation.type === 1) {
        localStorage.removeItem('ppdb_draft');
    }
});
</script>
@endsection
