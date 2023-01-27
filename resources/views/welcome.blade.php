<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Cloud Storage Service </title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    </head>

    <body class="antialiased">
    @if($errors->any())
        <div class = "alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif
    <div class="container">
        <h1 class="mb-2">Hello, {{auth()->user()->name}}</h1>
        @if (isset($storage_size))
            <h2>Total storage size {{$storage_size}}</h2>
        @endif
        @if (Route::current()->getName()!='file.index')
            <a href="/" class="btn btn-success my-2">Back</a>
        @endif
        @if (isset($current_folder))
            <div class="mt-2"><span class="badge bg-secondary text-white btn">{{$current_folder->title}}</span> </div>
        @else
            <div class="col-12 col-md-6">
                <form method="post" action="{{route('folder.create')}}" >
                    @csrf
                    <div class="row">
                        <div class="form-group col-6">
                            <input name="title" required class="form-control">
                        </div>
                        <div class="form-group col-6">
                            <input type="submit" class="form-control btn btn-primary" value="Create folder">
                        </div>
                    </div>

                </form>
            </div>
        @endif
        <div class="folders my-4">
            @if (isset($folders))
                @foreach($folders as $folder)
                    <span class="badge bg-primary mb-2"><a class="btn text-white" href="{{route('folder',['id'=>$folder->id])}}">{{$folder->title}} </a></span>
                @endforeach
            @endif
        </div>
        <div class="my-4 ">
            <form method="post" action="{{route('file.store')}}" enctype="multipart/form-data" >
                @csrf
                <div class="form-group  col-12 col-md-6">
                    <input type="file" name="file" class="form-control" required>
                    <input type="hidden" name="folder_id" value="{{$current_folder->id??''}}">
                </div>
                <div class="form-group col-12 col-md-6">
                    <input type="submit" class="form-control btn btn-success mt-2">
                </div>
            </form>
        </div>
        <div class="files   ">
            @if (count($files))
                <h2 >Your files in this folder ({{$size}} MB)</h2>
                @foreach($files as $file)
                    <div class="row mt-2">
                        <div class="col-4">
                            <a href="{{route('file',['id'=>$file->id])}}">{{$file->name}} - {{$file->sizemb}}MB</a>
                        </div>
                        <div class="col-6">
                            <form method="post" action="{{route('file.update',['id'=>$file->id])}}" >
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-group col-6">
                                        <input name="title" required class="form-control">
                                    </div>
                                    <div class="form-group col-6">
                                        <input type="submit" class="form-control btn btn-primary" value="Rename">
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="col-2">
                            <form method="post" action="{{route('file.update',['id'=>$file->id])}}" >
                                @csrf
                                @method('DELETE')
                                <input type="submit" class="form-control btn btn-danger" value="Delete">
                            </form>
                        </div>

                    </div>
                <hr>
                @endforeach
@endif
        </div>

    </div>


    </body>
</html>
