<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link text-center">
        <img src="{{ asset('storage/frontend/assets/dist/images/main-logo.png') }}"
            onerror="this.src='{{ URL::asset('storage/admin/default/img1.jpg') }}'" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3"
            style="opacity: 1;background-color: #fff;height: 33px;width: 33px;">
        <span class="brand-text font-weight-light" style="display: -webkit-box;">
            @if (@$general_setting->site_name)
                {{ @$general_setting->site_name }}
            @else
                Admin
                Dashboard
            @endif
        </span>
    </a>
    <div class="sidebar">
        {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img @if (Auth::user()->image) src="{{ Auth::user()->image }}"
                @else src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                    onerror="this.src='{{ URL::asset('storage/admin/default/img1.jpg') }}'" alt="Your Slider Image"
                    class="img-circle elevation-2" alt="User Image" style="height:33px;">

            </div>
            <div class="info">
                <a href="{{ route('admin.profile') }}" class="d-block"
                    style="text-transform: capitalize">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a>

            </div>
        </div>
        <div>
            <input type="text" id="searchInput"
                placeholder="Search Menu..."style="width: 100%;border-radius: 9px;margin-bottom: 13px;height: 46px;">
        </div> --}}
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @if (isset($navbars))
                    @foreach (@$navbars as $item)
                        @php
                            $slug = explode('.', $item->page_url);
                            $flag = false;
                            $current_routes = explode('.', Route::currentRouteName());
                            $current_name = $current_routes[1];
                        @endphp
                        @if (count($item->active_children) > 0)
                            @foreach ($item->active_children as $child)
                                @if (strcmp(Route::currentRouteName(), $child->page_url) == 0 || str_contains($child->page_url, $current_name))
                                    @php
                                        $flag = true;
                                    @endphp
                                @endif
                            @endforeach
                        @else
                            @php
                                $flag =
                                    strcmp(Route::currentRouteName(), $item->page_url) == 0 ||
                                    str_contains($item->page_url, $current_name);
                            @endphp
                        @endif
                        @php
                            $show = false;
                        @endphp
                        @switch($item->menu_name)
                            @case('Dashboard')
                            @case('Content Management')

                            @case('Events & Tournaments')
                            @case('Members & Teams')

                            @case('System Management')
                            @case('Settings')

                            @case('Reports')
                                @if (Auth::user()->hasAnyRole(['super admin', 'admin']))
                                    @php
                                        $show = true;
                                    @endphp
                                @endif
                            @break

                            @default
                        @endswitch
                        @if ($show)
                            <li class="nav-item  {{ $flag ? 'menu-open' : '' }}">
                                <a href="{{ $item->page_url != '#' ? route($item->page_url) : '#' }}"
                                    class="nav-link {{ $flag ? 'active' : '' }}">
                                    @if ($item->icon)
                                        <i class="nav-icon fas {{ $item->icon }}"></i>
                                    @endif
                                    <p>
                                        {{ $item->menu_name }}
                                        @if (count($item->active_children) > 0)
                                            <i class="fas fa-angle-left right"></i>
                                        @endif
                                    </p>
                                </a>
                                @if (count($item->active_children) > 0)
                                    <ul class="nav nav-treeview">
                                        @foreach ($item->active_children as $child)
                                            @php
                                                $subshow = false;
                                            @endphp
                                            @switch($child->menu_name)
                                                @case('Banner')
                                                @case('HomePageContent')

                                                @case('News')
                                                @case('Events')

                                                @case('Past Tournaments')
                                                @case('Photos')

                                                @case('New Join Members')
                                                @case('Members')

                                                @case('Teams')
                                                @case('Payment Config')

                                                @case('Email Template')
                                                @case('General Setting')

                                                @case('Sponsors')
                                                @case('Pages Setup')

                                                @case('About US')
                                                @case('Contact Us')

                                                @case('Admin User')

                                                    @default
                                                        @if (Auth::user()->hasAnyRole(['super admin', 'admin']))
                                                            @php
                                                                $subshow = true;
                                                            @endphp
                                                        @endif
                                                @endswitch
                                                @php
                                                    $subpath = explode('.', $child->page_url);
                                                    $subpath_name = $subpath[1];
                                                @endphp
                                                @if ($subshow)
                                                    <li class="nav-item">
                                                        <a href="{{ route($child->page_url) }}"
                                                            class="nav-link dd {{ strcmp(Route::currentRouteName(), $child->page_url) == 0 || strcmp($subpath_name, $current_name) == 0 ? 'active' : '' }}">
                                                            <i class="fa {{ $child->icon }} nav-icon"></i>
                                                            <p>{{ $child->menu_name }}</p>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ul>
            </nav>
        </div>
    </aside>
