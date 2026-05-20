<x-doctor-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Audit Log Details</h2>
                <p class="text-sm text-gray-500 mt-1">Log ID: #{{ $auditLog->id }}</p>
            </div>
            <a href="{{ route('doctor.audit-logs.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                ← Back to Logs
            </a>
        </div>
    </x-slot>

    <div class="py-6 space-y-6">
        <!-- Alert for Anomalies -->
        @if($auditLog->is_anomaly)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Anomaly Detected</h3>
                        <p class="mt-1 text-sm text-yellow-700">{{ $auditLog->anomaly_reason }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Information -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-teal-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    Basic Information
                </h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Timestamp</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-medium">{{ $auditLog->created_at->format('F d, Y h:i:s A') }}</dd>
                        <dd class="text-xs text-gray-500">{{ $auditLog->created_at->diffForHumans() }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Action</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $auditLog->action === 'created' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $auditLog->action === 'updated' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $auditLog->action === 'deleted' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $auditLog->action === 'viewed' ? 'bg-gray-100 text-gray-800' : '' }}
                                {{ $auditLog->action === 'accessed' ? 'bg-purple-100 text-purple-800' : '' }}">
                                {{ ucfirst($auditLog->action) }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Description</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $auditLog->description }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">User</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $auditLog->user?->name ?? 'System' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Record Type</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ class_basename($auditLog->auditable_type) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Record ID</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-mono">#{{ $auditLog->auditable_id }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Security Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-teal-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                    Security Information
                </h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Risk Level</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $auditLog->risk_level === 'low' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $auditLog->risk_level === 'medium' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $auditLog->risk_level === 'high' ? 'bg-orange-100 text-orange-800' : '' }}
                                {{ $auditLog->risk_level === 'critical' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($auditLog->risk_level) }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $auditLog->ip_address }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Session ID</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-mono break-all">{{ $auditLog->session_id ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Device Fingerprint</dt>
                        <dd class="mt-1 text-xs text-gray-600 font-mono break-all">{{ $auditLog->device_fingerprint ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">User Agent</dt>
                        <dd class="mt-1 text-xs text-gray-600 break-all">{{ $auditLog->user_agent }}</dd>
                    </div>
                    @if($auditLog->location)
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Location</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $auditLog->location }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>

        <!-- PHI Information -->
        @if($auditLog->involves_phi)
            <div class="bg-white rounded-xl shadow-sm border border-purple-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-purple-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                    Protected Health Information (PHI) Access
                </h3>
                <div class="bg-purple-50 rounded-lg p-4">
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-xs font-medium text-purple-700 uppercase tracking-wider">PHI Involved</dt>
                            <dd class="mt-1 text-sm text-purple-900 font-medium">Yes - This action involved Protected Health Information</dd>
                        </div>
                        @if($auditLog->phi_fields_accessed)
                            <div>
                                <dt class="text-xs font-medium text-purple-700 uppercase tracking-wider">Fields Accessed</dt>
                                <dd class="mt-2 flex flex-wrap gap-2">
                                    @foreach($auditLog->phi_fields_accessed as $field)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ ucfirst(str_replace('_', ' ', $field)) }}
                                        </span>
                                    @endforeach
                                </dd>
                            </div>
                        @endif
                        @if($auditLog->access_reason)
                            <div>
                                <dt class="text-xs font-medium text-purple-700 uppercase tracking-wider">Access Reason</dt>
                                <dd class="mt-1 text-sm text-purple-900">{{ $auditLog->access_reason }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>
        @endif

        <!-- Request Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-teal-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                </svg>
                Request Details
            </h3>
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Request Method</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-mono font-medium bg-gray-100 text-gray-800">
                            {{ $auditLog->request_method ?? 'N/A' }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Response Status</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-mono font-medium
                            {{ str_starts_with($auditLog->response_status, '2') ? 'bg-green-100 text-green-800' : '' }}
                            {{ str_starts_with($auditLog->response_status, '4') || str_starts_with($auditLog->response_status, '5') ? 'bg-red-100 text-red-800' : '' }}">
                            {{ $auditLog->response_status ?? 'N/A' }}
                        </span>
                    </dd>
                </div>
                @if($auditLog->duration_ms)
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $auditLog->duration_ms }}ms</dd>
                    </div>
                @endif
                <div class="md:col-span-2">
                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Request URL</dt>
                    <dd class="mt-1 text-xs text-gray-600 font-mono break-all bg-gray-50 p-2 rounded">{{ $auditLog->request_url ?? 'N/A' }}</dd>
                </div>
            </dl>
        </div>

        <!-- Data Changes -->
        @if($auditLog->old_values || $auditLog->new_values)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-teal-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                    </svg>
                    Data Changes
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($auditLog->old_values)
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Previous Values</h4>
                            <pre class="bg-red-50 border border-red-200 rounded-lg p-3 text-xs overflow-x-auto">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    @endif
                    @if($auditLog->new_values)
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">New Values</h4>
                            <pre class="bg-green-50 border border-green-200 rounded-lg p-3 text-xs overflow-x-auto">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Integrity Verification -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-teal-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
                Tamper Detection
            </h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Log Hash (SHA-256)</dt>
                    <dd class="mt-1 text-xs text-gray-600 font-mono break-all bg-gray-50 p-2 rounded">{{ $auditLog->hash ?? 'N/A' }}</dd>
                </div>
                @if($auditLog->previous_log_id)
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Previous Log ID</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <a href="{{ route('doctor.audit-logs.show', $auditLog->previous_log_id) }}" class="text-teal-600 hover:text-teal-700 font-medium">
                                #{{ $auditLog->previous_log_id }}
                            </a>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Chain Integrity</dt>
                        <dd class="mt-1">
                            @if($auditLog->verifyIntegrity())
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Verified
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Broken Chain
                                </span>
                            @endif
                        </dd>
                    </div>
                @endif
            </dl>
        </div>
    </div>
</x-doctor-layout>
