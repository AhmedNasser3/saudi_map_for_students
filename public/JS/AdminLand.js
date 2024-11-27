// pdf excel download
$(document).ready(function() {
    $('#userTable').DataTable({
        dom: 'Bfrtip', // Enables Buttons, Filtering, and Pagination
        buttons: [{
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> Export CSV',
                className: 'btn btn-primary'
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Export Excel',
                className: 'btn btn-success'
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> Export PDF',
                className: 'btn btn-danger'
            }
        ],
        responsive: true, // Makes the table responsive
        pageLength: 25, // Default rows per page
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ], // Rows per page options
        language: {
            search: "Search:", // Custom label for search
            paginate: {
                previous: "Prev",
                next: "Next"
            }
        }
    });
});

// image show in creation
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var preview = document.getElementById('preview');
        preview.src = reader.result;
        preview.style.display = 'block';
    }
    reader.readAsDataURL(event.target.files[0]);
}
