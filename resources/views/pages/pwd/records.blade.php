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
                    <button type="button" class="text-white hover:bg-blue-500 p-2 rounded-md" x-on:click="$dispatch('close')">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                        </svg>
                    </button>
                </div>

                <div class="overflow-y-auto px-4 pt-2 pb-4">
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
                                    placeholder="Cellphone Number"
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
                                    placeholder="Contact Number"
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
                    <button type="button" class="text-white hover:bg-blue-500 p-2 rounded-md" x-on:click="$dispatch('close')">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                        </svg>
                    </button>
                </div>

                <div class="overflow-y-auto px-4 pt-2 pb-4">
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
                                    placeholder="Cellphone Number"
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
                                    placeholder="Contact Number"
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
            <div x-data="{ tab: 'personal_details' }" x-show="true"  @open-modal.window="if ($event.detail === 'view') tab = 'personal_details'" class="max-h-full flex flex-col">
                <div class="p-4 flex justify-between items-center bg-blue-600">
                    <h2 class="text-md font-medium text-white dark:text-gray-100">PWD ID Beneficiary Information</h2>
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
                    <button @click="tab = 'assistance_history'" :class="{ 'border-b-2 border-blue-600 dark:border-white text-blue-600 dark:text-white': tab === 'assistance_history' }" class="pb-1">Assistance History</button>
                </div>

                {{-- View Modal Navigation Content --}}
                <div class="overflow-y-auto ">
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
                                        <x-form.label class="block">Sex</x-form.label>
                                        <h3 id="pwd_sex" class="font-semibold"></h3>
                                    </div>
                                </div>
                                <div>
                                    <x-form.label class="block">Cellphone Number</x-form.label>
                                    <span id="pwd_cellphone_number" class="font-semibold"></span>
                                </div>
                                <div>
                                    <x-form.label class="block">Date Added</x-form.label>
                                    <span id="pwd_created_at" class="font-semibold"></span>
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

                    {{-- Assistance History page --}}
                    <div x-show="tab === 'assistance_history'" x-cloak>
                        <div class="pl-6 pr-6 pt-4 pb-6">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-gray-600 pb-2">Payout History</p>
                                <button x-on:click="$dispatch('open-modal', 'add-payout')" class="text-sm flex items-center px-2 py-1 border-2 text-blue-600 border-blue-600">
                                    <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                                    </svg>
                                    Add Payout
                                </button>
                            </div>
                            <div class="space-y-6">
                                <div class="w-full h-full">
                                    <table id="payout_history" class="display text-xs border border-gray-400 dark:border-gray-600 w-full">
                                        <thead class="bg-gray-200 dark:bg-dark-eval-1">
                                            <tr>
                                                <th>DATE</th>
                                                <th>AMOUNT</th>
                                                <th>TYPE</th>
                                                <th>CLAIMED BY</th>
                                                <th>FAMILY MEMBER</th>
                                                <th>REMARKS</th>
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
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                url: `/pwd/records/store`,
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
                            $('#pwd_records').DataTable().ajax.reload(null, false); // reload the table
                            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'add-beneficiary' })); // close the modal
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

{{-- Fetch all beneficiaries --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#pwd_records').DataTable({
            ajax: {
                url: '/pwd/records/data',
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
                                data-sex="${row.sex}"
                                data-cellphone_number="${row.cellphone_number}"
                                data-created_at="${row.created_at}"
                                data-qr_code="${row.qr_code}"
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
            layout: {
                topStart: 'search',
                topEnd: null
            },
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
    });
</script>

{{-- Update Script --}}
<script>
    // Show Update Beneficiary Data
    $(document).on('click', '[data-id]', function () {
        const btn = $(this);

        $('#update_preview').attr('src', `/beneficiary_photos/${btn.data('photo')}`);
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
                url: `/pwd/records/${id}/update`,
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
                            $('#pwd_records').DataTable().ajax.reload(null, false); // reload the table
                            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'update-beneficiary' })); // close the modal
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

        $('#pwd_photo').attr('src', `/beneficiary_photos/${btn.data('photo')}`);
        $('#pwd_id').text(`PWD-${String(btn.data('id')).padStart(3, '0')}`);
        $('#pwd_first_name').text(btn.data('first_name'));
        $('#pwd_last_name').text(btn.data('last_name'));
        $('#pwd_address').text(`${btn.data('barangay')}, ${btn.data('city_municipality')}, ${btn.data('province')}`);
        $('#pwd_type_of_disability').text(btn.data('type_of_disability'));
        $('#pwd_date_of_birth').text(new Date(btn.data('date_of_birth')).toLocaleString('en-PH', { month: 'long', day: 'numeric', year: 'numeric' }));
        $('#pwd_sex').text(btn.data('sex'));
        $('#pwd_cellphone_number').text(btn.data('cellphone_number'));
        $('#pwd_created_at').text(btn.data('created_at'));
        $('#qr-code-image').attr('src', `/qrcodes/${btn.data('qr_code')}`);
    });
</script>

{{-- NOT YET DONE --}}
{{-- Display Assistance History Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#payout_history').DataTable({
            ajax: {
                url: ``,
                dataSrc: 'data'
            },
            // FAKE DATA
            data: [
                {
                    date: 'June 10, 2025',
                    amount: '₱1,500',
                    type: 'Financial Assistance',
                    claimed_by: 'Ana Reyes',
                    family_member: 'John Reyes',
                    remarks: 'Initial Assistance',
                },
                {
                    date: 'May 05, 2025',
                    amount: '₱2,000',
                    type: 'Financial Assistance',
                    claimed_by: 'Carlos Dela Cruz',
                    family_member: 'Maria Dela Cruz',
                    remarks: 'Initial Assistance',
                },
                {
                    date: 'April 15, 2025',
                    amount: '₱1,200',
                    type: 'Financial Assistance',
                    claimed_by: 'Jose Santos',
                    family_member: 'Leo Santos',
                    remarks: 'Initial Assistance',
                },
            ],
            columns: [
                { data: 'date' },
                { data: 'amount' },
                { data: 'type' },
                { data: 'claimed_by' },
                { data: 'family_member' },
                { data: 'remarks' },
            ],
            responsive: true,
            paging: false,
            lengthChange: false,
            searching: false,
            info: false
        });
    });
</script>
