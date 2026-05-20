<x-doctor-layout>
    <div class="py-6">
        <!-- Welcome Section -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Welcome back, Dr. {{ Auth::user()->name }}</h1>
            <p class="text-gray-500 mt-1 text-sm">Here's what's happening with your practice today.</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <!-- Today's Consultations -->
            <div class="bg-white rounded-xl border border-gray-100 p-5 hover:shadow-md transition-all duration-200 group relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-teal-500 rounded-l-xl"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Consultations</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1.5">{{ $todayConsultations }}</p>
                        <p class="text-gray-400 text-xs mt-1">Completed today</p>
                    </div>
                    <div class="w-11 h-11 bg-teal-50 rounded-xl flex items-center justify-center group-hover:bg-teal-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-teal-600">
                            <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625zM7.5 15a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 017.5 15zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H8.25z" clip-rule="evenodd" />
                            <path d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Today's Appointments -->
            <div class="bg-white rounded-xl border border-gray-100 p-5 hover:shadow-md transition-all duration-200 group relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-violet-500 rounded-l-xl"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Appointments</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1.5">{{ $todayAppointments }}</p>
                        <p class="text-gray-400 text-xs mt-1">Scheduled for today</p>
                    </div>
                    <div class="w-11 h-11 bg-violet-50 rounded-xl flex items-center justify-center group-hover:bg-violet-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-violet-600">
                            <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- This Week's Revenue -->
            <div class="bg-white rounded-xl border border-gray-100 p-5 hover:shadow-md transition-all duration-200 group relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-emerald-500 rounded-l-xl"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Week Revenue</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1.5">₱{{ number_format($weekRevenue, 2) }}</p>
                        <p class="text-gray-400 text-xs mt-1">From paid consultations</p>
                    </div>
                    <div class="w-11 h-11 bg-emerald-50 rounded-xl flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-emerald-600">
                            <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" />
                            <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 17.625V4.875zM8.25 9.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM18.75 9a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V9.75a.75.75 0 00-.75-.75h-.008zM4.5 9.75A.75.75 0 015.25 9h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H5.25a.75.75 0 01-.75-.75V9.75z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Patients -->
            <div class="bg-white rounded-xl border border-gray-100 p-5 hover:shadow-md transition-all duration-200 group relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-amber-500 rounded-l-xl"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Patients</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1.5">{{ $totalPatients }}</p>
                        <p class="text-gray-400 text-xs mt-1">{{ $activePatients }} active</p>
                    </div>
                    <div class="w-11 h-11 bg-amber-50 rounded-xl flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-amber-600">
                            <path d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z" />
                            <path d="M5.082 14.254a8.287 8.287 0 00-1.308 5.135 9.687 9.687 0 01-1.764-.44l-.115-.04a.563.563 0 01-.373-.487l-.01-.121a3.75 3.75 0 013.57-4.047zM20.226 19.389a8.287 8.287 0 00-1.308-5.135 3.75 3.75 0 013.57 4.047l-.01.121a.563.563 0 01-.373.486l-.115.04c-.567.2-1.156.349-1.764.441z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-8">
            <!-- Consultation Trends Chart -->
            <div class="bg-white rounded-xl border border-gray-100 p-6">
                <div class="mb-5">
                    <h2 class="text-sm font-semibold text-gray-900">Consultation Trends</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Last 6 months consultation activity</p>
                </div>
                <div class="h-72">
                    <canvas id="consultationChart"></canvas>
                </div>
            </div>

            <!-- Revenue Trends Chart -->
            <div class="bg-white rounded-xl border border-gray-100 p-6">
                <div class="mb-5">
                    <h2 class="text-sm font-semibold text-gray-900">Revenue Trends</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Last 6 months revenue performance</p>
                </div>
                <div class="h-72">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">
            <!-- Left Column - Upcoming Appointments & Recent Activity -->
            <div class="lg:col-span-2 space-y-5">
                <!-- Upcoming Appointments -->
                <div class="bg-white rounded-xl border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-sm font-semibold text-gray-900">Upcoming Appointments</h2>
                        <a href="{{ route('doctor.appointments.index') }}" class="text-xs text-teal-600 hover:text-teal-700 font-medium">
                            View All →
                        </a>
                    </div>
                    
                    @if($upcomingAppointments->count() > 0)
                        <div class="space-y-2">
                            @foreach($upcomingAppointments as $appointment)
                                <div class="flex items-center justify-between p-3 bg-gray-50/80 rounded-lg hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 bg-gradient-to-br from-teal-500 to-emerald-600 rounded-lg flex items-center justify-center text-white text-xs font-semibold">
                                            {{ substr($appointment->patient->first_name, 0, 1) }}{{ substr($appointment->patient->last_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</p>
                                            <p class="text-xs text-gray-400">{{ $appointment->start_time->format('M d, Y') }} at {{ $appointment->start_time->format('h:i A') }}</p>
                                        </div>
                                    </div>
                                    <span class="px-2.5 py-1 text-[10px] font-semibold rounded-md uppercase tracking-wide {{ $appointment->status === 'approved' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 mx-auto mb-2 text-gray-200">
                                <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd" />
                            </svg>
                            <p class="text-sm text-gray-400">No upcoming appointments</p>
                        </div>
                    @endif
                </div>

                <!-- Recent Consultations -->
                <div class="bg-white rounded-xl border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-sm font-semibold text-gray-900">Recent Consultations</h2>
                    </div>
                    
                    @if($recentConsultations->count() > 0)
                        <div class="space-y-2">
                            @foreach($recentConsultations as $consultation)
                                <div class="flex items-center justify-between p-3 bg-gray-50/80 rounded-lg hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 bg-gradient-to-br from-violet-500 to-purple-600 rounded-lg flex items-center justify-center text-white text-xs font-semibold">
                                            {{ substr($consultation->patient->first_name, 0, 1) }}{{ substr($consultation->patient->last_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $consultation->patient->first_name }} {{ $consultation->patient->last_name }}</p>
                                            <p class="text-xs text-gray-400">{{ $consultation->consultation_date->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('consultations.show', $consultation) }}" class="text-xs text-teal-600 hover:text-teal-700 font-medium">
                                        View →
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 mx-auto mb-2 text-gray-200">
                                <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625z" clip-rule="evenodd" />
                            </svg>
                            <p class="text-sm text-gray-400">No recent consultations</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column - Quick Stats & Actions -->
            <div class="space-y-5">
                <!-- Monthly Revenue -->
                <div class="bg-white rounded-xl border border-gray-100 p-5">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">This Month's Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1.5">₱{{ number_format($monthRevenue, 2) }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ now()->format('F Y') }}</p>
                </div>

                <!-- Pending Appointments Alert -->
                @if($pendingAppointments > 0)
                    <div class="bg-amber-50 border border-amber-100 rounded-xl p-5">
                        <div class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5">
                                <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h3 class="text-sm font-semibold text-amber-900">Pending Appointments</h3>
                                <p class="text-xs text-amber-700 mt-0.5">{{ $pendingAppointments }} appointment{{ $pendingAppointments > 1 ? 's' : '' }} waiting for approval</p>
                                <a href="{{ route('doctor.appointments.index') }}" class="text-xs text-amber-800 font-semibold hover:text-amber-900 mt-2 inline-block">
                                    Review Now →
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl border border-gray-100 p-5">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Quick Actions</h3>
                    <div class="space-y-1">
                        <a href="{{ route('patients.index') }}" class="flex items-center gap-2.5 p-2.5 rounded-lg hover:bg-gray-50 transition-colors group">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-gray-400 group-hover:text-teal-600 transition-colors">
                                <path d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75a12.696 12.696 0 01-6.337-1.684.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z" />
                            </svg>
                            <span class="text-sm font-medium text-gray-600 group-hover:text-gray-900 transition-colors">View All Patients</span>
                        </a>
                        <a href="{{ route('doctor.billing.index') }}" class="flex items-center gap-2.5 p-2.5 rounded-lg hover:bg-gray-50 transition-colors group">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-gray-400 group-hover:text-teal-600 transition-colors">
                                <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" />
                                <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 17.625V4.875z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm font-medium text-gray-600 group-hover:text-gray-900 transition-colors">Billing Records</span>
                        </a>
                        <a href="{{ route('doctor.appointments.index') }}" class="flex items-center gap-2.5 p-2.5 rounded-lg hover:bg-gray-50 transition-colors group">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-gray-400 group-hover:text-teal-600 transition-colors">
                                <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm font-medium text-gray-600 group-hover:text-gray-900 transition-colors">Manage Schedule</span>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Prepare data for Consultation Chart
        const monthlyData = @json($monthlyTrend);
        
        // Create arrays for labels and data
        const labels = [];
        const consultationData = [];
        
        // Fill in the last 6 months
        for (let i = 5; i >= 0; i--) {
            const date = new Date();
            date.setMonth(date.getMonth() - i);
            const monthKey = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0');
            const monthLabel = date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
            
            labels.push(monthLabel);
            
            // Find matching data
            const monthData = monthlyData.find(item => item.month === monthKey);
            consultationData.push(monthData ? monthData.count : 0);
        }
        
        // Create the consultation chart
        const ctx = document.getElementById('consultationChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Consultations',
                    data: consultationData,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverBackgroundColor: 'rgb(59, 130, 246)',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Consultations: ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 12
                            },
                            color: '#6B7280'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 12
                            },
                            color: '#6B7280'
                        },
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // Prepare data for Revenue Chart
        const revenueData = @json($revenueTrend);
        const revenueValues = [];
        
        // Fill in the last 6 months for revenue
        for (let i = 5; i >= 0; i--) {
            const date = new Date();
            date.setMonth(date.getMonth() - i);
            const monthKey = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0');
            
            // Find matching data
            const monthRevenue = revenueData.find(item => item.month === monthKey);
            revenueValues.push(monthRevenue ? parseFloat(monthRevenue.revenue) : 0);
        }
        
        // Create the revenue chart
        const ctx2 = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue',
                    data: revenueValues,
                    backgroundColor: 'rgba(34, 197, 94, 0.8)',
                    borderColor: 'rgb(34, 197, 94)',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Revenue: ₱' + context.parsed.y.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 12
                            },
                            color: '#6B7280',
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 12
                            },
                            color: '#6B7280'
                        },
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-doctor-layout>
