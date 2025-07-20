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
                        <h5>Age 8-16</h5>
                        <p class="font-bold text-xl" id="total_beneficiaries_age_8_to_16">
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
                        <h5>Age 17-30</h5>
                        <p class="font-bold text-xl" id="total_beneficiaries_age_17_to_30">
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
                        <h5>Age 31 and above</h5>
                        <p class="font-bold text-xl" id="age_31_above_total">
                            <span class="text-sm font-normal">Loading…</span>
                        </p>
                    </div>
                    <svg class="w-8 h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="px-6 pt-4 pb-6 bg-white dark:bg-dark-eval-1 shadow-md">
            <h3 class="pb-2 font-semibold text-lg">Barangay Statistics</h3>

            <div class="grid grid-cols-3 grid-rows-3 gap-4">
                <div class="bg-gray-100 dark:bg-dark-eval-0 shadow-md p-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <h5>Bangkal</h5>
                            <p class="font-bold text-xl text-blue-600" id="bangkal">
                                <span class="text-sm text-gray-700 dark:text-white font-normal">Loading…</span>
                            </p>
                        </div>
                        <svg class="w-8 h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
                        </svg>
                    </div>
                </div>

                <div class="bg-gray-100 dark:bg-dark-eval-0 shadow-md p-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <h5>Calaylayan</h5>
                            <p class="font-bold text-xl text-blue-600" id="calaylayan">
                                <span class="text-sm text-gray-700 dark:text-white font-normal">Loading…</span>
                            </p>
                        </div>
                        <svg class="w-8 h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
                        </svg>
                    </div>
                </div>

                <div class="bg-gray-100 dark:bg-dark-eval-0 shadow-md p-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <h5>Capitangan</h5>
                            <p class="font-bold text-xl text-blue-600" id="capitangan">
                                <span class="text-sm text-gray-700 dark:text-white font-normal">Loading…</span>
                            </p>
                        </div>
                        <svg class="w-8 h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
                        </svg>
                    </div>
                </div>

                <div class="bg-gray-100 dark:bg-dark-eval-0 shadow-md p-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <h5>Gabon</h5>
                            <p class="font-bold text-xl text-blue-600" id="gabon">
                                <span class="text-sm text-gray-700 dark:text-white font-normal">Loading…</span>
                            </p>
                        </div>
                        <svg class="w-8 h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
                        </svg>
                    </div>
                </div>

                <div class="bg-gray-100 dark:bg-dark-eval-0 shadow-md p-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <h5>Laon</h5>
                            <p class="font-bold text-xl text-blue-600" id="laon">
                                <span class="text-sm text-gray-700 dark:text-white font-normal">Loading…</span>
                            </p>
                        </div>
                        <svg class="w-8 h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
                        </svg>
                    </div>
                </div>

                <div class="bg-gray-100 dark:bg-dark-eval-0 shadow-md p-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <h5>Mabatang</h5>
                            <p class="font-bold text-xl text-blue-600" id="mabatang">
                                <span class="text-sm text-gray-700 dark:text-white font-normal">Loading…</span>
                            </p>
                        </div>
                        <svg class="w-8 h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
                        </svg>
                    </div>
                </div>

                <div class="bg-gray-100 dark:bg-dark-eval-0 shadow-md p-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <h5>Omboy</h5>
                            <p class="font-bold text-xl text-blue-600" id="omboy">
                                <span class="text-sm text-gray-700 dark:text-white font-normal">Loading…</span>
                            </p>
                        </div>
                        <svg class="w-8 h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
                        </svg>
                    </div>
                </div>

                <div class="bg-gray-100 dark:bg-dark-eval-0 shadow-md p-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <h5>Salian</h5>
                            <p class="font-bold text-xl text-blue-600" id="salian">
                                <span class="text-sm text-gray-700 dark:text-white font-normal">Loading…</span>
                            </p>
                        </div>
                        <svg class="w-8 h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
                        </svg>
                    </div>
                </div>

                <div class="bg-gray-100 dark:bg-dark-eval-0 shadow-md p-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <h5>Wawa</h5>
                            <p class="font-bold text-xl text-blue-600" id="wawa">
                                <span class="text-sm text-gray-700 dark:text-white font-normal">Loading…</span>
                            </p>
                        </div>
                        <svg class="w-8 h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function fetchCount() {
            $.ajax({
                url: "{{ route('admin.dashboard.fetch') }}",
                method: 'GET',
                success: function(data) {
                    $('#total_beneficiaries').text(data.total_beneficiaries);
                    $('#total_beneficiaries_age_8_to_16').text(data.total_beneficiaries_age_8_to_16);
                    $('#total_beneficiaries_age_17_to_30').text(data.total_beneficiaries_age_17_to_30);
                    $('#age_31_above_total').text(data.age_31_above_total);
                    $('#bangkal').html(
                        data.bangkal + ' <span class="text-sm font-normal text-gray-700 dark:text-white">beneficiaries</span>'
                    );
                    $('#calaylayan').html(
                        data.calaylayan + ' <span class="text-sm font-normal text-gray-700 dark:text-white">beneficiaries</span>'
                    );
                    $('#capitangan').html(
                        data.capitangan + ' <span class="text-sm font-normal text-gray-700 dark:text-white">beneficiaries</span>'
                    );
                    $('#gabon').html(
                        data.gabon + ' <span class="text-sm font-normal text-gray-700 dark:text-white">beneficiaries</span>'
                    );
                    $('#laon').html(
                        data.laon + ' <span class="text-sm font-normal text-gray-700 dark:text-white">beneficiaries</span>'
                    );
                    $('#mabatang').html(
                        data.mabatang + ' <span class="text-sm font-normal text-gray-700 dark:text-white">beneficiaries</span>'
                    );
                    $('#omboy').html(
                        data.omboy + ' <span class="text-sm font-normal text-gray-700 dark:text-white">beneficiaries</span>'
                    );
                    $('#salian').html(
                        data.salian + ' <span class="text-sm font-normal text-gray-700 dark:text-white">beneficiaries</span>'
                    );
                    $('#wawa').html(
                        data.wawa + ' <span class="text-sm font-normal text-gray-700 dark:text-white">beneficiaries</span>'
                    );
                }
            });
        }
        fetchCount();
        setInterval(fetchCount, 1000);
    });
</script>
