@extends("template.main")
@section('title', 'Contact List')
@section('body')
<div class="row d-flex justify-content-center m-5">
    <div class="col-xl-8">
        <h2 style="margin-bottom: 20px;">Active Contacts</h2>
        <table class="table" id="active_contacts_table" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr>
                    <th style="background-color: #f2f2f2; font-weight: bold; text-align: left; padding: 8px;">Name</th>
                    <th style="background-color: #f2f2f2; font-weight: bold; text-align: left; padding: 8px;">Email</th>
                    <th style="background-color: #f2f2f2; font-weight: bold; text-align: left; padding: 8px;">Phone</th>
                    <th style="background-color: #f2f2f2; font-weight: bold; text-align: left; padding: 8px;">Message</th>
                    <th style="background-color: #f2f2f2; font-weight: bold; text-align: left; padding: 8px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                // Convert the list of contacts to an array
                $contactsArray = [];
                foreach ($contacts as $index => $contact) {
                    if (!isset($contact['deleted']) || $contact['deleted'] == false) {
                        $contactsArray[] = $contact;
                    }
                }
                @endphp

                @foreach ($contactsArray as $index => $contact)
                <tr id="contact_row_{{ $index }}">
                    <td style="padding: 8px;">{{ $contact['name'] }}</td>
                    <td style="padding: 8px;">{{ $contact['email'] }}</td>
                    <td style="padding: 8px;">{{ $contact['phone'] }}</td>
                    <td style="padding: 8px;">{{ $contact['message'] }}</td>
                    <td style="padding: 8px;">
                        <button class="btn btn-danger"
                            onclick="deleteContact('{{ $contact['email'] }}', '{{ $index }}')" style="padding: 8px 16px; border: none; cursor: pointer; border-radius: 4px; background-color: #ffc6c4; color: white;">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        </div>
</div>

<script>
    // JavaScript
    function deleteContact(email, index) {
        if (confirm("Are you sure you want to delete this contact?")) {
            var rowId = 'contact_row_' + index;
            var row = document.getElementById(rowId);
            row.style.display = 'none';

            $.ajax({
                url: '/delete-contact',
                type: 'POST',
                data: { email: email, _token: '{{ csrf_token() }}', action: 'delete' },
                success: function(response) {
                    if (!response.success) {
                        row.style.display = '';
                        alert('Failed to delete contact. Please try again.');
                    } else {
                        // If deletion is successful, remove the contact from the array
                        var deletedContactsTable = document.getElementById('deleted_contacts_table');
                        var newRow = row.cloneNode(true); // Clone the row
                        newRow.id = ''; // Remove the id attribute to prevent conflicts
                        deletedContactsTable.querySelector('tbody').appendChild(newRow);
                        row.remove(); // Remove the original row

                        // Update the contacts array by removing the deleted contact
                        // Find the index of the contact in the array
                        var deletedIndex = {{ $index }};

                        // Remove the contact from the array
                        contactsArray.splice(deletedIndex, 1);
                    }
                },
                error: function(xhr, status, error) {
                    row.style.display = '';
                    console.error(xhr.responseText);
                    alert('Failed to delete contact. Please try again.');
                }
            });
        }
    }

    function clearAllCookies() {
    // Clear specific contact-related cookies here
    clearCookie('contact_list');
    clearCookie('deleted_contacts_list');
    // You can add more cookie names if needed

    // Reload the page after clearing cookies
    location.reload();
}

function clearCookie(cookieName) {
    document.cookie = cookieName + '=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/';
}

document.getElementById('clear-cookies-btn').addEventListener('click', function() {
    // Call the function to clear all cookies
    clearAllCookies();
});



</script>
@endsection
