<x-patient-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @php
                $hasEmergencyData = $patient->emergency_last_name || $patient->emergency_first_name || $patient->emergency_relationship || $patient->emergency_address || $patient->emergency_apt_num || $patient->emergency_city || $patient->emergency_state || $patient->emergency_zip_code || $patient->emergency_home_phone || $patient->emergency_work_phone || $patient->emergency_other_phone;
                $hasOtherContactData = $patient->other_last_name || $patient->other_first_name || $patient->other_relationship || $patient->other_address || $patient->other_apt_num || $patient->other_city || $patient->other_state || $patient->other_zip_code || $patient->other_home_phone || $patient->other_work_phone || $patient->other_other_phone;
                $showModalEdit = $errors->has('emergency_last_name') || $errors->has('other_last_name') || (old('emergency_last_name') || $hasEmergencyData) || (old('other_last_name') || $hasOtherContactData);
            @endphp

            <div class="bg-white overflow-hidden sm:rounded-lg p-6 rounded-xl shadow-md">
                <form method="POST" action="{{ route('patient.profile.update') }}" enctype="multipart/form-data" onsubmit="console.log('Main form submitted!')">
                    @csrf
                    @method('patch')

                    <!-- Section: Personal Details -->
                    <div class="mb-6 p-4 rounded-xl shadow-md bg-clinic-earth-light">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                <x-heroicon-o-user class="w-5 h-5 mr-2 text-clinic-green-dark" /> Personal Details
                            </h3>
                            <div>
                                <button type="button" x-data="" x-on:click.prevent="$dispatch('open-additional-patient-details-modal', 'patient-details-modal')" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                    Edit More Details
                                </button>
                            </div>
                        </div>

                        <!-- Patient ID (Display Only) -->
                        <div class="mb-4">
                            <x-input-label :value="__('Patient ID')" />
                            <p class="text-gray-600 dark:text-gray-400">{{ $patient->id }}</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Last Name -->
                            <div>
                                <x-input-label for="last_name" :value="__('Last Name')" />
                                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name', $patient->last_name)" required autocomplete="family-name" />
                                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                            </div>

                            <!-- First Name -->
                            <div>
                                <x-input-label for="first_name" :value="__('First Name')" />
                                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name', $patient->first_name)" required autofocus autocomplete="given-name" />
                                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Middle Name -->
                        <div class="mt-4">
                            <x-input-label for="middle_name" :value="__('Middle Name')" />
                            <x-text-input id="middle_name" class="block mt-1 w-full" type="text" name="middle_name" :value="old('middle_name', $patient->middle_name)" autocomplete="additional-name" />
                            <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                        </div>

                        <!-- Nickname -->
                        <div class="mt-4">
                            <x-input-label for="nickname" :value="__('Nickname')" />
                            <x-text-input id="nickname" class="block mt-1 w-full" type="text" name="nickname" :value="old('nickname', $patient->nickname)" />
                            <x-input-error :messages="$errors->get('nickname')" class="mt-2" />
                        </div>

                        <!-- Date of Birth -->
                        <div class="mt-4">
                            <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                            <x-text-input id="date_of_birth" class="block mt-1 w-full flatpickr" type="date" name="date_of_birth" :value="old('date_of_birth', $patient->date_of_birth)" required autocomplete="bday" />
                            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                        </div>

                        <!-- Social Security Number -->
                        <div class="mt-4">
                            <x-input-label for="social_security_number" :value="__('Social Security Number')" />
                            <x-text-input id="social_security_number" class="block mt-1 w-full" type="text" name="social_security_number" :value="old('social_security_number', $patient->social_security_number)" />
                            <x-input-error :messages="$errors->get('social_security_number')" class="mt-2" />
                        </div>

                        <!-- Gender -->
                        <div class="mt-4">
                            <x-input-label for="gender_male" :value="__('Gender')" class="block" />
                            <div class="mt-1 flex flex-wrap gap-x-4">
                                <label for="gender_male" class="inline-flex items-center">
                                    <input id="gender_male" type="radio" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-clinic-green-dark shadow-sm focus:ring-clinic-green-dark dark:focus:ring-clinic-green-dark dark:focus:ring-offset-gray-800" name="gender" value="Male" {{ old('gender', $patient->gender) == 'Male' ? 'checked' : '' }} required>
                                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Male</span>
                                </label>
                                <label for="gender_female" class="inline-flex items-center">
                                    <input id="gender_female" type="radio" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-clinic-green-dark shadow-sm focus:ring-clinic-green-dark dark:focus:ring-clinic-green-dark dark:focus:ring-offset-gray-800" name="gender" value="Female" {{ old('gender', $patient->gender) == 'Female' ? 'checked' : '' }}>
                                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Female</span>
                                </label>
                                <label for="gender_other" class="inline-flex items-center">
                                    <input id="gender_other" type="radio" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-clinic-green-dark shadow-sm focus:ring-clinic-green-dark dark:focus:ring-clinic-green-dark dark:focus:ring-offset-gray-800" name="gender" value="Other" {{ old('gender', $patient->gender) == 'Other' ? 'checked' : '' }}>
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
                                <option value="Married" {{ old('marital_status', $patient->marital_status) == 'Married' ? 'selected' : '' }}>Married</option>
                                <option value="Single" {{ old('marital_status', $patient->marital_status) == 'Single' ? 'selected' : '' }}>Single</option>
                                <option value="Divorced" {{ old('marital_status', $patient->marital_status) == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                <option value="Separated" {{ old('marital_status', $patient->marital_status) == 'Separated' ? 'selected' : '' }}>Separated</option>
                                <option value="Widowed" {{ old('marital_status', $patient->marital_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                <option value="Other" {{ old('marital_status', $patient->marital_status) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <x-input-error :messages="$errors->get('marital_status')" class="mt-2" />
                        </div>

                        <!-- Language -->
                        <div class="mt-4">
                            <x-input-label for="language" :value="__('Language')" />
                            <x-text-input id="language" class="block mt-1 w-full" type="text" name="language" :value="old('language', $patient->language)" />
                            <x-input-error :messages="$errors->get('language')" class="mt-2" />
                        </div>

                        <!-- Race -->
                        <div class="mt-4">
                            <x-input-label for="race" :value="__('Race')" />
                            <x-text-input id="race" class="block mt-1 w-full" type="text" name="race" :value="old('race', $patient->race)" />
                            <x-input-error :messages="$errors->get('race')" class="mt-2" />
                        </div>

                        <!-- Photo Upload -->
                        <div class="mt-4" x-data="{ photoName: null, photoPreview: '{{ $patient->photo ? Storage::url($patient->photo) : null }}' }">
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
                    <div class="mb-6 p-4 rounded-xl shadow-md bg-white">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <x-heroicon-o-map-pin class="w-5 h-5 mr-2 text-clinic-green-dark" /> Home Address
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Region -->
                            <div>
                                <x-input-label for="region" :value="__('Region')" />
                                <x-text-input id="region" class="block mt-1 w-full" type="text" name="region" :value="old('region', $patient->region)" autocomplete="address-level1" />
                                <x-input-error :messages="$errors->get('region')" class="mt-2" />
                            </div>

                            <!-- Province -->
                            <div>
                                <x-input-label for="province" :value="__('Province')" />
                                <x-text-input id="province" class="block mt-1 w-full" type="text" name="province" :value="old('province', $patient->province)" autocomplete="address-level2" />
                                <x-input-error :messages="$errors->get('province')" class="mt-2" />
                            </div>

                            <!-- City -->
                            <div class="mt-4 md:mt-0">
                                <x-input-label for="city" :value="__('City')" />
                                <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city', $patient->city)" autocomplete="address-level3" />
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>

                            <!-- Barangay -->
                            <div class="mt-4 md:mt-0">
                                <x-input-label for="barangay" :value="__('Barangay')" />
                                <x-text-input id="barangay" class="block mt-1 w-full" type="text" name="barangay" :value="old('barangay', $patient->barangay)" autocomplete="address-level4" />
                                <x-input-error :messages="$errors->get('barangay')" class="mt-2" />
                            </div>

                            <!-- Zip Code -->
                            <div class="mt-4">
                                <x-input-label for="zip_code" :value="__('Zip Code')" />
                                <x-text-input id="zip_code" class="block mt-1 w-full" type="text" name="zip_code" :value="old('zip_code', $patient->zip_code)" autocomplete="postal-code" />
                                <x-input-error :messages="$errors->get('zip_code')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Section: Contact Information -->
                    <div class="mb-6 p-4 rounded-xl shadow-md bg-clinic-earth-light">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <x-heroicon-o-phone class="w-5 h-5 mr-2 text-clinic-green-dark" /> Contact Information
                        </h3>
                        <!-- Contact Number -->
                        <div>
                            <x-input-label for="phone_number" :value="__('Contact Number')" />
                            <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number', $patient->phone_number)" required autocomplete="tel" />
                            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email Address')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $patient->user->email)" autocomplete="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Section: Employment Details -->
                    <div class="mb-6 p-4 rounded-xl shadow-md bg-white">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <x-heroicon-o-briefcase class="w-5 h-5 mr-2 text-clinic-green-dark" /> Employment Details
                        </h3>
                        <!-- Employment Status -->
                        <div>
                            <x-input-label for="employment_status" :value="__('Employment Status')" class="block" />
                            <div class="mt-1 flex flex-wrap gap-x-4">
                                @foreach (['Active duty military', 'Employed', 'Student', 'Child', 'Disabled', 'Retired', 'Self employed', 'Other'] as $status)
                                    <label for="employment_status_{{ Str::slug($status) }}" class="inline-flex items-center mb-2">
                                        <input id="employment_status_{{ Str::slug($status) }}" type="radio" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-clinic-green-dark shadow-sm focus:ring-clinic-green-dark dark:focus:ring-clinic-green-dark dark:focus:ring-offset-gray-800" name="employment_status" value="{{ $status }}" {{ old('employment_status', $patient->employment_status) == $status ? 'checked' : '' }}>
                                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ $status }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('employment_status')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-clinic-green-dark focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Save Changes') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Section: Update Password (Moved outside main form for consistent design) -->
            <div class="mb-6 p-4 rounded-xl shadow-md bg-clinic-earth-light">
                <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6" onsubmit="console.log('Password update form submitted!')">
                    @csrf
                    @method('put')

                    @include('profile.partials.update-password-form')

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save Password') }}</x-primary-button>

                        @if (session('status') === 'password-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600 dark:text-gray-400"
                            >{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Modal - Outside the form to prevent nesting issues -->
            <x-modal name="patient-details-modal" focusable maxWidth="2xl" x-cloak
                x-data="{ show: false }" {{-- Always start hidden --}}
                x-on:open-additional-patient-details-modal.window="show = true"
                x-show="show"
                x-init="$el.style.opacity = '0'; $watch('show', value => { $el.style.opacity = value ? '1' : '0' })"
            >
                
                <x-slot name="title">
                    {{ __('Additional Patient Details') }}
                </x-slot>

                <div>
                <form method="POST" action="{{ route('patient.profile.update') }}" enctype="multipart/form-data" onsubmit="console.log('Modal form submitted!')">
                    @csrf
                    @method('patch')
                    
                    <!-- Hidden fields to maintain main form data -->
                        <input type="hidden" name="last_name" value="{{ old('last_name', $patient->last_name) }}">
                        <input type="hidden" name="first_name" value="{{ old('first_name', $patient->first_name) }}">
                        <input type="hidden" name="middle_name" value="{{ old('middle_name', $patient->middle_name) }}">
                        <input type="hidden" name="nickname" value="{{ old('nickname', $patient->nickname) }}">
                        <input type="hidden" name="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth) }}">
                        <input type="hidden" name="social_security_number" value="{{ old('social_security_number', $patient->social_security_number) }}">
                        <input type="hidden" name="gender" value="{{ old('gender', $patient->gender) }}">
                        <input type="hidden" name="marital_status" value="{{ old('marital_status', $patient->marital_status) }}">
                        <input type="hidden" name="language" value="{{ old('language', $patient->language) }}">
                        <input type="hidden" name="race" value="{{ old('race', $patient->race) }}">
                        <input type="hidden" name="region" value="{{ old('region', $patient->region) }}">
                        <input type="hidden" name="province" value="{{ old('province', $patient->province) }}">
                        <input type="hidden" name="city" value="{{ old('city', $patient->city) }}">
                        <input type="hidden" name="barangay" value="{{ old('barangay', $patient->barangay) }}">
                        <input type="hidden" name="zip_code" value="{{ old('zip_code', $patient->zip_code) }}">
                        <input type="hidden" name="phone_number" value="{{ old('phone_number', $patient->phone_number) }}">
                        <input type="hidden" name="email" value="{{ old('email', $patient->user->email) }}">
                        <input type="hidden" name="employment_status" value="{{ old('employment_status', $patient->employment_status) }}">

                        <div class="p-6 max-h-96 overflow-y-auto">
                        <!-- Emergency/Next of Kin Contact Information -->
                        <div class="mb-6 p-4 rounded-xl shadow-md bg-white">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <x-heroicon-o-heart class="w-5 h-5 mr-2 text-clinic-green-dark" /> EMERGENCY/NEXT OF KIN CONTACT INFORMATION
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Last Name -->
                                <div>
                                    <x-input-label for="emergency_last_name" :value="__('Last Name')" />
                                    <x-text-input id="emergency_last_name" class="block mt-1 w-full" type="text" name="emergency_last_name" :value="old('emergency_last_name', $patient->emergency_last_name)" />
                                    <x-input-error :messages="$errors->get('emergency_last_name')" class="mt-2" />
                                </div>

                                <!-- First Name -->
                                <div>
                                    <x-input-label for="emergency_first_name" :value="__('First Name')" />
                                    <x-text-input id="emergency_first_name" class="block mt-1 w-full" type="text" name="emergency_first_name" :value="old('emergency_first_name', $patient->emergency_first_name)" />
                                    <x-input-error :messages="$errors->get('emergency_first_name')" class="mt-2" />
                                </div>

                                <!-- Relationship to Patient -->
                                <div>
                                    <x-input-label for="emergency_relationship" :value="__('Relationship to Patient')" />
                                    <x-text-input id="emergency_relationship" class="block mt-1 w-full" type="text" name="emergency_relationship" :value="old('emergency_relationship', $patient->emergency_relationship)" />
                                    <x-input-error :messages="$errors->get('emergency_relationship')" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-4">
                                <!-- Region -->
                                <div>
                                    <x-input-label for="emergency_region" :value="__('Region')" />
                                    <x-text-input id="emergency_region" class="block mt-1 w-full" type="text" name="emergency_region" :value="old('emergency_region', $patient->emergency_region)" autocomplete="address-level1" />
                                    <x-input-error :messages="$errors->get('emergency_region')" class="mt-2" />
                                </div>

                                <!-- Province -->
                                <div>
                                    <x-input-label for="emergency_province" :value="__('Province')" />
                                    <x-text-input id="emergency_province" class="block mt-1 w-full" type="text" name="emergency_province" :value="old('emergency_province', $patient->emergency_province)" autocomplete="address-level2" />
                                    <x-input-error :messages="$errors->get('emergency_province')" class="mt-2" />
                                </div>

                                <!-- City -->
                                    <div>
                                    <x-input-label for="emergency_city" :value="__('City')" />
                                    <x-text-input id="emergency_city" class="block mt-1 w-full" type="text" name="emergency_city" :value="old('emergency_city', $patient->emergency_city)" autocomplete="address-level3" />
                                    <x-input-error :messages="$errors->get('emergency_city')" class="mt-2" />
                                </div>

                                <!-- Barangay -->
                                    <div>
                                    <x-input-label for="emergency_barangay" :value="__('Barangay')" />
                                    <x-text-input id="emergency_barangay" class="block mt-1 w-full" type="text" name="emergency_barangay" :value="old('emergency_barangay', $patient->emergency_barangay)" autocomplete="address-level4" />
                                    <x-input-error :messages="$errors->get('emergency_barangay')" class="mt-2" />
                                </div>

                                <!-- Zip Code -->
                                    <div>
                                    <x-input-label for="emergency_zip_code" :value="__('Zip Code')" />
                                    <x-text-input id="emergency_zip_code" class="block mt-1 w-full" type="text" name="emergency_zip_code" :value="old('emergency_zip_code', $patient->emergency_zip_code)" autocomplete="postal-code" />
                                    <x-input-error :messages="$errors->get('emergency_zip_code')" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                <!-- Home Phone -->
                                <div>
                                    <x-input-label for="emergency_home_phone" :value="__('Home Phone')" />
                                    <x-text-input id="emergency_home_phone" class="block mt-1 w-full" type="text" name="emergency_home_phone" :value="old('emergency_home_phone', $patient->emergency_home_phone)" autocomplete="tel-home" />
                                    <x-input-error :messages="$errors->get('emergency_home_phone')" class="mt-2" />
                                </div>

                                <!-- Work Phone -->
                                <div>
                                    <x-input-label for="emergency_work_phone" :value="__('Work Phone')" />
                                    <x-text-input id="emergency_work_phone" class="block mt-1 w-full" type="text" name="emergency_work_phone" :value="old('emergency_work_phone', $patient->emergency_work_phone)" autocomplete="tel-work" />
                                    <x-input-error :messages="$errors->get('emergency_work_phone')" class="mt-2" />
                                </div>

                                <!-- Other Phone -->
                                <div>
                                    <x-input-label for="emergency_other_phone" :value="__('Other Phone')" />
                                    <x-text-input id="emergency_other_phone" class="block mt-1 w-full" type="text" name="emergency_other_phone" :value="old('emergency_other_phone', $patient->emergency_other_phone)" />
                                    <x-input-error :messages="$errors->get('emergency_other_phone')" class="mt-2" />
                                    <div class="mt-2 flex flex-wrap gap-x-4">
                                        <input type="hidden" name="emergency_other_phone_cell" value="0">
                                        <label for="emergency_other_phone_cell" class="inline-flex items-center">
                                            <input id="emergency_other_phone_cell" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-clinic-green-dark shadow-sm focus:ring-clinic-green-dark dark:focus:ring-clinic-green-dark dark:focus:ring-offset-gray-800" name="emergency_other_phone_cell" value="1" {{ old('emergency_other_phone_cell', $patient->emergency_other_phone_cell) ? 'checked' : '' }}>
                                            <span class="ms-2 text-sm text-gray-400">Cell</span>
                                        </label>
                                        <input type="hidden" name="emergency_other_phone_pager" value="0">
                                        <label for="emergency_other_phone_pager" class="inline-flex items-center">
                                            <input id="emergency_other_phone_pager" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-clinic-green-dark shadow-sm focus:ring-clinic-green-dark dark:focus:ring-clinic-green-dark dark:focus:ring-offset-gray-800" name="emergency_other_phone_pager" value="1" {{ old('emergency_other_phone_pager', $patient->emergency_other_phone_pager) ? 'checked' : '' }}>
                                            <span class="ms-2 text-sm text-gray-400">Pager</span>
                                        </label>
                                            <input type="hidden" name="emergency_other_phone_fax" value="0">
                                            <label for="emergency_other_phone_fax" class="inline-flex items-center">
                                                <input id="emergency_other_phone_fax" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-clinic-green-dark shadow-sm focus:ring-clinic-green-dark dark:focus:ring-clinic-green-dark dark:focus:ring-offset-gray-800" name="emergency_other_phone_fax" value="1" {{ old('emergency_other_phone_fax', $patient->emergency_other_phone_fax) ? 'checked' : '' }}>
                                                <span class="ms-2 text-sm text-gray-400">Fax</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>                    
                            <!-- Other Contact Information -->
                            <div class="mb-6 p-4 rounded-xl shadow-md bg-clinic-earth-light">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <x-heroicon-o-users class="w-5 h-5 mr-2 text-clinic-green-dark" /> OTHER CONTACT INFORMATION (NOT LIVING WITH PATIENT)
                                </h3>
                            
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Last Name -->
                                    <div>
                                        <x-input-label for="other_last_name" :value="__('Last Name')" />
                                        <x-text-input id="other_last_name" class="block mt-1 w-full" type="text" name="other_last_name" :value="old('other_last_name', $patient->other_last_name)" />
                                        <x-input-error :messages="$errors->get('other_last_name')" class="mt-2" />
                                    </div>
                            
                                    <!-- First Name -->
                                    <div>
                                        <x-input-label for="other_first_name" :value="__('First Name')" />
                                        <x-text-input id="other_first_name" class="block mt-1 w-full" type="text" name="other_first_name" :value="old('other_first_name', $patient->other_first_name)" />
                                        <x-input-error :messages="$errors->get('other_first_name')" class="mt-2" />
                                    </div>
                            
                                    <!-- Relationship to Patient -->
                                    <div>
                                        <x-input-label for="other_relationship" :value="__('Relationship to Patient')" />
                                        <x-text-input id="other_relationship" class="block mt-1 w-full" type="text" name="other_relationship" :value="old('other_relationship', $patient->other_relationship)" />
                                        <x-input-error :messages="$errors->get('other_relationship')" class="mt-2" />
                                    </div>
                                </div>
                            
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-4">
                                    <!-- Region -->
                                    <div>
                                        <x-input-label for="other_region" :value="__('Region')" />
                                        <x-text-input id="other_region" class="block mt-1 w-full" type="text" name="other_region" :value="old('other_region', $patient->other_region)" autocomplete="address-level1" />
                                        <x-input-error :messages="$errors->get('other_region')" class="mt-2" />
                                    </div>
                            
                                    <!-- Province -->
                                    <div>
                                        <x-input-label for="other_province" :value="__('Province')" />
                                        <x-text-input id="other_province" class="block mt-1 w-full" type="text" name="other_province" :value="old('other_province', $patient->other_province)" autocomplete="address-level2" />
                                        <x-input-error :messages="$errors->get('other_province')" class="mt-2" />
                                    </div>
                            
                                    <!-- City -->
                                    <div>
                                        <x-input-label for="other_city" :value="__('City')" />
                                        <x-text-input id="other_city" class="block mt-1 w-full" type="text" name="other_city" :value="old('other_city', $patient->other_city)" autocomplete="address-level3" />
                                        <x-input-error :messages="$errors->get('other_city')" class="mt-2" />
                                    </div>
                            
                                    <!-- Barangay -->
                                    <div>
                                        <x-input-label for="other_barangay" :value="__('Barangay')" />
                                        <x-text-input id="other_barangay" class="block mt-1 w-full" type="text" name="other_barangay" :value="old('other_barangay', $patient->other_barangay)" autocomplete="address-level4" />
                                        <x-input-error :messages="$errors->get('other_barangay')" class="mt-2" />
                                    </div>
                            
                                    <!-- Zip Code -->
                                    <div>
                                        <x-input-label for="other_zip_code" :value="__('Zip Code')" />
                                        <x-text-input id="other_zip_code" class="block mt-1 w-full" type="text" name="other_zip_code" :value="old('other_zip_code', $patient->other_zip_code)" autocomplete="postal-code" />
                                        <x-input-error :messages="$errors->get('other_zip_code')" class="mt-2" />
                                    </div>
                                </div>
                            
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                    <!-- Home Phone -->
                                    <div>
                                        <x-input-label for="other_home_phone" :value="__('Home Phone')" />
                                        <x-text-input id="other_home_phone" class="block mt-1 w-full" type="text" name="other_home_phone" :value="old('other_home_phone', $patient->other_home_phone)" autocomplete="tel-home" />
                                        <x-input-error :messages="$errors->get('other_home_phone')" class="mt-2" />
                                    </div>
                            
                                    <!-- Work Phone -->
                                    <div>
                                        <x-input-label for="other_work_phone" :value="__('Work Phone')" />
                                        <x-text-input id="other_work_phone" class="block mt-1 w-full" type="text" name="other_work_phone" :value="old('other_work_phone', $patient->other_work_phone)" autocomplete="tel-work" />
                                        <x-input-error :messages="$errors->get('other_work_phone')" class="mt-2" />
                                    </div>
                            
                                    <!-- Other Phone -->
                                    <div>
                                        <x-input-label for="other_other_phone" :value="__('Other Phone')" />
                                        <x-text-input id="other_other_phone" class="block mt-1 w-full" type="text" name="other_other_phone" :value="old('other_other_phone', $patient->other_other_phone)" />
                                        <x-input-error :messages="$errors->get('other_other_phone')" class="mt-2" />
                                        <div class="mt-2 flex flex-wrap gap-x-4">
                                            <input type="hidden" name="other_other_phone_cell" value="0">
                                            <label for="other_other_phone_cell" class="inline-flex items-center">
                                                <input id="other_other_phone_cell" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-clinic-green-dark shadow-sm focus:ring-clinic-green-dark dark:focus:ring-clinic-green-dark dark:focus:ring-offset-gray-800" name="other_other_phone_cell" value="1" {{ old('other_other_phone_cell', $patient->other_other_phone_cell) ? 'checked' : '' }}>
                                                <span class="ms-2 text-sm text-gray-400">Cell</span>
                                            </label>
                                            <input type="hidden" name="other_other_phone_pager" value="0">
                                            <label for="other_other_phone_pager" class="inline-flex items-center">
                                                <input id="other_other_phone_pager" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-clinic-green-dark shadow-sm focus:ring-clinic-green-dark dark:focus:ring-clinic-green-dark dark:focus:ring-offset-gray-800" name="other_other_phone_pager" value="1" {{ old('other_other_phone_pager', $patient->other_other_phone_pager) ? 'checked' : '' }}>
                                                <span class="ms-2 text-sm text-gray-400">Pager</span>
                                            </label>
                                            <input type="hidden" name="other_other_phone_fax" value="0">
                                            <label for="other_other_phone_fax" class="inline-flex items-center">
                                                <input id="other_other_phone_fax" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-clinic-green-dark shadow-sm focus:ring-clinic-green-dark dark:focus:ring-clinic-green-dark dark:focus:ring-offset-gray-800" name="other_other_phone_fax" value="1" {{ old('other_other_phone_fax', $patient->other_other_phone_fax) ? 'checked' : '' }}>
                                                <span class="ms-2 text-sm text-gray-400">Fax</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="mt-6 flex justify-end">
                            <x-secondary-button type="button" x-on:click="show = false">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                    
                            <x-primary-button class="ms-3" type="submit">
                                {{ __('Save') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </x-modal>
        </div>
    </div>
</x-patient-layout>