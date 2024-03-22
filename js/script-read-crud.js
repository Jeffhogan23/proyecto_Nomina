$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();

    // Add event listener for search input
    $('#search').on('keyup', function() {
        // Get the search keyword
        let keyword = $(this).val();

        // Search in the table
        $.each($('tbody tr'), function() {
            let currentRow = $(this);
            let id = currentRow.find('td:nth-child(1)').text();
            let name = currentRow.find('td:nth-child(2)').text();
            let address = currentRow.find('td:nth-child(3)').text();
            let salary = currentRow.find('td:nth-child(4)').text();

            // If keyword matches any part of the name, address or salary
            if (id.toLowerCase().includes(keyword.toLowerCase()) || name.toLowerCase().includes(keyword.toLowerCase()) || address.toLowerCase()
                .includes(keyword.toLowerCase()) || salary.toLowerCase().includes(keyword
                    .toLowerCase())) {
                currentRow.show();
            } else {
                currentRow.hide();
            }
        });
    });
});