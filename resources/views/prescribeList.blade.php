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
                    <li class="breadcrumb-item active" aria-current="page">Patient History</li>
                </ol>
            </nav>
        </div>
        
    </div>
    <!--end breadcrumb-->
    <div class="card radius-15">
        <div class="card-body">

           

            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">Sl</th>
                            <th scope="col">Date</th>
                            <th scope="col">ID</th>
                            <th scope="col">Patient</th>
                            <th scope="col">Details</th>
                            <th scope="col">Doctor</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($prescriptions as $key => $item)
                        <tr>
                            <td scope="row">{{$key+1}}</td>
                            <td>{{date('Y-m-d', strtotime($item->created_at)) }}</td>
                            <td>{{$item->patient->uniqueId}}</td>
                            <td>{{$item->patient->name}}</td>
                            <td>{!! $item->details !!}</td>
                            <td>{{$item->doctor->name}}</td>
                            <td>
                                <a href="{{route('prescription.print', ['id' => $item->id])}}" class="btn btn-sm btn-success prescribe" target="_blank">Print</a>
                               
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('script')
    
        
    <script>

        $(function() {

            var table = $('.table').DataTable();

        });


        $('.prescribe').on('click', function () {
                
                $('#name').val($(this).data('name'));
                $('#id').val($(this).data('id'));
                
                var route = '{!! route('prescribe.store') !!}';
                $("#form").attr("action", route);

                $('#prescribe').modal('show');
            });
    </script>
@endsection