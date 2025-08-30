<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Solo Parent Record Data</title>
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
                    <h1 class="font-bold text-2xl">Solo Parent Record Data</h1>

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
                                <div><strong>SP ID:</strong> <span id="sp_id">Loading...</span></div>
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
                                </div>

                                <div class="flex flex-row items-center text-center gap-4 pb-2">
                                    <div class="flex flex-col items-center text-center flex-1">
                                        <div id="religion" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                            Religion
                                        </strong>
                                    </div>

                                    <div class="flex flex-col items-center text-center flex-1">
                                        <div id="philsys_card_number" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                            Philsys Card Number
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
                                        <div id="employment_status" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                            Employment Status
                                        </strong>
                                    </div>
                                </div>

                                <div class="flex flex-row items-center text-center gap-4 pb-2">
                                    <div class="flex flex-col items-center text-center flex-1">
                                        <div id="occupation" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                            Occupation
                                        </strong>
                                    </div>

                                    <div class="flex flex-col items-center text-center flex-1">
                                        <div id="company_agency" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                            Company Agency
                                        </strong>
                                    </div>
                                </div>

                                <div class="flex flex-row items-center text-center gap-4 pb-2">
                                    <div class="flex flex-col items-center text-center flex-1">
                                        <div id="monthly_income" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                        Monthly Income
                                        </strong>
                                    </div>

                                    <div class="flex flex-col items-center text-center flex-1">
                                        <div id="cellphone_number" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                        Cellphone Number
                                        </strong>
                                    </div>

                                    <div class="flex flex-col items-center text-center flex-1">
                                        <div id="number_of_children" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                        Number of Children
                                        </strong>
                                    </div>
                                </div>

                                <div class="flex flex-row items-center text-center gap-4 pb-2">
                                    <div class="flex flex-col items-center text-center flex-1">
                                        <div id="pantawid_beneficiary" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                            Pantawid Beneficiary
                                        </strong>
                                    </div>

                                    <div class="flex flex-col items-center text-center flex-1">
                                        <div id="indigenous_person" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                            Indigenous Person
                                        </strong>
                                    </div>
                                </div>

                                <div class="flex flex-row items-center text-center gap-4 pb-2">
                                    <div class="flex flex-col items-center text-center flex-1">
                                        <div id="household_id" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                            Household ID
                                        </strong>
                                    </div>
                                    <div class="flex flex-col items-center text-center flex-1">
                                        <div id="name_of_affliation" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                            Name of Affliation
                                        </strong>
                                    </div>
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
                                        <div id="relationship_to_solo_parent" class="w-full border-gray-400 mb-1">Loading...</div>
                                        <strong class="w-full border-t border-gray-400">
                                            Relationship to Solo Parent
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

                    <div class="bg-white dark:bg-dark-eval-1 shadow rounded p-4">
                        <h3 class="font-bold text-lg pb-4">Family Members</h3>
                        <div id="familyMembersContainer"></div>
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
                url: `/solo_parent/record/data/scan/${id}`,
                type: 'GET',
                success: function(res) {
                    if(res.success){
                        let data = res.data;
                        console.log(data);
                        $('#photo').attr('src', data.photo);
                        $('#qr_code').attr('src', data.qr_code);
                        $('#sp_id').text(`SP-${String(data.id).padStart(3, '0')}`);
                        $('#full_name').text([data.first_name, data.middle_name, data.last_name].filter(Boolean).join(' '));
                        $('#address').text([data.house_no_unit_floor, data.street, data.barangay, data.city_municipality, data.province].filter(Boolean).join(', '));
                        $('#date_of_birth').text(data.date_of_birth);
                        $('#place_of_birth').text(data.place_of_birth);
                        $('#age').text(data.age);
                        $('#sex').text(data.sex);
                        $('#civil_status').text(data.civil_status);
                        $('#religion').text(data.religion);
                        $('#philsys_card_number').text(data.philsys_card_number);
                        $('#educational_attainment').text(data.educational_attainment);
                        $('#employment_status').text(data.employment_status);
                        $('#occupation').text(data.occupation);
                        $('#company_agency').text(data.company_agency);
                        $('#monthly_income').text(data.monthly_income);
                        $('#cellphone_number').text(data.cellphone_number);
                        $('#number_of_children').text(data.number_of_children);
                        $('#pantawid_beneficiary').text(data.pantawid_beneficiary);
                        $('#household_id').text(data.household_id);
                        $('#indigenous_person').text(data.indigenous_person);
                        $('#name_of_affliation').text(data.name_of_affliation);
                        $('#emerg_full_name').text([data.emerg_first_name, data.emerg_middle_name, data.emerg_last_name].filter(Boolean).join(' '));
                        $('#emerg_address').text(data.emerg_address);
                        $('#relationship_to_solo_parent').text(data.relationship_to_solo_parent);
                        $('#emerg_contact_number').text(data.emerg_contact_number);
                        $('#status').html(data.status);

                        const requirements = res.data.requirements;
                        let html = '';

                        // Define the labels of requirements
                        const fields = [
                            { key: 'valid_id', label: 'Valid ID', expiredANDupdatedKey: 'valid_id' },
                            { key: 'birth_certificate', label: 'Birth Certificate', expiredANDupdatedKey: 'birth_certificate' },
                            { key: 'solo_parent_id_application_form', label: 'Solo Parent ID Application Form', expiredANDupdatedKey: 'solo_parent_id_application_form' },
                            { key: 'affidavit_of_solo_parent', label: 'Affidavit of Solo Parent', expiredANDupdatedKey: 'affidavit_of_solo_parent' },
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

                        const familyMembers = data.family_members;

                        if (familyMembers.length === 0) {
                            $('#familyMembersContainer').html(`
                                <table class="min-w-full border border-gray-300">
                                    <thead>
                                        <tr class="bg-gray-200 dark:bg-dark-eval-0">
                                            <th class="border px-2 py-1">Name</th>
                                            <th class="border px-2 py-1">Relationship</th>
                                            <th class="border px-2 py-1">Date of Birth</th>
                                            <th class="border px-2 py-1">Age</th>
                                            <th class="border px-2 py-1">Sex</th>
                                            <th class="border px-2 py-1">Civil Status</th>
                                            <th class="border px-2 py-1">Educational Attainment</th>
                                            <th class="border px-2 py-1">Occupation</th>
                                            <th class="border px-2 py-1">Monthly Income</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border px-2 py-1 text-center align-middle" colspan="9">No family members</td>
                                        </tr>
                                    </tbody>
                                </table>
                            `);
                        } else {
                            let familyHtml = `
                                <table class="min-w-full border border-gray-300">
                                    <thead>
                                        <tr class="bg-gray-200 dark:bg-dark-eval-0">
                                            <th class="border px-2 py-1">Name</th>
                                            <th class="border px-2 py-1">Relationship</th>
                                            <th class="border px-2 py-1">Date of Birth</th>
                                            <th class="border px-2 py-1">Age</th>
                                            <th class="border px-2 py-1">Sex</th>
                                            <th class="border px-2 py-1">Civil Status</th>
                                            <th class="border px-2 py-1">Educational Attainment</th>
                                            <th class="border px-2 py-1">Occupation</th>
                                            <th class="border px-2 py-1">Monthly Income</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            `;

                            familyMembers.forEach(member => {
                                familyHtml += `
                                    <tr>
                                        <td class="border px-2 py-1">${member.family_member_name}</td>
                                        <td class="border px-2 py-1">${member.relationship}</td>
                                        <td class="border px-2 py-1">${member.family_member_date_of_birth}</td>
                                        <td class="border px-2 py-1">${member.family_member_age}</td>
                                        <td class="border px-2 py-1">${member.family_member_sex}</td>
                                        <td class="border px-2 py-1">${member.family_member_civil_status}</td>
                                        <td class="border px-2 py-1">${member.family_member_educational_attainment}</td>
                                        <td class="border px-2 py-1">${member.family_member_occupation}</td>
                                        <td class="border px-2 py-1">${member.family_member_monthly_income}</td>
                                    </tr>
                                `;
                            });

                            familyHtml += `
                                    </tbody>
                                </table>
                            `;

                            $('#familyMembersContainer').html(familyHtml);
                        }
                    }
                },
                error: function(res) {
                    $('#recordData').html('<p>' + res.responseJSON.message + '</p>');
                }
            });
        }
    });
</script>