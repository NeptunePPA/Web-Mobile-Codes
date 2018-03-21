@if(Auth::user()->roll == "1")
    <div class="main-menu">
        <ul>
            <li {{ Request::is('admin/dashboard') ? 'class=active' : '' || Request::is('admin/dashboard/*') ? 'class=active' : ''}}>
                <a href="{{ URL::to('admin/dashboard') }}" title="">
                    @if(Request::is('admin/dashboard') ||Request::is('admin/dashboard/*') )
                        <img src="{{URL::to('public/upload/menu/white/Dashboard.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Dashboard.png')}}" class="newlogo">
                    @endif
                </a>
                <span class="menu-caption">Dashboard</span>
            </li>
            <li {{ Request::is('admin/clients') ? 'class=active' : '' || Request::is('admin/clients/add') ? 'class=active' : '' || Request::is('admin/clients/edit/*') ? 'class=active' : '' }}>
                <a href="{{ URL::to('admin/clients') }}" title="">
                    @if(Request::is('admin/clients') || Request::is('admin/clients/add')|| Request::is('admin/clients/edit/*'))
                        <img src="{{URL::to('public/upload/menu/white/Clients.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Clients.png')}}" class="newlogo">
                    @endif
                </a>
                <span class="menu-caption">Clients</span>
            </li>
            <li {{ Request::is('admin/projects') ? 'class=active' : '' || Request::is('admin/projects/add') ? 'class=active' : '' || Request::is('admin/projects/edit/*') ? 'class=active' : '' }}>
                <a href="{{ URL::to('admin/projects') }}" title="">

                    @if(Request::is('admin/projects') || Request::is('admin/projects/*'))
                        <img src="{{URL::to('public/upload/menu/white/Project.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Project.png')}}" class="newlogo">
                    @endif
                </a>
                <span class="menu-caption">Projects</span>
            </li>
            <li {{ Request::is('admin/category') ? 'class=active' : '' || Request::is('admin/category/add') ? 'class=active' : '' || Request::is('admin/category/edit/*') ? 'class=active' : '' || Request::is('admin/category/viewclient/*') ? 'class=active' : '' || Request::is('admin/category-group') ? 'class=active' :'' ||Request::is('admin/category-group/*') ? 'class=active' : ''||Request::is('admin/clients/category/sort') ? 'class=active' : '' ||Request::is('admin/clients/category/sort/*') ? 'class=active' : '' ||Request::is('admin/category/sort/*') ? 'class=active' : ''  }}>
                <a href="{{ URL::to('admin/category') }}" title="">
                    @if(Request::is('admin/category') || Request::is('admin/category/*') || Request::is('admin/category-group') || Request::is('admin/category-group/*') || Request::is('admin/clients/category/sort') || Request::is('admin/clients/category/sort/*') || Request::is('admin/category/sort/*'))
                        <img src="{{URL::to('public/upload/menu/white/Category.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Category.png')}}" class="newlogo">
                    @endif
                </a>
                <span class="menu-caption">Categories</span>
            </li>
            <li {{ Request::is('admin/users') ? 'class=active' : '' || Request::is('admin/users/add') ? 'class=active' : '' || Request::is('admin/users/edit/*') ? 'class=active' : '' || Request::is('admin/users/*') ? 'class=active' : ''}}>
                <a href="{{ URL::to('admin/users') }}" title="">
                    @if(Request::is('admin/users') || Request::is('admin/users/*'))
                        <img src="{{URL::to('public/upload/menu/white/user.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/user.png')}}" class="newlogo">
                    @endif
                </a>
                <span class="menu-caption">Users</span>
            </li>

            <li class="dropdown {{ Request::is('admin/tracking/*') ? 'active' : '' }}">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    @if(Request::is('admin/tracking/*'))
                        <img src="{{URL::to('public/upload/menu/white/Tracking.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Tracking.png')}}" class="newlogo">
                    @endif

                    <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{URL::to('admin/tracking/users')}}">User Analytics</a></li>
                    <li><a href="{{URL::to('admin/tracking/organization')}}">Organization Analytics</a></li>
                    <li><a href="{{URL::to('admin/tracking/orders')}}">Order Analytics</a></li>
                    <li><a href="{{URL::to('admin/tracking/survey')}}">Physician Preference</a></li>
                </ul>
                <span class="menu-caption">Tracking</span>
            </li>

            <li {{ Request::is('admin/manufacturer') ? 'class=active' : '' || Request::is('admin/manufacturer/add') ? 'class=active' : '' || Request::is('admin/manufacturer/edit/*') ? 'class=active' : '' }}>
                <a href="{{ URL::to('admin/manufacturer') }}" title="">
                    @if(Request::is('admin/manufacturer') || Request::is('admin/manufacturer/*') )
                        <img src="{{URL::to('public/upload/menu/white/Manufacturer.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Manufacturer.png')}}" class="newlogo">
                    @endif

                </a>
                <span class="menu-caption">Manufacturers</span>
            </li>

            <li {{ Request::is('admin/itemfiles') ? 'class=active' : '' || Request::is('admin/itemfiles/add') ? 'class=active' : '' || Request::is('admin/itemfiles/create') ? 'class=active' : '' || Request::is('admin/itemfiles/view/*') ? 'class=active' : '' || Request::is('admin/itemfiles/edit/*') ? 'class=active' : '' || Request::is('admin/itemfiles/*') ? 'class=active' : '' }}>
                <a href="{{ URL::to('admin/itemfiles') }}" title="">
                    @if(Request::is('admin/itemfiles') || Request::is('admin/itemfiles/*') )
                        <img src="{{URL::to('public/upload/menu/white/ItemFile1.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/ItemFile1.png')}}" class="newlogo">
                    @endif

                </a>
                <span class="menu-caption">Item Files</span>
            </li>

            <li {{ Request::is('admin/repcasetracker') ? 'class=active' : '' || Request::is('admin/repcasetracker/add') ? 'class=active' : '' || Request::is('admin/repcasetracker/store') ? 'class=active' : '' || Request::is('admin/repcasetracker/edit/*') ? 'class=active' : '' || Request::is('admin/app/*') ? 'class=active' : '' || Request::is('admin/repcasetracker/*') ? 'class=active' : '' }}>
                <a href="{{ URL::to('admin/repcasetracker') }}" title="">
                    @if(Request::is('admin/repcasetracker') || Request::is('admin/repcasetracker/*') || Request::is('admin/app/*') )
                        <img src="{{URL::to('public/upload/menu/white/Case1.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Case1.png')}}" class="newlogo">
                    @endif

                </a>
                <span class="menu-caption">Rep Case Tracker</span>
            </li>

            <li {{ Request::is('admin/devices') ? 'class=active' : '' || Request::is('admin/devices/add') ? 'class=active' : '' || Request::is('admin/devices/edit/*') ? 'class=active' : '' || Request::is('admin/devices/view/*') ? 'class=active' : '' ||Request::is('admin/devices/*') ? 'class=active' : ''}}>
                <a href="{{ URL::to('admin/devices') }}" title="">
                    @if(Request::is('admin/devices') || Request::is('admin/devices/*') )
                        <img src="{{URL::to('public/upload/menu/white/Devices.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Devices.png')}}" class="newlogo">
                    @endif
                </a>
                <span class="menu-caption">Devices</span>
            </li>

            <li {{ Request::is('admin/orders') ? 'class=active' : '' || Request::is('admin/orders/edit/*') ? 'class=active' : ''  || Request::is('admin/orders/*') ? 'class=active' : ''}}>
                <a href="{{ URL::to('admin/orders') }}" title="">

                    @if(Request::is('admin/orders') || Request::is('admin/orders/*') )
                        <img src="{{URL::to('public/upload/menu/white/Order.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Order.png')}}" class="newlogo">
                    @endif

                </a>
                <span class="menu-caption">Orders</span>
            </li>
            <li {{ Request::is('admin/schedule') ? 'class=active' : ''  || Request::is('admin/schedule/add') ? 'class=active' : '' || Request::is('admin/schedule/edit/*') ? 'class=active' : '' || Request::is('admin/schedule/*') ? 'class=active' : '' }}>
                <a href="{{ URL::to('admin/schedule') }}" title="">
                    @if(Request::is('admin/schedule') || Request::is('admin/schedule/*') )
                        <img src="{{URL::to('public/upload/menu/white/Calendar.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Calendar.png')}}" class="newlogo">
                    @endif
                    </a>
                <span class="menu-caption">Scheduler</span>
            </li>
            <li {{ Request::is('admin/marketshare') ? 'class=active' : '' }}>
                <a href="{{ URL::to('admin/marketshare') }}" title="">

                    @if(Request::is('admin/marketshare'))
                        <img src="{{URL::to('public/upload/menu/white/Market Share.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Market Share.png')}}" class="newlogo">
                    @endif

                </a>
                <span class="menu-caption">Market Share</span>
            </li>
            <li>
                <a href="{{ URL::to('admin/logout') }}" title="">
                    <img src="{{URL::to('public/upload/menu/logout.png')}}" class="newlogo"></a>
                <span class="menu-caption">Logout</span>
            </li>
        </ul>
    </div>
@elseif(Auth::user()->roll == "2")
    <div class="main-menu">
        <ul>
            <li {{ Request::is('admin/dashboard') ? 'class=active' : '' || Request::is('admin/dashboard/*') ? 'class=active' : ''}}>
                <a href="{{ URL::to('admin/dashboard') }}" title="">
                    @if(Request::is('admin/dashboard') ||Request::is('admin/dashboard/*') )
                        <img src="{{URL::to('public/upload/menu/white/Dashboard.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Dashboard.png')}}" class="newlogo">
                    @endif
                </a>
                <span class="menu-caption">Dashboard</span>
            </li>
            <li {{ Request::is('admin/clients') ? 'class=active' : '' || Request::is('admin/clients/add') ? 'class=active' : '' || Request::is('admin/clients/edit/*') ? 'class=active' : '' }}>
                <a href="{{ URL::to('admin/clients') }}" title="">
                    @if(Request::is('admin/clients') || Request::is('admin/clients/add')|| Request::is('admin/clients/edit/*'))
                        <img src="{{URL::to('public/upload/menu/white/Clients.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Clients.png')}}" class="newlogo">
                    @endif
                </a>
                <span class="menu-caption">Clients</span>
            </li>
            <li {{ Request::is('admin/projects') ? 'class=active' : '' || Request::is('admin/projects/add') ? 'class=active' : '' || Request::is('admin/projects/edit/*') ? 'class=active' : '' }}>
                <a href="{{ URL::to('admin/projects') }}" title="">

                    @if(Request::is('admin/projects') || Request::is('admin/projects/*'))
                        <img src="{{URL::to('public/upload/menu/white/Project.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Project.png')}}" class="newlogo">
                    @endif
                </a>
                <span class="menu-caption">Projects</span>
            </li>
            <li {{ Request::is('admin/category') ? 'class=active' : '' || Request::is('admin/category/add') ? 'class=active' : '' || Request::is('admin/category/edit/*') ? 'class=active' : '' || Request::is('admin/category/viewclient/*') ? 'class=active' : '' || Request::is('admin/category-group') ? 'class=active' :'' ||Request::is('admin/category-group/*') ? 'class=active' : ''||Request::is('admin/clients/category/sort') ? 'class=active' : '' ||Request::is('admin/clients/category/sort/*') ? 'class=active' : '' ||Request::is('admin/category/sort/*') ? 'class=active' : ''  }}>
                <a href="{{ URL::to('admin/category') }}" title="">
                    @if(Request::is('admin/category') || Request::is('admin/category/*') || Request::is('admin/category-group') || Request::is('admin/category-group/*') || Request::is('admin/clients/category/sort') || Request::is('admin/clients/category/sort/*') || Request::is('admin/category/sort/*'))
                        <img src="{{URL::to('public/upload/menu/white/Category.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Category.png')}}" class="newlogo">
                    @endif
                </a>
                <span class="menu-caption">Categories</span>
            </li>
            <li {{ Request::is('admin/users') ? 'class=active' : '' || Request::is('admin/users/add') ? 'class=active' : '' || Request::is('admin/users/edit/*') ? 'class=active' : '' || Request::is('admin/users/*') ? 'class=active' : ''}}>
                <a href="{{ URL::to('admin/users') }}" title="">
                    @if(Request::is('admin/users') || Request::is('admin/users/*'))
                        <img src="{{URL::to('public/upload/menu/white/user.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/user.png')}}" class="newlogo">
                    @endif
                </a>
                <span class="menu-caption">Users</span>
            </li>
            <li class="dropdown {{ Request::is('admin/tracking/*') ? 'active' : '' }}">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    @if(Request::is('admin/tracking/*'))
                        <img src="{{URL::to('public/upload/menu/white/Tracking.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Tracking.png')}}" class="newlogo">
                    @endif

                    <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{URL::to('admin/tracking/users')}}">User Analytics</a></li>
                    <li><a href="{{URL::to('admin/tracking/organization')}}">Organization Analytics</a></li>
                    <li><a href="{{URL::to('admin/tracking/orders')}}">Order Analytics</a></li>
                    <li><a href="{{URL::to('admin/tracking/survey')}}">Physician Preference</a></li>
                </ul>
                <span class="menu-caption">Tracking</span>
            </li>
            <li {{ Request::is('admin/itemfiles') ? 'class=active' : '' || Request::is('admin/itemfiles/add') ? 'class=active' : '' || Request::is('admin/itemfiles/create') ? 'class=active' : '' || Request::is('admin/itemfiles/view/*') ? 'class=active' : '' || Request::is('admin/itemfiles/edit/*') ? 'class=active' : '' || Request::is('admin/itemfiles/*') ? 'class=active' : '' }}>
                <a href="{{ URL::to('admin/itemfiles') }}" title="">
                    @if(Request::is('admin/itemfiles') || Request::is('admin/itemfiles/*') )
                        <img src="{{URL::to('public/upload/menu/white/ItemFile1.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/ItemFile1.png')}}" class="newlogo">
                    @endif

                </a>
                <span class="menu-caption">Item Files</span>
            </li>
            <li {{ Request::is('admin/repcasetracker') ? 'class=active' : '' || Request::is('admin/repcasetracker/add') ? 'class=active' : '' || Request::is('admin/repcasetracker/store') ? 'class=active' : '' || Request::is('admin/repcasetracker/edit/*') ? 'class=active' : '' || Request::is('admin/app/*') ? 'class=active' : '' || Request::is('admin/repcasetracker/*') ? 'class=active' : '' }}>
                <a href="{{ URL::to('admin/repcasetracker') }}" title="">
                    @if(Request::is('admin/repcasetracker') || Request::is('admin/repcasetracker/*') || Request::is('admin/app/*') )
                        <img src="{{URL::to('public/upload/menu/white/Case1.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Case1.png')}}" class="newlogo">
                    @endif

                </a>
                <span class="menu-caption">Rep Case Tracker</span>
            </li>
            <li {{ Request::is('admin/devices') ? 'class=active' : '' || Request::is('admin/devices/add') ? 'class=active' : '' || Request::is('admin/devices/edit/*') ? 'class=active' : '' || Request::is('admin/devices/view/*') ? 'class=active' : '' ||Request::is('admin/devices/*') ? 'class=active' : ''}}>
                <a href="{{ URL::to('admin/devices') }}" title="">
                    @if(Request::is('admin/devices') || Request::is('admin/devices/*') )
                        <img src="{{URL::to('public/upload/menu/white/Devices.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Devices.png')}}" class="newlogo">
                    @endif
                </a>
                <span class="menu-caption">Devices</span>
            </li>
            <li {{ Request::is('admin/orders') ? 'class=active' : '' || Request::is('admin/orders/edit/*') ? 'class=active' : ''  || Request::is('admin/orders/*') ? 'class=active' : ''}}>
                <a href="{{ URL::to('admin/orders') }}" title="">

                    @if(Request::is('admin/orders') || Request::is('admin/orders/*') )
                        <img src="{{URL::to('public/upload/menu/white/Order.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Order.png')}}" class="newlogo">
                    @endif

                </a>
                <span class="menu-caption">Orders</span>
            </li>
            <li {{ Request::is('admin/schedule') ? 'class=active' : ''  || Request::is('admin/schedule/add') ? 'class=active' : '' || Request::is('admin/schedule/edit/*') ? 'class=active' : '' || Request::is('admin/schedule/*') ? 'class=active' : '' }}>
                <a href="{{ URL::to('admin/schedule') }}" title="">
                    @if(Request::is('admin/schedule') || Request::is('admin/schedule/*') )
                        <img src="{{URL::to('public/upload/menu/white/Calendar.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Calendar.png')}}" class="newlogo">
                    @endif
                </a>
                <span class="menu-caption">Scheduler</span>
            </li>
            <li {{ Request::is('admin/marketshare') ? 'class=active' : '' }}>
                <a href="{{ URL::to('admin/marketshare') }}" title="">

                    @if(Request::is('admin/marketshare'))
                        <img src="{{URL::to('public/upload/menu/white/Market Share.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Market Share.png')}}" class="newlogo">
                    @endif

                </a>
                <span class="menu-caption">Market Share</span>
            </li>
            <li><a href="{{ URL::to('admin/logout') }}" title=""><img src="{{URL::to('public/upload/menu/logout.png')}}"
                                                                      class="newlogo"></a></li>
        </ul>
    </div>

@elseif(Auth::user()->roll == "4")
    <div class="main-menu">
        <ul>
            <li {{ Request::is('admin/orders') ? 'class=active' : '' || Request::is('admin/orders/edit/*') ? 'class=active' : '' }}>
                <a href="{{ URL::to('admin/orders') }}" title=""><img src="{{URL::to('public/upload/menu/orders.png')}}"
                                                                      class="newlogo"></a>
            </li>
            <li><a href="{{ URL::to('admin/logout') }}" title=""><img src="{{URL::to('public/upload/menu/logout.png')}}"
                                                                      class="newlogo"></a></li>
        </ul>
    </div>
@elseif(Auth::user()->roll == "5")
    <div class="main-menu">
        <ul>
            <li {{ Request::is('admin/orders') ? 'class=active' : '' || Request::is('admin/orders/edit/*') ? 'class=active' : ''  || Request::is('admin/orders/*') ? 'class=active' : ''}}>
                <a href="{{ URL::to('admin/orders') }}" title="">

                    @if(Request::is('admin/orders') || Request::is('admin/orders/*') )
                        <img src="{{URL::to('public/upload/menu/white/Order.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Order.png')}}" class="newlogo">
                    @endif

                </a>
                <span class="menu-caption">Orders</span>
            </li>

            <li {{ Request::is('admin/marketshare') ? 'class=active' : '' }}>
                <a href="{{ URL::to('admin/marketshare') }}" title="">

                    @if(Request::is('admin/marketshare'))
                        <img src="{{URL::to('public/upload/menu/white/Market Share.png')}}" class="newlogo">
                    @else
                        <img src="{{URL::to('public/upload/menu/blue/Market Share.png')}}" class="newlogo">
                    @endif

                </a>
                <span class="menu-caption">Market Share</span>
            </li>
            <li><a href="{{ URL::to('admin/logout') }}" title=""><img src="{{URL::to('public/upload/menu/logout.png')}}"
                                                                      class="newlogo"></a></li>
        </ul>
    </div>
@endif
