<!-- Header -->
<nav class="navbar navbar-expand-xl navbar-expand-custom bg-white">
        <div class="container-fluid px-sm-5">
          <!-- Logo -->
          <a class="navbar-brand logo" href="/">
            <img src="{{asset('assets/images/logo.png')}}" />
            <span></span>
            <h1 class="font-weight-normal">IOC Checker</h1>
          </a>
          <!-- Side -->
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#nav"
            aria-controls="nav"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <!-- Links -->
          <div
            class="collapse navbar-collapse justify-content-center mt-2 mt-xl-0"
            id="nav"
          >
            <ul class="navbar-nav mb-2 mb-lg-0 justify-content-center">
              <li class="nav-item">
                <a
                  class="nav-link"
                  aria-current="page"
                  href="#"
                  data-link="dashboard"
                  >Dashboard</a
                >
              </li>

              <li class="nav-item">
                <a
                  class="nav-link isActive"
                  aria-current="page"
                  href="/"
                  data-link="home"
                  >IOC Collection</a
                >
              </li>
              <li class="nav-item">
                <a
                  class="nav-link"
                  aria-current="page"
                  href="/sweep.html"
                  data-link="network"
                  >Network Sweep</a
                >
              </li>
              <li class="nav-item">
                <a
                  class="nav-link"
                  aria-current="page"
                  href="#"
                  data-link="blocking"
                  >Blocking List</a
                >
              </li>
              <li class="nav-item">
                <a
                  class="nav-link"
                  aria-current="page"
                  href="/reports.html"
                  data-link="reports"
                  >Reports</a
                >
              </li>
              <li class="nav-item">
                <a
                  class="nav-link"
                  aria-current="page"
                  href="#"
                  data-link="account"
                  >Account Management</a
                >
              </li>
            </ul>
            <button class="logout mb-1">Logout</button>
          </div>
        </div>
      </nav>
      <!--/ Header /-->