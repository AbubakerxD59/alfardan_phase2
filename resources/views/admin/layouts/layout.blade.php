<!DOCTYPE html>
<html>
  <head>
  	<title>ALFARDAN | @yield('title')</title>
  	<meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
      <meta name="viewport" content="width=device-width, initial-scale=1">
	   <meta http-equiv="refresh" content="3600">

      <!-- Bootstrap core CSS -->
      <link href="{{asset('alfardan/css/bootstrap.min.css')}}" rel="stylesheet">
      <!-- Custom styles  -->
      <link rel="stylesheet" type="text/css" href="{{asset('alfardan/css/style.css')}}">

       <link rel="stylesheet" type="text/css" href="{{asset('alfardan/css/jquery.multiselect.css')}}">

      <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
      
      <link rel="stylesheet" type="text/css" href="{{asset('alfardan/css/slick-theme.css')}}">
      
      <link rel="stylesheet" type="text/css" href="{{asset('alfardan/css/slick.css')}}">

      <link rel="stylesheet" type="text/css" href="{{asset('alfardan/css/jquery.mCustomScrollbar.css')}}">

      <link rel="stylesheet" href="{{asset('richtexteditor/rte_theme_default.css')}}" />


      @yield('css')
      <style>
        /*.swal-text,
        .swal-title{
            color: #fff !important;
        }*/
        .swal-overlay--show-modal .swal-modal{
            /*background-color: #000 !important;*/
            border: 1px solid #707070 !important;
        }
        .swal-button--danger{
            background-color: #C89328 !important;
            width: 133px !important;
        }
        .swal-button--cancel{
          background-color: #000 !important;
          color: #fff !important;
          border: 1px solid #C89328 !important;
          width: 133px !important;
        }
      </style>
  </head>
  <body>
    <!-- <div class="wrapper"> -->
      
  <!-- Image loader -->
  <div id="loader" style="display: none;top: 15%;left: 0;z-index: 100000;text-align: center;width: 100%;position: absolute;padding: 0% 45%;">
    <img src="{{asset('loader.gif')}}"  style="width: 100%;">
  </div>
  <div  id="preloaders" class="preloader"  style="top: 15%;left: 0;z-index: 100000;text-align: center;width: 100%;position: absolute;padding: 0% 45%;">
    <img src="{{asset('loader.gif')}}" class="pre-img" style="width: 100%;">
  </div>
  <!-- Image loader -->
	  @yield('content')
    <!-- </div> -->

    <script src="{{asset('alfardan/js/bootstrap.bundle.js')}}"></script>
	  <script src="{{asset('alfardan/js/jquery.min.js')}}"></script>
    <script  src="{{asset('alfardan/js/jquery.multiselect.js')}}"></script>
    <script src="{{asset('alfardan/js/fontawesome.js')}}"></script>
    <script src="{{asset('alfardan/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script src="{{asset('alfardan/js/main.js')}}"></script>
    <script src="{{asset('alfardan/js/uploadPreview.min.js')}}"></script>
    <!-- <script src="{{asset('alfardan/js/multiselect.min.js')}}"></script> -->
    <script src="{{asset('alfardan/js/slick.min.js')}}"></script>


    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>


    <script>
      $(window).on('load',function() 
        {          
          $("#preloaders").fadeOut(2000);
      });
    </script>

    <script>
      $(document).ready( function () {
        $('#myTable').DataTable({
          "ordering": false,
			'iDisplayLength': 25
           
        });
      });
    </script>
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
   <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script>
 
     $('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          var name = $(this).data("name");
          event.preventDefault();

          swal({
              title: `Are you sure you want to delete this record?`,
              text: "If you delete this, it will be gone forever.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              form.submit();
            }
          });
      });
    </script>  --> 

    <script>
      
      // insert user data in edit popup modal  
      // $('#editUser').on('show.bs.modal', function (event) {
      //   var button = $(event.relatedTarget) 
      //   var firstname = button.data('firstname')
      //   var lastname = button.data('lastname')
      //   var email = button.data('email')
      //   var phone = button.data('phone')
      //   var apt = button.data('apt')
      //   var userid = button.data('userid')
      //   var image = button.data('userimage')
      //   console.log(image)

      //   var modal = $(this)
      //   modal.find('.modal-body #first_name').val(firstname);
      //   modal.find('.modal-body #last_name').val(lastname);
      //   modal.find('.modal-body #email').val(email);
      //   modal.find('.modal-body #mobile').val(phone);
      //   modal.find('.modal-body #apt').val(apt);
      //   modal.find('.modal-body #userid').val(userid);
      //   $("#add-tenant-img-preview").css("background-image", "url(" + image + ")");
      // })

      // delete select user popup modal
      $('#remove-item').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget) 

        var user_id = button.data('userid') 
        var modal = $(this)

        modal.find('.modal-body #user_id').val(user_id);
      })

      // reject accept user request for tenant popup
      
      $('#reject-item').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget) 

        var user_id = button.data('userid') 
        var modal = $(this)

        modal.find('.modal-body #userid').val(user_id);
      })
    </script> 
    <script type="text/javascript">
      $(document).ready(function(){

        $(".profile-slider").slick({
        lazyLoad: 'ondemand', // ondemand progressive anticipated
        infinite: true
      });
      });
    </script>

    <script type="text/javascript"
    src="https://maps.google.com/maps/api/js?key={{env('google_map_key')}}&libraries=places" ></script>
    <!-- <script>
      $(document).ready(function () {
        $("#latitudeArea").addClass("d-none");
        $("#longtitudeArea").addClass("d-none");
      });
    </script> -->
    <script>
      google.maps.event.addDomListener(window, 'load', initialize);

      function initialize(input) {
      console.log(input);
       

        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.addListener('place_changed', function () {
          var place = autocomplete.getPlace();
          $('.latitude').val(place.geometry['location'].lat());
          $('.longitude').val(place.geometry['location'].lng());

          // $("#latitudeArea").removeClass("d-none");
          // $("#longtitudeArea").removeClass("d-none");
        });



      }
       var inputs = $("input.location");//document.getElementsByClassName('location');
        
        for(var i=0;i<inputs.length;i++){
          initialize(inputs[i]);
        }
		
		 
    </script>

    <style type="text/css">
  


#addeditbookeduser .add-user-holder{
      max-width: 630px;
      margin: 0 auto;
}
#addeditbookeduser .body-wrapper h2 {
    font-size: 23px;
    font-weight: bold;
    color: #fff;
}
#addeditbookeduser .modal-content {
    background-color: #2B2B2B;
}
#addeditbookeduser .body-wrapper {
    height: 100%;
    background-color: #2B2B2B;
    margin-bottom: 0px;
}
#addeditbookeduser .table-cap {
    line-height: 31px;
    border-bottom: 2px solid #707070;
    display: inline-block;
}
#addeditbookeduser .body-wrapper .add-user-form-wrapper input {
    font-size: 13px;
    color: #fff;
    display: block;
    background-color: transparent;
    border: 1px solid #707070;
    border-radius: 0;
    width: 100%;
    height: 37px;
    margin-bottom: 10px;
    padding-left: 5px;
}
#addeditbookeduser .body-wrapper .status-input input{
    height: 110px;
}
#addeditbookeduser .body-wrapper .add-user-form-wrapper label {
    font-size: 13px;
    font-weight: bold;
    color: #fff;
    display: inline-block;
    padding-bottom: 10px;
}
#addeditbookeduser select option {
    color: #000;
}
</style>
    @stack('script') 
    
  </body>
</html>
