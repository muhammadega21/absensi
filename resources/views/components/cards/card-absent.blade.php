<div class="col-12 col-md-4">
    <div class="card info-card {{ $classCard }}">

        <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
            </ul>
        </div>

        <div class="card-body">
            <h5 class="card-title">Absent <span>| Today</span></h5>

            <div class="d-flex align-items-center mb-3">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person "></i>
                </div>
                <div class="card-desc ps-3">
                    <h6>17</h6>
                    <span class="small pt-1 fw-bold">{{ $slot }}</span>
                </div>
            </div>
            <span class="date">21 Desember 2024</span>
        </div>

    </div>
</div>
