<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
     with font-awesome or any other icon font library -->
     <li class="nav-item has-treeview menu-open">
      <a href="{{ url('/home') }}" class="nav-link active">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
      </a>
    </li> 
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="fa fa-bars"></i>
        <p>
          {{ trans('title.class_section') }}
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('view.class') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>{{ trans('title.class') }}</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('view.section') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>{{ trans('title.section') }}</p>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="fas fa-bus"></i>
        <p>
          {{trans('title.transport')}} 
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('view.vehicle_type') }}" class="nav-link">
             <i class="far fa-circle nav-icon"></i>
            <p>{{Lang::get('title.vehicle_type')}}</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('view.vehicle') }}" class="nav-link">
             <i class="far fa-circle nav-icon"></i>
            <p>{{Lang::get('title.vehicle')}}</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('view.root') }}" class="nav-link">
             <i class="far fa-circle nav-icon"></i>
            <p>{{Lang::get('title.root')}}</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('view.vehicle_root_map') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>{{Lang::get('title.vehicle_root_map')}}</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('view.stopage') }}" class="nav-link">
             <i class="far fa-circle nav-icon"></i>
            <p>{{Lang::get('title.stopage')}}</p>
          </a>
        </li> 
      </ul>
    </li>
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="fas fa-hotel"></i>
        <p>
          {{trans('title.hostal')}}
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('view.hostel') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>{{Lang::get('title.hostel')}}</p>
          </a>
        </li>
        <li class="nav-item">
        <a href="{{ route('view.room') }}" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>{{trans('title.room')}}</p>
        </a>
      </li>
      </ul>
    </li>
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="fas fa-cogs"></i>
        <p> 
          {{trans('title.setting')}}
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('view.school-details') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>{{trans('title.school_details')}}</p>
          </a>
        </li> 
      </ul>
    </li>
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="fa fa-user" aria-hidden="true"></i>
        <p>
          {{trans('title.roles')}}
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('view.roles') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>{{trans('title.roles')}}</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('add.permission') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>{{trans('title.permission')}}</p>
          </a>
        </li>
      </ul>
    </li>
  </ul>
</nav>