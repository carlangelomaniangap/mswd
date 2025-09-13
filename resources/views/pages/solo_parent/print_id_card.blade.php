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
    </style>
</head>
<body class="bg-gray-200 flex flex-col items-center">
    <section class="bg-white mx-auto w-[794px] h-[1123px] my-4 print:my-0 flex flex-col">
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

        <div class="flex-1 px-24 print:px-24">
            @if($type === 'SP')
                <div class="flex items-center justify-between">
                    <h1 class="font-bold text-xl pb-8">Solo Parent ID Card</h1>
                </div>
                <div class="flex flex-col items-center gap-6">
                    {{-- Front ID --}}
                    <div class="space-y-2">
                        <h3 class="font-bold text-black dark:text-white">FRONT</h3>
                        <div class="w-[358px] h-[228px] bg-white text-black rounded-lg shadow-md border p-4">
                            <div class="flex space-x-2">
                                <img src="{{ $data['photo'] }}" alt="ID Card Photo" class="w-12 h-12 object-cover bg-gray-300">
                                <h3 class="text-lg font-bold">{{ $data['name'] }}</h3>
                                <img src="{{asset('images/mswd_logo.png')}}" alt="Logo" class="w-12 h-12 object-cover">
                            </div>

                            <div class="text-xs mt-2">
                                <strong class="font-semibold">Solo Parent ID:</strong>
                                <span>{{ $data['sp_id'] }}</span>
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
                        <h3 class="font-bold text-black dark:text-white">BACK</h3>
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
</body>
</html>
