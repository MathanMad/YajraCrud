<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajax Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

</head>
<body>
    <div class="container">
        <h4>Add details</h4>
        <button class="btn btn-primary text-end" type="button" id="AddDetails">Add</button>
    </div>
    <div class="container">
        <table class="table table-bordered yajra-datatable">
            <input type="hidden" id="id">
            <thead class="table-info">
                <th>Sl</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Action</th>
            </thead>
        </table>
    </div>
    <div class="modal" tabindex="-1" id="Modal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="Form">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="name">
                      </div>
                      <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Email:</label>
                        <input type="text" class="form-control" id="email">
                      </div>
                      <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Mobile:</label>
                        <input type="text" class="form-control" id="mobile">
                      </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary"  id="submit">Save changes</button>
            </div>
            </form>
          </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        $('#AddDetails').click(function(){
            $('#submit').val('Create');
            $('.modal-title').html('Add Details');
            $('#Form').trigger('reset');
            $('#Modal').modal('show');
        });

        
        $(document).on('click', '.Edit', function() {
            var post_id=$(this).data('id');
            var formData = new FormData($('#Form')[0]);
            $('#Form').trigger("reset");
            $.ajax({
                data: formData,
                url:"{{Route('edit','')}}"+'/'+post_id,
                type:"GET",
                dataType:'json',
                processData: false,
                contentType: false,
                        success: function (data) {
                            $('.modal-title').html("Edit Category");
                            $('#submit').val("Update..");
                            $('#name').val(data.data.name);
                            $('#email').val(data.data.email);
                            $('#mobile').val(data.data.mobile);
                            $('#id').val(data.data.id);
                            $('#Modal').modal('toggle'); 
                        }, 
            })
        });
          

        $('#submit').click(function(){
            $('#submit').html('Adding...');
            var submit=$('#submit').val();
            var formData= new FormData();
                formData.append('id',$('#id').val());
                formData.append('name',$('#name').val());
                formData.append('email',$('#email').val());
                formData.append('mobile',$('#mobile').val());
            if(submit== 'Create'){
            $.ajax({
                data:formData,
                url:"{{route('store')}}",
                type:"POST",
                dataType:"json",
                contentType : false,
                processData: false,
                success: function (stored) {
                            location.reload();                        
               },
            error: function (xhr, ajaxOptions, thrownError) {
                    $('#errorbox').show();
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err);
                    $('#errorContent').html('');
                    $.each(err.errors, function(key, value) {
                        $('#errorContent').append('<strong><li>'+value+'</li></strong>');
                    });
                    $('#saveBtn').html("{{ __('save-changes') }}");
                }

            })
          }else{
            $.ajax({
                data:formData,
                url:"{{route('update')}}",
                type:"POST",
                dataType:"json",
                contentType : false,
                processData: false,
                success: function (brand) {
                            location.reload();                       
               },
            error: function (xhr, ajaxOptions, thrownError) {
                    $('#errorbox').show();
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err);
                    $('#errorContent').html('');
                    $.each(err.errors, function(key, value) {
                        $('#errorContent').append('<strong><li>'+value+'</li></strong>');
                    });
                    $('#saveBtn').html("{{ __('save-changes') }}");
                }

              })

             }
        });
        $(document).on('click', '.Delete', function(){
            var post_id=$(this).attr('data-id');
           if(confirm("Are You sure want to delete !")){
            $.ajax({
                url: "{{ Route('delete','') }}"+'/'+post_id,
                type: "DELETE",
                dataType: 'json',
                processData: false,
                contentType: false,
                        success: function (deleted) {
                            location.reload();
                        },

        error: function (xhr, ajaxOptions, thrownError) {
            $('#errorbox').show();
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err);
                    $('#errorContent').html('');
                    $.each(err.errors, function(key, value) {
                        $('#errorContent').append('<strong><li>'+value+'</li></strong>');
                    });
                    $('#saveBtn').html("{{ __('save-changes') }}");
        }

            })
        }
        });

        $(function(){
            var table =$('.yajra-datatable').DataTable({
                processing:true,
                serverSide:true,
                ajax:"{{Route('fetchinfo')}}",
                columns:[
                    // this colums print database id only..

                    // {data:'id', name:'id' }, 
                            // OR key++
                            
                    { data: 'id',render: function(data, type, row, meta) {
                    // Increment the id by 1 for display purposes
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }, name: 'id'
                    },
                    {data:'name',  name:'name' },
                    {data:'email',  name:'email' },
                    {data:'mobile',  name:'mobile' },
                    {data:'action',  name:'action', orderable: false, searchable: false  }
            ]
            })
        });

    });
    </script>
</body>
</html>