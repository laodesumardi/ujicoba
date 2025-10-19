@extends('layouts.admin')

@section('title', 'Library Profile Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Library Profile Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.libraries.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Libraries
                        </a>
                        <a href="{{ route('admin.libraries.edit', $library->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">Basic Information</h5>
                            
                            <table class="table table-borderless">
                                <tr>
                                    <td width="30%"><strong>Library Name:</strong></td>
                                    <td>{{ $library->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Description:</strong></td>
                                    <td>{{ $library->description ?: 'No description provided' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Location:</strong></td>
                                    <td>{{ $library->location ?: 'Not specified' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone:</strong></td>
                                    <td>{{ $library->phone ?: 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $library->email ?: 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @if($library->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Organization Chart -->
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">Organization Chart</h5>
                            
                            @if($library->organization_chart)
                                <div class="text-center">
                                    <img src="{{ $library->organization_chart_url }}" alt="Organization Chart" 
                                         class="img-fluid rounded border" style="max-height: 300px;">
                                </div>
                            @else
                                <div class="text-center text-muted">
                                    <i class="fas fa-image fa-3x mb-2"></i>
                                    <p>No organization chart uploaded</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <!-- Opening Hours -->
                    @if($library->opening_hours)
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-primary mb-3">Opening Hours</h5>
                            <div class="alert alert-info">
                                <pre class="mb-0">{{ $library->opening_hours }}</pre>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Services and Facilities -->
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">Services</h5>
                            @if($library->services)
                                <div class="alert alert-light">
                                    <pre class="mb-0">{{ $library->services }}</pre>
                                </div>
                            @else
                                <p class="text-muted">No services information provided</p>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">Facilities</h5>
                            @if($library->facilities)
                                <div class="alert alert-light">
                                    <pre class="mb-0">{{ $library->facilities }}</pre>
                                </div>
                            @else
                                <p class="text-muted">No facilities information provided</p>
                            @endif
                        </div>
                    </div>

                    <!-- Rules and Membership -->
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">Library Rules</h5>
                            @if($library->rules)
                                <div class="alert alert-warning">
                                    <pre class="mb-0">{{ $library->rules }}</pre>
                                </div>
                            @else
                                <p class="text-muted">No rules information provided</p>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">Membership Information</h5>
                            @if($library->membership_info)
                                <div class="alert alert-info">
                                    <pre class="mb-0">{{ $library->membership_info }}</pre>
                                </div>
                            @else
                                <p class="text-muted">No membership information provided</p>
                            @endif
                        </div>
                    </div>

                    <!-- Librarian Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">Librarian Information</h5>
                            
                            <table class="table table-borderless">
                                <tr>
                                    <td width="30%"><strong>Name:</strong></td>
                                    <td>{{ $library->librarian_name ?: 'Not specified' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone:</strong></td>
                                    <td>{{ $library->librarian_phone ?: 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $library->librarian_email ?: 'Not provided' }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">Collection Information</h5>
                            @if($library->collection_info)
                                <div class="alert alert-light">
                                    <pre class="mb-0">{{ $library->collection_info }}</pre>
                                </div>
                            @else
                                <p class="text-muted">No collection information provided</p>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a href="{{ route('admin.libraries.edit', $library->id) }}" class="btn btn-primary">
                                        <i class="fas fa-edit"></i> Edit Library Profile
                                    </a>
                                    <a href="{{ route('admin.libraries.index') }}" class="btn btn-secondary ml-2">
                                        <i class="fas fa-list"></i> Back to List
                                    </a>
                                </div>
                                <div>
                                    <form action="{{ route('admin.libraries.destroy', $library->id) }}" method="POST" 
                                          class="d-inline" onsubmit="return confirm('Are you sure you want to delete this library profile?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


