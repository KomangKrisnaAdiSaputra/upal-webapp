@php
    use Illuminate\Support\Str;

@endphp
<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li class="{{ request()->is('dashboard') ? 'mm-active' : '' }}" style="padding-bottom: 10px;">
                <a href="{{ route('dashboard.index') }}" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-381-speedometer"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            {{-- <li class="{{ Str::startsWith(request()->path(), 'laporan/') ? 'mm-active' : '' }}">
                <a class="has-arrow ai-icon " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-file-1"></i>
                    <span class="nav-text">Laporan</span>
                </a>
                <ul aria-expanded="false">
                    <li class="{{ Str::startsWith(request()->path(), 'laporan/airlimbah') ? 'custom-active' : '' }}">
                        <a href="{{ route('laporan.airlimbah') }}">
                            Air Limbah
                        </a>
                    </li>
                    <li class="{{ Str::startsWith(request()->path(), 'laporan/airirigasi') ? 'custom-active' : '' }}">
                        <a href="{{ route('laporan.airirigasi') }}">
                            Air Irigasi
                        </a>
                    </li>
                </ul>
            </li> --}}
            <li class="{{ Str::startsWith(request()->path(), 'pengecekkan/') ? 'mm-active' : '' }}">
                <a class="has-arrow ai-icon " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-archive"></i>
                    <span class="nav-text">Pengecekkan</span>
                </a>
                <ul aria-expanded="false">
                    <li
                        class="{{ Str::startsWith(request()->path(), 'pengecekkan/airlimbah') ? 'custom-active' : '' }}">
                        <a href="{{ route('pengecekkan.airlimbah') }}">
                            Air Limbah
                        </a>
                    </li>
                    <li
                        class="{{ Str::startsWith(request()->path(), 'pengecekkan/airirigasi') ? 'custom-active' : '' }}">
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
                    <li
                        class="{{ Str::startsWith(request()->path(), 'pencatatan/mc/airlimbah') ? 'custom-active' : '' }}">
                        <a href="{{ route('pencatatan.mc.airlimbah') }}">
                            Minute Counter Air Limbah
                        </a>
                    </li>
                    <li
                        class="{{ Str::startsWith(request()->path(), 'pencatatan/mc/airirigasi') ? 'custom-active' : '' }}">
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
                    <li class="{{ Str::startsWith(request()->path(), 'master/group/') ? 'custom-active' : '' }}">
                        <a href="{{ route('master.group') }}">
                            Group
                        </a>
                    </li>
                    <li class="{{ Str::startsWith(request()->path(), 'master/customer/') ? 'custom-active' : '' }}">
                        <a href="{{ route('master.customer') }}">
                            Customer
                        </a>
                    </li>
                    <li class="{{ Str::startsWith(request()->path(), 'master/usermanager/') ? 'custom-active' : '' }}">
                        <a href="{{ route('master.usermanager') }}">
                            User Manager
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
