@extends('layouts.admin')

@section('title', 'Library Profile Details')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Library Profile Details</h1>
                <p class="text-gray-600 mt-1">View and manage library information</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.libraries.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Libraries
                </a>
                <a href="{{ route('admin.libraries.edit', $library->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-8">
                <div class="grid lg:grid-cols-2 gap-8">
                    <!-- Basic Information -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                            Basic Information
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between py-3 border-b border-gray-100">
                                <span class="font-semibold text-gray-700">Library Name:</span>
                                <span class="text-gray-900">{{ $library->name }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-100">
                                <span class="font-semibold text-gray-700">Description:</span>
                                <span class="text-gray-900">{{ $library->description ?: 'No description provided' }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-100">
                                <span class="font-semibold text-gray-700">Location:</span>
                                <span class="text-gray-900">{{ $library->location ?: 'Not specified' }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-100">
                                <span class="font-semibold text-gray-700">Phone:</span>
                                <span class="text-gray-900">{{ $library->phone ?: 'Not provided' }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-100">
                                <span class="font-semibold text-gray-700">Email:</span>
                                <span class="text-gray-900">{{ $library->email ?: 'Not provided' }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-100">
                                <span class="font-semibold text-gray-700">Status:</span>
                                @if($library->is_active)
                                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">Active</span>
                                @else
                                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-800">Inactive</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Organization Chart -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-sitemap text-green-600 mr-3"></i>
                            Organization Chart
                        </h3>

                        <div class="text-center">
                            @if($library->organization_chart)
                                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                    <img src="{{ route('image.serve.model', ['model' => 'library', 'id' => $library->id, 'field' => 'organization_chart', 'v' => ($library->updated_at ? $library->updated_at->timestamp : time())], false) }}" alt="Struktur Organisasi Perpustakaan" 
                                         class="w-full max-w-md rounded-lg border border-gray-200 object-contain" 
                                         loading="lazy" 
                                         onerror="this.src='{{ asset('images/default-struktur.png') }}'; this.alt='Gambar tidak tersedia';">
                                    <p class="text-xs text-gray-500 mt-2">
                                        <strong>Storage Path:</strong> {{ $library->organization_chart }}
                                    </p>
                                </div>
                            @else
                                <div class="border border-gray-200 rounded-lg p-8 bg-gray-50 text-center">
                                    <i class="fas fa-image text-gray-400 text-4xl mb-2"></i>
                                    <p class="text-sm text-gray-500">No organization chart uploaded</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Opening Hours -->
                @if($library->opening_hours)
                <div class="border-t border-gray-200 pt-8 mt-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-clock text-purple-600 mr-3"></i>
                        Opening Hours
                    </h3>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <pre class="text-sm text-gray-700 whitespace-pre-wrap">{{ $library->opening_hours }}</pre>
                    </div>
                </div>
                @endif

                <!-- Services and Facilities -->
                <div class="border-t border-gray-200 pt-8 mt-8">
                    <div class="grid lg:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-concierge-bell text-purple-600 mr-3"></i>
                                Services
                            </h3>
                            @if($library->services)
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                    <pre class="text-sm text-gray-700 whitespace-pre-wrap">{{ $library->services }}</pre>
                                </div>
                            @else
                                <p class="text-gray-500 italic">No services information provided</p>
                            @endif
                        </div>

                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-building text-orange-600 mr-3"></i>
                                Facilities
                            </h3>
                            @if($library->facilities)
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                    <pre class="text-sm text-gray-700 whitespace-pre-wrap">{{ $library->facilities }}</pre>
                                </div>
                            @else
                                <p class="text-gray-500 italic">No facilities information provided</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Rules and Membership -->
                <div class="border-t border-gray-200 pt-8 mt-8">
                    <div class="grid lg:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-gavel text-orange-600 mr-3"></i>
                                Library Rules
                            </h3>
                            @if($library->rules)
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <pre class="text-sm text-gray-700 whitespace-pre-wrap">{{ $library->rules }}</pre>
                                </div>
                            @else
                                <p class="text-gray-500 italic">No rules information provided</p>
                            @endif
                        </div>

                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-users text-blue-600 mr-3"></i>
                                Membership Information
                            </h3>
                            @if($library->membership_info)
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <pre class="text-sm text-gray-700 whitespace-pre-wrap">{{ $library->membership_info }}</pre>
                                </div>
                            @else
                                <p class="text-gray-500 italic">No membership information provided</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Librarian Information -->
                <div class="border-t border-gray-200 pt-8 mt-8">
                    <div class="grid lg:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-user-tie text-indigo-600 mr-3"></i>
                                Librarian Information
                            </h3>
                            
                            <div class="space-y-4">
                                <div class="flex justify-between py-3 border-b border-gray-100">
                                    <span class="font-semibold text-gray-700">Name:</span>
                                    <span class="text-gray-900">{{ $library->librarian_name ?: 'Not specified' }}</span>
                                </div>
                                <div class="flex justify-between py-3 border-b border-gray-100">
                                    <span class="font-semibold text-gray-700">Phone:</span>
                                    <span class="text-gray-900">{{ $library->librarian_phone ?: 'Not provided' }}</span>
                                </div>
                                <div class="flex justify-between py-3 border-b border-gray-100">
                                    <span class="font-semibold text-gray-700">Email:</span>
                                    <span class="text-gray-900">{{ $library->librarian_email ?: 'Not provided' }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-books text-teal-600 mr-3"></i>
                                Collection Information
                            </h3>
                            @if($library->collection_info)
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                    <pre class="text-sm text-gray-700 whitespace-pre-wrap">{{ $library->collection_info }}</pre>
                                </div>
                            @else
                                <p class="text-gray-500 italic">No collection information provided</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="border-t border-gray-200 pt-8 mt-8">
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.libraries.edit', $library->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center transition-colors">
                                <i class="fas fa-edit mr-2"></i>
                                Edit Library Profile
                            </a>
                            <a href="{{ route('admin.libraries.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg flex items-center transition-colors">
                                <i class="fas fa-list mr-2"></i>
                                Back to List
                            </a>
                        </div>
                        <div>
                            <form action="{{ route('admin.libraries.destroy', $library->id) }}" method="POST" 
                                  class="inline" onsubmit="return confirm('Are you sure you want to delete this library profile?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg flex items-center transition-colors">
                                    <i class="fas fa-trash mr-2"></i>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


