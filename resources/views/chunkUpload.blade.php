<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Chunk File Upload in Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card w-50 m-auto">
                    <div class="card-header bg-info text-white">
                        <h4>Chunk File Upload in Laravel</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group" id="file-input">
                            <input type="file" id="pickfiles" class="form-control">
                            <div id="filelist"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    {{-- <script src="{{ asset('/plupload/js/plupload.full.min.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/plupload/3.1.5/plupload.full.min.js" integrity="sha512-yLlgKhLJjLhTYMuClLJ8GGEzwSCn/uwigfXug5Wf2uU5UdOtA8WRSMJHJcZ+mHgHmNY+lDc/Sfp86IT9hve0Rg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var path = "{{ asset('/plupload/js/') }}";

            var uploader = new plupload.Uploader({
                browse_button: 'pickfiles',
                container: document.getElementById('file-input'),
                url: '{{ route('chunk.store') }}',
                // url: '{{ route('upload') }}',

                chunk_size: '90mb', // 1 MB
                max_retries: 2,
                filters: {
                    //max_file_size: '200mb'
                },
                multipart_params: {
                    // Extra Parameter
                    "_token": "{{ csrf_token() }}"
                },
                init: {
                    PostInit: function() {
                        document.getElementById('filelist').innerHTML = '';
                    },
                    FilesAdded: function(up, files) {
                        plupload.each(files, function(file) {
                            console.log('FilesAdded');
                            console.log(file);
                            document.getElementById('filelist').innerHTML += '<div id="' + file
                                .id + '">' + file.name + ' (' + plupload.formatSize(file.size) +
                                ') <b></b></div>';
                        });
                        uploader.start();
                    },
                    UploadProgress: function(up, file) {
                        console.log('UploadProgress');
                        console.log(file);
                        document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML =
                            '<span>' + file.percent + "%</span>";
                    },
                    FileUploaded: function(up, file, result) {

                        console.log('FileUploaded');
                        console.log(file);
                        console.log(JSON.parse(result.response));
                        responseResult = JSON.parse(result.response);

                        if (responseResult.ok == 0) {
                            toastr.error(responseResult.info, 'Error Alert', {
                                timeOut: 5000
                            });
                        }
                        if (result.status != 200) {
                            toastr.error('Your File Uploaded Not Successfully!!', 'Error Alert', {
                                timeOut: 5000
                            });
                        }
                        if (responseResult.ok == 1 && result.status == 200) {
                            toastr.success('Your File Uploaded Successfully!!', 'Success Alert', {
                                timeOut: 5000
                            });
                        }
                    },
                    UploadComplete: function(up, file) {
                        // toastr.success('Your File Uploaded Successfully!!', 'Success Alert', {timeOut: 5000});
                    },
                    Error: function(up, err) {
                        // DO YOUR ERROR HANDLING!
                        toastr.error('Your File Uploaded Not Successfully!!', 'Error Alert', {
                            timeOut: 5000
                        });
                        console.log(err);
                    }
                }
            });
            uploader.init();
        });
    </script>
</body>

</html>
