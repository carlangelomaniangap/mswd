<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aics Record Data</title>
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
                    <h1 class="font-bold text-2xl">Aics Record Data</h1>

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
                                <div><strong>AICS ID:</strong> <span id="aics_id">Loading...</span></div>
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

                                <div class="flex flex-col items-center text-center pb-2">
                                    <div id="nature_of_problem" class="w-full border-gray-400 mb-1">Loading...</div>
                                    <strong class="w-full border-t border-gray-400">
                                        Nature of Problem
                                    </strong>
                                </div>

                                <div class="flex flex-col items-center text-center pb-2 w-full">
                                    <div id="problem_description" class="w-full border border-gray-400 p-2 mb-1">
                                        Loading...
                                    </div>
                                    <strong class="text-center">
                                        Problem Description
                                    </strong>
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

                    <div class="bg-white dark:bg-dark-eval-1 shadow rounded p-4">
                        <h3 class="font-bold text-lg pb-4">Payout History</h3>
                        <div id="payoutHistoriesContainer"></div>
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
                url: `/aics/record/data/scan/${id}`,
                type: 'GET',
                success: function(res) {
                    if(res.success){
                        let data = res.data;

                        $('#photo').attr('src', data.photo);
                        $('#qr_code').attr('src', data.qr_code);
                        $('#aics_id').text(`AICS-${String(data.id).padStart(3, '0')}`);
                        $('#full_name').text([data.first_name, data.middle_name, data.last_name].filter(Boolean).join(' '));
                        $('#address').text([data.house_no_unit_floor, data.street, data.barangay, data.city_municipality, data.province].filter(Boolean).join(', '));
                        $('#date_of_birth').text(data.date_of_birth);
                        $('#place_of_birth').text(data.place_of_birth);
                        $('#age').text(data.age);
                        $('#sex').text(data.sex);
                        $('#civil_status').text(data.civil_status);
                        $('#educational_attainment').text(data.educational_attainment);
                        $('#occupation').text(data.occupation);
                        $('#cellphone_number').text(data.cellphone_number);
                        $('#nature_of_problem').text(data.nature_of_problem);
                        $('#problem_description').text(data.problem_description);
                        $('#created_at').text(data.created_at);
                        $('#status').html(data.status);

                        const requirements = res.data.requirements;
                        let html = '';

                        // Define the labels of requirements
                        const fields = [
                            { key: 'personal_letter', label: 'Personal Letter (1 orig., 1 Photocopy)', expiredANDupdatedKey: 'personal_letter_expires_at' },
                            { key: 'brgy_cert_of_indigency_ng_pasyente_at_client', label: 'BRGY. Certificate of Indigency ng Pasyente at Client <br> (1 orig., 1 Photocopy)', expiredANDupdatedKey: 'brgy_cert_of_indigency_ng_pasyente_at_client_expires_at' },
                            { key: 'brgy_cert_of_indigency_ng_pasyente_at_magulang', label: 'BRGY. Certificate of Indigency ng Pasyente at Magulang <br> (1 orig. 1 Photocopy)', expiredANDupdatedKey: 'brgy_cert_of_indigency_ng_pasyente_at_magulang_expires_at' },
                            { key: 'brgy_cert_of_indigency', label: 'BRGY. Certificate of Indigency (1 orig., 1 Photocopy)', expiredANDupdatedKey: 'brgy_cert_of_indigency_expires_at' },
                            { key: 'medical_abstract_or_medical_certificate', label: 'Medical Abstract/Medical Certificate <br> (2 Photocopies)', expiredANDupdatedKey: 'medical_abstract_or_medical_certificate_expires_at' },
                            { key: 'latest_na_reseta_with_costing', label: 'Latest na Reseta with Costing (2 Photocopies)', expiredANDupdatedKey: 'latest_na_reseta_with_costing_expires_at' },
                            { key: 'latest_na_laboratory_test_with_costing', label: 'Latest na Laboratory Test with Costing <br> (2 Photocopies)', expiredANDupdatedKey: 'latest_na_laboratory_test_with_costing_expires_at' },
                            { key: 'hospital_bill', label: 'Hospital Bill <br> - Final Bill (If Discharged) <br> - Progress (If Still In) <br> - Promissory Note', expiredANDupdatedKey: 'hospital_bill_expires_at' },
                            { key: 'birth_certificate_of_patient', label: 'Birth Certificate of Patient (2 Photocopies)', expiredANDupdatedKey: 'birth_certificate_of_patient_expires_at' },
                            { key: 'brgy_certificate_of_proof_ng_pangangalaga', label: 'Brgy. Certificate of Proof ng Pangangalaga <br> (1 orig., 1 Photocopy)', expiredANDupdatedKey: 'brgy_certificate_of_proof_ng_pangangalaga_expires_at' },
                            { key: 'birth_certificate_of_client', label: 'Birth Certificate of Client (2 Photocopies)', expiredANDupdatedKey: 'birth_certificate_of_client_expires_at' },
                            { key: 'marriage_cert_or_brgy_cert_of_cohabitation', label: 'Marriage Certificate/BRGY. Certificate of Cohabitation <br> (2 Photocopies)', expiredANDupdatedKey: 'marriage_cert_or_brgy_cert_of_cohabitation_expires_at' },
                            { key: 'birth_certificate_of_pasyente_at_client', label: 'Birth Certificate of Pasyente at Client <br> (2 Photocopies)', expiredANDupdatedKey: 'birth_certificate_of_pasyente_at_client_expires_at' },
                            { key: 'one_valid_id_client_at_pasyente', label: '1 Valid ID (Client at Pasyente) <br> (2 Photocopies, Back to Back)', expiredANDupdatedKey: 'one_valid_id_client_at_pasyente_expires_at' },
                            { key: 'authorization_letter', label: 'Autorization Letter (1 orig., 1 Photocopy)', expiredANDupdatedKey: 'authorization_letter_expires_at' },
                            { key: 'one_valid_id', label: '1 Valid ID (2 Photocopies, Back to Back)', expiredANDupdatedKey: 'one_valid_id_expires_at' },
                            { key: 'death_certificate', label: 'Death Certificate', expiredANDupdatedKey: 'death_certificate_expires_at' },
                            { key: 'proof_of_billing_or_promissory_note_from_funeral', label: 'Proof of Billing/Promissory Note From Funeral', expiredANDupdatedKey: 'proof_of_billing_or_promissory_note_from_funeral_expires_at' },
                            { key: 'marriage_cert_or_birth_cert_or_cert_of_cohabitation', label: 'Marriage Certificate/Birth Certificate/Certificate of Cohabitation <br> (If not Married)', expiredANDupdatedKey: 'marriage_cert_or_birth_cert_or_cert_of_cohabitation_expires_at' },
                            { key: 'photocopy_of_valid_id', label: 'Photocopy of Valid ID <br> - If PWD Member (PWD ID) <br> - If Senior Citizen (Senior Citizen ID)', expiredANDupdatedKey: 'photocopy_of_valid_id_expires_at' },
                            { key: 'surrender_id', label: 'Surrender ID (PWD/SC ID)', expiredANDupdatedKey: 'surrender_id_expires_at' },
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
                                            <th class="border px-2 py-1">Age</th>
                                            <th class="border px-2 py-1">Civil Status</th>
                                            <th class="border px-2 py-1">Educational Attainment</th>
                                            <th class="border px-2 py-1">Occupation</th>
                                            <th class="border px-2 py-1">Monthly Income</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border px-2 py-1 text-center align-middle" colspan="7">No family members</td>
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
                                            <th class="border px-2 py-1">Age</th>
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
                                        <td class="border px-2 py-1">${member.family_member_age}</td>
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

                        const payoutHistory = data.payout_history;

                        if (payoutHistory.length === 0) {
                            $('#payoutHistoriesContainer').html(`
                                <table class="min-w-full border border-gray-300">
                                    <thead>
                                        <tr class="bg-gray-200 dark:bg-dark-eval-0">
                                            <th class="border px-2 py-1">Date</th>
                                            <th class="border px-2 py-1">Amount</th>
                                            <th class="border px-2 py-1">Type</th>
                                            <th class="border px-2 py-1">Claimed by</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border px-2 py-1 text-center align-middle" colspan="4">No payout history</td>
                                        </tr>
                                    </tbody>
                                </table>
                            `);
                        } else {
                            let payoutHtml = `
                                <table class="min-w-full border border-gray-300">
                                    <thead>
                                        <tr class="bg-gray-200 dark:bg-dark-eval-0">
                                            <th class="border px-2 py-1">Date</th>
                                            <th class="border px-2 py-1">Amount</th>
                                            <th class="border px-2 py-1">Type</th>
                                            <th class="border px-2 py-1">Claimed by</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            `;

                            payoutHistory.forEach(payout => {
                                payoutHtml += `
                                    <tr>
                                        <td class="border px-2 py-1">${payout.created_at}</td>
                                        <td class="border px-2 py-1">${payout.amount}</td>
                                        <td class="border px-2 py-1">${payout.type}</td>
                                        <td class="border px-2 py-1">${payout.claimed_by}</td>
                                    </tr>
                                `;
                            });

                            payoutHtml += `
                                    </tbody>
                                </table>
                            `;

                            $('#payoutHistoriesContainer').html(payoutHtml);
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