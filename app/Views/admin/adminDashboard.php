<?= $this->extend('layouts/frontend.php') ?>

<?= $this->section('content') ?>
<?php
$db = \Config\Database::connect();
?>
<style>
    /* Sidebar Styling */
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

    /* Main Content */
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

    /* Card Styling */
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
    .card-title {
        color: #2d3748;
    }

    /* Card Colors */
    .bg-info { background-color: #b3cde0 !important; }
    .bg-success { background-color: #c3e6cb !important; }
    .bg-warning { background-color: #ffdd94 !important; }

    /* Table Styling */
    .table-primary {
        background-color: #f0f4f8;
        color: #2a4365;
    }
    .table-hover tbody tr:hover {
        background-color: #e3e7ea;
        cursor: pointer;
    }

    /* Button Hover Effects */
    .btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .btn-sm:hover {
        transform: scale(1.05);
    }

    .btn-success:hover {
        background-color: #38a169;
        border-color: #38a169;
    }
    .btn-danger:hover {
        background-color: #e53e3e;
        border-color: #e53e3e;
    }
    .btn-warning:hover {
        background-color: #f6ad55;
        border-color: #f6ad55;
    }
    .btn-info:hover {
        background-color: #63b3ed;
        border-color: #63b3ed;
    }
</style>


<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-sticky p-3">
                <ul class="nav flex-column">
                    <li class="nav-item mb-3">
                        <a class="nav-link active d-flex align-items-center" href="/admin/adminDashboard">
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
            
        <!-- Main Content -->
        <main class="main-content col-md-9 ms-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 text-primary">Admin Dashboard</h1>
        <?php if (isset($loggedInUser)): ?>
            <button class="btn btn-sm btn-outline-primary">
                Welcome, <?= esc($loggedInUser['name']) ?>!
            </button>
        <?php else: ?>
            <button class="btn btn-sm btn-outline-primary">
                Welcome, Guest!
            </button>
        <?php endif; ?>
        </div>

            <!-- Dashboard Stats -->
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card bg-info shadow">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-person-fill display-4 me-3"></i> <!-- Icon for Total Users -->
                            <div>
                                <h5 class="card-title">Total Users</h5>
                                <p class="card-text display-6"><?= $totalUsers ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card bg-success shadow">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-person-badge display-4 me-3"></i> <!-- Icon for Senior Citizens -->
                            <div>
                                <h5 class="card-title">Senior Citizens</h5>
                                <p class="card-text display-6"><?= $seniorCitizensCount ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card bg-warning shadow">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-person-plus display-4 me-3"></i> <!-- Icon for Caregivers -->
                            <div>
                                <h5 class="card-title">Caregivers</h5>
                                <p class="card-text display-6"><?= $caregiversCount ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <!-- Flash Message -->
    <?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success" id="flashMessage">
        <?= session()->getFlashdata('message') ?>
    </div>
    <script>
        // Wait for 3 seconds (3000ms), then hide the flash message
        setTimeout(function() {
            document.getElementById('flashMessage').style.display = 'none';
        }, 3000);
    </script>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success" id="flashMessage">
        <?= session()->getFlashdata('success') ?>
    </div>
    <script>
        // Wait for 3 seconds (3000ms), then hide the flash message
        setTimeout(function() {
            document.getElementById('flashMessage').style.display = 'none';
        }, 3000);
    </script>
    <?php endif; ?>
    
            <!-- Recent Activities -->
            <h3 class="mt-5">Recent Activities</h3>
            <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="bi bi-person-plus"></i> Add User
            </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Role</th>
                            <th>Age</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= $user['id'] ?></td>
        <td><?= $user['name'] ?></td>
        <td><?= $user['email'] ?></td>
        <td><?= $user['emergency_contact'] ?></td>
        <td><?= ucfirst($user['role']) ?></td>
        <td><?= $user['age'] ?> years old</td>
        <td><?= $user['is_approved'] ? 'Approved' : 'Pending' ?></td>
        <td>
        <?php if (!$user['is_approved']): ?>
            <!-- Show Approve and Reject Buttons for Unapproved Users -->
            <a href="/admin/approveUser/<?= $user['id'] ?>" class="btn btn-sm btn-success text-white">
                <i class="bi bi-check"></i> Approve
            </a>
            <a href="/admin/rejectUser/<?= $user['id'] ?>" class="btn btn-sm btn-danger text-white" onclick="return confirm('Are you sure you want to reject this user?')">
                <i class="bi bi-x"></i> Reject
            </a>
        <?php else: ?>
            <!-- Show Edit, Delete, and Assign Buttons for Approved Users -->
            <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#editModal<?= $user['id'] ?>">
                <i class="bi bi-pencil"></i> Edit
            </button>
            <a href="/delete/<?= $user['id'] ?>" class="btn btn-sm btn-danger text-white" onclick="return confirm('Are you sure you want to delete this user?')">
                <i class="bi bi-trash"></i> Delete
            </a>
            <?php if ($user['role'] == 'senior_citizen'): ?>
        <!-- Check if caregiver is already assigned -->
        <?php 
        // Check if a caregiver is assigned to this senior citizen
        $assignedCaregiver = $db->table('senior_caregiver')->where('senior_id', $user['id'])->get()->getRow();
        if (!$assignedCaregiver): ?>
            <!-- Assign Caregiver button -->
            <a href="/admin/assignCaregiver/<?= $user['id'] ?>" class="btn btn-sm btn-info text-white">
                <i class="bi bi-person-plus"></i> Assign Caregiver
            </a>
        <?php else: ?>
            <!-- Change Caregiver button -->
            <a href="/admin/changeCaregiver/<?= $user['id'] ?>" class="btn btn-sm btn-success text-white">
                <i class="bi bi-arrow-clockwise"></i> Change Caregiver
            </a>
        <?php endif; ?>
    <?php endif; ?>
    <?php endif; ?>
        </td>
    </tr>
    <!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/addUser" method="post">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                    </div>
                    <div class="mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob" placeholder="Enter date of birth" required>
                    </div>
                    <div class="mb-3">
                        <label for="emergency_contact" class="form-label">Emergency Contact</label>
                        <input type="number" class="form-control" id="emergency_contact" name="emergency_contact" placeholder="Enter contact number" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="admin">Admin</option>
                            <option value="caregiver">Caregiver</option>
                            <option value="senior_citizen">Senior Citizen</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal<?= $user['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $user['id'] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editModalLabel<?= $user['id'] ?>">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/update/<?= $user['id'] ?>" method="post">
                    <div class="modal-body">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= esc($user['id']) ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= esc($user['name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= esc($user['email']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" id="age" name="age" value="<?= esc($user['age']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="emergency_contact" class="form-label">Contact</label>
                            <input type="number" class="form-control" id="emergency_contact" name="emergency_contact" value="<?= esc($user['emergency_contact']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="caregiver" <?= $user['role'] == 'caregiver' ? 'selected' : '' ?>>Caregiver</option>
                                <option value="senior_citizen" <?= $user['role'] == 'senior_citizen' ? 'selected' : '' ?>>Senior Citizen</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</tbody>

                </table>
            </div>
        </main>
    </div>
</div>

<?= $this->endSection() ?>
