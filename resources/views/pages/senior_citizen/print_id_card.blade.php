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
            @if($type === 'SC')
                <div class="flex items-center justify-between">
                    <h1 class="font-bold text-xl pb-8">Senior ID Card</h1>
                </div>
                <div class="flex flex-col items-center gap-6">
                    {{-- Front ID --}}
                    <div class="space-y-2">
                        <h3 class="font-bold text-black dark:text-white">FRONT</h3>
                        <div class="w-[358px] h-[228px] flex flex-col bg-white text-black rounded-lg shadow-md border">
                            <div class="flex items-center justify-between px-4 bg-blue-800 rounded-t-lg">
                                <img src="{{asset('images/senior_citizen.png')}}" alt="Logo" class="w-11 h-11 object-contain">
                                <div class="text-center text-xs text-white">
                                    <p>Republic of the Philippines</p>
                                    <p>Office of the Senior Citizens Affairs (OSCA)</p>
                                    <p>Abucay, Bataan</p>
                                </div>
                                <img src="{{asset('images/abucay.png')}}" alt="Logo" class="w-11 h-11 object-contain">
                            </div>
                            <div class="flex-1 flex flex-row">
                                <div class="p-2">
                                    <img src="{{ $data['photo'] }}" alt="ID Card Photo" class="w-24 h-24 object-cover bg-gray-300">
                                    <div class="text-xs text-center mt-2">
                                        <p class="font-bold">{{ $data['sc_id'] }}</p>
                                        <p class="font-semibold border-t border-black">Senior ID</p>
                                    </div>
                                </div>
                                <div class="flex flex-col pt-2">
                                    <div class="flex items-center gap-2">
                                        <p class="text-xs">Name:</p>
                                        <p class="text-sm font-bold">{{ $data['name'] }}</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <p class="text-xs">Address:</p>
                                        <p class="text-sm font-bold">{{ $data['address'] }}</p>
                                    </div>
                                    <div class="flex items-center justify-start gap-4">
                                        <div class="flex items-center gap-2">
                                            <p class="text-xs">Date of Birth:</p>
                                            <p class="text-sm font-semibold">{{ $data['date_of_birth'] }}</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <p class="text-xs">Sex:</p>
                                            <p class="text-sm font-semibold">{{ $data['sex'] }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <p class="text-xs">Date Issued:</p>
                                        <p class="text-sm font-semibold">{{ $data['created_at'] }}</p>
                                    </div>
                                    <div class="flex-1 flex items-end justify-between gap-4 my-1">
                                        <div class="text-xs text-center">
                                            <p class="font-semibold border-t border-black">Signature/Thumbmark</p>
                                        </div>
                                        <img src="{{ $data['qr_code'] }}" alt="QR Code" class="w-16 h-16">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center text-xs text-white bg-blue-800 rounded-b-lg">
                                <p>This card is non-transferable</p>
                            </div>
                        </div>
                    </div>

                    {{-- Back ID --}}
                    <div class="space-y-2">
                        <h3 class="font-bold text-black dark:text-white">BACK</h3>
                        <div class="w-[358px] h-[228px] flex flex-col bg-white text-black rounded-lg shadow-md border p-2">
                            <div>
                                <p class="text-sm font-semibold">Benefits and Privileges under RA 9994</p>
                            </div>
                            <div class="flex-1 flex items-start justify-between">
                                <div class="text-[8px]">
                                    <p>Free Medical/Dental, diagnostic & laboratory services in all government facilities.</p>
                                    <p>20% discount for medicine</p>
                                    <p>20% discount in hotels, restaurant, recreation centers</p>
                                    <p>20% discount in theaters, cinema houses & concert halls</p>
                                    <p>20% discount in medical/dental services, diagnostics & laboratory fees in private facilities</p>
                                    <p>50% discount in basic necessities & prime commodities</p>
                                    <p>12% VAT - exemption on the purchase goods & services which are entitled to the 20% discount</p>
                                    <p>5% discount for the monthly utilization of water & electricity, provided that the water and electricity meter bases are under the name of the senior citizens</p>
                                    <p class="pt-2">Persons and Corporation violating RA9994 shall be penalized.</p>
                                    <p>Only for the executive use of Senior Citizen, abuse of the privileges is punished by law.</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-center gap-12">
                                <div>
                                    <p class="text-center text-sm font-semibold">JUNE O. CARAIG</p>
                                    <p class="text-center text-xs">OSCA HEAD</p>
                                </div>
                                <div>
                                    <p class="text-center text-sm font-semibold">HON. ERIK J. MARTEL</p>
                                    <p class="text-center text-xs">City/Municipal Mayor</p>
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
