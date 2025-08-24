<template>
    <div class="relative notification-dropdown">
        <button
            @click="toggleDropdown"
            class="relative inline-flex items-center justify-center w-10 h-10 rounded-full text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200"
            :class="{ 'text-blue-600 bg-blue-50': unreadCount > 0 }"
        >
            <!-- Bell Icon -->
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
            </svg>
            
            <!-- Notification Badge -->
            <span 
                v-if="unreadCount > 0" 
                class="absolute -top-1 -right-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full animate-pulse"
            >
                {{ unreadCount > 9 ? '9+' : unreadCount }}
            </span>
        </button>

        <!-- Dropdown Panel -->
        <div 
            v-if="showDropdown" 
            class="fixed inset-x-4 top-16 sm:absolute sm:right-0 sm:left-auto sm:inset-x-auto sm:top-auto z-50 sm:mt-3 w-auto sm:w-96 bg-white border border-gray-200 rounded-xl shadow-xl ring-1 ring-black ring-opacity-5"
        >
            <!-- Header -->
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900">
                            Pranešimai
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-600">
                            Notifications
                        </p>
                    </div>
                    <div v-if="unreadCount > 0" class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ getNotificationsText(unreadCount) }} / new
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Empty State -->
            <div v-if="notifications.length === 0" class="px-4 sm:px-6 py-8 sm:py-12 text-center">
                <svg class="mx-auto w-10 h-10 sm:w-12 sm:h-12 text-gray-300 mb-3 sm:mb-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                </svg>
                <h3 class="text-sm font-medium text-gray-900 mb-1">
                    Nėra pranešimų
                </h3>
                <p class="text-xs sm:text-sm text-gray-500">
                    No notifications yet
                </p>
            </div>
            
            <!-- Notifications List -->
            <div v-else class="max-h-80 overflow-y-auto">
                <div 
                    v-for="notification in notifications" 
                    :key="notification.id"
                    @click="handleNotificationClick(notification)"
                    class="relative px-4 sm:px-6 py-3 sm:py-4 hover:bg-gray-50 cursor-pointer transition-colors duration-150 border-b border-gray-50 last:border-b-0"
                    :class="{ 
                        'bg-blue-50 hover:bg-blue-100': !notification.read_at,
                        'hover:bg-gray-50': notification.read_at 
                    }"
                >
                    <!-- Status Icon -->
                    <div class="absolute left-2 sm:left-4 top-3 sm:top-4">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center"
                             :class="{
                                'bg-green-100': notification.data.new_status === 'approved',
                                'bg-red-100': notification.data.new_status === 'rejected',
                                'bg-yellow-100': notification.data.new_status === 'pending'
                             }">
                            <!-- Approved Icon -->
                            <svg v-if="notification.data.new_status === 'approved'" class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <!-- Rejected Icon -->
                            <svg v-else-if="notification.data.new_status === 'rejected'" class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <!-- Pending Icon -->
                            <svg v-else class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="ml-12 sm:ml-14 pr-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-900 mb-1">
                                    {{ getStatusMessage(notification.data.new_status) }}
                                </p>
                                <p class="text-xs sm:text-sm text-gray-700 mb-2 truncate">
                                    <span class="font-medium">{{ notification.data.task_title }}</span>
                                </p>
                                <div v-if="notification.data.comments" class="mb-2">
                                    <p class="text-xs text-gray-600 bg-gray-100 rounded-lg px-2 sm:px-3 py-1 sm:py-2">
                                        <span class="font-semibold block sm:inline">Komentaras / Comment:</span>
                                        <span class="block sm:inline sm:ml-1">{{ truncateText(notification.data.comments, 100) }}</span>
                                    </p>
                                </div>
                                <p class="text-xs text-gray-500 flex items-center">
                                    <svg class="w-3 h-3 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ formatDate(notification.created_at) }}
                                </p>
                            </div>
                            
                            <!-- Unread Indicator -->
                            <div v-if="!notification.read_at" class="flex-shrink-0 ml-2">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Click indicator -->
                    <div class="absolute right-2 sm:right-4 top-1/2 transform -translate-y-1/2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div v-if="notifications.length > 0" class="px-4 sm:px-6 py-3 bg-gray-50 border-t border-gray-100 rounded-b-xl space-y-2">
                <button 
                    v-if="unreadCount > 0"
                    @click.stop="markAllAsRead"
                    class="w-full flex items-center justify-center px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 hover:border-blue-300 transition-colors duration-150"
                >
                    <svg class="w-3 sm:w-4 h-3 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="hidden sm:inline">Pažymėti visus kaip perskaitytus / Mark all as read</span>
                    <span class="sm:hidden">Pažymėti visus / Mark all</span>
                </button>
                
                <button 
                    @click.stop="showConfirmDialog = true"
                    class="w-full flex items-center justify-center px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-red-700 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 hover:border-red-300 transition-colors duration-150"
                >
                    <svg class="w-3 sm:w-4 h-3 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <span class="hidden sm:inline">Išvalyti visus / Clear all</span>
                    <span class="sm:hidden">Išvalyti / Clear</span>
                </button>
            </div>
            
            <!-- Confirmation Dialog -->
            <div v-if="showConfirmDialog" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[60] p-4">
                <div class="bg-white rounded-lg shadow-xl max-w-sm w-full mx-4">
                    <div class="p-6">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-gray-900 text-center">
                            Išvalyti visus pranešimus?
                        </h3>
                        <p class="mb-4 text-sm text-gray-600 text-center">
                            Clear all notifications?
                        </p>
                        <p class="mb-6 text-xs text-gray-500 text-center">
                            Šis veiksmas negali būti atšauktas / This action cannot be undone
                        </p>
                        <div class="flex space-x-3">
                            <button
                                @click="showConfirmDialog = false"
                                class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 transition-colors duration-150"
                            >
                                Atšaukti / Cancel
                            </button>
                            <button
                                @click="clearAllNotifications"
                                class="flex-1 px-4 py-2 text-sm font-medium text-white bg-red-600 border border-red-600 rounded-md hover:bg-red-700 transition-colors duration-150"
                            >
                                Išvalyti / Clear
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';

const showDropdown = ref(false);
const notifications = ref([]);
const showConfirmDialog = ref(false);

const unreadCount = computed(() => {
    return notifications.value.filter(n => !n.read_at).length;
});

const toggleDropdown = async (event) => {
    event.stopPropagation();
    if (!showDropdown.value) {
        await fetchNotifications();
    }
    showDropdown.value = !showDropdown.value;
};

const fetchNotifications = async () => {
    try {
        const response = await fetch('/api/notifications');
        if (response.ok) {
            notifications.value = await response.json();
        }
    } catch (error) {
        console.error('Failed to fetch notifications:', error);
    }
};

const handleNotificationClick = async (notification) => {
    // Mark as read first
    await markAsRead(notification.id);
    
    // Navigate to the task if submission_id exists in notification data
    if (notification.data.submission_id) {
        // We need to get the task ID from the submission
        try {
            const response = await fetch(`/api/submission/${notification.data.submission_id}/task`);
            if (response.ok) {
                const data = await response.json();
                router.visit(`/tasks/${data.task_id}`);
                showDropdown.value = false;
            }
        } catch (error) {
            console.error('Failed to get task ID:', error);
        }
    }
};

const markAsRead = async (notificationId) => {
    try {
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        
        const response = await fetch(`/api/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token || '',
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            const notification = notifications.value.find(n => n.id === notificationId);
            if (notification) {
                notification.read_at = new Date().toISOString();
            }
        }
    } catch (error) {
        console.error('Failed to mark notification as read:', error);
    }
};

const markAllAsRead = async () => {
    try {
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        const response = await fetch('/api/notifications/read-all', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token || ''
            }
        });
        
        if (response.ok) {
            notifications.value.forEach(notification => {
                notification.read_at = new Date().toISOString();
            });
        }
    } catch (error) {
        console.error('Failed to mark all notifications as read:', error);
    }
};

const clearAllNotifications = async () => {
    try {
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        const response = await fetch('/api/notifications/clear-all', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token || '',
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            notifications.value = [];
            showConfirmDialog.value = false;
        }
    } catch (error) {
        console.error('Failed to clear all notifications:', error);
    }
};

const getStatusMessage = (status) => {
    const messages = {
        'approved': {
            lt: 'Užduotis priimta',
            en: 'Submission approved'
        },
        'rejected': {
            lt: 'Užduotis atmesta',
            en: 'Submission rejected'
        },
        'pending': {
            lt: 'Laukiama vertinimo',
            en: 'Pending review'
        }
    };
    
    const message = messages[status] || { lt: 'Statusas atnaujintas', en: 'Status updated' };
    return `${message.lt} / ${message.en}`;
};

const truncateText = (text, maxLength) => {
    if (!text) return '';
    if (text.length <= maxLength) return text;
    return text.substring(0, maxLength).trim() + '...';
};

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleString('lt-LT', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

// Helper function for Lithuanian notification count endings
const getNotificationsText = (count) => {
    if (count % 10 === 1 && count % 100 !== 11) {
        return `${count} naujas`;
    } else if ([2, 3, 4, 5, 6, 7, 8, 9].includes(count % 10) && ![12, 13, 14, 15, 16, 17, 18, 19].includes(count % 100)) {
        return `${count} nauji`;
    } else {
        return `${count} naujų`;
    }
};

const handleClickOutside = (event) => {
    const dropdown = event.target.closest('.notification-dropdown');
    if (!dropdown) {
        showDropdown.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
    fetchNotifications();
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script>