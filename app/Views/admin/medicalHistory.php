<?= $this->extend('layouts/frontend.php') ?>

<?= $this->section('content') ?>

<style>
     .sidebar {
        width: 70px;
        background: rgba(233, 244, 248, 0.9);
        color: #2d3748;
        transition: width 0.3s;
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        overflow: hidden;
        border-right: 1px solid #cbd5e0;
        z-index: 100;
     }
     .sidebar:hover {
        width: 220px;
    }
    .sidebar .nav-link {
        font-size: 1rem;
        color: #4a5568;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        border-radius: 6px;
        margin: 5px 0;
        transition: background-color 0.3s, color 0.3s;
    }
    .sidebar .nav-link:hover {
        color: #2b6cb0;
        background-color: rgba(66, 153, 225, 0.15);
    }
    .sidebar .nav-link.active {
        background-color: rgba(66, 153, 225, 0.2);
        color: #2c5282;
        font-weight: bold;
    }
    .sidebar .nav-link i {
        font-size: 1.2rem;
        margin-right: 10px;
        transition: transform 0.3s;
    }
    .sidebar:hover .nav-link i {
        transform: scale(1.1);
    }

    .main-content {
        margin-left: 70px;
        padding: 20px;
        transition: margin-left 0.3s;
        background-color: #f7fafc;
        min-height: 100vh;
    }
    .sidebar:hover ~ .main-content {
        margin-left: 220px;
    }

    .card {
        background: #ffffff;
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .table-primary {
        background-color: #f0f4f8;
        color: #2a4365;
    }
    .table-hover tbody tr:hover {
        background-color: #e3e7ea;
    }

    .table-responsive {
        margin-top: 20px;
    }
    .icon {
        margin-right: 8px;
        
    }
</style>

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
                        <a class="nav-link d-flex align-items-center" href="/admin/medicationReports">
                            <i class="bi bi-capsule"></i> <span>Medication Reports</span>
                        </a>
                    </li>
                    <li class="nav-item mb-3">
                        <a class="nav-link active d-flex align-items-center" href="/admin/medicationHistory">
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
            <h1 class="h2 text-primary text-center">Health & Medication History</h1>
            <p class="text-muted text-center">Review Health and Medication History submitted by caregivers for each senior citizen.</p>
            
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-primary">
                    <tr>
                <th>Senior Name</th>
                <th>Medication Name</th>
                <th>Prescribed By</th>
                <th>Dosage</th>
                <th>Date Prescribed</th>
                   </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($medicationHistory as $history): ?>
                <tr>
                    <td><?= esc($history['senior_name']) ?></td>
                    <td><?= esc($history['medication_name']) ?></td>
                    <td><?= esc($history['prescribed_by_name']) ?></td>
                    <td><?= esc($history['dosage']) ?></td>
                    <td><?= esc($history['date_prescribed']) ?></td>
                </tr>
            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>