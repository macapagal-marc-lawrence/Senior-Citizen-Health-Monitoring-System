<?= $this->extend('layouts/frontend.php') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
    <nav class="sidebar">
            <div class="sidebar-sticky p-3">
                <ul class="nav flex-column">
                    <li class="nav-item mb-3">
                        <a class="nav-link d-flex align-items-center" href="/admin/adminDashboard">
                            <i class="bi bi-house-door"></i> <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item mb-3">
                        <a class="nav-link d-flex align-items-center" href="/admin/healthReports">
                            <i class="bi bi-heart"></i> <span>Health Reports</span>
                        </a>
                    </li>
                    <li class="nav-item mb-3">
                        <a class="nav-link active d-flex align-items-center" href="/admin/medicationReports">
                            <i class="bi bi-capsule"></i> <span>Medication Reports</span>
                        </a>
                    </li>
                    <li class="nav-item mb-3">
                        <a class="nav-link d-flex align-items-center" href="/admin/medicationHistory">
                            <i class="bi bi-clock-history"></i> <span>Medical History</span>
                        </a>
                    </li>
                    <li class="nav-item mb-3">
                        <a class="nav-link d-flex align-items-center" href="/login">
                            <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

    </div>

</div>

<?= $this->endSection() ?>
