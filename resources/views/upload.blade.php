@extends('layout.app')

@section('content')

{{-- Data Table --}}
<div class="container d-none" id="uploadContainer">
<div class="row">
<div class="col-md-12 p-5">	
	<button id="uploadImage" class="btn btn-sm my-3 btn-success">Upload</button>	
		<table id="uploadTable" class="table table-striped table-sm table-bordered" style="width:100%;">
			<thead>
				<tr>
          			<th>Serial</th>
					<th>Photo</th>
					<th>Status</th>
					<th>Action</th>

				</tr>
			</thead>
			<tbody id="uploadTbody"> </tbody>
		</table>
</div>
</div>
</div>

{{-- Loader --}}
<div class="container m-4">
	<div class="row">
		<div id="uploadLoader" class="spinner-grow mx-auto mt-5" style="width: 10rem; height: 10rem;" role="status"></div>
	</div>
</div>

{{-- Upload Photo Modal --}}
<div class="modal fade" id="uploadImageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog mx-auto mt-5 cascading-modal modal-md" role="document">

    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header light-blue darken-3 white-text">
        <h4 class="title"><i class="fas fa-upload"></i>Upload Photo</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
      </div>

      <!--Body-->
      <div class="modal-body mb-0 p-3">
		
		<div class="row px-5 py-3">
					<input type="file" class="form-control my-3" id="image">
					<!-- Default inline 1-->
					<div class="custom-control custom-radio custom-control-inline mr-4">
					<input type="radio" value='paid' class="custom-control-input" id="defaultInline1" name="image-status">
					<label class="custom-control-label" for="defaultInline1" style="cursor:pointer">Paid</label>
					</div>

					<!-- Default inline 2-->
					<div class="custom-control custom-radio custom-control-inline ">
					<input type="radio" value='free' class="custom-control-input" id="defaultInline2" name="image-status">
					<label class="custom-control-label" for="defaultInline2" style="cursor:pointer">Free</label>
					</div>
		</div>
		
		
      </div>
      <!--Footer-->
      <div class="modal-footer flex-end">
        <button type="button" class="btn btn-md btn-info" data-dismiss="modal">Cancel</button>
        <button type="button" id="uploadPhotoBtn" class="btn btn-md btn-success">Upload</button>
      </div>


    </div>
    <!--/.Content-->

  </div>
</div>

{{-- Something Went Wrong --}}
<div class="container m-4"  id="uploadError">
	<div class="row  d-none">
		<h2 class="m-5 mx-auto text-center">Something Went Wrong !!</h2>
	</div>
</div>

@endsection
@section('script')
<script type="text/javascript">

retrivePhoto();

function retrivePhoto(){
	axios.get('/retrivePhoto')
	.then(function(response){
			if (response.status==200) {
				$('#uploadContainer').removeClass('d-none');
				$('#uploadLoader').addClass('d-none');

				$('#uploadTable').DataTable().destroy();
				$('#uploadTbody').empty();
				
				let data = response.data;
        		let j = 1;
				$.each(data, function(i){
					$('<tr>').html(
					"<td>"+ j++ +
          			"</td>"+"<td><img height='40' width='40' class='rounded-circle shadow d-block mx-auto' alt='' src=storage/app/images/"+data[i].image+"/></td>"+
					"<td>"+data[i].status+"</td>"+
					"<td class='text-center'><a id='deleteImg' status="+data[i].status+" delete="+data[i].id+" path="+data[i].image+" class='btn btn-sm btn-danger' ><i class='fas fa-trash'></i></a></td>"
					).appendTo('#uploadTbody');

				});
			        //Data Table Plugin Set
			        $('#uploadTable').DataTable();
			        $('.dataTables_length').addClass('bs-select');
					
					$(document).on('click','a#deleteImg',function(){
													let id=  $(this).attr('delete');
													let path=  $(this).attr('path');
													let status=  $(this).attr('status');
													deletePhoto(id, path, status);
													});
			}else{
				$('#uploadError').removeClass('d-none');
				$('#uploadLoader').addClass('d-none');
			}
	}).catch(function(error){
				$('#uploadError').removeClass('d-none');
				$('#uploadLoader').addClass('d-none');
	});
}

//Upload Image Modal
$('#uploadImage').click(function(){
  $('#uploadImageModal').modal('show');
});
//Upload photo Confirm
$('button#uploadPhotoBtn').click(function(){

		let image = $('#image').prop('files')[0];
		if (image != undefined) {
			let imgName = image.name;
			let imgSize = (image.size/(1024*1024)).toFixed(1);
			let imgExt = imgName.split('.').pop().toLowerCase();
			let status = $("input[name='image-status']:checked").val();

				if(status != undefined){
					if(imgSize > 1){toastr.error('Error! Image Must be Less then 1 MB');
					}else if(imgExt == 'jpg' || imgExt == 'png' || imgExt == 'jpeg'){

						// toastr.success('Success! Data Inserted');

						let url = '/uploadPhoto';
						let data = new FormData();
							data.append('status', status);
							data.append('key', image);
							
						let config = {headers:{'content-type':'multipart/form-data'}};

						axios.post(url, data, config).then(function(response){
							if(response.status==200){
								
								retrivePhoto();
								$("input[name='image-status']:checked").val('');
								toastr.success('Success! Image Uploaded');
								
								 $('#uploadImageModal').modal('hide');
							}

						});
				
					}else{toastr.error('Error! Unsupported Format');}

				}else{toastr.error('Error! Status Not Be Undefined');}

		}else{toastr.error('Error! Image Not Be Empty');}
});


function deletePhoto(id, path, status) {

	axios.post('/deletePhoto',{id:id,path:path,status:status})
	.then(function(response){
		if (response.status==200) {
            retrivePhoto();
			toastr.success('SUCCESS! Delete Success.');
		}else{
			toastr.error('ERROR! Delete Failed Else.');
		}  		

	});
}




</script>
@endsection