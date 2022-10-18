@extends('app')
@section('content')

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
        <div class="breadcrumb-title pr-3">Dashboard</div>
        <div class="pl-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class='bx bx-home-alt'></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Patient</li>
                </ol>
            </nav>
        </div>
        <div class="ml-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-primary addButton" ><i class='bx bx-plus'></i> Add New</button>
            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card radius-15">
        <div class="card-body">

            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>    
                <strong>{{ $message }}</strong>
            </div>
            @endif

            @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>    
                <strong>{{ $message }}</strong>
            </div>
            @endif

            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">Sl</th>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($patients as $key => $patient)
                        <tr>
                            <td scope="row">{{$key+1}}</td>
                            <td>{{$patient->uniqueId}}</td>
                            <td>{{$patient->name}}</td>
                            <td>{{$patient->email}}</td>
                            <td>{{$patient->mobile}}</td>
                            <td>
                                <button class="btn btn-sm btn-warning edit" data-id="{{$patient->id}}" data-name ="{{$patient->name}}" data-email="{{$patient->email}}" data-mobile="{{$patient->mobile}}">Edit</button>
                                <button class="btn btn-sm btn-danger delete" data-id="{{$patient->id}}" >Delete</button>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Patient</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">	<span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data" id="form" >
                    @csrf
                    <div class="modal-body">
                        
                        
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Mobile</label>
                            <div class="col-sm-10">
                                <input type="text" name="mobile" id="mobile" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" name="email" id="email" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name='id' id="id" />
                        <button type="submit" class="btn btn-primary save">Save</button>
                        <button type="submit" class="btn btn-warning update">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>

            $('.addButton').on( 'click', function () {
                $('#form').trigger("reset");
                $(".save").show();
                $(".update").hide();
                var route = '{!! route('patient.store') !!}';
                $("#form").attr("action", route);
                $('#exampleModal1').modal('show');
            });

            $('.edit').on('click', function () {
                
                $('#name').val($(this).data('name'));
                $('#email').val($(this).data('email'));
                $('#mobile').val($(this).data('mobile'));
                $('#id').val($(this).data('id'));
            
                $(".save").hide();
                $(".update").show();
                var route = '{!! route('patient.update') !!}';
                $("#form").attr("action", route);

                $('#exampleModal1').modal('show');
            });

            $('.delete').on( 'click', function () {
                var id = $(this).data('id');

                Swal.fire({
                title: 'Warning!',
                text: "Are you want to delete ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type:'get',
                            dataType: "JSON",
                            url : '{!! url('patient/destroy') !!}' + '/' + id,
                            success:function(data){
                            Swal.fire(
                                data.title,
                                data.message,
                                data.status
                                )
                                // table.ajax.reload();

                                location.reload();
                            }
                        });
                        
                    }
                })
    
            });

        $(function() {

            var table = $('.table').DataTable();

        });
    </script>
@endsection