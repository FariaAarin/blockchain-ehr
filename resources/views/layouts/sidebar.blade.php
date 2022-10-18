<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div class="">
            <img src="{{asset('assets/admin/images/logo_icon.jpg')}}" class="logo-icon-2" alt="" />
        </div>
        <div>
            <h6 class="logo-text">EHR</h6>
        </div>
        <a href="javascript:;" class="toggle-btn ml-auto"> <i class="bx bx-menu"></i>
        </a>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
       

        <li>
            <a href="{{route('dashboard')}}">
                <div class="parent-icon icon-color-2"><i class="bx bx-home-alt"></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        
        <li class="menu-label">Web Apps</li>

        @if (Auth::user()->type == 1)
        <li>
            <a href="{{route('doctor.list')}}">
                <div class="parent-icon icon-color-2"><i class="bx bx-user"></i>
                </div>
                <div class="menu-title">Doctor's</div>
            </a>
        </li>
        <li>
            <a href="{{route('patient.list')}}">
                <div class="parent-icon icon-color-2"><i class="bx bx-user"></i>
                </div>
                <div class="menu-title">Patient's</div>
            </a>
        </li>

        <li>
            <a href="{{route('pathology.list')}}">
                <div class="parent-icon icon-color-2"><i class="bx bx-receipt"></i>
                </div>
                <div class="menu-title">Pathology</div>
            </a>
        </li>
        @endif

        @if (Auth::user()->type == 2)
        <li>
            <a href="{{route('patient.prescribe')}}">
                <div class="parent-icon icon-color-2"><i class="bx bx-user"></i>
                </div>
                <div class="menu-title">Patient Prescribe</div>
            </a>
        </li>
        {{-- <li>
            <a href="{{route('prescribe.list')}}">
                <div class="parent-icon icon-color-2"><i class="bx bx-receipt"></i>
                </div>
                <div class="menu-title">Patient History</div>
            </a>
        </li> --}}
        @endif

    </ul>
    <!--end navigation-->
</div>