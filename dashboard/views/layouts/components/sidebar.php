<div class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
      <a href="index.php?controller=dashboard&action=index" class="logo">
        <img
          src="assets/img/dash-logo.png"
          alt="navbar brand"
          class="navbar-brand"
          height="20" />
      </a>
      <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
          <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler">
          <i class="gg-menu-left"></i>
        </button>
      </div>
      <button class="topbar-toggler more">
        <i class="gg-more-vertical-alt"></i>
      </button>
    </div>
    <!-- End Logo Header -->
  </div>
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-secondary">
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Admin Sections</h4>
        </li>


        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#orders">
            <i class="fas fa-shopping-cart"></i>
            <p>User Subsicriptions</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="orders">
            <ul class="nav nav-collapse">
              <li>
                <a href="index.php?page=user-subscriptions/index">
                  <span class="sub-item">User Subscriptions List</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#forms">
            <i class="fas fa-list-ul"></i>
            <p>Meal Categories</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="forms">
            <ul class="nav nav-collapse">
              <li>
                <a href="index.php?page=meal-categories/index">
                  <span class="sub-item">All Meal Categories</span>
                </a>
              </li>
              <li>
                <a href="index.php?page=meal-categories/create">
                  <span class="sub-item">Create New Category</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#discounts">
            <i class="fas fa-box-open"></i>
            <p>Main Subscriptions</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="discounts">
            <ul class="nav nav-collapse">
              <li>
                <a href="index.php?page=subscriptions/index">
                  <span class="sub-item">Main Subscriptions List</span>
                </a>
              </li>
              <li>
                <a href="index.php?page=subscriptions/create">
                  <span class="sub-item">Create new Subscription</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#customers">
            <i class="fas fa-users"></i>
            <p>Customers</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="customers">
            <ul class="nav nav-collapse">
              <li>
                <a href="index.php?page=customers/index">
                  <span class="sub-item">Customers List</span>
                </a>
              </li>
              <li>
                <a href="index.php?page=customers/create">
                  <span class="sub-item">Create New Customer</span>
                </a>
              </li>
            </ul>
          </div>
        </li>





        
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#tables">
              <i class="fas fa-user-cog"></i>
              <p>Admins</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="tables">
              <ul class="nav nav-collapse">
                <li>
                  <a href="index.php?controller=admin&action=index">
                    <span class="sub-item">Admins Data</span>
                  </a>
                </li>
                <li>
                  <a href="index.php?controller=admin&action=create">
                    <span class="sub-item">Create new Admin</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        <li class="nav-item">
          <a href="index.php?controller=contact&action=index">
            <i class="fas fa-address-book"></i>
            <p>Contacts</p>
          </a>
        </li>

        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Kitchen</h4>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#mealsMenu">
            <i class="fas fa-utensils"></i>
            <p>Meals</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="mealsMenu">
            <ul class="nav nav-collapse">
              <li>
                <a href="index.php?page=meals/index">
                  <span class="sub-item">All Meals</span>
                </a>
              </li>
              <li>
                <a href="index.php?page=meals/create">
                  <span class="sub-item">Create New Meal</span>
                </a>
              </li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#mealSelections">
            <i class="fas fa-clipboard-list"></i>
            <p>Meal Selections</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="mealSelections">
            <ul class="nav nav-collapse">
              <li>
                <a href="index.php?page=meals-selection/index">
                  <span class="sub-item">Meal Selections List</span>
                </a>
              </li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#mealSchedules">
            <i class="fas fa-calendar-alt"></i> <!-- New icon -->
            <p>Meal Schedules</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="mealSchedules"> <!-- Fixed ID -->
            <ul class="nav nav-collapse">
              <li>
                <a href="index.php?page=meal-schedules/index">
                  <span class="sub-item">Meal Schedules List</span>
                </a>
              </li>
            </ul>
          </div>
        </li>

      </ul>
    </div>
  </div>
</div>