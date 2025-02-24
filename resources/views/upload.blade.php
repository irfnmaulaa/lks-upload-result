<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload Hasil LKS</title>
    <link rel="stylesheet" href="{{ asset('public/css/bootstrap.min.css') }}">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            background: #151515;
            color: #FFF;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5 my-5">
            @if(session('message'))
                <div class="alert bg-success text-white">
                    {{ session('message') }}
                </div>
            @endif
            <div class="border p-3 rounded">
                <h3>Upload Hasil LKS</h3>
                <p>File 1: <strong>XX_MODULE_BACKEND.zip</strong> <br>File 2: <strong>XX_MODULE_FRONTEND.zip</strong></p>
                <form action="{{ route('up') }}" method="POST" enctype="multipart/form-data" id="form-upload">
                    @csrf
                    <input type="file" name="file" id="file" class="form-control mb-2">
                </form>
                <div id="uploading-message" class="border bg-primary p-2 px-3 rounded d-none">
                    Tunggu bentar, lagi upload...
                </div>
                <hr>
                <div class="mb-2">
                    Sudah mengumpulkan:
                </div>
                <div id="files" class="d-flex flex-column gap-2">
                    @foreach($files as $file)
                        <div class="border rounded p-2" style="font-size: 18px;">
                            {{$file}}
                        </div>
                    @endforeach
                    @if(count($files) <= 0)
                        <div class="border rounded p-2" style="font-size: 18px;">
                            Belum ada
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    const file = document.getElementById('file')
    const formUpload = document.getElementById('form-upload')
    const uploadingMessage = document.getElementById('uploading-message')
    const fileList = document.getElementById('files')

    let isUploading = false
    function setIsUploading(value) {
        isUploading = value

        if(isUploading) {
            formUpload.classList.add('d-none')
            uploadingMessage.classList.remove('d-none')
        } else {
            formUpload.classList.remove('d-none')
            uploadingMessage.classList.add('d-none')
        }
    }

    file.addEventListener('change', function(e) {
        e.preventDefault()
        formUpload.submit()

        setIsUploading(true)
    })

    async function getFiles() {
        const response = await fetch('{{ route('files') }}')
        const json = await response.json()

        if(json.length > 0) {
            fileList.innerHTML = json.map(item => (`
            <div class="border rounded p-2" style="font-size: 18px;">
                ${item}
            </div>
        `)).join('')
        } else {
            fileList.innerHTML = `
            <div class="border rounded p-2" style="font-size: 18px;">
                Belum ada
            </div>
        `
        }
    }

    setInterval(() => {
        getFiles()
    }, 3000)
</script>

@if($errors->any())
    @foreach($errors->all() as $error)
        <script>
            alert('ERROR: {{$error}}')
        </script>
    @endforeach
@endif

</body>
</html>
