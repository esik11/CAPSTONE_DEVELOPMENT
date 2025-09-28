<x-doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Patient') }}
        </h2>
    </x-slot>

    @php
        $showModalCreate = $errors->has('emergency_last_name') || $errors->has('other_last_name') || old('emergency_last_name') || old('other_last_name');
    @endphp
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('patients.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Section: Personal Details -->
                    <div class="mb-6 p-4 border rounded-lg bg-clinic-earth-light">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-900">Personal Details</h3>
                            <div x-data @click.prevent="$dispatch('open-additional-patient-details-modal', 'patient-details-modal')">
                                <x-secondary-button type="button">
                                    {{ __('Add More Patient Details') }}
                                </x-secondary-button>
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

                        <!-- Nickname -->
                        <div class="mt-4">
                            <x-input-label for="nickname" :value="__('Nickname')" />
                            <x-text-input id="nickname" class="block mt-1 w-full" type="text" name="nickname" :value="old('nickname')" />
                            <x-input-error :messages="$errors->get('nickname')" class="mt-2" />
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

                    <!-- Section: Home Address -->
                    <div class="mb-6 p-4 border rounded-lg bg-clinic-earth-light">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Home Address</h3>
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

                    <!-- Section: Contact Information -->
                    <div class="mb-6 p-4 border rounded-lg bg-clinic-earth-light">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Contact Information</h3>
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
                    <div class="mb-6 p-4 border rounded-lg bg-clinic-earth-light">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Employment Details</h3>
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

                    <x-modal name="patient-details-modal" :show="$showModalCreate" focusable title="{{ __('Additional Patient Details') }}" x-cloak
                        x-data="{ show: $showModalCreate }" x-on:open-additional-patient-details-modal.window="show = true">
                        <div class="p-6">
                            <!-- Emergency/Next of Kin Contact Information -->
                            <div class="mb-6 p-4 border rounded-lg bg-clinic-earth-light">
                                <h3 class="text-lg font-bold text-gray-900 mb-4">EMERGENCY/NEXT OF KIN CONTACT INFORMATION</h3>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                                        <x-text-input id="emergency_relationship" class="block mt-1 w-full" type="text" name="emergency_relationship" :value="old('emergency_relationship')" />
                                        <x-input-error :messages="$errors->get('emergency_relationship')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-4">
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

                            <!-- Section: Other Contact Information (Not Living with Patient) -->
                            <div class="mb-6 p-4 border rounded-lg bg-clinic-earth-light">
                                <h3 class="text-lg font-bold text-gray-900 mb-4">OTHER CONTACT INFORMATION (NOT LIVING WITH PATIENT)</h3>

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

                        <div class="flex items-center justify-end mt-4">
                            <x-secondary-button type="button" x-on:click="$dispatch('close')">
                                {{ __('Cancel') }}
                            </x-secondary-button>

                            <x-primary-button class="ms-4">
                                {{ __('Save Changes') }}
                            </x-primary-button>
                        </div>
                    </x-modal>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-4">
                            {{ __('Add Patient') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-doctor-layout>