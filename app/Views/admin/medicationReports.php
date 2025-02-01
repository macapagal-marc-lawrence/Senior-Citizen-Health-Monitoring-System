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

        <main class="main-content col-md-9 ms-sm-auto col-lg-10 px-4">
            <h1 class="h2 text-primary text-center">Medication Reports</h1>
        <p class="text-muted text-center">Review Medication data submitted by caregivers for each senior citizen.</p>
        
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                    <th>#</th>
                            <th>Senior Citizen Name</th>
                            <th>Medication Name</th>
                            <th>Dosage</th>
                            <th>Frequency</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Record Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($medicationReports as $report): ?>
                        <tr>
                        <td><?= $report['id'] ?></td>
                        <td><?= esc($report['senior_name']) ?></td>
                        <td><?= htmlspecialchars($report['medication_name']) ?></td>
                                <td><?= htmlspecialchars($report['dosage']) ?></td>
                                <td><?= htmlspecialchars($report['frequency']) ?></td>
                                <td><?= date('F j, Y', strtotime($report['start_date'])) ?></td>
                                <td><?= date('F j, Y', strtotime($report['end_date'])) ?></td>
                                <td><?= date('F j, Y, g:i a', strtotime($report['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                </tbody>
            </table>    
        </div>

        <div class="mt-3">
                <a href="/admin/adminDashboard" class="btn btn-primary">
                <i class="bi bi-arrow-left-circle icon"></i>Back to Dashboard</a>
            </div>
        </main>
    </div>
</div>

<?= $this->endSection() ?>
