<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
</head>

<body>
    <div class="flex-container">
        <div>
            <form id="uploadForm" enctype="multipart/form-data">
                <input type="file" id="fileInput" placeholder="drap and drop file here" style="display: none;">
                <label for="fileInput" id="dropzone"
                    style="display: block; padding: 40px 20px; border: 2px dashed #888; border-radius: 8px; background: #f1f1f1; cursor: pointer;">
                    drag and drop file here <br>
                    Click to select
                </label>
                <button type="submit">Upload</button>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>
        </div>
        <p id="result"></p>
    </div>
    @vite('resources/js/app.js')
    <script>
        //drag and drop logic
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('fileInput');

        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.style.background = '#e0e0e0';
        });

        dropzone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            dropzone.style.background = '#f1f1f1';
        });

        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.style.background = '#f1f1f1';
            const files = e.dataTransfer.files;
            document.getElementById('fileInput').files = files;
            document.getElementById('dropzone').innerText = files[0].name;
        });

        fileInput.addEventListener('change', (e) => {
            document.getElementById('dropzone').innerText = fileInput.files[0].name;
        });

        document.getElementById('uploadForm').addEventListener('submit', function (e) {
            e.preventDefault();

            // Add new row to table with upload details
            const table = document.getElementById('myTable');
            const newRow = table.insertRow(-1);
            const now = new Date();

            // Add current time
            const timeCell = newRow.insertCell(0);
            timeCell.textContent = now.toLocaleString();

            // Add filename
            const fileCell = newRow.insertCell(1);
            fileCell.textContent = fileInput.files[0].name;

            // Add status
            const statusCell = newRow.insertCell(2);
            statusCell.textContent = 'Pending';
            statusCell.id = fileInput.files[0].name;

            const formData = new FormData();
            formData.append('file', fileInput.files[0]);
            formData.append('now', now);

            fetch('/upload-endpoint', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            })
                .then(response => response.json())
                .then(data => {
                    // Show success message (ensure you have an element with id="status" in your HTML)
                    document.getElementById('result').innerText = data.error;
                    // Optionally reset the dropzone text
                    document.getElementById('dropzone').innerText = 'drag and drop file here \n Click to select';
                    fileInput.value = '';
                })
                .catch(error => {
                    console.error(error);
                    document.getElementById(fileInput.files[0].name).innerText = 'Upload failed!';
                });
        });
    </script>
    <style>
        .flex-container {
            border: 1px solid gray;
            width: 100%;
        }

        .flex-container>div {
            background-color: #f1f1f1;
            width: auto;
            padding: 10px;
            margin: 10px;
            text-align: center;
            line-height: 75px;
            font-size: 30px;
        }
    </style>

    <style>
        table {
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
        }

        th,
        td {
            text-align: left;
            padding: 16px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }
    </style>

    <table id="myTable" style="width: 100%">
        <tr>
            <th onclick="sortTable()">Time</th>
            <th onclick="sortTable()">File Name</th>
            <th onclick="sortTable()">Status</th>
        </tr>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            //websocket logic
            window.Echo.channel("statusChannel").listen("fileEvent", (e) => {
                // Find the row with matching filename and update its status
                const statusCell = document.getElementById(e.fileName);
                if (statusCell) {
                    statusCell.textContent = e.status;
                }
                console.log('Status updated:', e.fileName, e.status);
            });
        });
        function sortTable() {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("myTable");
            switching = true;
            /*Make a loop that will continue until
        no switching has been done:*/
            while (switching) {
                //start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                /*Loop through all table rows (except the
                first, which contains table headers):*/
                for (i = 1; i < (rows.length - 1); i++) {
                    //start by saying there should be no switching:
                    shouldSwitch = false;
                    /*Get the two elements you want to compare,
                    one from current row and one from the next:*/
                    x = rows[i].getElementsByTagName("TD")[0];
                    y = rows[i + 1].getElementsByTagName("TD")[0];
                    //check if the two rows should switch place:
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    /*If a switch has been marked, make the switch
                    and mark that a switch has been done:*/
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
        }
    </script>
</body>

</html>
