<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

<style>
/* Importing Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Open+Sans:wght@400;600&display=swap');

/* General Layout and Text */
body {
    font-family: 'Roboto', sans-serif;  /* Default font */
}

.header-text {
    font-size: 26px;
    font-weight: 500;  /* Slightly heavier font weight */
    color: #2d3e50;
    margin-bottom: 20px;
}

/* Table Styling */
.table {
    margin-top: 20px;
    width: 100%;
    border-collapse: collapse;
    font-family: 'Open Sans', sans-serif; /* For table content */
}

.table th, .table td {
    padding: 12px;
    text-align: left;
    font-size: 15px;  /* Slightly larger font for better readability */
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f9f9f9;
}

.table-bordered th, .table-bordered td {
    border: 1px solid #ddd;
}

/* Row Hover Effect */
.table-row-hover:hover {
    background-color: #f1f1f1;
    cursor: pointer;
}

/* Header Styling for the Table */
thead.thead-light th {
    background-color: #e9f7f9;
    color: #007b8c;
    font-weight: bold;
}

/* Button Styles */
.btn {
    font-size: 15px;  /* Slightly larger font size */
    padding: 8px 12px;
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s, transform 0.2s;
}

.btn:hover {
    transform: scale(1.05);
}

/* Edit and Delete Buttons */
.btn-warning,
.btn-danger {
    font-size: 15px;
    padding: 8px 18px;
    width: 120px;
    text-align: center;
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s, transform 0.2s;
}

/* Default Button Hover Effects */
.btn-warning:hover,
.btn-danger:hover {
    transform: scale(1.05);
}

/* Modal Styles */
.modal-content {
    border-radius: 10px;
}

.modal-header {
    background-color: #e9f7f9;
    border-bottom: 1px solid #ddd;
}

.modal-footer {
    background-color: #f8f9fa;
}

/* Form Input Fields */
.form-label {
    font-weight: bold;
    margin-bottom: 5px;
    font-family: 'Open Sans', sans-serif;
}

.form-control {
    margin-bottom: 15px;
    font-family: 'Open Sans', sans-serif;
}

/* Navbar and Header */
.navbar {
    background-color: var(--primary-color);
}

.navbar-brand {
    color: #fff;
}

.navbar-light .navbar-nav .nav-link {
    color: #ffffff;
}

.navbar-light .navbar-nav .nav-link:hover {
    color: #ffcc00;
}

/* Logout Button */
.btn-danger {
    background-color: #ff4747;
    color: white;
}

.btn-danger:hover {
    background-color: #e43e3e;
}



/* Footer */
footer {
    background-color: #2d3e50;
    color: white;
    padding: 10px;
    text-align: center;
    margin-top: 30px;
}
</style>


<!-- Header Section with Logout Button -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Caregiver Dashboard</a>
        <div class="ml-auto">
            <a href="<?= site_url('/login') ?>" class="btn btn-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
</nav>

<div class= "container mt-4">
    
    
        <h2 class= "header-text text-center">Health & Medication Records for <?=$senior ['name']?></h2>

        <div class="row">

        <!-- Health Records -->
        <div class="col-md-12 table-responsive">
            <h4 class="text-primary">Health Records</h4>
            <?php if (count($healthRecords) > 0): ?>
                <table class="table table-striped table-bordered table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 15%;">Health Condition</th>
                            <th style="width: 25%;">Description</th>
                            <th style="width: 10%;">Temperature</th>
                            <th style="width: 10%;">Blood Pressure</th>
                            <th style="width: 10%;">Heart Rate</th>
                            <th style="width: 15%;">Record Date</th>
                            <th style="width: 15%;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($healthRecords as $record): ?>
                            <tr class="table-row-hover">
                                <td><?= htmlspecialchars($record['health_condition']) ?></td>
                                <td><?= htmlspecialchars($record['description']) ?></td>
                                <td><?= htmlspecialchars($record['temperature']) ?> °C</td>
                                <td><?= htmlspecialchars($record['blood_pressure']) ?> mmHg</td>
                                <td><?= htmlspecialchars($record['heart_rate']) ?> bpm</td>
                                <td><?= date('F j, Y, g:i a', strtotime($record['record_date'])) ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $record['id'] ?>">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <a href="/deleteRecord/<?= $record['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?')">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </a>
                                </td>
                            </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="editModal<?= $record['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $record['id'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel<?= $record['id'] ?>">Edit Health Record</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="/updateRecord/<?= $record['id'] ?>" method="post">
                                            <input type="hidden" name="id" value="<?= esc($record['id']) ?>">
                                            <div class="modal-body">
                                                <?= csrf_field() ?>
                                                <div class="mb-3">
                                                    <label for="health_condition" class="form-label">Health Condition</label>
                                                    <input type="text" class="form-control" name="health_condition" value="<?= esc($record['health_condition']) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="description" class="form-label">Description</label>
                                                    <input type="text" class="form-control" name="description" value="<?= esc($record['description']) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="temperature" class="form-label">Temperature</label>
                                                    <input type="text" class="form-control" name="temperature" value="<?= esc($record['temperature']) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="blood_pressure" class="form-label">Blood Pressure</label>
                                                    <input type="text" class="form-control" name="blood_pressure" value="<?= esc($record['blood_pressure']) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="heart_rate" class="form-label">Heart Rate</label>
                                                    <input type="text" class="form-control" name="heart_rate" value="<?= esc($record['heart_rate']) ?>" required>
                                                </div>
                                            </div>  

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No health records found.</p>
            <?php endif; ?>
        </div>


         <!-- Medication Records -->
         <div class="col-md-12 table-responsive mt-5">  
            <h4 class="text-primary">Medication Records</h4>
            <?php if (count($medications) > 0): ?>
                <table class="table table-striped table-bordered table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 20%;">Medication Name</th>
                            <th style="width: 15%;">Dosage</th>
                            <th style="width: 15%;">Frequency</th>
                            <th style="width: 15%;">Start Date</th>
                            <th style="width: 15%;">End Date</th>
                            <th style="width: 10%;">Recorded At</th>
                            <th style="width: 10%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($medications as $medication): ?>
                            <tr class="table-row-hover">
                                <td><?= htmlspecialchars($medication['medication_name']) ?></td>
                                <td><?= htmlspecialchars($medication['dosage']) ?></td>
                                <td><?= htmlspecialchars($medication['frequency']) ?></td>
                                <td><?= date('F j, Y', strtotime($medication['start_date'])) ?></td>
                                <td><?= date('F j, Y', strtotime($medication['end_date'])) ?></td>
                                <td><?= date('F j, Y, g:i a', strtotime($medication['created_at'])) ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModalMed<?= $medication['id'] ?>">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <a href="/deleteMed/<?= $medication['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?')">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </a>
                                </td>
                            </tr>

                            
                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModalMed<?= $medication['id'] ?>" tabindex="-1" aria-labelledby="editModalLabelMed<?= $medication['id'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabelMed<?= $medication['id'] ?>">Edit Medication Record</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <form action="/updateMed/<?= $medication['id'] ?>" method="post">
                                            <input type="hidden" name="id" value="<?= esc($medication['id']) ?>">
                                            <div class="modal-body">
                                                <?= csrf_field() ?>
                                                <div class="mb-3">
                                                    <label for="medication_name" class="form-label">Medication Name</label>
                                                    <input type="text" class="form-control" name="medication_name" value="<?= esc($medication['medication_name']) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="dosage" class="form-label">Dosage</label>
                                                    <input type="text" class="form-control" name="dosage" value="<?= esc($medication['dosage']) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="frequency" class="form-label">Frequency</label>
                                                    <input type="text" class="form-control" name="frequency" value="<?= esc($medication['frequency']) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="start_date" class="form-label">Start Date</label>
                                                    <input type="date" class="form-control" name="start_date" value="<?= esc($medication['start_date']) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="end_date" class="form-label">End Date</label>
                                                    <input type="date" class="form-control" name="end_date" value="<?= esc($medication['end_date']) ?>" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>

                                        </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No medication records found.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="mt-3">
    <a href="<?= site_url('/caregiver/caregiverDashboard') ?>" class="btn btn-primary btn-lg">
        <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
    </a>
</div>




<?= $this->endSection() ?>


</div>