@section('title', 'AICS Records')

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('AICS Records') }}
            </h2>
        </div>
    </x-slot>

    <div class="pb-4 flex justify-end">
        <x-button variant="success" size="sm" x-on:click="$dispatch('open-modal', 'add-beneficiary')">
            <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
            </svg>
            Add New Beneficiary
        </x-button>

        <x-modal name="add-beneficiary" maxWidth="2xl">
            <div class="max-h-full flex flex-col">
                <div class="p-4 flex justify-between items-center bg-blue-600">
                    <h2 class="text-md font-medium text-white dark:text-gray-100">AICS ID Application Form</h2>
                    <button type="button" class="text-white hover:bg-blue-500 p-2 rounded-md" x-on:click="$dispatch('close')">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                        </svg>
                    </button>
                </div>

                <div id="addContainer" class="overflow-y-auto px-4 pt-2 pb-4">
                    <form id="addBeneficiary" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="flex flex-col items-center justify-center space-y-2">
                            <!-- Image Preview -->
                            <img src="/images/default_photo.png" id="preview" alt="Photo" class="w-24 h-24 object-cover bg-gray-300 dark:bg-gray-400" />

                            <!-- Custom Label/Button -->
                            <label for="photo" class="text-sm flex items-center cursor-pointer px-2 py-1 border border-gray-800 rounded text-gray-700 dark:text-gray-400 hover:border-gray-400 hover:bg-gray-200 dark:border-gray-600 dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 mr-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2M8 9l4-5 4 5m1 8h.01"/>
                                </svg>
                                Upload 2x2 Photo
                            </label>

                            <!-- Hidden File Input (using your Blade component) -->
                            <input type="file" id="photo" name="photo" accept="image/*" class="hidden" />
                        </div>

                        <div class="p-4 rounded border border-gray-800 dark:border-gray-600 space-y-4">
                            <h3 class="text-blue-600 dark:text-blue-400">Personal Information</h3>

                            {{-- Full Name --}}
                            <div class="grid grid-cols-3 grid-rows-1 gap-2">
                                <div>
                                    <x-form.label
                                        for="first_name"
                                        class="block"
                                    >
                                        First Name
                                        <sup class="text-red-500">*</sup>
                                    </x-form.label>
                                    <x-form.input
                                        id="first_name"
                                        class="w-full"
                                        type="text"
                                        name="first_name"
                                        placeholder="First Name"
                                        required
                                    />
                                </div>

                                <div>
                                    <x-form.label
                                        for="middle_name"
                                        class="block"
                                    >
                                        Middle Name
                                    </x-form.label>
                                    <x-form.input
                                        id="middle_name"
                                        class="w-full"
                                        type="text"
                                        name="middle_name"
                                        placeholder="Middle Name"
                                    />
                                </div>

                                <div>
                                    <x-form.label
                                        for="last_name"
                                        class="block"
                                    >
                                        Last Name
                                        <sup class="text-red-500">*</sup>
                                    </x-form.label>
                                    <x-form.input
                                        id="last_name" 
                                        class="w-full"
                                        type="text"
                                        name="last_name"
                                        placeholder="Last Name"
                                        required
                                    />
                                </div>
                            </div>

                            {{-- Address --}}
                            <h3 class="text-blue-600 dark:text-blue-400">Address</h3>

                            <div class="grid grid-cols-3 grid-rows-1 gap-2">
                                <div>
                                    <x-form.label
                                        for="house_no_unit_floor"
                                        class="block"
                                    >
                                        House No./Unit/Floor
                                    </x-form.label>
                                    <x-form.input
                                        id="house_no_unit_floor" 
                                        class="w-full"
                                        type="text"
                                        name="house_no_unit_floor"
                                        placeholder="House No./Unit/Floor"
                                    />
                                </div>

                                <div>
                                    <x-form.label
                                        for="street"
                                        class="block"
                                    >
                                        Street
                                    </x-form.label>
                                    <x-form.input
                                        id="street"
                                        class="w-full"
                                        type="text"
                                        name="street"
                                        placeholder="Street"
                                    />
                                </div>

                                <div>
                                    <x-form.label
                                        for="barangay"
                                        class="block"
                                    >
                                        Barangay
                                        <sup class="text-red-500">*</sup>
                                    </x-form.label>
                                    <x-form.select 
                                        name="barangay" 
                                        id="barangay" 
                                        class="w-full"
                                        required
                                    >
                                        <option value="" selected disabled>Select</option>
                                        <option value="Bangkal">Bangkal</option>
                                        <option value="Calaylayan">Calaylayan</option>
                                        <option value="Capitangan">Capitangan</option>
                                        <option value="Gabon">Gabon</option>
                                        <option value="Laon">Laon</option>
                                        <option value="Mabatang">Mabatang</option>
                                        <option value="Omboy">Omboy</option>
                                        <option value="Salian">Salian</option>
                                        <option value="Wawa">Wawa</option>
                                    </x-form.select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 grid-rows-1 gap-2">
                                <div>
                                    <x-form.label
                                        for="city_municipality"
                                        class="block"
                                    >
                                        City/Municipality
                                        <sup class="text-red-500">*</sup>
                                    </x-form.label>
                                    <x-form.input
                                        id="city_municipality"
                                        class="w-full"
                                        type="text"
                                        name="city_municipality"
                                        placeholder="Province"
                                        value="Abucay"
                                        required
                                        readonly
                                    />
                                </div>

                                <div>
                                    <x-form.label
                                        for="province"
                                        class="block"
                                    >
                                        Province
                                        <sup class="text-red-500">*</sup>
                                    </x-form.label>
                                    <x-form.input
                                        id="province"
                                        class="w-full"
                                        type="text"
                                        name="province"
                                        placeholder="Province"
                                        value="Bataan"
                                        required
                                        readonly
                                    />
                                </div>
                            </div>

                            {{-- Other Info --}}
                            <div class="grid grid-cols-2 grid-rows-1 gap-2">
                                <div>
                                    <x-form.label
                                        for="date_of_birth"
                                        class="block"
                                    >
                                        Date of Birth
                                        <sup class="text-red-500">*</sup>
                                    </x-form.label>
                                    <x-form.input
                                        id="date_of_birth"
                                        class="w-full"
                                        type="date"
                                        name="date_of_birth"
                                        required
                                    />
                                </div>

                                <div>
                                    <x-form.label
                                        for="place_of_birth"
                                        class="block"
                                    >
                                        Place of Birth
                                        <sup class="text-red-500">*</sup>
                                    </x-form.label>
                                    <x-form.input
                                        id="place_of_birth"
                                        class="w-full"
                                        type="text"
                                        name="place_of_birth"
                                        placeholder="Place of Birth"
                                        required
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-3 grid-rows-1 gap-2">
                                <div>
                                    <x-form.label
                                        for="age"
                                        class="block"
                                    >
                                        Age
                                        <sup class="text-red-500">*</sup>
                                    </x-form.label>
                                    <x-form.input
                                        id="age"
                                        class="w-full"
                                        type="number"
                                        name="age"
                                        placeholder="Age"
                                        required
                                        readonly
                                    />
                                </div>

                                <div>
                                    <x-form.label
                                        for="sex"
                                        class="block"
                                    >
                                        Sex
                                        <sup class="text-red-500">*</sup>
                                    </x-form.label>
                                    <x-form.select 
                                        name="sex" 
                                        id="sex" 
                                        class="w-full"
                                        required
                                    >
                                        <option value="" selected disabled>Select</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </x-form.select>
                                </div>

                                <div>
                                    <x-form.label
                                        for="civil_status"
                                        class="block"
                                    >
                                        Civil Status
                                        <sup class="text-red-500">*</sup>
                                    </x-form.label>
                                    <x-form.select 
                                        name="civil_status" 
                                        id="civil_status" 
                                        class="w-full"
                                        required
                                    >
                                        <option value="" selected disabled>Select</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Widowed">Widowed</option>
                                        <option value="Separated">Separated</option>
                                    </x-form.select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 grid-rows-1 gap-2">
                                <div>
                                    <x-form.label
                                        for="educational_attainment"
                                        class="block"
                                    >
                                        Educational Attainment
                                    </x-form.label>
                                    <x-form.select 
                                        name="educational_attainment" 
                                        id="educational_attainment" 
                                        class="w-full"
                                        required
                                    >
                                        <option value="" selected disabled>Select</option>
                                        <option value="No Formal Education">No formal Education</option>
                                        <option value="Elementary Undergraduate">Elementary Undergraduate</option>
                                        <option value="Elementary Graduate">Elementary Graduate</option>
                                        <option value="High School Undergraduate">High School Undergraduate</option>
                                        <option value="High School Graduate">High School Graduate</option>
                                        <option value="Vocational Graduate">Vocational Graduate</option>
                                        <option value="College Undergraduate">College Undergraduate</option>
                                        <option value="College Graduate">College Graduate</option>
                                        <option value="Post Graduate">Post Graduate</option>
                                    </x-form.select>
                                </div>

                                <div>
                                    <x-form.label
                                        for="occupation"
                                        class="block"
                                    >
                                        Occupation
                                    </x-form.label>
                                    <x-form.input
                                        id="occupation"
                                        class="w-full"
                                        type="text"
                                        name="occupation"
                                        placeholder="Occupation"
                                    />
                                </div>
                            </div>

                            <div>
                                <x-form.label
                                    for="cellphone_number"
                                    class="block"
                                >
                                    Cellphone Number
                                    <sup class="text-red-500">*</sup>
                                </x-form.label>
                                <x-form.input
                                    id="cellphone_number"
                                    class="w-full"
                                    type="tel"
                                    name="cellphone_number"
                                    placeholder="e.g. 09123456789"
                                    pattern="^09\d{9}$"
                                    maxlength="11"
                                    inputmode="numeric"
                                />
                            </div>
                        </div>

                        {{-- Problem Assessment --}}
                        <div class="p-4 rounded border border-gray-800 dark:border-gray-600 space-y-4">
                            <h3 class="text-blue-600 dark:text-blue-400">PROBLEM ASSESSMENT</h3>

                            <div class="space-y-4">
                                <div>
                                    <x-form.label
                                        for="nature_of_problem"
                                        class="block"
                                    >
                                        Nature of Problem
                                        <sup class="text-red-500">*</sup>
                                    </x-form.label>
                                    <x-form.select 
                                        name="nature_of_problem" 
                                        id="nature_of_problem" 
                                        class="w-full"
                                        required
                                    >
                                        <option value="" selected disabled>Select</option>
                                        <option value="Medical">Medical</option>
                                        <option value="Financial">Financial</option>
                                        <option value="Educational">Educational</option>
                                        <option value="Burial">Burial</option>
                                        <option value="Transportation">Transportation</option>
                                        <option value="Food">Food</option>
                                        <option value="Others">Others</option>
                                    </x-form.select>
                                </div>

                                <div>
                                    <x-form.label
                                        for="problem_description"
                                        class="block"
                                    >
                                        Problem Description
                                        <sup class="text-red-500">*</sup>
                                    </x-form.label>
                                    <x-form.textarea
                                        id="problem_description"
                                        class="w-full"
                                        name="problem_description"
                                        placeholder="Problem Description"
                                        rows="4"
                                    ></x-form.textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <x-button type="submit" variant="success" class="ml-2">Save</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </x-modal>
    </div>

    <div class="p-6 overflow-y-auto bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div id="statusContainer">
            <label>
                Status Filter:
                <select id="statusFilter" class="dark:bg-dark-eval-1 rounded-sm border border-gray-400 py-1 pl-4 pr-8">
                    <option value="">All</option>
                    <option value="Eligible">Eligible</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Expired">Expired</option>
                    <option value="Not Eligible">Not Eligible</option>
                </select>
            </label>
        </div>

        <table id="aics_records" class="text-sm border border-gray-500 display nowrap" style="width:100%">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th>Name</th>
                    <th>Date Created</th>
                    <th>Address</th>
                    <th>Sex</th>
                    <th>Contact No.</th>
                    <th>AICS ID</th>
                    <th>Status</th>
                    <th>Eligibility</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>

        <x-modal name="view" maxWidth="2xl">
            <div x-data="{ tab: 'personal_details' }" x-show="true"  @open-modal.window="if ($event.detail === 'view') tab = 'personal_details'" class="max-h-full flex flex-col">
                <div class="p-4 flex justify-between items-center bg-blue-600">
                    <h2 class="text-md font-medium text-white dark:text-gray-100">AICS ID Beneficiary Information</h2>
                    <button type="button" class="text-white hover:bg-blue-500 p-2 rounded-md" x-on:click="$dispatch('close')">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                        </svg>
                    </button>
                </div>

                {{-- View Modal Navigation --}}
                <div class="bg-white dark:bg-dark-eval-1 flex items-center justify-center space-x-8 p-4 text-sm shadow-md">
                    <button @click="tab = 'personal_details'" :class="{ 'border-b-2 border-blue-600 dark:border-white text-blue-600 dark:text-white': tab === 'personal_details' }" class="pb-1">Personal Details</button>
                    <button @click="tab = 'requirements'" :class="{ 'border-b-2 border-blue-600 dark:border-white text-blue-600 dark:text-white': tab === 'requirements' }" class="pb-1">Requirements</button>
                    <button @click="tab = 'family_composition'" :class="{ 'border-b-2 border-blue-600 dark:border-white text-blue-600 dark:text-white': tab === 'family_composition' }" class="pb-1">Family Composition</button>
                    <button @click="tab = 'assistance_history'" :class="{ 'border-b-2 border-blue-600 dark:border-white text-blue-600 dark:text-white': tab === 'assistance_history' }" class="pb-1">Assistance History</button>
                </div>

                {{-- View Modal Navigation Content --}}
                <div class="overflow-y-auto">
                    {{-- Personal Details page --}}
                    <div x-show="tab === 'personal_details'" x-cloak>
                        <div id="aics_info" class="grid grid-cols-2 gap-4 p-6">
                            <div class="space-y-4">
                                <div class="flex flex-col items-center justify-center space-y-4">
                                    <img id="aics_photo" class="w-24 h-24 object-cover bg-gray-300 dark:bg-gray-400 rounded-full shadow" />
                                    <p class="text-sm text-white bg-blue-500 px-2 py-1">AICS ID: <strong><span id="aics_id"></span></strong></p>
                                </div>
                                <div class="flex items-center justify-start gap-6">
                                    <div>
                                        <x-form.label class="block">First Name</x-form.label>
                                        <h3 id="aics_first_name" class="font-semibold"></h3>
                                    </div>
                                    <div>
                                        <x-form.label class="block">Last Name</x-form.label>
                                        <h3 id="aics_last_name" class="font-semibold"></h3>
                                    </div>
                                </div>
                                <div>
                                    <x-form.label class="block">Complete Address</x-form.label>
                                    <span id="aics_address" class="font-semibold"></span>
                                </div>
                                <div class="flex items-center justify-start gap-6">
                                    <div>
                                        <x-form.label class="block">Date of Birth</x-form.label>
                                        <h3 id="aics_date_of_birth" class="font-semibold"></h3>
                                    </div>
                                    <div>
                                        <x-form.label class="block">Sex</x-form.label>
                                        <h3 id="aics_sex" class="font-semibold"></h3>
                                    </div>
                                </div>
                                <div>
                                    <x-form.label class="block">Cellphone Number</x-form.label>
                                    <span id="aics_cellphone_number" class="font-semibold"></span>
                                </div>
                                <div>
                                    <x-form.label class="block">Date Added</x-form.label>
                                    <span id="aics_created_at" class="font-semibold"></span>
                                </div>
                            </div>
                            <div>
                                <img id="qr-code-image" src="" alt="QR Code" class="w-40 h-40">
                            </div>
                        </div>
                    </div>

                    {{-- Requirements page --}}
                    <div x-show="tab === 'requirements'" x-cloak>
                        <div class="pl-6 pr-6 pt-4 pb-4">
                            <p class="text-sm font-semibold text-gray-600 pb-2">Requirements Status</p>

                            <div class="space-y-2">
                                <div class="w-full p-4 border flex items-center justify-between">
                                    <div>
                                        <p class="text-sm">VALID ID</p>
                                        <p class="text-xs">Last updated</p>
                                    </div>
                                    
                                    <div>
                                        <x-form.select 
                                            name="valid_id"
                                            id="valid_id"
                                            class=""
                                            size="sm"
                                        >
                                            <option value="" selected disabled>Select</option>
                                            <option value="complete">Complete</option>
                                            <option value="denied">Denied</option>
                                        </x-form.select>
                                    </div>
                                </div>

                                <div class="w-full p-4 border flex items-center justify-between">
                                    <div>
                                        <p class="text-sm">Medical Certificate</p>
                                        <p class="text-xs">Last updated</p>
                                    </div>
                                    
                                    <div>
                                        <x-form.select 
                                            name="medical_certificate"
                                            id="medical_certificate"
                                            class=""
                                            size="sm"
                                        >
                                            <option value="" selected disabled>Select</option>
                                            <option value="complete">Complete</option>
                                            <option value="denied">Denied</option>
                                        </x-form.select>
                                    </div>
                                </div>

                                <div class="w-full p-4 border flex items-center justify-between">
                                    <div>
                                        <p class="text-sm">Barangay Certificate</p>
                                        <p class="text-xs">Last updated</p>
                                    </div>
                                    
                                    <div>
                                        <x-form.select 
                                            name="barangay_certificate"
                                            id="barangay_certificate"
                                            class=""
                                            size="sm"
                                        >
                                            <option value="" selected disabled>Select</option>
                                            <option value="complete">Complete</option>
                                            <option value="denied">Denied</option>
                                        </x-form.select>
                                    </div>
                                </div>

                                <div class="w-full p-4 border flex items-center justify-between">
                                    <div>
                                        <p class="text-sm">Birth Certificate</p>
                                        <p class="text-xs">Last updated</p>
                                    </div>
                                    
                                    <div>
                                        <x-form.select 
                                            name="birth_certificate"
                                            id="birth_certificate"
                                            class=""
                                            size="sm"
                                        >
                                            <option value="" selected disabled>Select</option>
                                            <option value="complete">Complete</option>
                                            <option value="denied">Denied</option>
                                        </x-form.select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pr-6 text-xs flex items-center justify-end space-x-2">
                            <button class="px-4 py-2 border-2 text-blue-600 border-blue-600">Print Details</button>
                            <button class="px-4 py-2 border-2 text-green-600 border-green-600">Edit Record</button>
                            <button class="px-4 py-2 border-2 text-red-600 border-red-600">Delete Record</button>
                        </div>
                    </div>

                    {{-- Family Composition page --}}
                    <div x-show="tab === 'family_composition'" x-cloak>
                        <div class="pl-6 pr-6 pt-4 pb-6">
                            <div class="flex items-center justify-between pb-4">
                                <p class="text-sm font-semibold text-gray-600 pb-2">Family Member</p>
                                <button x-on:click="$dispatch('open-modal', 'add-family-member')" class="text-sm flex items-center px-2 py-1 border-2 text-blue-600 border-blue-600">
                                    <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                                    </svg>
                                    Add Member
                                </button>

                                {{-- Add member modal --}}
                                <x-modal name="add-family-member" maxWidth="md">
                                    <div class="max-h-full flex flex-col">
                                        <div class="p-4 flex justify-between items-center bg-blue-600">
                                            <h2 class="text-md font-medium text-white dark:text-gray-100">Add Member</h2>
                                            <button type="button" class="text-white hover:bg-blue-500 p-2 rounded-md" x-on:click="$dispatch('close')">
                                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                                                </svg>
                                            </button>
                                        </div>

                                        <div id="addFamilyMemberContainer" class="overflow-y-auto p-4">
                                            <form id="addFamilyMemberForm" method="POST">
                                                @csrf
                                                <input type="hidden" name="aics_record_id" id="aics_record_id">
                                                <div class="space-y-4">
                                                    <div>
                                                        <x-form.label
                                                            for="family_member_name"
                                                        >
                                                            Name
                                                            <sup class="text-red-500">*</sup>
                                                        </x-form.label>
                                                        <x-form.input
                                                            id="family_member_name"
                                                            class="w-full"
                                                            type="text"
                                                            name="family_member_name"
                                                            placeholder="Name"
                                                            required
                                                        />
                                                    </div>
                                                    <div>
                                                        <x-form.label
                                                            for="relationship"
                                                        >
                                                            Relationship
                                                            <sup class="text-red-500">*</sup>
                                                        </x-form.label>
                                                        <x-form.select id="relationship" name="relationship" required >
                                                            <option value="" disabled selected>Select</option>
                                                            <option value="Great-grandfather">Great-grandfather</option>
                                                            <option value="Great-grandmother">Great-grandmother</option>
                                                            <option value="Great-grandson">Great-grandson</option>
                                                            <option value="Great-granddaughter">Great-granddaughter</option>
                                                            <option value="GrandFather">Grand Father</option>
                                                            <option value="GrandMother">Grand Mother</option>
                                                            <option value="Grandson">Grandson</option>
                                                            <option value="Granddaughter">Granddaughter</option>
                                                            <option value="Father">Father</option>
                                                            <option value="Mother">Mother</option>
                                                            <option value="Spouse">Spouse</option>
                                                            <option value="Uncle">Uncle</option>
                                                            <option value="Auntie">Auntie</option>
                                                            <option value="Brother">Brother</option>
                                                            <option value="Sister">Sister</option>
                                                            <option value="Son">Son</option>
                                                            <option value="Daughter">Daughter</option>
                                                            <option value="Nephew">Nephew</option>
                                                            <option value="Niece">Niece</option>
                                                            <option value="Cousin">Cousin</option>
                                                            <option value="Father-in-law">Father-in-law</option>
                                                            <option value="Mother-in-law">Mother-in-law</option>
                                                            <option value="Brother-in-law">Brother-in-law</option>
                                                            <option value="Sister-in-law">Sister-in-law</option>
                                                            <option value="Son-in-law">Son-in-law</option>
                                                            <option value="Daughter-in-law">Daughter-in-law</option>
                                                            <option value="Stepfather">Stepfather</option>
                                                            <option value="Stepmother">Stepmother</option>
                                                            <option value="Stepbrother">Stepbrother</option>
                                                            <option value="Stepsister">Stepsister</option>
                                                            <option value="Half-brother">Half-brother</option>
                                                            <option value="Half-sister">Half-sister</option>
                                                        </x-form.select>
                                                    </div>
                                                    <div class="grid grid-cols-2 grid-rows-1 gap-4">
                                                        <div>
                                                            <x-form.label
                                                                for="family_member_age"
                                                            >
                                                                Age
                                                                <sup class="text-red-500">*</sup>
                                                            </x-form.label>
                                                            <x-form.input
                                                                id="family_member_age"
                                                                class="w-full"
                                                                type="number"
                                                                name="family_member_age"
                                                                min="1"
                                                                step="1"
                                                                placeholder="Age"
                                                                required
                                                            />
                                                        </div>
                                                        <div>
                                                            <x-form.label
                                                                for="family_member_civil_status"
                                                                class="block"
                                                            >
                                                                Civil Status
                                                                <sup class="text-red-500">*</sup>
                                                            </x-form.label>
                                                            <x-form.select 
                                                                name="family_member_civil_status" 
                                                                id="family_member_civil_status" 
                                                                class="w-full"
                                                                required
                                                            >
                                                                <option value="" selected disabled>Select</option>
                                                                <option value="Single">Single</option>
                                                                <option value="Married">Married</option>
                                                                <option value="Divorced">Divorced</option>
                                                                <option value="Widowed">Widowed</option>
                                                                <option value="Separated">Separated</option>
                                                            </x-form.select>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <x-form.label
                                                            for="family_member_educational_attainment"
                                                            class="block"
                                                        >
                                                            Educational Attainment
                                                            <sup class="text-red-500">*</sup>
                                                        </x-form.label>
                                                        <x-form.select 
                                                            name="family_member_educational_attainment" 
                                                            id="family_member_educational_attainment" 
                                                            class="w-full"
                                                            required
                                                        >
                                                            <option value="" selected disabled>Select</option>
                                                            <option value="No Formal Education">No formal Education</option>
                                                            <option value="Elementary Undergraduate">Elementary Undergraduate</option>
                                                            <option value="Elementary Graduate">Elementary Graduate</option>
                                                            <option value="High School Undergraduate">High School Undergraduate</option>
                                                            <option value="High School Graduate">High School Graduate</option>
                                                            <option value="Vocational Graduate">Vocational Graduate</option>
                                                            <option value="College Undergraduate">College Undergraduate</option>
                                                            <option value="College Graduate">College Graduate</option>
                                                            <option value="Post Graduate">Post Graduate</option>
                                                        </x-form.select>
                                                    </div>
                                                    <div>
                                                        <x-form.label
                                                            for="family_member_occupation"
                                                            class="block"
                                                        >
                                                            Occupation
                                                            <sup class="text-red-500">*</sup>
                                                        </x-form.label>
                                                        <x-form.input
                                                            id="family_member_occupation"
                                                            class="w-full"
                                                            type="text"
                                                            name="family_member_occupation"
                                                            placeholder="Occupation"
                                                            required
                                                        />
                                                    </div>
                                                    <div>
                                                        <x-form.label
                                                            for="family_member_monthly_income"
                                                            class="block"
                                                        >
                                                            Monthly Income
                                                            <sup class="text-red-500">*</sup>
                                                        </x-form.label>
                                                        <x-form.input
                                                            id="family_member_monthly_income"
                                                            class="w-full"
                                                            type="number"
                                                            name="family_member_monthly_income"
                                                            min="1"
                                                            step="1"
                                                            placeholder="e.g. 10000"
                                                            required
                                                        />
                                                    </div>
                                                </div>
                                                <div class="mt-6 flex justify-end">
                                                    <x-button type="submit" variant="success" class="ml-2">Add</x-button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </x-modal>
                            </div>
                            <div class="space-y-6">
                                <div class="w-full h-full">
                                    <table id="family_member" class="display text-xs border border-gray-400 dark:border-gray-600" style="width:100%">
                                        <thead class="bg-gray-200 dark:bg-dark-eval-1">
                                            <tr>
                                                <th>NAME</th>
                                                <th>RELATIONSHIP</th>
                                                <th>AGE</th>
                                                <th>STATUS</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="text-xs flex items-center justify-end space-x-2">
                                    <button class="px-4 py-2 border-2 text-blue-600 border-blue-600">Print Details</button>
                                    <button class="px-4 py-2 border-2 text-green-600 border-green-600">Edit Record</button>
                                    <button class="px-4 py-2 border-2 text-red-600 border-red-600">Delete Record</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Assistance History page --}}
                    <div x-show="tab === 'assistance_history'" x-cloak>
                        <div class="pl-6 pr-6 pt-4 pb-6">
                            <div class="flex items-center justify-between pb-4">
                                <p class="text-sm font-semibold text-gray-600 pb-2">Payout History</p>
                                <button x-on:click="$dispatch('open-modal', 'add-payout')" class="text-sm flex items-center px-2 py-1 border-2 text-blue-600 border-blue-600">
                                    <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                                    </svg>
                                    Add Payout
                                </button>

                                {{-- Add payout modal --}}
                                <x-modal name="add-payout" height="fit" maxWidth="xs">
                                    <div class="flex flex-col">
                                        <div class="sticky top-0 z-10 p-4 flex justify-between items-center bg-blue-600">
                                            <h2 class="text-md font-medium text-white dark:text-gray-100">Add Payout</h2>
                                            <button type="button" class="text-white hover:bg-blue-500 p-2 rounded-md" x-on:click="$dispatch('close')">
                                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="p-4">
                                            <form id="addPayoutForm" method="POST">
                                                @csrf

                                                <input type="hidden" name="aics_record_id_payout" id="aics_record_id_payout">

                                                <div class="space-y-4">
                                                    <div>
                                                        <x-form.label
                                                            for="amount"
                                                        >
                                                            Amount
                                                            <sup class="text-red-500">*</sup>
                                                        </x-form.label>
                                                        <x-form.input type="number" name="amount" id="amount" min="1" step="1" class="w-full" placeholder="e.g. 1000" required />
                                                    </div>

                                                    <div>
                                                        <x-form.label
                                                            for="type"
                                                        >
                                                            Type
                                                            <sup class="text-red-500">*</sup>
                                                        </x-form.label>
                                                        <x-form.input type="text" name="type" id="type" class="w-full" required readonly />
                                                    </div>

                                                    <div>
                                                        <x-form.label
                                                            for="claimed_by"
                                                        >
                                                            Claimed By
                                                            <sup class="text-red-500">*</sup>
                                                        </x-form.label>
                                                        <x-form.select name="claimed_by" id="claimed_by" required></x-form.select>
                                                    </div>
                                                </div>

                                                <div class="mt-6 flex justify-end">
                                                    <x-button type="submit" variant="success" class="ml-2">Add</x-button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </x-modal>
                            </div>
                            <div class="space-y-6">
                                <div class="w-full h-full">
                                    <table id="payout_history" class="display text-xs border border-gray-400 dark:border-gray-600" style="width:100%">
                                        <thead class="bg-gray-200 dark:bg-dark-eval-1">
                                            <tr>
                                                <th>DATE</th>
                                                <th>AMOUNT</th>
                                                <th>TYPE</th>
                                                <th>CLAIMED BY</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="text-xs flex items-center justify-end space-x-2">
                                    <button class="px-4 py-2 border-2 text-blue-600 border-blue-600">Print Details</button>
                                    <button class="px-4 py-2 border-2 text-green-600 border-green-600">Edit Record</button>
                                    <button class="px-4 py-2 border-2 text-red-600 border-red-600">Delete Record</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-modal>
    </div>
</x-app-layout>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.11/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.11/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(event) {
        const img = document.getElementById('preview');
        img.src = event.target.result;
        img.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    });

    document.querySelectorAll('#cellphone_number, #family_member_monthly_income, #family_member_age, #amount').forEach(el => {
        el.addEventListener('keydown', function(e) {
            const allowedKeys = ['Backspace', 'ArrowLeft', 'ArrowRight', 'Tab', 'Delete', 'Home', 'End'];

            if (!((e.key >= '0' && e.key <= '9') || allowedKeys.includes(e.key))) {
                e.preventDefault();
            }
        });
    });
</script>

{{-- Auto calculate age using date of birth --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const birthdateInput = document.getElementById('date_of_birth');
        const ageInput = document.getElementById('age');

        // Calculate age based on date of birth
        function calculateAge(birthDate) {
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
                
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            return age;
        }

        birthdateInput.addEventListener('change', function() {
            const birthDate = new Date(this.value);
            ageInput.value = calculateAge(birthDate);
        });

        // Trigger age calculation on page load if birthday is already set
        if (birthdateInput.value) {
            birthdateInput.dispatchEvent(new Event('change'));
        }
    });
</script>

{{-- Fetch all beneficiaries --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let table = new DataTable('#aics_records', {
            ajax: {
                url: '/aics/records/data',
                dataSrc: 'data'
            },
            ordering: false,
            columns: [
                { data: 'name' },
                { data: 'created_at' },
                { data: 'address' },
                { data: 'sex' },
                { data: 'cellphone_number' },
                { data: 'aics_id' },
                { data: 'status' },
                { data: 'eligibility' },
                {
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `
                            <x-button 
                                variant="primary"
                                size="sm"
                                data-id="${row.id}"
                                data-photo="${row.photo}"
                                data-first_name="${row.first_name}"
                                data-last_name="${row.last_name}"
                                data-barangay="${row.barangay}"
                                data-city_municipality="${row.city_municipality}"
                                data-province="${row.province}"
                                data-date_of_birth="${row.date_of_birth}"
                                data-sex="${row.sex}"
                                data-cellphone_number="${row.cellphone_number}"
                                data-created_at="${row.created_at}"
                                data-type="${row.nature_of_problem}"
                                data-qr_code="${row.qr_code}"
                                x-on:click="$dispatch('open-modal', 'view')"
                            >
                                <svg class="w-4 h-4 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                    <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                </svg>
                                View
                            </x-button>
                        `;
                    }
                }
            ],
            responsive: true,
            lengthChange: false,
            language: {
                emptyTable: 'No AICS records found.',
                zeroRecords: 'No AICS records found.',
                info: 'Showing _END_ of _TOTAL_ records',
                infoEmpty: 'No entries to show',
                loadingRecords: 'Loading...',
                infoFiltered: '',
                search: 'Search:',
                searchPlaceholder: 'Search beneficiaries...',
                paginate: {
                    first: '',
                    last: '',
                    next: 'Next',
                    previous: 'Previous'
                }
            },
        });

        $('#aics_records_filter').css({
            display: 'flex',
            justifyContent: 'space-between',
            alignItems: 'center',
            width: '100%',
            marginBottom: '10px'
        });

        $('#aics_records_filter').prepend($('#statusContainer'));

        $('#aics_records_filter input[type="search"]').css({
            borderRadius: '0.125rem',
            border: '1px solid #9CA3AF',
            padding: '0.25rem 0 0.25rem 1rem',
        });

        $('#statusFilter').on('change', function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            table.column(6).search(val ? '^' + val + '$' : '', true, false).draw();
        });
    });
</script>

{{-- Add Beneficiary Action --}}
<script>
    $(document).ready(function () {
        $('#addBeneficiary').on('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this); // get the form input data

            $.ajax({
                url: `/aics/records/store`,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            $('#addBeneficiary')[0].reset();
                            $('#addContainer').scrollTop(0);
                            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'add-beneficiary' })); // close the modal
                            $('#aics_records').DataTable().ajax.reload(null, false); // reload the table
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: response.message,
                        });
                    }
                }
            });
        });
    });
</script>

{{-- View display each Beneficiary --}}
<script>
    $(document).on('click', '[data-id]', function () {
        const btn = $(this);

        $('#aics_photo').attr('src', `/beneficiary_photos/${btn.data('photo')}`);
        $('#aics_id').text(`AICS-${String(btn.data('id')).padStart(3, '0')}`);
        $('#aics_first_name').text(btn.data('first_name'));
        $('#aics_last_name').text(btn.data('last_name'));
        $('#aics_address').text(`${btn.data('barangay')}, ${btn.data('city_municipality')}, ${btn.data('province')}`);
        $('#aics_date_of_birth').text(btn.data('date_of_birth'));
        $('#aics_sex').text(btn.data('sex'));
        $('#aics_cellphone_number').text(btn.data('cellphone_number'));
        $('#nature_of_problem').text(btn.data('nature_of_problem'));
        $('#aics_created_at').text(btn.data('created_at'));
        $('#qr-code-image').attr('src', `/qrcodes/${btn.data('qr_code')}`);

        // hidden input for add-family-member
        $('#aics_record_id').val(btn.data('id'));

        // payout form data
        // hidden input for add-payout
        $('#aics_record_id_payout').val(btn.data('id'));

        $('#type').val(btn.data('type'));
        // populate claimed_by select
        const recordId = btn.data('id');
        const fullName = `${btn.data('first_name')} ${btn.data('last_name')}`;
        const $claimedBy = $('#claimed_by');

        $claimedBy.empty();

        $claimedBy.append(`<option value="" disabled selected>Select</option>`);

        // add the beneficiary
        $claimedBy.append(`<option value="${fullName}">${fullName}</option>`);

        // add the family member of beneficiary
        $.get(`/aics/records/${recordId}/family-member`, function (response) {
            response.data.forEach(member => {
                $claimedBy.append(
                    `<option value="${member.family_member_name}">
                        ${member.family_member_name}
                    </option>`
                );
            });
        });
    });
</script>

{{-- Display Family Composition Script --}}
<script>
    $(document).on('click', '[data-id]', function () {
        const id = $(this).data('id');
        $('#family_member').DataTable({
            destroy: true, //remove this//
            ajax: {
                url: `/aics/records/${id}/family-member`,
                dataSrc: 'data'
            },
            ordering: false,
            columns: [
                { data: 'family_member_name' },
                { data: 'relationship' },
                { data: 'family_member_age' },  
                { data: 'family_member_status' },
            ],
            responsive: true,
            lengthChange: false,
            searching: false,
            info: false,
            language: {
                paginate: {
                    first: '',
                    last: '',
                    next: 'Next',
                    previous: 'Previous'
                }
            }
        });
    });
</script>

{{-- Add Family Member Script --}}
<script>
    $(document).ready(function () {
        $('#addFamilyMemberForm').on('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this); // get the form input data
            const newMemberName = $('#family_member_name').val().trim();

            $.ajax({
                url: `/aics/records/store/family-member`,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    const recordId = $('#aics_record_id').val(); // preserve id
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            $('#addFamilyMemberForm')[0].reset(); // reset the form
                            $('#addFamilyMemberContainer').scrollTop(0);
                            $('#aics_record_id').val(recordId); // restore the hidden id input
                            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'add-family-member' })); // close the modal
                            $('#family_member').DataTable().ajax.reload(null, false); // reload the table

                            $('#claimed_by').append(
                                `<option value="${newMemberName}">${newMemberName}</option>`
                            );
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: response.message,
                        });
                    }
                }
            });
        });
    });
</script>

{{-- Display Assistance History Script --}}
<script>
    $(document).on('click', '[data-id]', function () {
        const id = $(this).data('id');
        $('#payout_history').DataTable({
            destroy: true,
            ajax: {
                url: `/aics/records/${id}/payout-histories`,
                dataSrc: 'data'
            },
            ordering: false,
            columns: [
                { data: 'date' },
                { data: 'amount' },
                { data: 'type' },
                { data: 'claimed_by' },
            ],
            responsive: true,
            lengthChange: false,
            searching: false,
            info: false,
            language: {
                paginate: {
                    first: '',
                    last: '',
                    next: 'Next',
                    previous: 'Previous'
                }
            }
        });
    });
</script>

{{-- Add Payout Script --}}
<script>
    $(document).ready(function () {
        $('#addPayoutForm').on('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this); // get the form input data

            $.ajax({
                url: `/aics/records/store/payout`,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    const recordId = $('#aics_record_id_payout').val(); // preserve id
                    const recordType = $('#type').val();  // preserve type
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            $('#addPayoutForm')[0].reset(); // reset the form
                            $('#aics_record_id_payout').val(recordId); // restore the hidden id input
                            $('#type').val(recordType); // restore the type input
                            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'add-payout' })); // close the modal
                            $('#payout_history').DataTable().ajax.reload(null, false); // reload the table
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: response.message,
                        });
                    }
                }
            });
        });
    });
</script>
