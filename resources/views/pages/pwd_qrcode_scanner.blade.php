<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PWD Record Data</title>
    <link rel="icon" href="{{ asset('images/mswd_logo.png') }}" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        [x-cloak] {
            display: none;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div
        x-data="mainState"
        :class="{ dark: isDarkMode }"
        x-on:resize.window="handleWindowResize"
        x-cloak
    >
        <div class="min-h-screen text-gray-900 bg-gray-100 dark:bg-dark-eval-0 dark:text-gray-200">
            <header
                class="sticky top-0 z-10 transition-transform duration-500 bg-white dark:bg-dark-eval-1"
                :class="{
                    '-translate-y-full': scrollingDown,
                    'translate-y-0': scrollingUp,
                }"
            >
                <div class="p-4 flex items-center justify-between">
                    <h1 class="font-bold text-2xl">PWD Record Data</h1>

                    <x-button
                        type="button"
                        class="hidden md:inline-flex"
                        icon-only
                        variant="secondary"
                        sr-text="Toggle dark mode"
                        x-on:click="toggleTheme"
                    >
                        <x-heroicon-o-moon
                            x-show="!isDarkMode"
                            aria-hidden="true"
                            class="w-6 h-6"
                        />

                        <x-heroicon-o-sun
                            x-show="isDarkMode"
                            aria-hidden="true"
                            class="w-6 h-6"
                        />
                    </x-button>
                </div>
            </header>

            <main class="p-4 sm:p-6 flex-1 mx-auto w-full max-w-4xl">
                <div class="space-y-4">
                    <div class="bg-white dark:bg-dark-eval-1 shadow rounded p-4">
                            {{-- Benefeciary details --}}
                        <h3 class="font-bold text-lg pb-4">Personal Details</h3>

                        <div class="grid grid-cols-3 grid-rows-1 gap-4">
                            <div class="flex flex-col items-center gap-4">
                                <img id="photo" alt="Photo" class="w-32 h-32 object-cover rounded border">
                                <img id="qr_code" alt="QR Code" class="w-32 h-32 object-cover rounded border">
                                <div><strong>PWD ID:</strong> <span id="aics_id">Loading...</span></div>
                            </div>

                            <div class="col-span-2">
                                <div class="flex flex-col items-center text-center pb-2">
                                    <div id="full_name" class="w-full border-gray-400 mb-1">Loading...</div>
                                    <strong class="w-full border-t border-gray-400">
                                        Full Name
                                    </strong>
                                </div>

                                <div class="flex flex-col items-center text-center pb-2">
                                    <div id="address" class="w-full border-gray-400 mb-1">Loading...</div>
                                    <strong class="w-full border-t border-gray-400">
                                        Address
                                    </strong>
                                </div>

                                <div class="flex flex-col items-center text-center pb-2">
                                    <div id="type_of_disability" class="w-full border-gray-400 mb-1">Loading...</div>
                                    <strong class="w-full border-t border-gray-400">
                                        Type of Disability
                                    </strong>
                                </div>

                                <div class="flex flex-row items-center text-center gap-4 pb-2">
                                    <div class="flex flex-col items-center text-center flex-1">
                                        <div id="date_of_birth" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                        Date of Birth
                                        </strong>
                                    </div>

                                    <div class="flex flex-col items-center text-center flex-1">
                                        <div id="place_of_birth" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                        Place of Birth
                                        </strong>
                                    </div>
                                </div>

                                <div class="flex flex-row items-center text-center gap-4 pb-2">
                                    <div class="flex flex-col items-center text-center flex-1">
                                        <div id="age" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                        Age
                                        </strong>
                                    </div>

                                    <div class="flex flex-col items-center text-center flex-1">
                                        <div id="sex" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                        Sex
                                        </strong>
                                    </div>

                                    <div class="flex flex-col items-center text-center flex-1">
                                        <div id="civil_status" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                        Civil Status
                                        </strong>
                                    </div>

                                    <div class="flex flex-col items-center text-center flex-1">
                                        <div id="blood_type" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                        Blood Type
                                        </strong>
                                    </div>
                                </div>

                                <div class="flex flex-row items-center text-center gap-4 pb-2">
                                    <div class="flex flex-col items-center text-center flex-1">
                                        <div id="educational_attainment" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                            Educational Attainment
                                        </strong>
                                    </div>

                                    <div class="flex flex-col items-center text-center flex-1">
                                        <div id="occupation" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                            Occupation
                                        </strong>
                                    </div>
                                </div>

                                <div class="flex flex-col items-center text-center pb-2">
                                    <div id="cellphone_number" class="w-full border-gray-400 mb-1">Loading...</div>
                                    <strong class="w-full border-t border-gray-400">
                                        Cellphone Number
                                    </strong>
                                </div>

                                <span><h3 class="font-bold text-lg py-4">INCASE OF EMERGENCY</h3></span>

                                <div class="flex flex-col items-center text-center pb-2">
                                    <div id="emerg_full_name" class="w-full border-gray-400 mb-1">Loading...</div>
                                    <strong class="w-full border-t border-gray-400">
                                        Full Name
                                    </strong>
                                </div>

                                <div class="flex flex-col items-center text-center pb-2">
                                    <div id="emerg_address" class="w-full border-gray-400 mb-1">Loading...</div>
                                    <strong class="w-full border-t border-gray-400">
                                        Address
                                    </strong>
                                </div>

                                <div class="flex flex-row items-center text-center gap-4 pb-2">
                                    <div class="flex flex-col items-center text-center flex-1">
                                        <div id="relationship_to_pwd" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                            Relationship to PWD
                                        </strong>
                                    </div>

                                    <div class="flex flex-col items-center text-center flex-1">
                                        <div id="emerg_contact_number" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                            Contact Number
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-dark-eval-1 shadow rounded p-4">
                        {{-- Requirements --}}
                        <h3 class="font-bold text-lg pb-4">Requirements</h3>
                        <div class="pb-4"><strong>Status:</strong> <span id="status"></span></div>
                        <div id="requirementsContainer" class="space-y-4"></div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>

<script>
    $(document).ready(function() {
        let id = "{{ $recordId }}";
        if(id) fetchRecord(id);

        function fetchRecord(id) {
            $.ajax({
                url: `/pwd/record/data/scan/${id}`,
                type: 'GET',
                success: function(res) {
                    if(res.success){
                        let data = res.data;

                        $('#photo').attr('src', data.photo);
                        $('#qr_code').attr('src', data.qr_code);
                        $('#aics_id').text(`PWD-${String(data.id).padStart(3, '0')}`);
                        $('#full_name').text([data.first_name, data.middle_name, data.last_name].filter(Boolean).join(' '));
                        $('#address').text([data.house_no_unit_floor, data.street, data.barangay, data.city_municipality, data.province].filter(Boolean).join(', '));
                        $('#type_of_disability').text(data.type_of_disability);
                        $('#date_of_birth').text(data.date_of_birth);
                        $('#place_of_birth').text(data.place_of_birth);
                        $('#age').text(data.age);
                        $('#sex').text(data.sex);
                        $('#civil_status').text(data.civil_status);
                        $('#blood_type').text(data.blood_type);
                        $('#educational_attainment').text(data.educational_attainment);
                        $('#occupation').text(data.occupation);
                        $('#cellphone_number').text(data.cellphone_number);
                        $('#emerg_full_name').text([data.emerg_first_name, data.emerg_middle_name, data.emerg_last_name].filter(Boolean).join(' '));
                        $('#emerg_address').text(data.emerg_address);
                        $('#relationship_to_pwd').text(data.relationship_to_pwd);
                        $('#emerg_contact_number').text(data.emerg_contact_number);
                        $('#status').html(data.status);

                        const requirements = res.data.requirements;
                        let html = '';

                        const fields = [
                            { key: 'valid_id', label: 'Valid ID', expiredANDupdatedKey: 'valid_id_expires_at' },
                            { key: 'medical_certificate', label: 'Medical Certificate', expiredANDupdatedKey: 'medical_certificate_expires_at' },
                            { key: 'barangay_certificate', label: 'Barangay Certificate', expiredANDupdatedKey: 'barangay_certificate_expires_at' },
                            { key: 'birth_certificate', label: 'Birth Certificate', expiredANDupdatedKey: 'birth_certificate_expires_at' }
                        ];

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

                        fields.forEach(field => {
                            if (requirements[field.key] !== undefined) {
                                const status = requirements[field.key];
                                const ContainerColor = containerStyles[status];
                                const textColor = textStyles[status];
                                const statusColor = statusStyles[status];

                                html += `
                                    <div class="w-full p-4 ${ContainerColor} flex items-center justify-between">
                                        <div>
                                            <p class="${textColor} font-semibold">${field.label}</p>
                                            <p class="${textColor} text-sm">${requirements[field.expiredANDupdatedKey]}</p>
                                        </div>
                                        <div>
                                            <p class="${textColor} font-semibold ${statusColor}">${requirements[field.key]}</p>
                                        </div>
                                    </div>
                                `;
                            }
                        });

                        $('#requirementsContainer').html(html);
                    }
                },
                error: function(res) {
                    $('#recordData').html('<p>' + res.responseJSON.message + '</p>');
                }
            });
        }
    });
</script>