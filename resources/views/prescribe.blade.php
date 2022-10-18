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
                    <li class="breadcrumb-item active" aria-current="page">Patient Prescribe</li>
                </ol>
            </nav>
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
                            {{-- <th scope="col">Mobile</th> --}}
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
                            {{-- <td>{{$patient->mobile}}</td> --}}
                            <td>
                                <div class="btn-group">
                                    @if(Auth::user()->type == 2)
                                        <button type="button" class="btn btn-primary prescribe" data-id="{{$patient->id}}" data-name="{{$patient->name}}" data-unique="{{$patient->uniqueId}}">Prescribe</button>
                                    @endif
                                    @php
                                        $fileName = $patient->uniqueId.'_'.$patient->name.'.json';
                                        $path = public_path('/assets/prescriptions/'.$fileName);
                                    @endphp
                                    
                                    @if(file_exists($path))

                                        @php
                                            $json = json_decode(file_get_contents(public_path('/assets/prescriptions/'.$fileName)), true);
                                        @endphp

                                        <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">	Print<span class="sr-only">Toggle Dropdown</span>
                                        </button>

                                        <div class="dropdown-menu">	
                                            @foreach ($json['chain'] as $item)
                                                <a class="dropdown-item" href="{{route('prescription.print', ['index' => $item['index'], 'name' => $fileName])}}" target="_blank">Prescription {{$item['index']+1}}</a>
                                            @endforeach
                                        </div>

                                    @endif

                                </div>

                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    


    <div class="modal fade" id="prescribe" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Patient Prescribe</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">	<span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data" id="form" >
                    @csrf
                    <div class="modal-body">
                        
                        
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" id="name" readonly class="form-control">
                            </div>
                        </div>

                        

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Pathology Test</label>
                            <div class="col-sm-10">
                                <select type="text" name="pathology[]" id="pathology" class="form-control selectpicker" multiple data-live-search="true" >
                                    <option value="">Select Pathology</option>
                                    @foreach($pathologyes as $pathology)
                                    <option value="{{$pathology->name}}">{{$pathology->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Prescription</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="details" id="details" cols="10" rows="10">

                                </textarea>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name='id' id="id" />
                        <input type="hidden" name='unique_id' id="unique_id" />
                        <button type="submit" class="btn btn-primary save">Save</button>
                        {{-- <button type="submit" class="btn btn-warning update">Update</button> --}}
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('assets/js/bootstrap-select.min.js')}}"></script>
    <script src='{{asset('assets/js/tinymce.min.js')}}' referrerpolicy="origin"></script>

        
    <script>


        $(function() {

            var table = $('.table').DataTable();

        });


        $('.prescribe').on('click', function () {
                
            $('#name').val($(this).data('name'));
            $('#id').val($(this).data('id'));
            $('#unique_id').val($(this).data('unique'));
            
            var route = '{!! route('prescribe.store') !!}';
            $("#form").attr("action", route);

            $('#prescribe').modal('show');
        });

        $('#prescription_id').on('change', function () {

            window.open("{{url('patient/prescription/dprint?id=')}}"+$("#prescription_id").val(), '_blank');
            
        });
    </script>
@endsection