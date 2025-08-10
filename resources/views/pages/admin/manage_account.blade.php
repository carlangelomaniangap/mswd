@section('title', 'Manage Account')

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Manage Account') }}
            </h2>
        </div>
    </x-slot>

    <div class="px-4 py-2 bg-white dark:bg-dark-eval-1">
        <table id="ManageAccount" class="text-sm border border-gray-500 display nowrap" style="width:100%">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th>Role</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>

        {{-- Reset Password Modal --}}
        <x-modal name="reset-password" maxWidth="xs" height="fit">
            <div class="max-h-full flex flex-col">
                <div class="p-4 flex justify-between items-center bg-blue-600">
                    <h2 class="text-md font-medium text-white dark:text-gray-100">Reset Password</h2>
                    <button type="button" class="text-white hover:bg-blue-500 p-2 rounded-md" x-on:click="$dispatch('close-modal', 'reset-password')">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                        </svg>
                    </button>
                </div>

                <div id="resetPasswordContainer" class="p-4">
                    <form id="resetPassword" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="userId" name="user_id">

                        <div class="flex space-x-2 pb-4">
                            <p>Name:</p>
                            <h4 class="underline" id="name"></h4>
                        </div>

                        <div class="grid grid-cols-1 grid-rows-2 gap-2">
                            <div>
                                <x-form.label
                                    for="new_password"
                                    class="block"
                                >
                                    New Password
                                    <sup class="text-red-500">*</sup>
                                </x-form.label>
                                <div class="relative">
                                    <x-form.input
                                        id="new_password"
                                        class="w-full"
                                        type="password"
                                        name="password"
                                        placeholder="New Password"
                                        required
                                    />
                                    <button
                                        type="button"
                                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500"
                                        onclick="togglePassword('new_password', 'showPassword', 'hiddenPassword')"
                                    >
                                        <!-- Show Password -->
                                        <svg id="showPassword" class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        </svg>

                                        <!-- Hidden Password -->
                                        <svg id="hiddenPassword" class="w-5 h-5 text-gray-800 dark:text-white hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <x-form.label
                                    for="password_confirmation"
                                    class="block"
                                >
                                    Password Confirmation
                                </x-form.label>
                                <div class="relative">
                                    <x-form.input
                                        id="password_confirmation"
                                        class="w-full"
                                        type="password"
                                        name="password_confirmation"
                                        placeholder="Password Confirmation"
                                        required
                                    />
                                    <button
                                        type="button"
                                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500"
                                        onclick="togglePassword('password_confirmation', 'showPasswordConfirmation', 'hiddenPasswordConfirmation')"
                                    >
                                        <!-- Show Password Confirmation -->
                                        <svg id="showPasswordConfirmation" class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        </svg>

                                        <!--  Hidden Password Confirmation -->
                                        <svg id="hiddenPasswordConfirmation" class="w-5 h-5 text-gray-800 dark:text-white hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <x-button type="submit" variant="success" class="ml-2">Save</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </x-modal>
    </div>

</x-app-layout>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Fetch all users --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#ManageAccount').DataTable({
            ajax: {
                url: '/admin/manage_account/data',
                dataSrc: 'data'
            },
            ordering: false,
            columns: [
                { data: 'role' },
                { data: 'name' },
                { data: 'email' },
                {
                    render: function (data, type, row) {
                        return `
                            <x-button 
                                variant="primary"
                                size="sm"
                                data-id="${row.id}"
                                data-name="${row.name}"
                                x-on:click="$dispatch('open-modal', 'reset-password')"
                            >
                                <svg class="w-4 h-4 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2" d="M7 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h1m4-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm7.441 1.559a1.907 1.907 0 0 1 0 2.698l-6.069 6.069L10 19l.674-3.372 6.07-6.07a1.907 1.907 0 0 1 2.697 0Z"/>
                                </svg>
                                Reset Password
                            </x-button>
                        `;
                    }
                }
            ],
            responsive: true,
            paging: false,
            searching: false,
            info: false,
            lengthChange: false
        });
    });
</script>

{{-- Reset Password Script --}}
<script>
    $(document).on('click', '[data-id]', function () {
        const btn = $(this);

        $('#userId').val(btn.data('id'));
        $('#name').text(btn.data('name'));
    });

    $(document).ready(function () {
        $('#resetPassword').on('submit', function (e) {
            e.preventDefault();

            const id = $('#userId').val();
            const formData = new FormData(this); // get the form input data

            $.ajax({
                url: `/admin/manage_account/${id}/update`,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            $('#resetPassword')[0].reset(); // Clear form
                            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'reset-password' })); // close the modal
                            $('#ManageAccount').DataTable().ajax.reload(null, false); // reload the table
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: response.message,
                        });
                    }
                }
            });
        });
    });
</script>

<script>
    function togglePassword(inputId, showIconId, hiddenIconId) {
        const input = document.getElementById(inputId);
        const passwordShow = document.getElementById(showIconId);
        const passwordHidden = document.getElementById(hiddenIconId);

        if (input.type === 'password') {
            input.type = 'text';
            passwordShow.classList.add('hidden');
            passwordHidden.classList.remove('hidden');
        } else {
            input.type = 'password';
            passwordShow.classList.remove('hidden');
            passwordHidden.classList.add('hidden');
        }
    }
</script>

<script>
    window.addEventListener('close-modal', function (event) {
        if (event.detail === 'reset-password') {
            $('#resetPassword')[0].reset();

            // Make sure the password fields are hidden again
            document.getElementById('new_password').type = 'password';
            document.getElementById('password_confirmation').type = 'password';

            // Reset icons "means password is hidden"
            document.getElementById('showPassword').classList.remove('hidden');
            document.getElementById('hiddenPassword').classList.add('hidden');

            document.getElementById('showPasswordConfirmation').classList.remove('hidden');
            document.getElementById('hiddenPasswordConfirmation').classList.add('hidden');
        }
    });
</script>
