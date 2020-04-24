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
    <li class="nav-item">
      <a href="pages/widgets.html" class="nav-link">
        <i class="nav-icon fas fa-th"></i>
        <p>
          Widgets
          <span class="right badge badge-danger">New</span>
        </p>
      </a>
    </li>
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
          Class & Section
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('view.class') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Class</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('view.section') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Section</p>
          </a>
        </li>
      </ul>
    </li>
    
  </ul>
</nav>