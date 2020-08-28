@extends('layout.app')
@section('content')
{{-- Data Table --}}
<div class="container d-none" id="contractTable">
<div class="row">
<div class="col-md-12 p-4">	
		<table id="contractMainTable"  class="table table-striped table-sm table-bordered" style="width:100%;">
			<thead>
				<tr>
					<th>Name</th>
					<th>Mobile</th>
					<th>Email</th>
					<th>Message</th>
					<th>Delete</th>

				</tr>
			</thead>
			<tbody id="contractDataTbody"> </tbody>
		</table>
</div>
</div>
</div>

{{-- Loader --}}
<div class="container m-4">
	<div class="row">
		<div id="contractPreloader" class="spinner-grow mx-auto mt-5" style="width: 10rem; height: 10rem;" role="status"></div>
	</div>
</div>

{{-- Something Went Wrong --}}
<div class="container m-4 d-none"  id="contractError">
	<div class="row ">
		<h2 class="m-5 mx-auto text-center">Something Went Wrong !!</h2>
	</div>
</div>

{{-- Delete Student Modal --}}
<div class="modal fade" id="deleteContractModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog cascading-modal" role="document">

    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header light-blue darken-3 white-text">
        <h4 class="title"><i class="fas fa-user-graduate"></i>Want To Delete</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
      </div>

      <!--Footer-->
      <div class="modal-footer flex-end">
        <button type="button" class="btn btn-sm btn-info" data-dismiss="modal">No</button>
        <button type="button" id="contractDeleteConfirm" class="btn btn-sm btn-danger">Yes</button>
      </div>


    </div>
    <!--/.Content-->

  </div>
</div>

@endsection
@section('script')
<script type="text/javascript">
allContractData();
function allContractData(){
	axios.get('/allContractData').then(function(response){

			if (response.status==200) {
				$('#contractTable').removeClass('d-none');
				$('#contractPreloader').addClass('d-none');

				$('#contractMainTable').DataTable().destroy();
				$('#contractDataTbody').empty();
				
				let data = response.data;
				$.each(data, function(i){

					$('<tr>').html(
					"<td>"+data[i].name+"</td>"+
					"<td>"+data[i].mobile+"</td>"+
					"<td>"+data[i].email+"</td>"+
					"<td>"+data[i].message+"</td>"+
					"<td><a id ='contractDeleteBtn' delete="+data[i].id+" class='btn btn-sm btn-danger mr-1' title='Delete Contract' ><i class='fas fa-trash-alt'></i></a></td>"

					).appendTo('#contractDataTbody')

				});


				$('a#contractDeleteBtn').click(function(){
					let id= $(this).attr('delete');
				 	$('#deleteContractModal').modal('show');
				 	$('#contractDeleteConfirm').attr('delete',id);
				 	

				})

				//Data Table Plugin Set
				$('#contractMainTable').DataTable();
				$('.dataTables_length').addClass('bs-select');



			}else{
				$('#contractError').removeClass('d-none');
				$('#contractPreloader').addClass('d-none');
			}
	}).catch(function(error){
				$('#contractError').removeClass('d-none');
				$('#contractPreloader').addClass('d-none');
	});
}

//Course Delete Confirm Btn
$('#contractDeleteConfirm').click(function(){
  let id = $(this).attr('delete');
  deleteContractData(id);
  $('button#contractDeleteConfirm').html("<div class='spinner-grow spinner-grow-sm text-light' role='status'></div>");
});

//Delete Course Fucntion
function deleteContractData(id){

  axios.post('deleteContractData',{id:id}).then(function(response){
      if (response.status==200) {
          $('button#contractDeleteConfirm').html("Delete");
          $('#deleteContractModal').modal('hide');
          toastr.success('Deleted.');
          allContractData();
      }else{
          $('button#contractDeleteConfirm').html("Insert");
          $('#deleteContractModal').modal('hide');
          toastr.error('Failed.');
      }

  }).catch(function(error){
          $('button#contractDeleteConfirm').html("Insert");
          $('#deleteContractModal').modal('hide');
          toastr.error('Failed.');
  });
}
</script>
@endsection