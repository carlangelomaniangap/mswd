@section('title', 'Dashboard')

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="space-y-4">
        <div class="grid grid-cols-1 grid-rows-4 sm:grid-cols-4 sm:grid-rows-1 gap-4">
            <div class="p-6 text-white bg-green-600 shadow-md dark:bg-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h5>Total Beneficiaries</h5>
                        <p class="font-bold text-xl" id="total_beneficiaries">
                            <span class="text-sm font-normal">Loading…</span>
                        </p>
                    </div>
                    <svg class="w-8 h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
                    </svg>
                </div>
            </div>

            <div class="p-6 text-white bg-blue-600 shadow-md dark:bg-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h5>Age 60-69</h5>
                        <p class="font-bold text-xl" id="total_beneficiaries_age_60_to_69">
                            <span class="text-sm font-normal">Loading…</span>
                        </p>
                    </div>
                    <svg class="w-8 h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M4 4v15a1 1 0 0 0 1 1h15M8 16l2.5-5.5 3 3L17.273 7 20 9.667"/>
                    </svg>
                </div>
            </div>

            <div class="p-6 text-white bg-teal-600 shadow-md dark:bg-teal-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h5>Age 70-80</h5>
                        <p class="font-bold text-xl" id="total_beneficiaries_age_79_to_80">
                            <span class="text-sm font-normal">Loading…</span>
                        </p>
                    </div>
                    <svg class="w-8 h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M4 4.5V19a1 1 0 0 0 1 1h15M7 14l4-4 4 4 5-5m0 0h-3.207M20 9v3.207"/>
                    </svg>
                </div>
            </div>

            <div class="p-6 text-white bg-purple-600 shadow-md dark:bg-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h5>Age 81 and above</h5>
                        <p class="font-bold text-xl" id="age_81_above_total">
                            <span class="text-sm font-normal">Loading…</span>
                        </p>
                    </div>
                    <svg class="w-8 h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 grid-rows-1 gap-4">
            <div class="bg-white dark:bg-dark-eval-1 p-4 space-y-4">
                <h3 class="font-semibold">Brangay Statistics</h3>
                <div class="flex items-center justify-center">
                    <canvas id="barangaystats" height="300" width="300"></canvas>
                </div>
            </div>

            <div class="bg-white dark:bg-dark-eval-1 p-4 space-y-4">
                <h3 class="font-semibold">Status Statistics</h3>
                <div class="flex items-center justify-center">
                    <canvas id="statusstats" height="300" width="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>
    const barangaycanvas = document.getElementById('barangaystats').getContext('2d');
    const statuscanvas = document.getElementById('statusstats').getContext('2d');

    const barangayChart = new Chart(barangaycanvas, {
        type: 'pie',
        data: {
            labels: ['Bangkal', 'Calaylayan', 'Capitangan', 'Gabon', 'Laon', 'Mabatang', 'Omboy', 'Salian', 'Wawa'],
            datasets: [{
                label: 'Beneficiaries',
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0],
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#8AFF33', '#FF33F6', '#33FFF0'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'right',
                    align: 'center',
                    labels: {
                        boxWidth: 20,
                        padding: 10
                    }
                }
            },
            animation: { duration: 500 }
        }
    });

    const statusChart = new Chart(statuscanvas, {
        type: 'bar',
        data: {
            labels: ['Eligible', 'In Progress', 'Expired', 'Not Eligible'], // status on X-axis
            datasets: [{
                label: 'Total Count',
                data: [0, 0, 0, 0], // initial values
                backgroundColor: [
                    'rgba(40, 167, 69, 0.3)',   // Eligible - Light Green
                    'rgba(255, 193, 7, 0.3)',   // In Progress - Light Yellow
                    'rgba(253, 126, 20, 0.3)',  // Expired - Light Orange
                    'rgba(220, 53, 69, 0.3)'    // Not Eligible - Light Red
                ],
                borderColor: [
                    '#1e7e34', // Eligible - Darker Green
                    '#e0a800', // In Progress - Darker Yellow
                    '#e8590c', // Expired - Darker Orange
                    '#b02a37'  // Not Eligible - Darker Red
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5
                    },
                    title: {
                        display: true,
                        text: 'Count'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Status'
                    }
                }
            }
        }
    });

    function fetch() {
        $.ajax({
            url: `/senior_citizen/dashboard/fetch`,
            method: 'GET',
            success: function(data) {
                $('#total_beneficiaries').text(data.total_beneficiaries);
                $('#total_beneficiaries_age_60_to_69').text(data.total_beneficiaries_age_60_to_69);
                $('#total_beneficiaries_age_79_to_80').text(data.total_beneficiaries_age_79_to_80);
                $('#age_81_above_total').text(data.age_81_above_total);

                barangayChart.data.datasets[0].data = [
                    data.bangkal,
                    data.calaylayan,
                    data.capitangan,
                    data.gabon,
                    data.laon,
                    data.mabatang,
                    data.omboy,
                    data.salian,
                    data.wawa
                ];
                barangayChart.update();

                statusChart.data.datasets[0].data = [
                    data.overall_status['Eligible'] ?? 0,
                    data.overall_status['In Progress'] ?? 0,
                    data.overall_status['Expired'] ?? 0,
                    data.overall_status['Not Eligible'] ?? 0
                ];
                statusChart.update();
            }
        });
    }

    fetch();
    setInterval(fetch, 1000);
</script>
