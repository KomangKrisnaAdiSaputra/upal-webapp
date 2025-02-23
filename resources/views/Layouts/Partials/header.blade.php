@php
    $now = Carbon\Carbon::now()->setTimezone('+08:00');
    $hour = $now->hour;
    if ($hour >= 5 && $hour < 12) {
        $greeting = 'Good Morning';
    } elseif ($hour >= 12 && $hour < 18) {
        $greeting = 'Good Afternoon';
    } elseif ($hour >= 18 && $hour < 22) {
        $greeting = 'Good Evening';
    } else {
        $greeting = 'Good Night';
    }
@endphp
<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="dashboard_bar">
                        @yield('title')
                    </div>
                </div>
                <ul class="navbar-nav header-right">
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="javascript:;" role="button" data-toggle="dropdown">
                            <div class="header-info">
                                <small>{{ $greeting }}</small>
                                <span>{{ auth()?->user()?->nama ?? '' }}</span>
                            </div>
                            <img src="{{ asset('assets/images/avatar/1.png') }}" width="20" alt=""
                                loading="lazy" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('profile.index') }}" class="dropdown-item ai-icon">
                                <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary"
                                    width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span class="ml-2">Profile </span>
                            </a>
                            <a href="{{ route('auth.logout') }}" class="dropdown-item ai-icon">
                                <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger"
                                    width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12">
                                    </line>
                                </svg>
                                <span class="ml-2">Logout </span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
