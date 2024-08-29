$('.table_ssp_ledger').DataTable({
    serverSide: true,
    processing: true,
    searching: true,
    ajax: {
        url: 'ajax/sspLedger.ajax.php', // Update the URL to match your PHP script location
        type: 'POST',  // Use POST as the PHP script expects POST data
        data: function (d) {
            // Map DataTables parameters to PHP parameters
            return {
                draw: d.draw,
                start: d.start,
                length: d.length,
                search: {
                    value: d.search.value // DataTables search value
                },
                order: d.order // DataTables sorting parameters
            };
        },
        dataSrc: function (json) {
            if (json.error) {
                console.error('Error loading data:', json.error);
                return [];
            }
            return json.data;
        }
    },
    columns: [
        { data: 2 },
        { data: 1 },
        { data: 3 },
        { data: 4 },
        { data: 0 },
        { data: 5 },
        { data: 6 },
        { data: 7 }
    ],
    // Additional settings if needed
    deferRender: true,
    retrieve: true,
    // Optional: Add custom sorting or paging options if necessary
});
