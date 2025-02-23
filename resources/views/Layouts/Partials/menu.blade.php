<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li class="{{ request()->is('dashboard') ? 'mm-active' : '' }}" style="padding-bottom: 10px;">
                <a href="{{ route('dashboard.index') }}" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-381-speedometer"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="{{ Str::startsWith(request()->path(), 'laporan/') ? 'mm-active' : '' }}">
                <a class="has-arrow ai-icon " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-file-1"></i>
                    <span class="nav-text">Laporan</span>
                </a>
                <ul aria-expanded="false">
                    <li class="{{ Str::startsWith(request()->path(), 'laporan/airlimbah') ? 'mm-active' : '' }}">
                        <a href="{{ route('laporan.airlimbah') }}">
                            Air Limbah
                        </a>
                    </li>
                    {{-- <li class="{{ Str::startsWith(request()->path(), 'laporan/airirigasi') ? 'mm-active' : '' }}">
                        <a href="{{ route('laporan.airirigasi') }}">
                            Air Irigasi
                        </a>
                    </li> --}}
                </ul>
            </li>
            <li class="{{ Str::startsWith(request()->path(), 'pengecekkan/') ? 'mm-active' : '' }}">
                <a class="has-arrow ai-icon " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-archive"></i>
                    <span class="nav-text">Pengecekkan</span>
                </a>
                <ul aria-expanded="false">
                    <li class="{{ Str::startsWith(request()->path(), 'pengecekkan/airlimbah') ? 'mm-active' : '' }}">
                        <a href="{{ route('pengecekkan.airlimbah') }}">
                            Air Limbah
                        </a>
                    </li>
                    <li class="{{ Str::startsWith(request()->path(), 'pengecekkan/airirigasi') ? 'mm-active' : '' }}">
                        <a href="{{ route('pengecekkan.airirigasi') }}">
                            Air Irigasi
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ Str::startsWith(request()->path(), 'pencatatan/') ? 'mm-active' : '' }}">
                <a class="has-arrow ai-icon " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-notepad-2"></i>
                    <span class="nav-text">Pencatatan</span>
                </a>
                <ul aria-expanded="false">
                    <li class="{{ Str::startsWith(request()->path(), 'pencatatan/mc/airlimbah') ? 'mm-active' : '' }}">
                        <a href="{{ route('pencatatan.mc.airlimbah') }}">
                            Minute Counter Air Limbah
                        </a>
                    </li>
                    <li
                        class="{{ Str::startsWith(request()->path(), 'pencatatan/mc/airirigasi') ? 'mm-active' : '' }}">
                        <a href="{{ route('pencatatan.mc.airirigasi') }}">
                            Minute Counter Air Irigasi
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ Str::startsWith(request()->path(), 'master/') ? 'mm-active' : '' }}">
                <a class="has-arrow ai-icon " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-unlocked-2"></i>
                    <span class="nav-text">Master</span>
                </a>
                <ul aria-expanded="false">
                    <li class="{{ Str::startsWith(request()->path(), 'master/group/') ? 'mm-active' : '' }}">
                        <a href="{{ route('master.group') }}">
                            Group
                        </a>
                    </li>
                    <li class="{{ Str::startsWith(request()->path(), 'master/customer/') ? 'mm-active' : '' }}">
                        <a href="{{ route('master.customer') }}">
                            Customer
                        </a>
                    </li>
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
