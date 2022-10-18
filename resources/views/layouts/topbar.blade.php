<header class="top-header">
    <nav class="navbar navbar-expand">
        <div class="left-topbar d-flex align-items-center">
            <a href="javascript:;" class="toggle-btn">	<i class="bx bx-menu"></i>
            </a>
        </div>
        
        <div class="right-topbar ml-auto">
            <ul class="navbar-nav">
                
                <li class="nav-item dropdown dropdown-user-profile">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-toggle="dropdown">
                        <div class="media user-box align-items-center">
                            <div class="media-body user-info">
                                <p class="user-name mb-0">{{Auth::user()->name}}</p>
                                {{-- <p class="designattion mb-0">Avai  lable</p> --}}
                            </div>
                            <img src="{{asset('assets/images/profile.jpg')}}" class="user-img" alt="user avatar">
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">

                        <a class="dropdown-item" href="javascript:;"><i class="bx bx-user"></i><span>Profile</span></a>
                        
                        <div class="dropdown-divider mb-0"></div>

                        <a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit(); " ><i class="bx bx-power-off"></i><span>Logout</span></a>

                        <form action="{{route('logout')}}" method="POST" id="logout-form" >
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>