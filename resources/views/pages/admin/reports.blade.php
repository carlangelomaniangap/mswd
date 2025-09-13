@section('title', 'Reports')

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Reports') }}
            </h2>
        </div>
    </x-slot>

    <div class="bg-white p-4 space-y-8">
        <div class="space-y-4">
            <h3 class="font-semibold text-lg">Beneficiary Report</h3>
            <div class="filter-container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Report Selection -->
                <div class="table-selector-container">
                    <x-form.label for="table-selector">Select Report</x-form.label>
                    <x-form.select id="table-selector">
                        <option value="" disabled selected>Select report</option>
                        <option value="pwd">PWD</option>
                        <option value="aics">AICS</option>
                        <option value="senior_citizen">Senior Citizen</option>
                        <option value="solo_parent">Solo Parent</option>
                    </x-form.select>
                </div>

                <!-- Status Filter -->
                <div>
                    <x-form.label for="status">Filter by Status</x-form.label>
                    <x-form.select id="status">
                        <option value="">All</option>
                        <option value="Eligible">Eligible</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Expired">Expired</option>
                        <option value="Not Eligible">Not Eligible</option>
                    </x-form.select>
                </div>

                <!-- Start Date -->
                <div>
                    <x-form.label for="start-date">Start Date</x-form.label>
                    <x-form.input type="date" id="start-date" class="w-full" />
                </div>

                <!-- End Date -->
                <div>
                    <x-form.label for="end-date">End Date</x-form.label>
                    <x-form.input type="date" id="end-date" class="w-full" />
                </div>

                <!-- Buttons -->
                <div class="flex items-end gap-4">
                    <x-button id="clear-filters" variant="info">
                        Clear
                    </x-button>

                    <x-button onclick="printReports();">
                        Print
                    </x-button>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <h3 class="font-semibold text-lg">Family Composition Report</h3>
            <div class="filter-family-composition grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Report Selection -->
                <div class="table-selector-family-composition">
                    <x-form.label for="table-family-composition">Select Report</x-form.label>
                    <x-form.select id="table-family-composition">
                        <option value="" disabled selected>Select report</option>
                        <option value="aics_family_member">AICS</option>
                        <option value="senior_citizen_family_member">Senior Citizen</option>
                        <option value="solo_parent_family_member">Solo Parent</option>
                    </x-form.select>
                </div>

                <!-- Start Date -->
                <div>
                    <x-form.label for="start-date-family-composition">Start Date</x-form.label>
                    <x-form.input type="date" id="start-date-family-composition" class="w-full" />
                </div>

                <!-- End Date -->
                <div>
                    <x-form.label for="end-date">End Date</x-form.label>
                    <x-form.input type="date" id="end-date-family-composition" class="w-full" />
                </div>

                <!-- Buttons -->
                <div class="flex items-end gap-4">
                    <x-button id="clear-filters-family-composition" variant="info">
                        Clear
                    </x-button>

                    <x-button onclick="printReports('family_composition');">
                        Print
                    </x-button>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <h3 class="font-semibold text-lg">Aics Payout Report</h3>
            <div class="filter-container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                <!-- Start Date -->
                <div>
                    <x-form.label for="start-date-payout">Start Date</x-form.label>
                    <x-form.input type="date" id="start-date-payout" class="w-full" />
                </div>

                <!-- End Date -->
                <div>
                    <x-form.label for="end-date">End Date</x-form.label>
                    <x-form.input type="date" id="end-date-payout" class="w-full" />
                </div>

                <!-- Buttons -->
                <div class="flex items-end gap-4">
                    <x-button id="clear-filters-payout" variant="info">
                        Clear
                    </x-button>

                    <x-button onclick="printReports('aics_payout');">
                        Print
                    </x-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Beneficiary Report Clear
    document.getElementById('clear-filters').addEventListener('click', function() {
        document.getElementById('table-selector').selectedIndex = 0;
        document.getElementById('status').selectedIndex = 0;
        document.getElementById('start-date').value = '';
        document.getElementById('end-date').value = '';
    });

    // Family Composition Clear
    document.getElementById('clear-filters-family-composition').addEventListener('click', function() {
        document.getElementById('table-family-composition').selectedIndex = 0;
        document.getElementById('start-date-family-composition').value = '';
        document.getElementById('end-date-family-composition').value = '';
    });

    // AICS Payout Clear
    document.getElementById('clear-filters-payout').addEventListener('click', function() {
        document.getElementById('start-date-payout').value = '';
        document.getElementById('end-date-payout').value = '';
    });
</script>

<script>
    function printReports(reportType = null) {
        let selectedReport, status, startDate, endDate, url;

        if (reportType === 'family_composition') {
            selectedReport = document.getElementById('table-family-composition').value;
            startDate = document.getElementById('start-date-family-composition').value;
            endDate = document.getElementById('end-date-family-composition').value;

            // Family composition reports
            url = `/admin/reports/${selectedReport}?`;

        } else if (reportType === 'aics_payout') {
            selectedReport = 'aics_payout';
            startDate = document.getElementById('start-date-payout').value;
            endDate = document.getElementById('end-date-payout').value;

            // AICS payout report
            url = `/admin/reports/${selectedReport}?`;

        } else {
            selectedReport = document.getElementById('table-selector').value;
            status = document.getElementById('status').value;
            startDate = document.getElementById('start-date').value;
            endDate = document.getElementById('end-date').value;

            // Beneficiary reports
            url = `/admin/reports/${selectedReport}?`;

            if (status && status.toLowerCase() !== "all") {
                url += `status=${status.replace(/\s+/g, '_').toLowerCase()}&`;
            }
        }

        if (!selectedReport) {
            Swal.fire({ text: "Please select a report.", icon: "warning" });
            return;
        }

        if (!startDate && !endDate) {
            Swal.fire({ text: "Please select start date and end date", icon: "warning" });
            return;
        } else if (!startDate) {
            Swal.fire({ text: "Please select start date", icon: "warning" });
            return;
        } else if (!endDate) {
            Swal.fire({ text: "Please select end date.", icon: "warning" });
            return;
        }

        // Add date filters
        url += `start_date=${startDate}&end_date=${endDate}`;

        // Remove trailing "&" or "?"
        url = url.replace(/[&?]$/, '');

        window.open(url, '_blank');

        // Clear filters after printing
        if (reportType === 'family_composition') {
            document.getElementById('table-family-composition').selectedIndex = 0;
            document.getElementById('start-date-family-composition').value = '';
            document.getElementById('end-date-family-composition').value = '';
        } else if (reportType === 'aics_payout') {
            document.getElementById('start-date-payout').value = '';
            document.getElementById('end-date-payout').value = '';
        } else {
            document.getElementById('table-selector').selectedIndex = 0;
            document.getElementById('status').selectedIndex = 0;
            document.getElementById('start-date').value = '';
            document.getElementById('end-date').value = '';
        }
    }
</script>
