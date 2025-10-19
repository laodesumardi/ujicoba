@extends('layouts.admin')

@section('title', 'Edit Library Profile')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Library Profile</h1>
                <p class="text-gray-600 mt-1">Update information about the school library</p>
            </div>
            <a href="{{ route('admin.libraries.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Libraries
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <form action="{{ route('admin.libraries.update', $library->id) }}" method="POST" enctype="multipart/form-data" class="p-8">
                @csrf
                @method('PUT')
                
                <div class="grid lg:grid-cols-2 gap-8">
                    <!-- Basic Information -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                            Basic Information
                        </h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Library Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror" 
                                       id="name" name="name" value="{{ old('name', $library->name) }}" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror" 
                                          id="description" name="description" rows="3" placeholder="Describe the library...">{{ old('description', $library->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                                <input type="text" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('location') border-red-500 @enderror" 
                                       id="location" name="location" value="{{ old('location', $library->location) }}" placeholder="Library location...">
                                @error('location')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                    <input type="text" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $library->phone) }}" placeholder="Phone number...">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror" 
                                           id="email" name="email" value="{{ old('email', $library->email) }}" placeholder="Email address...">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Organization Chart & Hours -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-sitemap text-green-600 mr-3"></i>
                            Organization Chart & Hours
                        </h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label for="organization_chart" class="block text-sm font-medium text-gray-700 mb-2">
                                    Organization Chart Image
                                </label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="organization_chart" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Upload a file</span>
                                                <input id="organization_chart" name="organization_chart" type="file" class="sr-only" accept="image/*" onchange="previewImage(this)">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                                @error('organization_chart')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                
                                @if($library->organization_chart)
                                    <div class="mt-4">
                                        <p class="text-sm font-medium text-gray-700 mb-2">Current image:</p>
                                        <img src="{{ $library->organization_chart_url }}" alt="Current Organization Chart" 
                                             class="max-w-xs rounded-lg shadow-md" id="current-image">
                                    </div>
                                @endif
                            </div>

                            <div>
                                <label for="opening_hours" class="block text-sm font-medium text-gray-700 mb-2">Opening Hours</label>
                                <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('opening_hours') border-red-500 @enderror" 
                                          id="opening_hours" name="opening_hours" rows="3" 
                                          placeholder="e.g., Monday - Friday: 08:00 - 16:00&#10;Saturday: 08:00 - 12:00&#10;Sunday: Closed">{{ old('opening_hours', $library->opening_hours) }}</textarea>
                                @error('opening_hours')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Services and Rules -->
                <div class="border-t border-gray-200 pt-8 mt-8">
                    <div class="grid lg:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-concierge-bell text-purple-600 mr-3"></i>
                                Services & Facilities
                            </h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label for="services" class="block text-sm font-medium text-gray-700 mb-2">Available Services</label>
                                    <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('services') border-red-500 @enderror" 
                                              id="services" name="services" rows="4" 
                                              placeholder="• Book lending&#10;• Digital resources&#10;• Study rooms&#10;• Computer access&#10;• Research assistance">{{ old('services', $library->services) }}</textarea>
                                    @error('services')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="facilities" class="block text-sm font-medium text-gray-700 mb-2">Facilities</label>
                                    <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('facilities') border-red-500 @enderror" 
                                              id="facilities" name="facilities" rows="3" 
                                              placeholder="• Reading area&#10;• Computer lab&#10;• Meeting rooms&#10;• Quiet study zones">{{ old('facilities', $library->facilities) }}</textarea>
                                    @error('facilities')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-gavel text-orange-600 mr-3"></i>
                                Rules & Membership
                            </h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label for="rules" class="block text-sm font-medium text-gray-700 mb-2">Library Rules</label>
                                    <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('rules') border-red-500 @enderror" 
                                              id="rules" name="rules" rows="4" 
                                              placeholder="1. No food and drinks&#10;2. Keep quiet&#10;3. Return books on time&#10;4. Handle books with care">{{ old('rules', $library->rules) }}</textarea>
                                    @error('rules')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="membership_info" class="block text-sm font-medium text-gray-700 mb-2">Membership Information</label>
                                    <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('membership_info') border-red-500 @enderror" 
                                              id="membership_info" name="membership_info" rows="3" 
                                              placeholder="• Free for students and teachers&#10;• Registration required&#10;• Valid for one academic year&#10;• Bring student/teacher ID">{{ old('membership_info', $library->membership_info) }}</textarea>
                                    @error('membership_info')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Librarian & Collection Information -->
                <div class="border-t border-gray-200 pt-8 mt-8">
                    <div class="grid lg:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-user-tie text-indigo-600 mr-3"></i>
                                Librarian Information
                            </h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label for="librarian_name" class="block text-sm font-medium text-gray-700 mb-2">Librarian Name</label>
                                    <input type="text" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('librarian_name') border-red-500 @enderror" 
                                           id="librarian_name" name="librarian_name" value="{{ old('librarian_name', $library->librarian_name) }}" placeholder="Enter librarian name...">
                                    @error('librarian_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="librarian_phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                        <input type="text" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('librarian_phone') border-red-500 @enderror" 
                                               id="librarian_phone" name="librarian_phone" value="{{ old('librarian_phone', $library->librarian_phone) }}" placeholder="Phone number...">
                                        @error('librarian_phone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="librarian_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                        <input type="email" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('librarian_email') border-red-500 @enderror" 
                                               id="librarian_email" name="librarian_email" value="{{ old('librarian_email', $library->librarian_email) }}" placeholder="Email address...">
                                        @error('librarian_email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-books text-teal-600 mr-3"></i>
                                Collection & Status
                            </h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label for="collection_info" class="block text-sm font-medium text-gray-700 mb-2">Collection Information</label>
                                    <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('collection_info') border-red-500 @enderror" 
                                              id="collection_info" name="collection_info" rows="4" 
                                              placeholder="• Total books: 5,000+&#10;• Digital resources: 500 titles&#10;• Reference materials&#10;• Periodicals and magazines">{{ old('collection_info', $library->collection_info) }}</textarea>
                                    @error('collection_info')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                                               id="is_active" name="is_active" value="1" 
                                               {{ old('is_active', $library->is_active) ? 'checked' : '' }}>
                                        <label for="is_active" class="ml-3 text-sm font-medium text-gray-700">
                                            Active Library
                                        </label>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Uncheck to deactivate this library profile</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="border-t border-gray-200 pt-8 mt-8">
                    <div class="flex justify-between items-center">
                        <a href="{{ route('admin.libraries.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg flex items-center transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                        
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg flex items-center transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Update Library Profile
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            // Hide current image if exists
            const currentImage = document.getElementById('current-image');
            if (currentImage) {
                currentImage.style.display = 'none';
            }
            
            // Create or update preview
            let preview = document.getElementById('image-preview');
            if (!preview) {
                preview = document.createElement('img');
                preview.id = 'image-preview';
                preview.className = 'max-w-xs rounded-lg shadow-md mt-4';
                input.parentNode.appendChild(preview);
            }
            
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Auto-resize textareas
document.addEventListener('DOMContentLoaded', function() {
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    });
});
</script>
@endpush
