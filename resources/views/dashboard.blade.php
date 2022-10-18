@extends('app')
@section('content')

    <!--breadcrumb-->
    @if (Auth::user()->type == 1)
    <div class="row">
        <div class="col-12 col-lg-3">
            <div class="card radius-15 bg-primary-blue">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="mb-0 text-white">{{ \App\Models\User::where('type', 2)->count()}}</h2>
                        </div>
                        <div class="ml-auto font-35 text-white"><i class="bx bx-user"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-white">Total Doctor's</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card radius-15 bg-voilet">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="mb-0 text-white">{{ \App\Models\User::where('type', 3)->count()}}</h2>
                        </div>
                        <div class="ml-auto font-35 text-white"><i class="bx bx-user"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-white">Total Patient's</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(Auth::user()->type == 3)

    @php
        $prescriptions = \App\Models\Prescription::with('doctor', 'patient', 'pathologyTest', 'pathologyTest.pathology')->where('patient_id', Auth::user()->id)->get();
    @endphp

    
    <div class="card radius-15">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">Sl</th>
                            <th scope="col">Date</th>
                            <th scope="col">ID</th>
                            <th scope="col">Doctor</th>
                            <th scope="col">Details</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $fileName = Auth::user()->uniqueId.'_'.Auth::user()->name.'.json';
                            $path = public_path('/assets/prescriptions/'.$fileName);
                        @endphp

                        @if(file_exists($path))

                            @php
                                $json = json_decode(file_get_contents(public_path('/assets/prescriptions/'.$fileName)), true);
                            @endphp
                        
                            @foreach ($json['chain'] as $key => $item)
                            <tr>
                                <td scope="row">{{$key+1}}</td>
                                <td>{{date('Y-m-d', strtotime($item['content']['date'])) }}</td>
                                <td>{{$item['content']['unique_id']}}</td>
                                <td>{{$item['content']['doctor_name']}}</td>
                                <td>{!! $item['content']['details'] !!}</td>
                                <td>
                                    <a href="{{route('prescription.print', ['id' => $item['index'], 'name' => $fileName])}}" class="btn btn-sm btn-success prescribe" target="_blank">Print</a>
                                
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
    
@endsection
@section('script')
<script>
    $(function() {

    var table = $('.table').DataTable();

    });
</script>
@endsection
