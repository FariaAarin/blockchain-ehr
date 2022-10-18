<!DOCTYPE html>
<html>
<head>
    <title>Prescription Print</title>
    <link rel="icon" href="{{asset('assets/images/favicon-32x32.png')}}" type="image/png" />

    <style>
        @media print
            {    
                .no-print, .no-print *
                {
                    display: none !important;
                }
            }
    </style>
</head>
<body  onload="window.print()">
   

 <style>
     .borderNone{border: 1px solid silver;}
 </style>
    
    @if (empty($prescription))
        <h1 style="text-align: center;color:red;">Data not found</h1>
    @else
    <table border="none" cellpadding='5' cellspacing='0' style="margin: 0 auto; width:95%;background:white;text-align:center">
        
        <thead>
            <tr>
                <td colspan="3">
                    Doctor: {{$prescription['doctor_name']}}<br>
                    Email: {{Auth::user()->email}}<br>
                    Mobile: {{Auth::user()->mobile}}
                </td>
            </tr>
        </thead>

        <tbody>
          <tr>
            <td>
                ID:{{$prescription['unique_id']}}
            </td>
            <td>
                Name:{{$prescription['patient_name']}}
               
            </td>
            <td>
                Age:
            </td>
          </tr>
            <tr style="height: 400px;">
                <td width='30%'>
                    <h4>Pathology Test</h4>
                    <p>{{$prescription['pathology']}}</p>
                    
                </td>
                <td colspan="2">
                    {!! $prescription['details']!!}
                </td>
            </tr>

        </tbody>

    </table>
    
    @endif
    
</body>
</html>