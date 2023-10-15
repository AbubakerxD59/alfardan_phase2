<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap core CSS -->
    <link href="{{asset('alfardan/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Custom styles  -->
    <link rel="stylesheet" type="text/css" href="{{asset('alfardan/css/style.css')}}">
</head>
<body>
	@yield('content')

	<script src="{{asset('alfardan/js/jquery.min.js')}}"></script>
    <script src="{{asset('alfardan/js/bootstrap.bundle.js')}}"></script>
    <script src="{{asset('alfardan/js/fontawesome.js')}}"></script>
    <script src="{{asset('alfardan/js/main.js')}}"></script>
    <script src="{{asset('alfardan/js/uploadPreview.min.js')}}"></script>

     <script>
        $(document).ready(function() {
    $.uploadPreview({
      // for add modal
    input_field: "#add-tenant-img-upload",
    preview_box: "#add-tenant-img-preview",
    label_field: "#add-tenant-img-label"
    });
    });
    </script>
</body>
</html>