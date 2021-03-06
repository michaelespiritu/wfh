<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Job Opening Card -->
    <div class="col-md-4 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="h5 mb-1 font-weight-bold text-gray-800">
                <span>{{ count(auth()->user()->applications) }}</span>
                </div>
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-0">Applications</div>

            </div>
            <div class="col-auto">
                <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Job Credt Card -->
    <div class="col-md-4 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="h5 mb-1 font-weight-bold text-gray-800"></div>
                <div class="text-xs font-weight-bold text-success text-uppercase mb-0">Job Credit</div>
            </div>
            <div class="col-auto">
                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Total Spent Card Example -->
    <div class="col-md-4 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="h5 mb-1 font-weight-bold text-gray-800">$</div>
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-0">Total Spent</div>
            </div>
            <div class="col-auto">
                <!-- <i class="fas fa-comments fa-2x text-gray-300"></i> -->
                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>