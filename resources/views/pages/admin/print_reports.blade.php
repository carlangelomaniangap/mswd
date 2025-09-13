<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report | {{ $title }}</title>
    <link rel="icon" href="{{ asset('images/mswd_logo.png') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @media print {
            @page {
                margin: 0;
                size: a4;
            }

            body {
                margin: 0;
                padding: 0;
            }
        }

        #page {
            page-break-after: always;
        }
    </style>
</head>
<body class="bg-gray-200 flex flex-col items-center">
    @php
        $chunks = $records->chunk(20);
        if ($chunks->isEmpty()) {
            $chunks = collect([collect()]); // Force one empty page
        }
    @endphp

    @foreach($chunks as $pageRecords)
        <section id="page" class="bg-white mx-auto w-[794px] h-[1123px] my-4 print:my-0 flex flex-col">
            <header class="py-2">
                <div class="flex items-center justify-center mx-2">
                    <div class="flex items-center justify-center w-36">
                        <img src="{{ asset('images/abucay.png') }}" alt="Logo" class="h-24 w-24">
                    </div>
                    <div class="flex-1 font-serif text-center mx-2">
                        <p  class="text-sm">Republic of the Philippines</p>
                        <p class="text-md font-semibold">Office of the Municipal Social Welfare and Development</p>
                        <p class="text-sm">Ground flr. Municipal Hall Bldg. Calaylayan,Abucay, Bataan</p>
                        <p class="text-xs">Email: mswdoabucay@gmail.com</p>
                        <p class="text-xs">Facebook Page: MSWDO Abucay</p>
                    </div>
                    <div class="flex items-center justify-center w-36">
                        <img src="{{ asset('images/mswd_abucay.png') }}" alt="Logo" class="h-24 w-36">
                    </div>
                </div>
                <div class="mt-4 h-1.5 mx-4 bg-gray-300 border border-black rounded"></div>
            </header>

            <div class="flex-1 px-6 print:px-6">
                <div class="flex items-center justify-between pb-2">
                    <div>
                        <h3 class="font-bold">{{ $title }} Reports</h3>
                    </div>
                    <div class="flex items-center gap-4 text-sm">
                        <p><strong>Start Date:</strong> {{ date('F j, Y', strtotime($startDate)) }}</p>
                        <p><strong>End Date:</strong> {{date('F j, Y', strtotime($endDate)) }}</p>
                    </div>
                </div>

                <table class="w-full table-fixed border border-gray-300 border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-sm">
                            @if($report === 'pwd')
                                <th class="border border-gray-300 px-2 py-1">Name</th>
                                <th class="border border-gray-300 px-2 py-1">Address</th>
                                <th class="border border-gray-300 px-2 py-1 w-14">Sex</th>
                                <th class="border border-gray-300 px-2 py-1 w-24">Contact No.</th>
                                <th class="border border-gray-300 px-2 py-1 w-20">PWD ID</th>
                                <th class="border border-gray-300 px-2 py-1 w-20">Status</th>
                            @elseif($report === 'aics')
                                <th class="border border-gray-300 px-2 py-1">Name</th>
                                <th class="border border-gray-300 px-2 py-1">Date Created</th>
                                <th class="border border-gray-300 px-2 py-1">Address</th>
                                <th class="border border-gray-300 px-2 py-1 w-14">Sex</th>
                                <th class="border border-gray-300 px-2 py-1 w-24">Contact No.</th>
                                <th class="border border-gray-300 px-2 py-1 w-20">AICS ID</th>
                                <th class="border border-gray-300 px-2 py-1 w-20">Status</th>
                            @elseif($report === 'senior_citizen')
                                <th class="border border-gray-300 px-2 py-1">Name</th>
                                <th class="border border-gray-300 px-2 py-1 w-14">Age</th>
                                <th class="border border-gray-300 px-2 py-1">Address</th>
                                <th class="border border-gray-300 px-2 py-1 w-14">Sex</th>
                                <th class="border border-gray-300 px-2 py-1 w-24">Contact No.</th>
                                <th class="border border-gray-300 px-2 py-1 w-20">Senior ID</th>
                                <th class="border border-gray-300 px-2 py-1 w-20">Status</th>
                            @elseif($report === 'solo_parent')
                                <th class="border border-gray-300 px-2 py-1">Name</th>
                                <th class="border border-gray-300 px-2 py-1">Address</th>
                                <th class="border border-gray-300 px-2 py-1 w-14">Sex</th>
                                <th class="border border-gray-300 px-2 py-1 w-24">Contact No.</th>
                                <th class="border border-gray-300 px-2 py-1 w-16">SP ID</th>
                                <th class="border border-gray-300 px-2 py-1 w-20">No. of Children</th>
                                <th class="border border-gray-300 px-2 py-1 w-24">Employment Status</th>
                                <th class="border border-gray-300 px-2 py-1 w-20">Status</th>
                                <th class="border border-gray-300 px-2 py-1 hidden">Created At</th>
                            @elseif($report === 'aics_family_member')
                                <th class="border border-gray-300 px-2 py-1">Beneficiary Name</th>
                                <th class="border border-gray-300 px-2 py-1">Family Member Name</th>
                                <th class="border border-gray-300 px-2 py-1">Relationship</th>
                                <th class="border border-gray-300 px-2 py-1 w-20">Age</th>
                                <th class="border border-gray-300 px-2 py-1 w-20">Status</th>
                            @elseif($report === 'senior_citizen_family_member')
                                <th class="border border-gray-300 px-2 py-1">Beneficiary Name</th>
                                <th class="border border-gray-300 px-2 py-1">Family Member Name</th>
                                <th class="border border-gray-300 px-2 py-1">Relationship</th>
                                <th class="border border-gray-300 px-2 py-1 w-20">Age</th>
                                <th class="border border-gray-300 px-2 py-1 w-20">Status</th>
                            @elseif($report === 'solo_parent_family_member')
                                <th class="border border-gray-300 px-2 py-1">Beneficiary Name</th>
                                <th class="border border-gray-300 px-2 py-1">Family Member Name</th>
                                <th class="border border-gray-300 px-2 py-1">Relationship</th>
                                <th class="border border-gray-300 px-2 py-1 w-20">Age</th>
                                <th class="border border-gray-300 px-2 py-1 w-20">Status</th>
                            @elseif($report === 'aics_payout')
                                <th class="border border-gray-300 px-2 py-1">Beneficiary Name</th>
                                <th class="border border-gray-300 px-2 py-1 w-32">Date</th>
                                <th class="border border-gray-300 px-2 py-1 w-20">Amount</th>
                                <th class="border border-gray-300 px-2 py-1">Type</th>
                                <th class="border border-gray-300 px-2 py-1">Claimed By</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pageRecords as $record)
                            <tr class="text-xs">
                                @if($report === 'pwd')
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->last_name }}, {{ $record->first_name }} {{ $record->middle_name }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->barangay }}, {{ $record->city_municipality }}, {{ $record->province }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->sex }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->cellphone_number }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ 'PWD-' . str_pad($record->id, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->status }}</td>
                                @elseif($report === 'aics')
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->last_name }}, {{ $record->first_name }} {{ $record->middle_name }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ date('F j, Y', strtotime($record->created_at)) }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->barangay }}, {{ $record->city_municipality }}, {{ $record->province }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->sex }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->cellphone_number }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ 'AICS-' . str_pad($record->id, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->status }}</td>
                                @elseif($report === 'senior_citizen')
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->last_name }}, {{ $record->first_name }} {{ $record->middle_name }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->age }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->barangay }}, {{ $record->city_municipality }}, {{ $record->province }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->sex }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->cellphone_number }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ 'SC-' . str_pad($record->id, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->status }}</td>
                                @elseif($report === 'solo_parent')
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->last_name }}, {{ $record->first_name }} {{ $record->middle_name }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->barangay }}, {{ $record->city_municipality }}, {{ $record->province }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->sex }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->cellphone_number }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ 'SP-' . str_pad($record->id, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->number_of_children }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->employment_status }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->status }}</td>
                                @elseif($report === 'aics_family_member')
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->aicsRecord->last_name }}, {{ $record->aicsRecord->first_name }} {{ $record->aicsRecord->middle_name }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->family_member_name }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->relationship }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->family_member_age }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->family_member_status }}</td>
                                @elseif($report === 'senior_citizen_family_member')
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->seniorCitizenRecord->last_name }}, {{ $record->seniorCitizenRecord->first_name }} {{ $record->seniorCitizenRecord->middle_name }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->family_member_name }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->relationship }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->family_member_age }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->family_member_status }}</td>
                                @elseif($report === 'solo_parent_family_member')
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->soloParentRecord->last_name }}, {{ $record->soloParentRecord->first_name }} {{ $record->soloParentRecord->middle_name }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->family_member_name }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->relationship }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->family_member_age }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->family_member_status }}</td>
                                @elseif($report === 'aics_payout')
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->aicsRecord->last_name }}, {{ $record->aicsRecord->first_name }} {{ $record->aicsRecord->middle_name }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ date('F j, Y', strtotime($record->created_at)) }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->amount }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->type }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $record->claimed_by }}</td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td class="border border-gray-300 px-2 py-1 text-center"
                                    colspan="
                                        @if($report === 'pwd') 6
                                        @elseif($report === 'aics') 7
                                        @elseif($report === 'senior_citizen') 7
                                        @elseif($report === 'solo_parent') 8
                                        @elseif($report === 'aics_family_member') 5
                                        @elseif($report === 'senior_citizen_family_member') 5
                                        @elseif($report === 'solo_parent_family_member') 5
                                        @elseif($report === 'aics_payout') 5
                                        @else 1
                                        @endif
                                    "
                                >
                                    No records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <footer>
                <div class="h-1.5 mx-4 bg-gray-300 border border-black rounded"></div>
                <div class="flex items-center justify-center gap-8 p-2">
                    <em class="text-center text-[11px]">
                        <p class="pb-1">Our Vision</p>
                        <p>By 2030 the Office of the Municipal Social Welfare and Development Office</p>
                        <p>envisioned the disadvantaged and vulnerable sector of the society will be</p>
                        <p>alleviated from the poverty and hunger.</p>
                    </em>
                    <em class="text-center text-[11px]">
                        <p class="pb-1">Our Mission</p>
                        <p>To provide an efficient social protection program and services to the</p>
                        <p>To provide an efficient social protection program and services to the</p>
                        <p>situation, children, group and communities.</p>
                    </em>
                </div>
            </footer>

            <x-button class="print:hidden fixed top-4 right-4" onclick="window.print()">Print</x-button>
        </section>
    @endforeach
</body>
</html>
