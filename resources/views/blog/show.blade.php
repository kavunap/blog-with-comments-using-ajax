<!DOCTYPE html>
<html>
<head>
    <title>blog List</title>
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" /> --}}

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>
    <style>
        .alert-message {
          color: red;
        }
      </style>
</head>
<body>
    <div class="container mt-3">
        <p class="mb-2"><a href="{{ url('/blogs') }}"><< blog List</a></p>
        <h3 class="mb-2 pb-1 border-bottom"><strong>Blog title:</strong>{{$blog->title}}</h3>
        <p><strong>Blog description:</strong>{{$blog->description}}</p>
        <hr/>
        {{-- blog Comments --}}
        
        {{-- ## End blog Comments --}}
    </div>

    @include('comments')
</body>
</html>