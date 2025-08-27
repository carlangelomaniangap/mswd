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
                        <div><strong>Status:</strong> <span id="status"></span></div>
                        <div id="requirementsContainer"></div>
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
                            { key: 'letter_to_the_mayor', label: 'Letter to the Mayor' },
                            { key: 'letter_to_the_mayor_expires_at', label: 'Letter Expiry' },
                            { key: 'medical_certificate', label: 'Medical Certificate' },
                            { key: 'medical_certificate_expires_at', label: 'Medical Expiry' },
                            { key: 'laboratory_or_prescription', label: 'Laboratory or Prescription' },
                            { key: 'laboratory_or_prescription_expires_at', label: 'Laboratory Expiry' },
                            { key: 'death_certificate', label: 'Death Certificate' },
                            { key: 'death_certificate_expires_at', label: 'Death Expiry' },
                            { key: 'funeral_contract', label: 'Funeral Contract' },
                            { key: 'funeral_contract_expires_at', label: 'Funeral Expiry' },
                            { key: 'barangay_indigency', label: 'Barangay Indigency' },
                            { key: 'barangay_indigency_expires_at', label: 'Indigency Expiry' },
                            { key: 'valid_id', label: 'Valid ID' },
                            { key: 'valid_id_expires_at', label: 'Valid ID Expiry' },
                            { key: 'cedula', label: 'Cedula' },
                            { key: 'cedula_expires_at', label: 'Cedula Expiry' },
                            { key: 'barangay_certificate_or_marriage_contract', label: 'Barangay Certificate/Marriage Contract' },
                            { key: 'barangay_certificate_or_marriage_contract_expires_at', label: 'Certificate Expiry' },
                        ];

                        fields.forEach(field => {
                            if (requirements[field.key] !== undefined) {
                                html += `<li><strong>${field.label}:</strong> ${requirements[field.key]}</li>`;
                            }
                        });

                        $('#requirementsContainer').html(html);

                        const familyMembers = data.family_members;

                        if (familyMembers.length === 0) {
                            $('#familyMembersContainer').html('<p>No family members</p>');
                        } else {
                            let familyHtml = `
                                <table class="min-w-full border border-gray-300">
                                    <thead>
                                        <tr class="bg-gray-200 dark:bg-dark-eval-0">
                                            <th class="border px-2 py-1">Name</th>
                                            <th class="border px-2 py-1">Relationship</th>
                                            <th class="border px-2 py-1">Age</th>
                                            <th class="border px-2 py-1">Civil Status</th>
                                            <th class="border px-2 py-1">Education</th>
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
                            $('#payoutHistoriesContainer').html('<p>No payout history</p>');
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