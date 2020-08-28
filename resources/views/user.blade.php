@extends('layout.app')

@section('content')


<div id="loaderSection" class="container">
  <div class="row">
  <div class="col-md-12 p-5 text-center">
        <div class="spinner-grow text-danger mt-5" style="width: 5rem; height: 5rem;" role="status">
        </div>

  </div>
  </div>
</div>

<div id="mainSection" class="container d-none">
  <div class="row">
  <div class="col-md-12 p-5">
  <table id="userTableSection" class="table table-striped table-bordered text-center" width="100%">
    <thead>
      <tr>
      
      <th class="th-sm text-center">Name</th>
      <th class="th-sm text-center">Bkash No</th>
      <th class="th-sm text-center">Bkash TrxID</th>
      <th class="th-sm text-center">Status</th>
      <th class="th-sm text-center">Approval</th>
      <th class="th-sm text-center">Action</th>

      </tr>
    </thead>
    <tbody id="userTableBody">

    </tbody>
  </table>

  </div>
  </div>
</div>

<div id="errorSection" class="container d-none">
  <div class="row">
  <div class="col-md-12 p-5">
    <h2 class="text-center text-danger mt-5">Something Went Wrong !!</h2>
  </div>
  </div>
</div>


@endsection
@section('script')
<script type="text/javascript">
    getAllUser();


//Call Service Data 
function getAllUser() {
    axios.get('/getAllUser')
        .then(function(response) {
            
            if (response.status == 200) {
                $('#loaderSection').addClass('d-none');
                $('#mainSection').removeClass('d-none');
                let user = response.data;

                $('#userTableSection').DataTable().destroy();
                $('#userTableBody').empty();
                $.each(user, function(i, item) {
                    $('<tr>').html(
                        "<td>"+ user[i].name +"</td>" +
                        "<td>" + user[i].bkashno + "</td>" +
                        "<td>" + user[i].bkashtrxid + "</td>" +
                        "<td>" + user[i].status + "</td>" +
                        "<td>" + user[i].approval + "</td>" +
                        "<td class='d-flex flex-row'><a id='approve' class='btn btn-sm btn-success mr-1' key="+user[i].id+">Approve</a><a id='suspand' class='btn btn-sm btn-danger mr-1' key="+user[i].id+">Suspand</a></td>"
                    ).appendTo('#userTableBody');
                });

                //Data Tablel Plugin
                $('#userTableSection').DataTable();
                $('.dataTables_length').addClass('bs-select');

            } else {
                $('#loaderSection').addClass('d-none');
                $('#errorSection').removeClass('d-none');
                getAllUser();
            }

        }).catch(function(error) {
            $('#loaderSection').addClass('d-none');
            $('#errorSection').removeClass('d-none');
        });
};

//Status Approve Button On Click
  $(document).on('click', '#approve', function(){
    let id = $(this).attr('key');

    axios.post('/approve', {
            id: id
        })
          .then(function(response) {
            if (response.status==200) {
                toastr.success('SUCCESS! User Approved.');
                getAllUser();
            } else {
                toastr.error('ERROR! Operation Failed.');
            };
        }).catch(function(error) {
            toastr.error('ERROR! Operation Failed.');
      });
  }); 

//Status Approve Button On Click
  $(document).on('click', '#suspand', function(){
    let id = $(this).attr('key');

    axios.post('/suspand', {
            id: id
        })
          .then(function(response) {
            if (response.status==200) {
                toastr.success('SUCCESS! User Suspanded.');
                getAllUser();
            }else {
                toastr.error('ERROR! Operation Failed.');
            };
        }).catch(function(error) {
            toastr.error('ERROR! Operation Failed.');
      });
  }); 




</script>
@endsection