<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li class="{{ request()->is('dashboard') ? 'mm-active' : '' }}" style="padding-bottom: 10px;">
                <a href="{{ route('dashboard.index') }}" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-381-settings-2"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="{{ Str::startsWith(request()->path(), 'master/') ? 'mm-active' : '' }}">
                <a class="has-arrow ai-icon " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-controls-3"></i>
                    <span class="nav-text">Master</span>
                </a>
                <ul aria-expanded="false">
                    {{-- <li><a href="">Customer</a></li> --}}
                    <li class="{{ Str::startsWith(request()->path(), 'master/usermanager/') ? 'mm-active' : '' }}">
                        <a href="{{ route('master.usermanager') }}">
                            User Manager
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

        {{-- <div class="copyright">
          <p class="fs-14 font-w200"><strong class="font-w400">Koki Restaurant Admin Dashboard</strong> ©
              2020 All Rights Reserved</p>
          <p>Made with <i class="fa fa-heart"></i> by DexignZone</p>
      </div> --}}
    </div>
</div>
