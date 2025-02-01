<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

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
</div>