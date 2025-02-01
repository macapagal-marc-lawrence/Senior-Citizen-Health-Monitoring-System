<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

<nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <div class="container">
        <a class="navbar-brand text-white" href="#">Senior Dashboard</a>
        <div class="ml-auto">
            <a href="<?= site_url('/login') ?>" class="btn btn-warning btn-lg">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">

<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success" id="flashMessage">
        <?= session()->getFlashdata('message') ?>
    </div>
    <script>
        setTimeout(function() {
            document.getElementById('flashMessage').style.display = 'none';
        }, 3000);
    </script>
    <?php endif; ?>

    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between bg-primary text-white">
            <h5 class="card-title" style="font-size: 1.5rem;">Profile</h5>
            <button class="btn btn-outline-light btn-sm" data-toggle="collapse" data-target="#profileSection">View Profile</button>
        </div>
        <div id="profileSection" class="collapse">
            <div class="card-body">
                <p><strong>Name:</strong> <?= esc($user['name']) ?></p>
                <p><strong>Email:</strong> <?= esc($user['email']) ?></p>
                <p><strong>Age:</strong> <?= esc($age) ?> years old</p>
                
                <?php if ($caregiver): ?>
                    <p><strong>Caregiver's Name:</strong> <?= esc($caregiver['name']) ?></p>
                    <p><strong>Caregiver's Emergency Contact:</strong> <?= esc($caregiver['emergency_contact']) ?></p>
                <?php else: ?>
                    <p><em>No caregiver assigned.</em></p>
                <?php endif; ?>

            </div>
        </div>
    </div>
    
    <div class="card shadow-lg mb-5">
        <div class="card-header bg-dark text-white">
            <h5 class="card-title" style="font-size: 1.5rem;">Health Data Analytics</h5>
        </div>
        <div class="card-body bg-light">
            <h6 style="font-size: 1.25rem;">Blood Pressure, Heart Rate, and Temperature Over Time</h6>
            <div class="row">
                <div class="col-md-4">
                    <canvas id="bloodPressureChart"></canvas>
                </div>
                <div class="col-md-4">
                    <canvas id="heartRateChart"></canvas>
                </div>
                <div class="col-md-4">
                    <canvas id="temperatureChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between bg-primary text-white">
            <h5 class="card-title" style="font-size: 1.5rem;">Reminders</h5>
            <button class="btn btn-outline-light btn-sm" data-toggle="collapse" data-target="#reminderSection">View Reminders</button>
        </div>
        <div id="reminderSection" class="collapse">
        <?php if (count($reminders) > 0): ?>
        <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th style="font-size: 1.2rem;">Type of reminder</th>
                        <th style="font-size: 1.2rem;">Message</th>
                        <th style="font-size: 1.2rem;">Date</th>
                        <th style="font-size: 1.2rem;">Action</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reminders as $reminder): ?>
                        <tr>
                            <td style="font-size: 1.2rem;"><?= esc($reminder['type']) ?></td>
                            <td style="font-size: 1.2rem;"><?= esc($reminder['message']) ?></td>
                            <td style="font-size: 1.2rem;"><?= esc($reminder['date']) ?></td>
                            <td>    
                                <!-- Delete Button -->
                                <a href="/deleteReminder/<?= $reminder['id'] ?>" class="btn btn-success btn-sm">Marked as Done</a>
                                
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
                 </div>
                 <?php else: ?>
            <p><em>No reminders available yet.</em></p>
            <?php endif; ?>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="card-title" style="font-size: 1.5rem;">Health Records</h5>
        </div>
        <div class="card-body">
            <h6 style="font-size: 1.25rem;">Summary of Latest Health Records</h6>
            <?php if (count($healthRecords) > 0): ?>
                <p><strong>Latest Condition:</strong> <?= esc($healthRecords[0]['health_condition']) ?> on <?= esc($healthRecords[0]['record_date']) ?></p>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th style="font-size: 1.2rem;">Health Condition</th>
                        <th style="font-size: 1.2rem;">Description</th>
                        <th style="font-size: 1.2rem;">Blood Pressure</th>
                        <th style="font-size: 1.2rem;">Heart Rate</th>
                        <th style="font-size: 1.2rem;">Temperature</th>
                        <th style="font-size: 1.2rem;">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($healthRecords as $record): ?>
                        <tr>
                            <td style="font-size: 1.2rem;"><?= esc($record['health_condition']) ?></td>
                            <td style="font-size: 1.2rem;"><?= esc($record['description']) ?></td>
                            <td style="font-size: 1.2rem;"><?= esc($record['blood_pressure']) ?> mmHg</td>
                            <td style="font-size: 1.2rem;"><?= esc($record['heart_rate']) ?> bpm</td>
                            <td style="font-size: 1.2rem;"><?= esc($record['temperature']) ?> °C</td>
                            <td style="font-size: 1.2rem;"><?= esc($record['record_date']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>No health records available yet.</p>
            <?php endif; ?>
        </div>
    </div>

</div>
<?= $this->endSection() ?>