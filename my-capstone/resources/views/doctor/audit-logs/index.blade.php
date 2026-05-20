<x-doctor-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Audit Trail Logs</h2>
                <p class="text-sm text-gray-500 mt-1">Track all PHI access and system activities</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 space-y-6">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Activities</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_this_month']) }}</p>
                        <p class="text-xs text-gray-400 mt-1">This month</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">PHI Access</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['phi_access_count']) }}</p>
                        <p class="text-xs text-gray-400 mt-1">Protected records</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-purple-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Anomalies</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['anomalies_count']) }}</p>
                        <p class="text-xs text-gray-400 mt-1">Flagged activities</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-50 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-yellow-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">High Risk</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['high_risk_count']) }}</p>
                        <p class="text-xs text-gray-400 mt-1">Critical actions</p>
                    </div>
                    <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <form method="GET" action="{{ route('doctor.audit-logs.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Action</label>
                        <select name="action" class="w-full rounded-lg border-gray-300 text-sm">
                            <option value="">All Actions</option>
                            <option value="viewed" {{ request('action') === 'viewed' ? 'selected' : '' }}>Viewed</option>
                            <option value="created" {{ request('action') === 'created' ? 'selected' : '' }}>Created</option>
                            <option value="updated" {{ request('action') === 'updated' ? 'selected' : '' }}>Updated</option>
                            <option value="deleted" {{ request('action') === 'deleted' ? 'selected' : '' }}>Deleted</option>
                            <option value="accessed" {{ request('action') === 'accessed' ? 'selected' : '' }}>Accessed</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Risk Level</label>
                        <select name="risk_level" class="w-full rounded-lg border-gray-300 text-sm">
                            <option value="">All Levels</option>
                            <option value="low" {{ request('risk_level') === 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ request('risk_level') === 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ request('risk_level') === 'high' ? 'selected' : '' }}>High</option>
                            <option value="critical" {{ request('risk_level') === 'critical' ? 'selected' : '' }}>Critical</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">PHI Involved</label>
                        <select name="involves_phi" class="w-full rounded-lg border-gray-300 text-sm">
                            <option value="">All Records</option>
                            <option value="yes" {{ request('involves_phi') === 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ request('involves_phi') === 'no' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">From Date</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full rounded-lg border-gray-300 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">To Date</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full rounded-lg border-gray-300 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Description, IP..." class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors text-sm font-medium">
                        Apply Filters
                    </button>
                    <a href="{{ route('doctor.audit-logs.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                        Clear
                    </a>
                    <label class="ml-auto flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="is_anomaly" value="1" {{ request('is_anomaly') ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600">
                        Show Anomalies Only
                    </label>
                </div>
            </form>
        </div>

        <!-- Audit Logs Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Timestamp</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Description</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Record Type</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Risk</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">PHI</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">IP Address</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50 transition-colors {{ $log->is_anomaly ? 'bg-yellow-50' : '' }}">
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    <div class="font-medium">{{ $log->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $log->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $log->action === 'created' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $log->action === 'updated' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $log->action === 'deleted' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $log->action === 'viewed' ? 'bg-gray-100 text-gray-800' : '' }}
                                        {{ $log->action === 'accessed' ? 'bg-purple-100 text-purple-800' : '' }}">
                                        {{ ucfirst($log->action) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    <div class="max-w-xs truncate">{{ $log->description }}</div>
                                    @if($log->is_anomaly)
                                        <div class="text-xs text-yellow-600 mt-1 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                            </svg>
                                            {{ $log->anomaly_reason }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ class_basename($log->auditable_type) }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $log->risk_level === 'low' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $log->risk_level === 'medium' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $log->risk_level === 'high' ? 'bg-orange-100 text-orange-800' : '' }}
                                        {{ $log->risk_level === 'critical' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($log->risk_level) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($log->involves_phi)
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-purple-600 mx-auto">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                        </svg>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 font-mono">
                                    {{ $log->ip_address }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <a href="{{ route('doctor.audit-logs.show', $log) }}" class="text-teal-600 hover:text-teal-700 font-medium">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                    No audit logs found matching your criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($logs->hasPages())
                <div class="px-4 py-3 border-t border-gray-200">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-doctor-layout>
