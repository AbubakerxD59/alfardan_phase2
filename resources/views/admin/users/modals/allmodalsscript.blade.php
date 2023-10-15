<script type="text/javascript">
// document.ready function
  $(function() {
	$("#users-table").on("click", ".table-edit", function(e){
		$('#editform').trigger("reset");
		var id=$(this).attr('id');
		$.ajax({
			url:"{{route('admin.users.index')}}/"+id+"/edit",
            beforeSend: function(){
				$("#loader").show();
				$("#editUserbody").html("");
            },
			success : function(response) {
               $("#editUserbody").html(response);
            },
            complete:function(data){
            	$("#loader").hide();
           }
          });
      });
	  
	$.uploadPreview({
		input_field: "#edit-profile-upload-modal",
		preview_box: "#profile-img-preview",
		label_field: "#profile-img-preview label"
	});
	  
	  $("#editUser").on('change',".registered_as",function() {
		 var registered_as=$(this).val();
		  $('#editUser .leasing_type').val("");
		  
		  $('#editUser .leasing_type  option').each(function(i, obj) {
			  obj=$(this);
			 if(registered_as=='FAMILY MEMBER'){
		  		obj.prop('disabled', false);
				 obj.show();
		  	 }else{
		  		obj.prop('disabled', true);	
				 obj.hide();
			 }
			  
			 if(registered_as==obj.val()){
			  	obj.prop('disabled', false);
				obj.show();
		  		$('#editUser .leasing_type').val(registered_as);
			 }
		});
	 });
	  
	  
	  $("#editUser").on('change',".property",function() {
		 var property=$(this).val();
		  
		  if($(this).hasClass( "profile-tenant-form" )){
			property=$(this).find( ".property_radio" ).val();
		  
		  }
		  
		  var allprids = [];
		  allprids.push(property);
 
		  $.ajax({
			  url: "{{ route('admin.apartmentslist') }}",
			  type: 'Post',
			  data: {
				  'ids': allprids,
				  _token: '{{ csrf_token() }}'
			  },
			  dataType: 'json',
			  beforeSend: function() {
				  // Show image container
				  $("#loader").show();
			  },success: function(response) {
				  var apartment=$("#editUser .apartment");
				  var aps = apartment.attr("data-apartment_id");
				  
				  apartment.html("");
				  apartment.val(aps);
				  $.each(response, function(index, value) {
					  var option = {
						  value: value.id,
						  text: value.name
					  };
					  if (value.id==parseInt(aps)) {
						  option.selected = "selected";
					  }
					  apartment.append($('<option>', option));
				  });
			  },
			  complete: function(data) {
				  // Hide image container
				  $("#loader").hide();
			  }
		  });
	 });
	  
  });
</script>
 