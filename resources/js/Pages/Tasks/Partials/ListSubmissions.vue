<script setup>
import {DateTime} from "luxon";

defineProps({
    userSubmissions: Object,
});
</script>

<template>
    <div v-if="userSubmissions.length > 0" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900">Submission History</h3>
            <p class="text-gray-600 mt-1">Track the progress of your submissions</p>
        </div>
        
        <div class="divide-y divide-gray-200">
            <div v-for="(submission, index) in userSubmissions" :key="submission.id"
                 class="p-6 hover:bg-gray-50 transition-colors">
                
                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Submission Image -->
                    <div class="flex-shrink-0">
                        <div class="w-full lg:w-48 aspect-video lg:aspect-square">
                            <img :src="submission.image_path" 
                                 alt="Your submission" 
                                 class="w-full h-full object-cover rounded-lg border border-gray-200 shadow-sm"/>
                        </div>
                    </div>

                    <!-- Submission Details -->
                    <div class="flex-1 space-y-4">
                        <!-- Status Header -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <div class="flex items-center space-x-3">
                                <!-- Status Badge -->
                                <div class="flex items-center space-x-2">
                                    <div v-if="submission.status === 'approved'" class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    <div v-else-if="submission.status === 'rejected'" class="w-3 h-3 bg-red-500 rounded-full"></div>
                                    <div v-else class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                    
                                    <span class="font-medium text-sm uppercase tracking-wide"
                                          :class="{
                                              'text-green-700': submission.status === 'approved',
                                              'text-red-700': submission.status === 'rejected',
                                              'text-yellow-700': submission.status === 'pending'
                                          }">
                                        {{ submission.status }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Submission Time -->
                            <div class="text-sm text-gray-500 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                <span>Submitted {{ DateTime.fromISO(submission.created_at).toRelative() }}</span>
                            </div>
                        </div>

                        <!-- Status Message -->
                        <div class="p-4 rounded-lg border"
                             :class="{
                                 'bg-green-50 border-green-200': submission.status === 'approved',
                                 'bg-red-50 border-red-200': submission.status === 'rejected',
                                 'bg-yellow-50 border-yellow-200': submission.status === 'pending'
                             }">
                            <div class="flex items-start space-x-3">
                                <!-- Status Icon -->
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg v-if="submission.status === 'approved'" class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <svg v-else-if="submission.status === 'rejected'" class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    <svg v-else class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                
                                <!-- Status Text -->
                                <div class="flex-1">
                                    <p class="text-sm font-medium"
                                       :class="{
                                           'text-green-800': submission.status === 'approved',
                                           'text-red-800': submission.status === 'rejected',
                                           'text-yellow-800': submission.status === 'pending'
                                       }">
                                        <span v-if="submission.status === 'approved'">Solution Approved!</span>
                                        <span v-else-if="submission.status === 'rejected'">Solution Needs Improvement</span>
                                        <span v-else>Under Review</span>
                                    </p>
                                    
                                    <!-- Comments -->
                                    <div v-if="submission.comments" class="mt-2">
                                        <p class="text-sm font-medium text-gray-700 mb-1">Feedback:</p>
                                        <p class="text-sm text-gray-600 italic">"{{ submission.comments }}"</p>
                                    </div>
                                    
                                    <!-- Default messages -->
                                    <p v-else class="text-sm mt-1"
                                       :class="{
                                           'text-green-700': submission.status === 'approved',
                                           'text-red-700': submission.status === 'rejected',
                                           'text-yellow-700': submission.status === 'pending'
                                       }">
                                        <span v-if="submission.status === 'approved'">Great work! Your solution has been approved.</span>
                                        <span v-else-if="submission.status === 'rejected'">Please review and try again with a different approach.</span>
                                        <span v-else>Your submission is being reviewed. Please check back later.</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
