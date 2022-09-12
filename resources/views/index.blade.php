@php
    $getFiles = App\Models\UploadFile::all();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <title>CSV</title>
</head>
<body>
    <form id="CreateCSVForm" method="post">
        <input type="number" name="variationNumber" id="variationNumber">
        <button type="submit">Generate CSV</button>
    </form>
    <br>
    <form id="UploadFileForm" method="post" enctype="multipart/form-data">
        <input type="file" name="myFile" id="myFile">
        <button type="submit">Upload File</button>
    </form>
    @if($getFiles->count() > 0)
        <table>
            <tr>
                <th>File Name</th>
                <th>Action</th>
            </tr>
            @php
                foreach($getFiles as $file){
            @endphp
                <tr>
                    <td>{{$file->FileName}}</td>
                    <td><button type="submit" onClick="window.open('files/{{$file->FileName}}')">View File</button></td>
                </tr> 
            @php
                }
            @endphp
        </table>
    @endif

    <script>
        $("#CreateCSVForm").submit(function(e){
            e.preventDefault();
            
            if($("#variationNumber").val() == ""){
                alert('Number of records is required');
            }
            else if($("#variationNumber").val() < 1){
                alert('Number of records must be above zero');
            }
            else{
                var formData = new FormData($("#CreateCSVForm")[0]);

                formData.append('_token', '{{ csrf_token() }}');

                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route ("SaveData") }}',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data){
                        alert(data.status);
                        console.log(data);
                    },
                    error: function(error){
                        // alert(error.error);
                        console.log(error);
                    }
                });
            }
        });

        //Upload file
        $("#UploadFileForm").submit(function(e){
            e.preventDefault();
            if($("#myFile").val() == ''){
                alert('File is required');
            }
            else{
                var formData = new FormData($("#UploadFileForm")[0]);

                formData.append('_token', '{{ csrf_token() }}');

                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route ("UploadFile") }}',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data){
                        alert("File Uploaded, with the name of " + data);
                        window.location.reload();
                        console.log(data);
                    },
                    error: function(error){
                        // alert(error.error);
                        console.log(error);
                    }
                });
            }
        });
    </script>
</body>
</html>