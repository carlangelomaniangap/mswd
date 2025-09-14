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
                        <div class="w-[358px] h-[228px] bg-white text-black rounded-lg shadow-md border">
                            <div class="flex items-center justify-between px-4">
                                <div>
                                    <div class="flex items-center justify-center">
                                        <img src="{{asset('images/mswd_logo.png')}}" alt="Logo" class="w-7 h-7 object-cover">
                                        <p class="text-3xl text-[#0600b8] font-extrabold">DSWD</p>
                                    </div>
                                    <p class="text-[5px] text-[#0600b8] text-center">Department of Social Welfare and Development</p>
                                </div>
                                <div class="text-center text-xs">
                                    <p>Republic of the Philippines</p>
                                    <p>Municipality of Bataan</p>
                                </div>
                                <img src="{{asset('images/abucay.png')}}" alt="Logo" class="w-10 h-10 object-contain">
                            </div>
                            <p class="text-[9px] text-center pt-0.5">Municipal SOcial Welfare and Development Office (MSWDO)</p>
                            <p class="bg-blue-900 text-[10px] text-center font-semibold text-white mx-4">SOLO PARENT IDENTIFICATION CARD</p>

                            <div class="flex flex-row">
                                <div class="flex flex-col items-center pl-2 py-1">
                                    <img src="{{ $data['photo'] }}" alt="ID Card Photo" class="w-20 h-20 object-cover bg-gray-300">
                                    <div class="mt-1">
                                        <div class="h-12 border-2 border-black"></div>
                                        <p class="text-[10px] text-center font-semibold">Right Thumb Print</p>
                                    </div>
                                </div>
                                <div class="flex-1 flex flex-col px-2">
                                    <div class="flex justify-end gap-1">
                                        <strong class="text-sm font-semibold">Solo Parent ID:</strong>
                                        <span class="text-sm border-b border-black font-semibold">{{ $data['sp_id'] }}</span>
                                    </div>
                                    <div class="flex flex-col w-full">
                                        <div class="text-sm text-center w-full border-b border-black font-bold">
                                            {{ $data['name'] }}
                                        </div>
                                        <p class="text-xs text-center">Name</p>
                                    </div>
                                    <div class="flex gap-1 w-full">
                                        <p class="text-[9px]">Date and Place of Birth:</p>
                                        <span class="text-[9px] border-b border-black font-semibold flex-1">{{ $data['date_of_birth'] }} / {{ $data['place_of_birth'] }}</span>
                                    </div>
                                    <div class="flex gap-1 w-full">
                                        <p class="text-[9px]">Current Address:</p>
                                        <span class="text-[9px] border-b border-black font-semibold flex-1">{{ $data['address'] }}</span>
                                    </div>
                                    <div class="flex gap-1 w-full">
                                        <p class="text-[9px]">Solo Parent Category:</p>
                                        <span class="text-[9px] border-b border-black font-semibold flex-1">{{ $data['solo_parent_category'] }}</span>
                                    </div>
                                    <div class="flex items-center justify-center pt-4">
                                        <p class="text-[9px] text-center border-t border-black font-semibold w-24">Signature</p>
                                    </div>
                                    <div class="flex gap-1 w-full">
                                        <p class="text-[9px]">This card is Non-Transferable and valid until:</p>
                                        <span class="text-[9px] border-b border-black font-semibold flex-1"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Back ID --}}
                    <div class="space-y-2">
                        <h3 class="font-bold text-black dark:text-white">BACK</h3>
                        <div class="w-[358px] h-[228px] flex flex-col bg-white text-black rounded-lg shadow-md border p-2">
                            <div>
                                <p class="text-sm font-semibold pb-2">In case of emergency, you may contact the following:</p>
                            </div>
                            <div class="flex-1 flex items-start gap-2">
                                <div class="flex items-center justify-center">
                                    <img src="{{ $data['qr_code'] }}" alt="QR Code" class="w-32 h-32">
                                </div>
                                <div>
                                    <div class="flex items-center">
                                        <p class="text-xs mr-2">Name:</p>
                                        <div class="text-sm flex-1 border-b border-black font-bold">
                                            {{ $data['emerg_name'] }}
                                        </div>
                                    </div>

                                    <div class="flex items-center">
                                        <p class="text-xs mr-2">Relationship:</p>
                                        <div class="text-sm flex-1 border-b border-black font-bold">
                                            {{ $data['relationship_to_solo_parent'] }}
                                        </div>
                                    </div>

                                    <div class="flex items-center">
                                        <p class="text-xs mr-2">Address:</p>
                                        <div class="text-sm flex-1 border-b border-black font-bold">
                                            {{ $data['emerg_address'] }}
                                        </div>
                                    </div>

                                    <div class="flex items-center">
                                        <p class="text-xs mr-2">Contact Number:</p>
                                        <div class="text-sm flex-1 border-b border-black font-bold">
                                            {{ $data['emerg_contact_number'] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-center gap-12">
                                <div>
                                    <p class="text-center text-sm font-semibold">HON. ERIK J. MARTEL</p>
                                    <p class="text-center text-xs">City/Municipal Mayor</p>
                                </div>
                                <div>
                                    <p class="text-center text-sm font-semibold">ROSALIE B. CABRERA</p>
                                    <p class="text-center text-xs">ACTING - MSWDO</p>
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
