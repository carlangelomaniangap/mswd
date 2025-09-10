@section('title', 'PWD Records')

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('PWD Records') }}
            </h2>
        </div>
    </x-slot>

    {{-- Add Beneficiary --}}
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
                    <h2 class="text-md font-medium text-white dark:text-gray-100">PWD ID Application Form</h2>
                    <button type="button" class="text-white hover:bg-blue-500 p-2 rounded-md" x-on:click="$dispatch('close-modal', 'add-beneficiary')">
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

                            <div>
                                <x-form.label
                                    for="type_of_disability"
                                    class="block"
                                >
                                    Type of Disability
                                    <sup class="text-red-500">*</sup>
                                </x-form.label>
                                <x-form.input
                                    id="type_of_disability"
                                    class="w-full"
                                    type="text"
                                    name="type_of_disability"
                                    placeholder="Type of Disability"
                                    required
                                />
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

                            <div class="grid grid-cols-4 grid-rows-1 gap-2">
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

                                <div>
                                    <x-form.label
                                        for="blood_type"
                                        class="block"
                                    >
                                        Blood Type
                                    </x-form.label>
                                    <x-form.select 
                                        name="blood_type" 
                                        id="blood_type" 
                                        class="w-full"
                                    >
                                        <option value="" selected disabled>Select</option>
                                        <option value="A+">A+</option>
                                        <option value="B+">B+</option>
                                        <option value="AB+">AB+</option>
                                        <option value="O+">O+</option>
                                        <option value="A-">A-</option>
                                        <option value="B-">B-</option>
                                        <option value="AB-">AB-</option>
                                        <option value="O-">O-</option>
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
                                        <option value="No Formal Education">No Formal Education</option>
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

                        {{-- Emergency Contact --}}
                        <div class="p-4 rounded border border-gray-800 dark:border-gray-600 space-y-4">
                            <h3 class="text-blue-600 dark:text-blue-400">IN CASE OF EMERGENCY</h3>

                            <div class="grid grid-cols-3 grid-rows-1 gap-2">
                                <div>
                                    <x-form.label
                                        for="emerg_first_name"
                                        class="block"
                                    >
                                        First Name
                                        <sup class="text-red-500">*</sup>
                                    </x-form.label>
                                    <x-form.input
                                        id="emerg_first_name"
                                        class="w-full"
                                        type="text"
                                        name="emerg_first_name"
                                        placeholder="First Name"
                                        required
                                    />
                                </div>

                                <div>
                                    <x-form.label
                                        for="emerg_middle_name"
                                        class="block"
                                    >
                                        Middle Name
                                    </x-form.label>
                                    <x-form.input
                                        id="emerg_middle_name"
                                        class="w-full"
                                        type="text"
                                        name="emerg_middle_name"
                                        placeholder="Middle Name"
                                    />
                                </div>

                                <div>
                                    <x-form.label
                                        for="emerg_last_name"
                                        class="block"
                                    >
                                        Last Name
                                        <sup class="text-red-500">*</sup>
                                    </x-form.label>
                                    <x-form.input
                                        id="emerg_last_name" 
                                        class="w-full"
                                        type="text"
                                        name="emerg_last_name"
                                        placeholder="Last Name"
                                        required
                                    />
                                </div>
                            </div>

                            <div>
                                <x-form.label
                                    for="emerg_address"
                                    class="block"
                                >
                                    Address
                                    <sup class="text-red-500">*</sup>
                                </x-form.label>
                                <x-form.input
                                    id="emerg_address" 
                                    class="w-full"
                                    type="text"
                                    name="emerg_address"
                                    placeholder="Address"
                                    required
                                />
                            </div>

                            <div>
                                <x-form.label
                                    for="relationship_to_pwd"
                                    class="block"
                                >
                                    Relationship to PWD
                                    <sup class="text-red-500">*</sup>
                                </x-form.label>
                                <x-form.input
                                    id="relationship_to_pwd" 
                                    class="w-full"
                                    type="text"
                                    name="relationship_to_pwd"
                                    placeholder="Relationship to PWD"
                                    required
                                />
                            </div>

                            <div>
                                <x-form.label
                                    for="emerg_contact_number"
                                    class="block"
                                >
                                    Contact Number
                                    <sup class="text-red-500">*</sup>
                                </x-form.label>
                                <x-form.input
                                    id="emerg_contact_number" 
                                    class="w-full"
                                    type="tel"
                                    name="emerg_contact_number"
                                    placeholder="e.g. 09123456789"
                                    pattern="^09\d{9}$"
                                    maxlength="11"
                                    inputmode="numeric"
                                    required
                                />
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

    {{-- Display Beneficiary --}}
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

        <table id="pwd_records" class="text-sm border border-gray-500 display nowrap" style="width:100%">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Sex</th>
                    <th>Contact No.</th>
                    <th>PWD ID</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>

        {{-- Update --}}
        <x-modal name="update-beneficiary" maxWidth="2xl">
            <div class="max-h-full flex flex-col">
                <div class="p-4 flex justify-between items-center bg-blue-600">
                    <h2 class="text-md font-medium text-white dark:text-gray-100">PWD ID Application Form</h2>
                    <button type="button" class="text-white hover:bg-blue-500 p-2 rounded-md" x-on:click="$dispatch('close-modal', 'update-beneficiary')">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                        </svg>
                    </button>
                </div>

                <div id="updateContainer" class="overflow-y-auto px-4 pt-2 pb-4">
                    <form id="updateBeneficiary" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <input type="hidden" id="update_id" name="id">

                        <div class="flex flex-col items-center justify-center space-y-2">
                            <!-- Image Preview -->
                            <img id="update_preview" alt="Photo" class="w-24 h-24 object-cover bg-gray-300 dark:bg-gray-400" />

                            <!-- Custom Label/Button -->
                            <label for="update_photo" class="text-sm flex items-center cursor-pointer px-2 py-1 border border-gray-800 rounded text-gray-700 dark:text-gray-400 hover:border-gray-400 hover:bg-gray-200 dark:border-gray-600 dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 mr-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2M8 9l4-5 4 5m1 8h.01"/>
                                </svg>
                                Upload 2x2 Photo
                            </label>

                            <!-- Hidden File Input (using your Blade component) -->
                            <input type="file" id="update_photo" name="photo" accept="image/*" class="hidden" />
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
                                        id="update_first_name"
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
                                        id="update_middle_name"
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
                                        id="update_last_name" 
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
                                        id="update_house_no_unit_floor" 
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
                                        id="update_street"
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
                                        id="update_barangay" 
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
                                        id="update_city_municipality"
                                        class="w-full"
                                        type="text"
                                        name="city_municipality"
                                        placeholder="Province"
                                        required
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
                                        id="update_province"
                                        class="w-full"
                                        type="text"
                                        name="province"
                                        placeholder="Province"
                                        required
                                    />
                                </div>
                            </div>

                            <div>
                                <x-form.label
                                    for="type_of_disability"
                                    class="block"
                                >
                                    Type of Disability
                                    <sup class="text-red-500">*</sup>
                                </x-form.label>
                                <x-form.input
                                    id="update_type_of_disability"
                                    class="w-full"
                                    type="text"
                                    name="type_of_disability"
                                    placeholder="Type of Disability"
                                    required
                                />
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
                                        id="update_date_of_birth"
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
                                        id="update_place_of_birth"
                                        class="w-full"
                                        type="text"
                                        name="place_of_birth"
                                        placeholder="Place of Birth"
                                        required
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-4 grid-rows-1 gap-2">
                                <div>
                                    <x-form.label
                                        for="age"
                                        class="block"
                                    >
                                        Age
                                        <sup class="text-red-500">*</sup>
                                    </x-form.label>
                                    <x-form.input
                                        id="update_age"
                                        class="w-full"
                                        type="number"
                                        name="age"
                                        placeholder="Age"
                                        required
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
                                        id="update_sex" 
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
                                        id="update_civil_status" 
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

                                <div>
                                    <x-form.label
                                        for="blood_type"
                                        class="block"
                                    >
                                        Blood Type
                                    </x-form.label>
                                    <x-form.select 
                                        name="blood_type" 
                                        id="update_blood_type" 
                                        class="w-full"
                                    >
                                        <option value="" selected disabled>Select</option>
                                        <option value="A+">A+</option>
                                        <option value="B+">B+</option>
                                        <option value="AB+">AB+</option>
                                        <option value="O+">O+</option>
                                        <option value="A-">A-</option>
                                        <option value="B-">B-</option>
                                        <option value="AB-">AB-</option>
                                        <option value="O-">O-</option>
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
                                        id="update_educational_attainment"
                                        class="w-full"
                                        required
                                    >
                                        <option value="" selected disabled>Select</option>
                                        <option value="No Formal Education">No Formal Education</option>
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
                                        id="update_occupation"
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
                                </x-form.label>
                                <x-form.input
                                    id="update_cellphone_number"
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

                        {{-- Emergency Contact --}}
                        <div class="p-4 rounded border border-gray-800 dark:border-gray-600 space-y-4">
                            <h3 class="text-blue-600 dark:text-blue-400">IN CASE OF EMERGENCY</h3>

                            <div class="grid grid-cols-3 grid-rows-1 gap-2">
                                <div>
                                    <x-form.label
                                        for="emerg_first_name"
                                        class="block"
                                    >
                                        First Name
                                        <sup class="text-red-500">*</sup>
                                    </x-form.label>
                                    <x-form.input
                                        id="update_emerg_first_name"
                                        class="w-full"
                                        type="text"
                                        name="emerg_first_name"
                                        placeholder="First Name"
                                        required
                                    />
                                </div>

                                <div>
                                    <x-form.label
                                        for="emerg_middle_name"
                                        class="block"
                                    >
                                        Middle Name
                                    </x-form.label>
                                    <x-form.input
                                        id="update_emerg_middle_name"
                                        class="w-full"
                                        type="text"
                                        name="emerg_middle_name"
                                        placeholder="Middle Name"
                                    />
                                </div>

                                <div>
                                    <x-form.label
                                        for="emerg_last_name"
                                        class="block"
                                    >
                                        Last Name
                                        <sup class="text-red-500">*</sup>
                                    </x-form.label>
                                    <x-form.input
                                        id="update_emerg_last_name" 
                                        class="w-full"
                                        type="text"
                                        name="emerg_last_name"
                                        placeholder="Last Name"
                                        required
                                    />
                                </div>
                            </div>

                            <div>
                                <x-form.label
                                    for="emerg_address"
                                    class="block"
                                >
                                    Address
                                    <sup class="text-red-500">*</sup>
                                </x-form.label>
                                <x-form.input
                                    id="update_emerg_address" 
                                    class="w-full"
                                    type="text"
                                    name="emerg_address"
                                    placeholder="Address"
                                    required
                                />
                            </div>

                            <div>
                                <x-form.label
                                    for="relationship_to_pwd"
                                    class="block"
                                >
                                    Relationship to PWD
                                    <sup class="text-red-500">*</sup>
                                </x-form.label>
                                <x-form.input
                                    id="update_relationship_to_pwd" 
                                    class="w-full"
                                    type="text"
                                    name="relationship_to_pwd"
                                    placeholder="Relationship to PWD"
                                    required
                                />
                            </div>

                            <div>
                                <x-form.label
                                    for="emerg_contact_number"
                                    class="block"
                                >
                                    Contact Number
                                    <sup class="text-red-500">*</sup>
                                </x-form.label>
                                <x-form.input
                                    id="update_emerg_contact_number" 
                                    class="w-full"
                                    type="tel"
                                    name="emerg_contact_number"
                                    placeholder="e.g. 09123456789"
                                    pattern="^09\d{9}$"
                                    maxlength="11"
                                    inputmode="numeric"
                                    required
                                />
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <x-button type="submit" variant="success" class="ml-2">Save</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </x-modal>

        <x-modal name="view" maxWidth="2xl">
            <div x-data="{ tab: 'personal_details' }" x-show="true" @open-modal.window="if ($event.detail === 'view') tab = 'personal_details'" class="flex flex-col h-full">
                <div class="p-4 flex justify-between items-center bg-blue-600">
                    <h2 class="text-md font-medium text-white dark:text-gray-100">PWD ID Beneficiary Information</h2>
                    <button type="button" class="text-white hover:bg-blue-500 p-2 rounded-md" x-on:click="$dispatch('close-modal', 'view')">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                        </svg>
                    </button>
                </div>

                {{-- View Modal Navigation --}}
                <div class="bg-white dark:bg-dark-eval-1 flex items-center justify-center space-x-8 p-4 text-sm shadow-md">
                    <button @click="tab = 'personal_details'" :class="{ 'border-b-2 border-blue-600 dark:border-white text-blue-600 dark:text-white': tab === 'personal_details' }" class="pb-1">Personal Details</button>
                    <button @click="tab = 'requirements'" :class="{ 'border-b-2 border-blue-600 dark:border-white text-blue-600 dark:text-white': tab === 'requirements' }" class="pb-1">Requirements</button>
                </div>

                {{-- View Modal Navigation Content --}}
                <div class="flex-1 overflow-y-auto">
                    {{-- Personal Details page --}}
                    <div x-show="tab === 'personal_details'" x-cloak>
                        <div id="pwd_info" class="grid grid-cols-2 gap-4 p-6">
                            <div class="space-y-4">
                                <div class="flex flex-col items-center justify-center space-y-4">
                                    <img id="pwd_photo" class="w-24 h-24 object-cover bg-gray-300 dark:bg-gray-400 rounded-full shadow" />
                                    <p class="text-sm text-white bg-blue-500 px-2 py-1">PWD ID: <strong><span id="pwd_id"></span></strong></p>
                                </div>
                                <div class="flex items-center justify-start gap-6">
                                    <div>
                                        <x-form.label class="block">First Name</x-form.label>
                                        <h3 id="pwd_first_name" class="font-semibold"></h3>
                                    </div>
                                    <div>
                                        <x-form.label class="block">Last Name</x-form.label>
                                        <h3 id="pwd_last_name" class="font-semibold"></h3>
                                    </div>
                                </div>
                                <div>
                                    <x-form.label class="block">Complete Address</x-form.label>
                                    <span id="pwd_address" class="font-semibold"></span>
                                </div>
                                <div>
                                    <x-form.label class="block">Type of Disability</x-form.label>
                                    <span id="pwd_type_of_disability" class="font-semibold"></span>
                                </div>
                                <div class="flex items-center justify-start gap-6">
                                    <div>
                                        <x-form.label class="block">Date of Birth</x-form.label>
                                        <h3 id="pwd_date_of_birth" class="font-semibold"></h3>
                                    </div>
                                    <div>
                                        <x-form.label class="block">Place of Birth</x-form.label>
                                        <h3 id="pwd_place_of_birth" class="font-semibold"></h3>
                                    </div>
                                </div>
                                <div class="flex items-center justify-start gap-6">
                                    <div>
                                        <x-form.label class="block">Age</x-form.label>
                                        <h3 id="pwd_age" class="font-semibold"></h3>
                                    </div>
                                    <div>
                                        <x-form.label class="block">Sex</x-form.label>
                                        <h3 id="pwd_sex" class="font-semibold"></h3>
                                    </div>
                                    <div>
                                        <x-form.label class="block">Civil Status</x-form.label>
                                        <h3 id="pwd_civil_status" class="font-semibold"></h3>
                                    </div>
                                    <div>
                                        <x-form.label class="block">Blood Type</x-form.label>
                                        <h3 id="pwd_blood_type" class="font-semibold"></h3>
                                    </div>
                                </div>
                                <div class="flex items-center justify-start gap-6">
                                    <div>
                                        <x-form.label class="block">Educational Attainment</x-form.label>
                                        <h3 id="pwd_educational_attainment" class="font-semibold"></h3>
                                    </div>
                                    <div>
                                        <x-form.label class="block">Occupation</x-form.label>
                                        <h3 id="pwd_occupation" class="font-semibold"></h3>
                                    </div>
                                </div>
                                <div>
                                    <x-form.label class="block">Cellphone Number</x-form.label>
                                    <span id="pwd_cellphone_number" class="font-semibold"></span>
                                </div>
                                
                                <h1>INCASE OF EMERGENCY</h1>
                                <div class="flex items-center justify-start gap-6">
                                    <div>
                                        <x-form.label class="block">First Name</x-form.label>
                                        <h3 id="pwd_emerg_first_name" class="font-semibold"></h3>
                                    </div>
                                    <div>
                                        <x-form.label class="block">Last Name</x-form.label>
                                        <h3 id="pwd_emerg_last_name" class="font-semibold"></h3>
                                    </div>
                                </div>
                                <div>
                                    <x-form.label class="block">Address</x-form.label>
                                    <span id="pwd_emerg_address" class="font-semibold"></span>
                                </div>
                                <div>
                                    <x-form.label class="block">Relationship to PWD</x-form.label>
                                    <span id="pwd_relationship_to_pwd" class="font-semibold"></span>
                                </div>
                                <div>
                                    <x-form.label class="block">Contact Number</x-form.label>
                                    <span id="pwd_emerg_contact_number" class="font-semibold"></span>
                                </div>
                                <div>
                                    <x-form.label class="block">Date Added</x-form.label>
                                    <span id="pwd_created_at" class="font-semibold"></span>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-center justify-center">
                                    <img id="pwd_qr_code" alt="QR Code" class="w-40 h-40 object-cover">
                                </div>

                                <div class="flex items-center justify-center">
                                    <x-button x-on:click="$dispatch('open-modal', 'print-as-id')">
                                        Print as ID
                                    </x-button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Requirements page --}}
                    <div x-show="tab === 'requirements'" x-cloak>
                        <div class="p-6">
                            <p class="text-sm font-semibold text-gray-600 dark:text-white">Requirements Status</p>

                            <form id="Requirements" class="space-y-2">
                                @csrf
                                <input type="hidden" id="pwd_requirement_id" name="pwd_requirement_id">

                                <div class="w-full p-4 flex items-center justify-between">
                                    <div>
                                        <p class="text-sm">VALID ID</p>
                                        <p id="valid_id_expires_at" class="text-xs"></p>
                                    </div>
                                    
                                    <div>
                                        <x-form.select 
                                            name="valid_id"
                                            id="valid_id"
                                            size="sm"
                                        >
                                            <option value="" selected disabled>Select</option>
                                            <option value="Complete">Complete</option>
                                            <option value="Incomplete" hidden>Incomplete</option>
                                            <option value="Renewal" hidden>Renewal</option>
                                            <option value="Denied">Denied</option>
                                        </x-form.select>
                                    </div>
                                </div>

                                <div class="w-full p-4 flex items-center justify-between">
                                    <div>
                                        <p class="text-sm">Medical Certificate</p>
                                        <p id="medical_certificate_expires_at" class="text-xs"></p>
                                    </div>
                                    
                                    <div>
                                        <x-form.select 
                                            name="medical_certificate"
                                            id="medical_certificate"
                                            size="sm"
                                        >
                                            <option value="" selected disabled>Select</option>
                                            <option value="Complete">Complete</option>
                                            <option value="Incomplete" hidden>Incomplete</option>
                                            <option value="Renewal" hidden>Renewal</option>
                                            <option value="Denied">Denied</option>
                                        </x-form.select>
                                    </div>
                                </div>

                                <div class="w-full p-4 flex items-center justify-between">
                                    <div>
                                        <p class="text-sm">Barangay Certificate</p>
                                        <p id="barangay_certificate_expires_at" class="text-xs"></p>
                                    </div>
                                    
                                    <div>
                                        <x-form.select 
                                            name="barangay_certificate"
                                            id="barangay_certificate"
                                            size="sm"
                                        >
                                            <option value="" selected disabled>Select</option>
                                            <option value="Complete">Complete</option>
                                            <option value="Incomplete" hidden>Incomplete</option>
                                            <option value="Renewal" hidden>Renewal</option>
                                            <option value="Denied">Denied</option>
                                        </x-form.select>
                                    </div>
                                </div>

                                <div class="w-full p-4 flex items-center justify-between">
                                    <div>
                                        <p class="text-sm">Birth Certificate</p>
                                        <p id="birth_certificate_expires_at" class="text-xs"></p>
                                    </div>
                                    
                                    <div>
                                        <x-form.select 
                                            name="birth_certificate"
                                            id="birth_certificate"
                                            size="sm"
                                        >
                                            <option value="" selected disabled>Select</option>
                                            <option value="Complete">Complete</option>
                                            <option value="Incomplete" hidden>Incomplete</option>
                                            <option value="Renewal" hidden>Renewal</option>
                                            <option value="Denied">Denied</option>
                                        </x-form.select>
                                    </div>
                                </div>

                                <div class="pt-2 flex justify-end">
                                    <x-button id="EditBtn" type="submit" variant="primary">Update</x-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </x-modal>
        
        {{-- Print as ID modal --}}
        <x-modal name="print-as-id" height="fit" maxWidth="3xl">
            <div class="p-4 flex justify-between items-center bg-blue-600">
                <h2 class="text-md font-medium text-white dark:text-gray-100">PWD ID Card</h2>
                <button type="button" class="text-white hover:bg-blue-500 p-2 rounded-md" x-on:click="$dispatch('close-modal', 'print-as-id')">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                    </svg>
                </button>
            </div>

            <div class="p-4">
                <div class="flex justify-center gap-6">
                    {{-- Front ID --}}
                    <div class="space-y-2">
                        <h3 class="font-bold text-xs text-gray-700 dark:text-white">FRONT</h3>
                        <div class="w-[358px] h-[228px] bg-white text-black rounded-lg shadow-md border p-4">
                            <div class="flex space-x-2">
                                <img id="id_card_photo" alt="ID Card Photo" class="w-12 h-12 object-cover bg-gray-300">
                                <h3 id="id_card_name" class="text-lg font-bold"></h3>
                                <img src="{{asset('images/mswd_logo.png')}}" alt="Logo" class="w-12 h-12 object-cover">
                            </div>

                            <div class="text-xs mt-2">
                                <strong class="font-semibold">PWD ID:</strong>
                                <span id="id_card_pwd_id"></span>
                            </div>
                            <div class="text-xs mt-1">
                                <strong class="font-semibold">ADDRESS:</strong>
                                <span id="id_card_address"></span>
                            </div>
                            <div class="text-xs mt-1">
                                <strong class="font-semibold">SEX:</strong>
                                <span id="id_card_sex"></span>
                            </div>
                            <div class="text-xs mt-1">
                                <strong class="font-semibold">CONTACT NO:</strong>
                                <span id="id_card_contact_number"></span>
                            </div>

                            <div class="text-xs mt-1">
                                <strong class="font-semibold">BIRTHDAY:</strong>
                                <span id="id_card_birthday"></span>
                            </div>
                            <div class="text-xs mt-1">
                                <strong class="font-semibold">TYPE OF DISABILITY:</strong>
                                <span id="id_card_type_of_disability"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Back ID --}}
                    <div class="space-y-2">
                        <h3 class="font-bold text-xs text-gray-700 dark:text-white">BACK</h3>
                        <div class="w-[358px] h-[228px] grid grid-cols-2 gap-4 bg-white text-black rounded-lg shadow-md border p-4">
                            <div class="flex items-center justify-center">
                                <img id="id_card_qr_code" alt="QR Code" class="w-36 h-36 object-cover">
                            </div>
                            <div class="flex flex-col items-center justify-center">
                                <p class="text-[10px] text-justify">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa fuga eligendi perferendis possimus dolor voluptates modi error minima, nam vel sed commodi sint debitis.</p>

                                <div class="mt-6">
                                    <div class="border-b border-black w-32"></div>
                                        <p class="text-center text-xs mt-1">Signature</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center mt-6">
                        <x-button id="btnPrintID">Print</x-button>
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
    document.querySelectorAll('#cellphone_number, #emerg_contact_number,#update_cellphone_number, #update_emerg_contact_number').forEach(el => {
        el.addEventListener('keydown', function(e) {
            const allowedKeys = ['Backspace', 'ArrowLeft', 'ArrowRight', 'Tab', 'Delete', 'Home', 'End'];

            if (!((e.key >= '0' && e.key <= '9') || allowedKeys.includes(e.key))) {
                e.preventDefault();
            }
        });
    });
</script>

{{-- Add Beneficiary Form Script --}}
<script>
    // Display photo
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

    // Add Beneficiary Action
    $(document).ready(function () {
        $('#addBeneficiary').on('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this); // get the form input data

            $.ajax({
                url: `/admin/pwd/store`,
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
                            $('#preview').attr('src', '/images/default_photo.png');
                            $('#addContainer').scrollTop(0);
                            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'add-beneficiary' })); // close the modal
                            $('#pwd_records').DataTable().ajax.reload(null, false); // reload the table
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

{{-- Auto calculate age using date of birth --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function calculateAge(birthDate) {
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            return age >= 0 ? age : '';
        }

        // Add form
        const birthdateInput = document.getElementById('date_of_birth');
        const ageInput = document.getElementById('age');
        if (birthdateInput && ageInput) {
            birthdateInput.addEventListener('change', function() {
                ageInput.value = calculateAge(new Date(this.value));
            });
            if (birthdateInput.value) {
                ageInput.value = calculateAge(new Date(birthdateInput.value));
            }
        }

        // Update form
        const updateBirthdateInput = document.getElementById('update_date_of_birth');
        const updateAgeInput = document.getElementById('update_age');
        if (updateBirthdateInput && updateAgeInput) {
            updateBirthdateInput.addEventListener('change', function() {
                updateAgeInput.value = calculateAge(new Date(this.value));
            });
            if (updateBirthdateInput.value) {
                updateAgeInput.value = calculateAge(new Date(updateBirthdateInput.value));
            }
        }
    });
</script>

{{-- Fetch all beneficiaries --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#pwd_records').DataTable({
            ajax: {
                url: '/admin/pwd/data',
                dataSrc: 'data'
            },
            ordering: false,
            columns: [
                { data: 'name' },
                { data: 'address' },
                { data: 'sex' },
                { data: 'cellphone_number' },
                { data: 'pwd_id' },
                { data: 'status' },
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
                                data-type_of_disability="${row.type_of_disability}"
                                data-date_of_birth="${row.date_of_birth}"
                                data-place_of_birth="${row.place_of_birth}" 
                                data-age="${row.age}"
                                data-sex="${row.sex}"
                                data-civil_status="${row.civil_status}"
                                data-blood_type="${row.blood_type}"
                                data-educational_attainment="${row.educational_attainment}"
                                data-occupation="${row.occupation}"
                                data-cellphone_number="${row.cellphone_number}"
                                data-emerg_first_name="${row.emerg_first_name}"
                                data-emerg_last_name="${row.emerg_last_name}"
                                data-emerg_address="${row.emerg_address}"
                                data-relationship_to_pwd="${row.relationship_to_pwd}"
                                data-emerg_contact_number="${row.emerg_contact_number}"
                                data-created_at="${row.created_at}"
                                data-qr_code="${row.qr_code}"
                                data-valid_id="${row.valid_id}"
                                data-valid_id_expires_at="${row.valid_id_expires_at}"
                                data-medical_certificate="${row.medical_certificate}"
                                data-medical_certificate_expires_at="${row.medical_certificate_expires_at}"
                                data-barangay_certificate="${row.barangay_certificate}"
                                data-barangay_certificate_expires_at="${row.barangay_certificate_expires_at}"
                                data-birth_certificate="${row.birth_certificate}"
                                data-birth_certificate_expires_at="${row.birth_certificate_expires_at}"
                                x-on:click="$dispatch('open-modal', 'view')"
                            >
                                <svg class="w-4 h-4 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                    <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                </svg>
                                View
                            </x-button>

                            <x-button
                                variant="success"
                                size="sm"
                                data-id="${row.id}"
                                data-photo="${row.photo}"
                                data-first_name="${row.first_name}"
                                data-middle_name="${row.middle_name}"
                                data-last_name="${row.last_name}"
                                data-house_no_unit_floor="${row.house_no_unit_floor}"
                                data-street="${row.street}"
                                data-barangay="${row.barangay}"
                                data-city_municipality="${row.city_municipality}"
                                data-province="${row.province}"
                                data-type_of_disability="${row.type_of_disability}"
                                data-date_of_birth="${row.date_of_birth}"
                                data-place_of_birth="${row.place_of_birth}"
                                data-age="${row.age}"
                                data-sex="${row.sex}"
                                data-civil_status="${row.civil_status}"
                                data-blood_type="${row.blood_type}"
                                data-educational_attainment="${row.educational_attainment}"
                                data-occupation="${row.occupation}"
                                data-cellphone_number="${row.cellphone_number}"
                                data-emerg_first_name="${row.emerg_first_name}"
                                data-emerg_middle_name="${row.emerg_middle_name}"
                                data-emerg_last_name="${row.emerg_last_name}"
                                data-emerg_address="${row.emerg_address}"
                                data-relationship_to_pwd="${row.relationship_to_pwd}"
                                data-emerg_contact_number="${row.emerg_contact_number}"
                                x-on:click="$dispatch('open-modal', 'update-beneficiary')"
                            >
                                <svg class="w-4 h-4 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                </svg>
                                Edit
                            </x-button>
                        `;
                    }
                }
            ],
            responsive: true,
            lengthChange: false,
            language: {
                emptyTable: 'No PWD records found.',
                zeroRecords: 'No PWD records found.',
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

        $('#pwd_records_filter').css({
            display: 'flex',
            justifyContent: 'space-between',
            alignItems: 'center',
            width: '100%',
            marginBottom: '10px'
        });

        $('#pwd_records_filter').prepend($('#statusContainer'));

        $('#pwd_records_filter input[type="search"]').css({
            borderRadius: '0.125rem',
            border: '1px solid #9CA3AF',
            padding: '0.25rem 0 0.25rem 1rem',
        });

        $('#statusFilter').on('change', function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            $('#pwd_records').DataTable().column(5).search(val ? '^' + val + '$' : '', true, false).draw();
        });
    });
</script>

{{-- Update Script --}}
<script>
    // Show Update Beneficiary Data
    $(document).on('click', '[data-id]', function () {
        const btn = $(this);

        $('#update_preview').attr('src', btn.data('photo'));
        $('#update_id').val(btn.data('id'));
        $('#update_first_name').val(btn.data('first_name'));
        $('#update_middle_name').val(btn.data('middle_name'));
        $('#update_last_name').val(btn.data('last_name'));
        $('#update_house_no_unit_floor').val(btn.data('house_no_unit_floor'));
        $('#update_street').val(btn.data('street'));
        $('#update_barangay').val(btn.data('barangay'));
        $('#update_city_municipality').val(btn.data('city_municipality'));
        $('#update_province').val(btn.data('province'));
        $('#update_type_of_disability').val(btn.data('type_of_disability'));
        $('#update_date_of_birth').val(btn.data('date_of_birth'));
        $('#update_place_of_birth').val(btn.data('place_of_birth'));
        $('#update_age').val(btn.data('age'));
        $('#update_sex').val(btn.data('sex'));
        $('#update_civil_status').val(btn.data('civil_status'));
        $('#update_blood_type').val(btn.data('blood_type'));
        $('#update_educational_attainment').val(btn.data('educational_attainment'));
        $('#update_occupation').val(btn.data('occupation'));
        $('#update_cellphone_number').val(btn.data('cellphone_number'));
        $('#update_emerg_first_name').val(btn.data('emerg_first_name'));
        $('#update_emerg_middle_name').val(btn.data('emerg_middle_name'));
        $('#update_emerg_last_name').val(btn.data('emerg_last_name'));
        $('#update_emerg_address').val(btn.data('emerg_address'));
        $('#update_relationship_to_pwd').val(btn.data('relationship_to_pwd'));
        $('#update_emerg_contact_number').val(btn.data('emerg_contact_number'));
    });

    // Update Beneficiary Action
    $(document).ready(function () {
        $('#updateBeneficiary').on('submit', function (e) {
            e.preventDefault();

            const id = $('#update_id').val(); // get hidden id input
            const formData = new FormData(this); // get the form input data

            $.ajax({
                url: `/admin/pwd/${id}/update`,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            $('#updateContainer').scrollTop(0);
                            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'update-beneficiary' })); // close the modal
                            $('#pwd_records').DataTable().ajax.reload(null, false); // reload the table
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

    // Change the photo preview in update form
    document.getElementById('update_photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(event) {
        const img = document.getElementById('update_preview');
        img.src = event.target.result;
        img.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    });
</script>

{{-- View display each Beneficiary --}}
<script>
    $(document).on('click', '[data-id]', function () {
        const btn = $(this);

        $('#pwd_photo').attr('src', btn.data('photo'));
        $('#pwd_id').text(`PWD-${String(btn.data('id')).padStart(3, '0')}`);
        $('#pwd_first_name').text(btn.data('first_name'));
        $('#pwd_last_name').text(btn.data('last_name'));
        $('#pwd_address').text(`${btn.data('barangay')}, ${btn.data('city_municipality')}, ${btn.data('province')}`);
        $('#pwd_type_of_disability').text(btn.data('type_of_disability'));
        $('#pwd_date_of_birth').text(new Date(btn.data('date_of_birth')).toLocaleString('en-PH', { month: 'long', day: 'numeric', year: 'numeric' }));
        $('#pwd_place_of_birth').text(btn.data('place_of_birth'));
        $('#pwd_age').text(btn.data('age'));
        $('#pwd_sex').text(btn.data('sex'));
        $('#pwd_civil_status').text(btn.data('civil_status'));
        $('#pwd_blood_type').text(btn.data('blood_type'));
        $('#pwd_educational_attainment').text(btn.data('educational_attainment'));
        $('#pwd_occupation').text(btn.data('occupation'));
        $('#pwd_cellphone_number').text(btn.data('cellphone_number'));
        $('#pwd_emerg_first_name').text(btn.data('emerg_first_name'));
        $('#pwd_emerg_last_name').text(btn.data('emerg_last_name'));
        $('#pwd_emerg_address').text(btn.data('emerg_address'));
        $('#pwd_relationship_to_pwd').text(btn.data('relationship_to_pwd'));
        $('#pwd_emerg_contact_number').text(btn.data('emerg_contact_number'));
        $('#pwd_created_at').text(btn.data('created_at'));
        $('#pwd_qr_code').attr('src', btn.data('qr_code'));

        $('#pwd_requirement_id').val(btn.data('id'));
        $('#valid_id').val(btn.data('valid_id'));
        $('#valid_id_expires_at').text(btn.data('valid_id_expires_at'));
        $('#medical_certificate').val(btn.data('medical_certificate'));
        $('#medical_certificate_expires_at').text(btn.data('medical_certificate_expires_at'));
        $('#barangay_certificate').val(btn.data('barangay_certificate'));
        $('#barangay_certificate_expires_at').text(btn.data('barangay_certificate_expires_at'));
        $('#birth_certificate').val(btn.data('birth_certificate'));
        $('#birth_certificate_expires_at').text(btn.data('birth_certificate_expires_at'));

        const containerStyles = {
            'Complete': 'bg-green-100 border-2 border-green-500',
            'Incomplete': 'bg-yellow-100 border-2 border-yellow-500',
            'Renewal': 'bg-orange-100 border-2 border-orange-500',
            'Denied': 'bg-red-100 border-2 border-red-500'
        };

        const statusStyles = {
            'Complete': 'bg-white px-2 py-1 border-2 border-green-500 rounded',
            'Incomplete': 'bg-white px-2 py-1 border-2 border-yellow-500 rounded',
            'Renewal': 'bg-white px-2 py-1 border-2 border-orange-500 rounded',
            'Denied': 'bg-white px-2 py-1 border-2 border-red-500 rounded'
        };

        const textStyles = {
            'Complete': 'text-green-700',
            'Incomplete': 'text-yellow-700',
            'Renewal': 'text-orange-700',
            'Denied': 'text-red-700'
        };

        // apply styles to each requirement
        ['valid_id','medical_certificate','barangay_certificate','birth_certificate'].forEach(key => {
            const value = $(`#${key}`).val();
            const container = $(`#${key}`).closest('div.w-full.p-4');
            const label = $(`#${key}_expires_at`).prev();
            const expiresAt = $(`#${key}_expires_at`);
            const select = $(`#${key}`);

            container.addClass(`w-full p-4 ${containerStyles[value]} flex items-center justify-between`);
            label.attr('class', `text-sm ${textStyles[value]}`);
            expiresAt.addClass(`text-xs ${textStyles[value]}`);
            select.addClass(`${textStyles[value]} font-semibold ${statusStyles[value]}`);
        });

        $('#id_card_photo').attr('src', btn.data('photo'));
        $('#id_card_name').text(`${btn.data('first_name')} ${btn.data('last_name')}`);
        $('#id_card_pwd_id').text(`PWD-${String(btn.data('id')).padStart(3, '0')}`);
        $('#id_card_address').text(`${btn.data('barangay')}, ${btn.data('city_municipality')}, ${btn.data('province')}`);
        $('#id_card_sex').text(btn.data('sex'));
        $('#id_card_contact_number').text(btn.data('cellphone_number'));
        $('#id_card_birthday').text(new Date(btn.data('date_of_birth')).toLocaleString('en-PH', { month: 'long', day: 'numeric', year: 'numeric' }));
        $('#id_card_type_of_disability').text(btn.data('type_of_disability'));
        $('#id_card_qr_code').attr('src', btn.data('qr_code'));

        $('#btnPrintID')
        .data('id', btn.data('id'))
        .data('beneficiary', 'pwd')
        .data('first_name', btn.data('first_name'))
        .data('last_name', btn.data('last_name'))
        .data('address', `${btn.data('barangay')}, ${btn.data('city_municipality')}, ${btn.data('province')}`)
        .data('date_of_birth', btn.data('date_of_birth'))
        .data('sex', btn.data('sex'))
        .data('cellphone_number', btn.data('cellphone_number'))
        .data('qr_code', btn.data('qr_code'));
    });

    $('#btnPrintID').on('click', function () {
        const recordID = $(this).data('id');
        const beneficiary = $(this).data('beneficiary');

        if (!recordID) {
            alert('Cannot print: record not found.');
            return;
        }

        const type = 'PWD';

        const id = `${type}-${String(recordID).padStart(3, '0')}`;

        window.open(`/admin/${beneficiary}/print_id_card?id=${id}`, '_blank');
    });
</script>

{{-- Update Requirements Script --}}
<script>
    $(document).ready(function () {
        // Store the original form values before editing
        let originalValues = getFormValues();

        // Function to get the current form values as an object
        function getFormValues() {
            return {
                valid_id: $('#valid_id').val(),
                medical_certificate: $('#medical_certificate').val(),
                barangay_certificate: $('#barangay_certificate').val(),
                birth_certificate: $('#birth_certificate').val(),
            };
        }

        // Disable the Update button on page load
        $('#EditBtn').prop('disabled', true);

        // Check the old value if it has changes
        $('#valid_id, #medical_certificate, #barangay_certificate, #birth_certificate').on('input change', function () {
            const currentValues = getFormValues();
            if (JSON.stringify(currentValues) !== JSON.stringify(originalValues)) {
                $('#EditBtn').prop('disabled', false); // Enable the button update
            } else {
                $('#EditBtn').prop('disabled', true); // Disabled the button update
            }
        });

        $('#Requirements').on('submit', function (e) {
            e.preventDefault();

            const id = $('#pwd_requirement_id').val(); // get hidden id input
            const formData = new FormData(this); // get the form input data

            $.ajax({
                url: `/admin/pwd/${id}/update/requirements`,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $('#valid_id_expires_at').text(response.requirement.valid_id_expires_at);
                        $('#medical_certificate_expires_at').text(response.requirement.medical_certificate_expires_at);
                        $('#barangay_certificate_expires_at').text(response.requirement.barangay_certificate_expires_at);
                        $('#birth_certificate_expires_at').text(response.requirement.birth_certificate_expires_at);

                        const containerStyles = {
                            'Complete': 'bg-green-100 border-2 border-green-500',
                            'Incomplete': 'bg-yellow-100 border-2 border-yellow-500',
                            'Renewal': 'bg-orange-100 border-2 border-orange-500',
                            'Denied': 'bg-red-100 border-2 border-red-500'
                        };

                        const statusStyles = {
                            'Complete': 'border-green-500',
                            'Incomplete': 'border-yellow-500',
                            'Renewal': 'border-orange-500',
                            'Denied': 'border-red-500'
                        };

                        const textStyles = {
                            'Complete': 'text-green-700',
                            'Incomplete': 'text-yellow-700',
                            'Renewal': 'text-orange-700',
                            'Denied': 'text-red-700'
                        };

                        // apply styles to each requirement
                        ['valid_id','medical_certificate','barangay_certificate','birth_certificate'].forEach(key => {
                            const value = $(`#${key}`).val();
                            const container = $(`#${key}`).closest('div.w-full.p-4');
                            const label = $(`#${key}_expires_at`).prev();
                            const expiresAt = $(`#${key}_expires_at`);
                            const select = $(`#${key}`);

                            container.attr('class', `w-full p-4 ${containerStyles[value]} flex items-center justify-between`);
                            label.attr('class', `text-sm ${textStyles[value]}`);
                            expiresAt.attr('class', `text-xs ${textStyles[value]}`);
                            
                            select.removeClass(Object.values(statusStyles).join(' ') + ' ' + Object.values(textStyles).join(' '))
                                .addClass(`${statusStyles[value]} ${textStyles[value]}`);
                        });

                        $('#EditBtn').prop('disabled', true); // Disabled the button update
                        $('#pwd_records').DataTable().ajax.reload(null, false); // reload the Beneficiary table
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
