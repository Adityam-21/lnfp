<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Users</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <h2>Import Users from Excel/CSV</h2>

    <div id="messages"></div> <!-- Error and success messages will be shown here -->

    <form id="importForm" enctype="multipart/form-data">
        @csrf
        <label for="file">Upload CSV/XLSX File:</label>
        <input type="file" name="file" id="file" required>

        <button type="submit" class="btn btn-primary">Import Users</button>
    </form>

    <script>
        $(document).ready(function() {
            $('#importForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('user.import') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $('#messages').html('<p style="color: blue;">Uploading...</p>');
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#messages').html('<p style="color: green;">' + response.success + '</p>');
                            $('#importForm')[0].reset(); // Reset form after success
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorHtml = '<div style="color: red;"><ul>';
                            $.each(errors, function(key, value) {
                                errorHtml += '<li>' + value[0] + '</li>';
                            });
                            errorHtml += '</ul></div>';
                            $('#messages').html(errorHtml);
                        } else {
                            $('#messages').html('<p style="color: red;">Something went wrong!</p>');
                        }
                    }
                });
            });

            $('#file').on('change', function() {
                const allowedTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vnd.ms-excel', 'text/csv'
                ];
                const file = this.files[0];

                if (file && !allowedTypes.includes(file.type)) {
                    alert("Invalid file type! Please upload a valid CSV or Excel file.");
                    this.value = ''; // Clear file input
                }
            });
        });
    </script>

</body>

</html>
