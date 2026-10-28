<div x-data="{ 
    open: false, 
    count: 0, 
    notifications: [],
    fetchNotifications() {
        fetch('{{ route('notifications.latest') }}', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Forbidden');
            return response.json();
        })
        .then(data => {
            if (data && data.notifications) {
                if (data.count > this.count && this.count !== 0) {
                    if (typeof showToast === 'function') {
                        showToast('New notification received');
                    }
                    document.dispatchEvent(new CustomEvent('new-notification'));
                }
                this.count = data.count;
                this.notifications = data.notifications;
            }
        })
        .catch(err => {
            console.warn('Notifications temporarily unavailable');
        });
    },
    markAsRead() {
        fetch('{{ route('notifications.mark-read') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        }).then(() => {
            this.count = 0;
            this.fetchNotifications();
            if (typeof showToast === 'function') showToast('Notifications marked as read', 'success');
        });
    },
    clearAll() {
        fetch('{{ route('notifications.clear-all') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        }).then(() => {
            this.count = 0;
            this.notifications = [];
            if (typeof showToast === 'function') showToast('All notifications cleared', 'success');
        });
    }
}" 
x-init="
    fetchNotifications();
    setInterval(() => fetchNotifications(), 30000);
"
class="relative">
    
    <!-- Bell Icon -->
    <button @click="open = !open" class="relative p-2 text-gray-400 hover:text-violet-600 transition-colors bg-white rounded-xl border border-gray-100 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>
        
        <!-- Badge -->
        <template x-if="count > 0">
            <span class="absolute top-0 right-0 block h-4 w-4 transform -translate-y-1/2 translate-x-1/2 rounded-full bg-red-500 text-[8px] font-black text-white flex items-center justify-center border-2 border-white ring-2 ring-red-500/20" x-text="count"></span>
        </template>
    </button>

    <!-- Dropdown Panel -->
    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="absolute right-0 mt-3 w-80 bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden z-50">
        
        <div class="p-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Recent Notifications</h3>
            <span class="text-[10px] font-bold text-violet-600 bg-violet-50 px-2 py-0.5 rounded-full" x-text="count + ' Unread'"></span>
        </div>
        
        <div class="px-4 py-2 bg-white flex justify-between border-b border-gray-50">
            <button @click.prevent="markAsRead()" class="text-[10px] font-bold text-violet-500 hover:text-violet-700 transition-colors uppercase tracking-wider">Mark all read</button>
            <button @click.prevent="clearAll()" class="text-[10px] font-bold text-red-500 hover:text-red-700 transition-colors uppercase tracking-wider">Clear all</button>
        </div>

        <div class="max-h-[350px] overflow-y-auto custom-scrollbar">
            <template x-if="notifications.length === 0">
                <div class="p-8 text-center">
                    <p class="text-xs text-gray-400 font-medium">All caught up!</p>
                </div>
            </template>
            
            <template x-for="notif in notifications" :key="notif.id">
                <div class="p-4 border-b border-gray-50 hover:bg-gray-50/50 transition-colors cursor-pointer group">
                    <div class="flex gap-3">
                        <div class="w-2 h-2 rounded-full bg-violet-500 mt-1.5 flex-shrink-0 group-hover:scale-125 transition-transform"></div>
                        <div>
                            <p class="text-[11px] font-bold text-gray-900 leading-tight" x-text="notif.data.title || 'Notification'"></p>
                            <p class="text-[10px] text-gray-500 mt-1 leading-relaxed" x-text="notif.data.message"></p>
                            <p class="text-[9px] text-gray-400 mt-2 font-medium" x-text="notif.created_at_human"></p>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <a href="#" class="block p-3 text-center bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-violet-600 transition-colors">
            View All Notifications
        </a>
    </div>
</div>
