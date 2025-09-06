<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print ID Card</title>
    <link rel="icon" href="{{ asset('images/mswd_logo.png') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @media print {
            @page {
                margin: 0;
                size: auto;
                padding: 1in;
            }

            #btnPrint {
                visibility: hidden;
            }
        }
    </style>
</head>
<body>
    <section class="py-6 bg-gray-100">
        <div id="container" class="p-4 max-w-3xl mx-auto bg-white print:bg-transparent">
            @if($type === 'SC')
                <div class="flex items-center justify-between">
                    <h1 class="font-bold text-xl pb-8">Senior ID Card</h1>
                    <x-button id="btnPrint" onclick="window.print()">Print</x-button>
                </div>
                <div class="flex flex-col items-center gap-6">
                    {{-- Front ID --}}
                    <div class="space-y-2">
                        <h3 class="font-bold text-xs text-gray-700 dark:text-white">FRONT</h3>
                        <div class="w-[358px] h-[228px] bg-white text-black rounded-lg shadow-md border p-4">
                            <div class="flex space-x-2">
                                <img src="{{ $data['photo'] }}" alt="ID Card Photo" class="w-12 h-12 object-cover bg-gray-300">
                                <h3 class="text-lg font-bold">{{ $data['name'] }}</h3>
                                <img src="{{asset('images/mswd_logo.png')}}" alt="Logo" class="w-12 h-12 object-cover">
                            </div>

                            <div class="text-xs mt-2">
                                <strong class="font-semibold">Senior ID:</strong>
                                <span>{{ $data['sc_id'] }}</span>
                            </div>
                            <div class="text-xs mt-1">
                                <strong class="font-semibold">ADDRESS:</strong>
                                <span>{{ $data['address'] }}</span>
                            </div>
                            <div class="text-xs mt-1">
                                <strong class="font-semibold">SEX:</strong>
                                <span>{{ $data['sex'] }}</span>
                            </div>
                            <div class="text-xs mt-1">
                                <strong class="font-semibold">CONTACT NO:</strong>
                                <span>{{ $data['cellphone_number'] }}</span>
                            </div>

                            <div class="text-xs mt-1">
                                <strong class="font-semibold">BIRTHDAY:</strong>
                                <span>{{ $data['date_of_birth'] }}</span>
                            </div>
                            <div class="text-xs mt-1">
                                <strong class="font-semibold">AGE:</strong>
                                <span>{{ $data['age'] }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Back ID --}}
                    <div class="space-y-2">
                        <h3 class="font-bold text-xs text-gray-700 dark:text-white">BACK</h3>
                        <div class="w-[358px] h-[228px] grid grid-cols-2 gap-4 bg-white text-black rounded-lg shadow-md border p-4">
                            <div class="flex items-center justify-center">
                                <img src="{{ $data['qr_code'] }}" alt="QR Code" class="w-36 h-36 object-cover">
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
                </div>
            @endif
        </div>
    </section>
</body>
</html>