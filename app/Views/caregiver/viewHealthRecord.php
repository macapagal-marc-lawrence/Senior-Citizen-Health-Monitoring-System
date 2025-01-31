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

                  
</div>