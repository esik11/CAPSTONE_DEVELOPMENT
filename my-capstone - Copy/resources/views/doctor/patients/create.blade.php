<x-doctor-layout>
    <x-slot name="breadcrumbs">
        <li class="inline-flex items-center">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-teal-600">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
                Dashboard
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('patients.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-teal-600 md:ml-2">Patients</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Add New</span>
            </div>
        </li>
    </x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Add New Patient') }}
                </h2>
                <p class="text-sm text-gray-600 mt-0.5">Fill in patient information to create a new record</p>
            </div>
        </div>
    </x-slot>

    @php
        $showModalCreate = $errors->has('emergency_last_name') || $errors->has('other_last_name') || old('emergency_last_name') || old('other_last_name');
    @endphp
    <div class="py-6">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-200">
                <div class="p-6" x-data="{ activeTab: 'personal' }">
                    <!-- Tab Navigation -->
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex flex-wrap gap-1" aria-label="Tabs">
                            <button type="button" @click="activeTab = 'personal'" :class="activeTab === 'personal' ? 'border-teal-500 text-teal-600 bg-teal-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="py-3 px-4 border-b-2 font-medium text-sm transition-colors flex items-center gap-2 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Personal Details
                            </button>
                            <button type="button" @click="activeTab = 'address'" :class="activeTab === 'address' ? 'border-teal-500 text-teal-600 bg-teal-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="py-3 px-4 border-b-2 font-medium text-sm transition-colors flex items-center gap-2 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                Address
                            </button>
                            <button type="button" @click="activeTab = 'contact'" :class="activeTab === 'contact' ? 'border-teal-500 text-teal-600 bg-teal-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="py-3 px-4 border-b-2 font-medium text-sm transition-colors flex items-center gap-2 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                Contact & Employment
                            </button>
                        </nav>
                    </div>

                    <form method="POST" action="{{ route('patients.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Tab Panel: Personal Details -->
                        <div x-show="activeTab === 'personal'" x-transition class="space-y-6">
                    <!-- Section: Personal Details -->
                    <div class="mb-6 p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                        <div class="flex justify-between items-center mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Personal Details</h3>
                                    <p class="text-xs text-gray-600">Basic patient information</p>
                                </div>
                            </div>
                            <div x-data @click.prevent="$dispatch('open-additional-patient-details-modal', 'patient-details-modal')">
                                <button type="button" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border-2 border-teal-600 text-teal-600 hover:bg-teal-50 font-semibold rounded-lg transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    {{ __('Add Emergency Contact') }}
                                </button>
                            </div>
                        </div>

                        <!-- Patient ID (Display Only - Auto-generated) -->
                        <div class="mb-4">
                            <x-input-label for="patient_id_display" :value="__('Patient ID')" />
                            <p class="text-gray-600 dark:text-gray-400"><em>(Auto-generated upon creation)</em></p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Last Name -->
                            <div>
                                <x-input-label for="last_name" :value="__('Last Name')" />
                                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autocomplete="family-name" />
                                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                            </div>

                            <!-- First Name -->
                            <div>
                                <x-input-label for="first_name" :value="__('First Name')" />
                                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="given-name" />
                                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Middle Name -->
                        <div class="mt-4">
                            <x-input-label for="middle_name" :value="__('Middle Name')" />
                            <x-text-input id="middle_name" class="block mt-1 w-full" type="text" name="middle_name" :value="old('middle_name')" autocomplete="additional-name" />
                            <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                        </div>

           
                        <!-- Date of Birth -->
                        <div class="mt-4">
                            <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                            <x-text-input id="date_of_birth" class="block mt-1 w-full flatpickr" type="text" name="date_of_birth" :value="old('date_of_birth')" required autocomplete="bday" />
                            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                        </div>

                        <!-- Social Security Number -->
                        <div class="mt-4">
                            <x-input-label for="social_security_number" :value="__('Social Security Number')" />
                            <x-text-input id="social_security_number" class="block mt-1 w-full" type="text" name="social_security_number" :value="old('social_security_number')" />
                            <x-input-error :messages="$errors->get('social_security_number')" class="mt-2" />
                        </div>

                        <!-- Gender -->
                        <div class="mt-4">
                            <x-input-label for="gender_male" :value="__('Gender')" class="block" />
                            <div class="mt-1 flex flex-wrap gap-x-4">
                                <label for="gender_male" class="inline-flex items-center">
                                    <input id="gender_male" type="radio" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-clinic-green-dark shadow-sm focus:ring-clinic-green-dark dark:focus:ring-clinic-green-dark dark:focus:ring-offset-gray-800" name="gender" value="Male" {{ old('gender') == 'Male' ? 'checked' : '' }} required>
                                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Male</span>
                                </label>
                                <label for="gender_female" class="inline-flex items-center">
                                    <input id="gender_female" type="radio" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-clinic-green-dark shadow-sm focus:ring-clinic-green-dark dark:focus:ring-clinic-green-dark dark:focus:ring-offset-gray-800" name="gender" value="Female" {{ old('gender') == 'Female' ? 'checked' : '' }}>
                                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Female</span>
                                </label>
                                <label for="gender_other" class="inline-flex items-center">
                                    <input id="gender_other" type="radio" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-clinic-green-dark shadow-sm focus:ring-clinic-green-dark dark:focus:ring-clinic-green-dark dark:focus:ring-offset-gray-800" name="gender" value="Other" {{ old('gender') == 'Other' ? 'checked' : '' }}>
                                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Other</span>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>

                        <!-- Marital Status -->
                        <div class="mt-4">
                            <x-input-label for="marital_status" :value="__('Marital Status')" />
                            <select id="marital_status" name="marital_status" class="block mt-1 w-full border-gray-300 focus:border-clinic-blue-medium focus:ring-clinic-blue-medium rounded-md shadow-sm">
                                <option value="">Select Marital Status</option>
                                <option value="Married" {{ old('marital_status') == 'Married' ? 'selected' : '' }}>Married</option>
                                <option value="Single" {{ old('marital_status') == 'Single' ? 'selected' : '' }}>Single</option>
                                <option value="Divorced" {{ old('marital_status') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                <option value="Separated" {{ old('marital_status') == 'Separated' ? 'selected' : '' }}>Separated</option>
                                <option value="Widowed" {{ old('marital_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                <option value="Other" {{ old('marital_status') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <x-input-error :messages="$errors->get('marital_status')" class="mt-2" />
                        </div>

                        <!-- Language -->
                        <div class="mt-4">
                            <x-input-label for="language" :value="__('Language')" />
                            <x-text-input id="language" class="block mt-1 w-full" type="text" name="language" :value="old('language')" />
                            <x-input-error :messages="$errors->get('language')" class="mt-2" />
                        </div>

                        <!-- Race -->
                        <div class="mt-4">
                            <x-input-label for="race" :value="__('Race')" />
                            <x-text-input id="race" class="block mt-1 w-full" type="text" name="race" :value="old('race')" />
                            <x-input-error :messages="$errors->get('race')" class="mt-2" />
                        </div>

                        <!-- Photo Upload -->
                        <div class="mt-4" x-data="{ photoName: null, photoPreview: null }">
                            <x-input-label for="photo" :value="__('Patient Photo')" />
                            <input type="file" id="photo" name="photo" hidden x-ref="photo"
                                @change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                                ">

                            <div class="mt-2 relative w-40 h-40 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center cursor-pointer overflow-hidden"
                                onclick="document.getElementById('photo').click()">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-full h-full object-cover" alt="Patient Photo Preview">
                                </template>
                                <template x-if="!photoPreview">
                                    <div class="text-center text-gray-500">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m-4-4v-4m4-4h4m-4 0v4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <span class="mt-2 block text-sm font-medium">Add Photo</span>
                                    </div>
                                </template>
                            </div>
                            <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                        </div>
                    </div>
                        </div>

                        <!-- Tab Panel: Address -->
                        <div x-show="activeTab === 'address'" x-transition class="space-y-6">
                    <!-- Section: Home Address -->
                    <div class="mb-6 p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Home Address</h3>
                                <p class="text-xs text-gray-600">Residential information</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Region -->
                            <div>
                                <x-input-label for="region" :value="__('Region')" />
                                <x-text-input id="region" class="block mt-1 w-full" type="text" name="region" :value="old('region')" autocomplete="address-level1" />
                                <x-input-error :messages="$errors->get('region')" class="mt-2" />
                            </div>

                            <!-- Province -->
                            <div>
                                <x-input-label for="province" :value="__('Province')" />
                                <x-text-input id="province" class="block mt-1 w-full" type="text" name="province" :value="old('province')" autocomplete="address-level2" />
                                <x-input-error :messages="$errors->get('province')" class="mt-2" />
                            </div>

                            <!-- City -->
                            <div class="mt-4 md:mt-0">
                                <x-input-label for="city" :value="__('City')" />
                                <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" autocomplete="address-level3" />
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>

                            <!-- Barangay -->
                            <div class="mt-4 md:mt-0">
                                <x-input-label for="barangay" :value="__('Barangay')" />
                                <x-text-input id="barangay" class="block mt-1 w-full" type="text" name="barangay" :value="old('barangay')" autocomplete="address-level4" />
                                <x-input-error :messages="$errors->get('barangay')" class="mt-2" />
                            </div>

                            <!-- Zip Code -->
                            <div class="mt-4">
                                <x-input-label for="zip_code" :value="__('Zip Code')" />
                                <x-text-input id="zip_code" class="block mt-1 w-full" type="text" name="zip_code" :value="old('zip_code')" autocomplete="postal-code" />
                                <x-input-error :messages="$errors->get('zip_code')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                        </div>

                        <!-- Tab Panel: Contact & Employment -->
                        <div x-show="activeTab === 'contact'" x-transition class="space-y-6">
                    <!-- Section: Contact Information -->
                    <div class="mb-6 p-6 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Contact Information</h3>
                                <p class="text-xs text-gray-600">Phone and email details</p>
                            </div>
                        </div>
                        <!-- Contact Number -->
                        <div>
                            <x-input-label for="phone_number" :value="__('Contact Number')" />
                            <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" required autocomplete="tel" />
                            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email Address')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" autocomplete="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Section: Employment Details -->
                    <div class="mb-6 p-6 border-b border-gray-200 bg-gradient-to-r from-amber-50 to-orange-50">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Employment Details</h3>
                                <p class="text-xs text-gray-600">Work status information</p>
                            </div>
                        </div>
                        <!-- Employment Status -->
                        <div>
                            <x-input-label for="employment_status" :value="__('Employment Status')" class="block" />
                            <div class="mt-1 flex flex-wrap gap-x-4">
                                @foreach (['Active duty military', 'Employed', 'Student', 'Child', 'Disabled', 'Retired', 'Self employed', 'Other'] as $status)
                                    <label for="employment_status_{{ Str::slug($status) }}" class="inline-flex items-center mb-2">
                                        <input id="employment_status_{{ Str::slug($status) }}" type="radio" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-clinic-green-dark shadow-sm focus:ring-clinic-green-dark dark:focus:ring-clinic-green-dark dark:focus:ring-offset-gray-800" name="employment_status" value="{{ $status }}" {{ old('employment_status') == $status ? 'checked' : '' }}>
                                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ $status }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('employment_status')" class="mt-2" />
                        </div>
                    </div>
                        </div>

                        <!-- Submit Button (Always Visible) -->
                        <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-between">
                            <a href="{{ route('patients.index') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold rounded-lg transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white font-semibold rounded-lg shadow-lg shadow-teal-500/50 transition-all duration-200 hover:shadow-xl hover:shadow-teal-500/60">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ __('Add Patient') }}
                            </button>
                        </div>
                    </form>
                </div>

                    <x-modal name="patient-details-modal" :show="$showModalCreate" focusable maxWidth="2xl" x-cloak
                        x-data="{ show: $showModalCreate }" x-on:open-additional-patient-details-modal.window="show = true">
                        <!-- Modal Header -->
                        <div class="bg-gradient-to-r from-red-600 to-orange-600 px-6 py-5 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-white">Additional Patient Details</h2>
                                    <p class="text-sm text-white/80">Emergency and other contact information</p>
                                </div>
                            </div>
                            <button @click="$dispatch('close')" class="text-white/80 hover:text-white hover:bg-white/10 rounded-lg p-2 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <div class="p-6 max-h-[70vh] overflow-y-auto bg-gradient-to-br from-gray-50 to-white">
                            <!-- Emergency/Next of Kin Contact Information -->
                            <div class="mb-6 bg-white rounded-xl shadow-lg border border-red-200 overflow-hidden">
                                <div class="bg-gradient-to-r from-red-50 to-orange-50 px-6 py-4 border-b border-red-200">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-orange-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900">Emergency Contact</h3>
                                            <p class="text-xs text-gray-600">Next of kin information</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- Last Name -->
                                    <div>
                                        <x-input-label for="emergency_last_name" :value="__('Last Name')" />
                                        <x-text-input id="emergency_last_name" class="block mt-1 w-full" type="text" name="emergency_last_name" :value="old('emergency_last_name')" />
                                        <x-input-error :messages="$errors->get('emergency_last_name')" class="mt-2" />
                                    </div>

                                    <!-- First Name -->
                                    <div>
                                        <x-input-label for="emergency_first_name" :value="__('First Name')" />
                                        <x-text-input id="emergency_first_name" class="block mt-1 w-full" type="text" name="emergency_first_name" :value="old('emergency_first_name')" />
                                        <x-input-error :messages="$errors->get('emergency_first_name')" class="mt-2" />
                                    </div>

                                    <!-- Relationship to Patient -->
                                    <div>
                                        <x-input-label for="emergency_relationship" :value="__('Relationship to Patient')" />
                                        <x-text-input id="emergency_relationship" class="block mt-1 w-full" type="text" name="emergency_relationship" :value="old('emergency_relationship')" placeholder="e.g., Spouse, Parent, Sibling" />
                                        <x-input-error :messages="$errors->get('emergency_relationship')" class="mt-2" />
                                    </div>
                                </div>

                                    <div class="mt-6">
                                        <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            Address
                                        </h4>
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                    <!-- Region -->
                                    <div>
                                        <x-input-label for="emergency_region" :value="__('Region')" />
                                        <x-text-input id="emergency_region" class="block mt-1 w-full" type="text" name="emergency_region" :value="old('emergency_region')" autocomplete="address-level1" />
                                        <x-input-error :messages="$errors->get('emergency_region')" class="mt-2" />
                                    </div>

                                    <!-- Province -->
                                    <div>
                                        <x-input-label for="emergency_province" :value="__('Province')" />
                                        <x-text-input id="emergency_province" class="block mt-1 w-full" type="text" name="emergency_province" :value="old('emergency_province')" autocomplete="address-level2" />
                                        <x-input-error :messages="$errors->get('emergency_province')" class="mt-2" />
                                    </div>

                                    <!-- City -->
                                    <div class="mt-4 md:mt-0">
                                        <x-input-label for="emergency_city" :value="__('City')" />
                                        <x-text-input id="emergency_city" class="block mt-1 w-full" type="text" name="emergency_city" :value="old('emergency_city')" autocomplete="address-level3" />
                                        <x-input-error :messages="$errors->get('emergency_city')" class="mt-2" />
                                    </div>

                                    <!-- Barangay -->
                                    <div class="mt-4 md:mt-0">
                                        <x-input-label for="emergency_barangay" :value="__('Barangay')" />
                                        <x-text-input id="emergency_barangay" class="block mt-1 w-full" type="text" name="emergency_barangay" :value="old('emergency_barangay')" autocomplete="address-level4" />
                                        <x-input-error :messages="$errors->get('emergency_barangay')" class="mt-2" />
                                    </div>

                                    <!-- Zip Code -->
                                    <div class="mt-4">
                                        <x-input-label for="emergency_zip_code" :value="__('Zip Code')" />
                                        <x-text-input id="emergency_zip_code" class="block mt-1 w-full" type="text" name="emergency_zip_code" :value="old('emergency_zip_code')" autocomplete="postal-code" />
                                        <x-input-error :messages="$errors->get('emergency_zip_code')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                    <!-- Home Phone -->
                                    <div>
                                        <x-input-label for="emergency_home_phone" :value="__('Home Phone')" />
                                        <x-text-input id="emergency_home_phone" class="block mt-1 w-full" type="text" name="emergency_home_phone" :value="old('emergency_home_phone')" autocomplete="tel-home" />
                                        <x-input-error :messages="$errors->get('emergency_home_phone')" class="mt-2" />
                                    </div>

                                    <!-- Work Phone -->
                                    <div>
                                        <x-input-label for="emergency_work_phone" :value="__('Work Phone')" />
                                        <x-text-input id="emergency_work_phone" class="block mt-1 w-full" type="text" name="emergency_work_phone" :value="old('emergency_work_phone')" autocomplete="tel-work" />
                                        <x-input-error :messages="$errors->get('emergency_work_phone')" class="mt-2" />
                                    </div>

                                    <!-- Other Phone -->
                                    <div>
                                        <x-input-label for="emergency_other_phone" :value="__('Other Phone')" />
                                        <x-text-input id="emergency_other_phone" class="block mt-1 w-full" type="text" name="emergency_other_phone" :value="old('emergency_other_phone')" />
                                        <x-input-error :messages="$errors->get('emergency_other_phone')" class="mt-2" />
                                    </div>
                                </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Other Contact Information (Not Living with Patient) -->
                            <div class="mb-6 bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                                <div class="bg-gradient-to-r from-gray-50 to-slate-50 px-6 py-4 border-b border-gray-200">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-gray-500 to-slate-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900">Other Contact</h3>
                                            <p class="text-xs text-gray-600">Additional contact not living with patient</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-6">

                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-4">
                                    <!-- Region -->
                                    <div>
                                        <x-input-label for="other_region" :value="__('Region')" />
                                        <x-text-input id="other_region" class="block mt-1 w-full" type="text" name="other_region" :value="old('other_region')" autocomplete="address-level1" />
                                        <x-input-error :messages="$errors->get('other_region')" class="mt-2" />
                                    </div>

                                    <!-- Province -->
                                    <div>
                                        <x-input-label for="other_province" :value="__('Province')" />
                                        <x-text-input id="other_province" class="block mt-1 w-full" type="text" name="other_province" :value="old('other_province')" autocomplete="address-level2" />
                                        <x-input-error :messages="$errors->get('other_province')" class="mt-2" />
                                    </div>

                                    <!-- City -->
                                    <div class="mt-4 md:mt-0">
                                        <x-input-label for="other_city" :value="__('City')" />
                                        <x-text-input id="other_city" class="block mt-1 w-full" type="text" name="other_city" :value="old('other_city')" autocomplete="address-level3" />
                                        <x-input-error :messages="$errors->get('other_city')" class="mt-2" />
                                    </div>

                                    <!-- Barangay -->
                                    <div class="mt-4 md:mt-0">
                                        <x-input-label for="other_barangay" :value="__('Barangay')" />
                                        <x-text-input id="other_barangay" class="block mt-1 w-full" type="text" name="other_barangay" :value="old('other_barangay')" autocomplete="address-level4" />
                                        <x-input-error :messages="$errors->get('other_barangay')" class="mt-2" />
                                    </div>

                                    <!-- Zip Code -->
                                    <div class="mt-4">
                                        <x-input-label for="other_zip_code" :value="__('Zip Code')" />
                                        <x-text-input id="other_zip_code" class="block mt-1 w-full" type="text" name="other_zip_code" :value="old('other_zip_code')" autocomplete="postal-code" />
                                        <x-input-error :messages="$errors->get('other_zip_code')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                    <!-- Home Phone -->
                                    <div>
                                        <x-input-label for="other_home_phone" :value="__('Home Phone')" />
                                        <x-text-input id="other_home_phone" class="block mt-1 w-full" type="text" name="other_home_phone" :value="old('other_home_phone')" autocomplete="tel-home" />
                                        <x-input-error :messages="$errors->get('other_home_phone')" class="mt-2" />
                                    </div>

                                    <!-- Work Phone -->
                                    <div>
                                        <x-input-label for="other_work_phone" :value="__('Work Phone')" />
                                        <x-text-input id="other_work_phone" class="block mt-1 w-full" type="text" name="other_work_phone" :value="old('other_work_phone')" autocomplete="tel-work" />
                                        <x-input-error :messages="$errors->get('other_work_phone')" class="mt-2" />
                                    </div>

                                    <!-- Other Phone -->
                                    <div>
                                        <x-input-label for="other_other_phone" :value="__('Other Phone')" />
                                        <x-text-input id="other_other_phone" class="block mt-1 w-full" type="text" name="other_other_phone" :value="old('other_other_phone')" />
                                        <x-input-error :messages="$errors->get('other_other_phone')" class="mt-2" />
                                        <div class="mt-2 flex flex-wrap gap-x-4">
                                            <label for="other_other_phone_cell" class="inline-flex items-center">
                                                <input id="other_other_phone_cell" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-clinic-green-dark shadow-sm focus:ring-clinic-green-dark dark:focus:ring-clinic-green-dark dark:focus:ring-offset-gray-800" name="other_other_phone_cell" value="1" {{ old('other_other_phone_cell') ? 'checked' : '' }}>
                                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Cell</span>
                                            </label>
                                            <label for="other_other_phone_pager" class="inline-flex items-center">
                                                <input id="other_other_phone_pager" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-clinic-green-dark shadow-sm focus:ring-clinic-green-dark dark:focus:ring-clinic-green-dark dark:focus:ring-offset-gray-800" name="other_other_phone_pager" value="1" {{ old('other_other_phone_pager') ? 'checked' : '' }}>
                                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Pager</span>
                                            </label>
                                            <label for="other_other_phone_fax" class="inline-flex items-center">
                                                <input id="other_other_phone_fax" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-clinic-green-dark shadow-sm focus:ring-clinic-green-dark dark:focus:ring-clinic-green-dark dark:focus:ring-offset-gray-800" name="other_other_phone_fax" value="1" {{ old('other_other_phone_fax') ? 'checked' : '' }}>
                                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Fax</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end gap-3">
                            <button type="button" x-on:click="$dispatch('close')" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold rounded-lg transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                {{ __('Cancel') }}
                            </button>

                            <button type="button" x-on:click="$dispatch('close')" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white font-semibold rounded-lg shadow-lg shadow-teal-500/50 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                {{ __('Save Details') }}
                            </button>
                        </div>
                    </x-modal>
            </div>
        </div>
    </div>
</x-doctor-layout>