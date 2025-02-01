

<!-- Header Section with Logout Button -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Caregiver Dashboard</a>
        <div class="ml-auto">
            <span class="navbar-text center">
                Welcome, Caregiver- <?= esc($user['name']) ?>
            </span>
            <a href="<?= site_url('/login') ?>" class="btn btn-danger ml-3">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
</nav>


<div class="container mt-5">
        <h2 class="text-center mb-4">Caregiver Dashboard</h2>

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

         <!-- Dashboard Summary Section -->
         <div class="row mb-4">
        <!-- Assigned Seniors Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-users"></i> Assigned Seniors
                        <!-- Dropdown toggle button -->
                        <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#assignedSeniors" aria-expanded="false" aria-controls="assignedSeniors">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </h5>

                     <!-- Dropdown content -->
                     <div class="collapse" id="assignedSeniors">
                        <p class="card-text"><?= count($seniors) ?> Seniors</p>
                    </div>
                </div>
            </div>
        </div>
             <!-- Pending Reminders Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-bell"></i> Pending Reminders
                        <!-- Dropdown toggle button -->
                        <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#pendingReminders" aria-expanded="false" aria-controls="pendingReminders">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </h5>
                    <!-- Dropdown content -->
                    <div class="collapse" id="pendingReminders">
                        <?php foreach ($seniors as $senior): ?>
                            <p class="card-text"><?= count($reminders[$senior['id']]) ?> Reminders for <?= esc($senior['name']) ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Table with Senior Citizen List -->
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
            <th>Senior Citizen Name</th>
            <th>Age</th>
            <th>Emergency Contact</th>
            <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($seniors as $senior): ?>
            <?php
                // Calculate age from date of birth
                $dob = new DateTime($senior['dob']);
                $today = new DateTime();
                $age = $today->diff($dob)->y;
            ?>
            <tr>
                <td><?= esc($senior['name']) ?></td>
                <td><?= esc($age) ?> years old</td>
                <td><?= esc($senior['emergency_contact']) ?></td>
                <td>
                        <a href="<?= base_url('/caregiver/viewHealthRecords/' . $senior['id']) ?>" class="btn btn-info btn-sm">
                            <i class="fas fa-file-medical"></i> View Records
                        </a>
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addRecordModal<?= $senior['id'] ?>">
                            <i class="fas fa-notes-medical"></i> Add Health Record
                        </button>
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addMedicationModal<?= $senior['id'] ?>">
                            <i class="fas fa-capsules"></i> Add Medication
                        </button>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#addReminderModal<?= $senior['id'] ?>">
                            <i class="fas fa-calendar-check"></i> Add Reminder
                        </button>
                    </td>
                </tr>

                <!-- Add Health Record Modal -->
                <div class="modal fade" id="addRecordModal<?= $senior['id'] ?>" tabindex="-1" aria-labelledby="addRecordLabel<?= $senior['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addRecordLabel<?= $senior['id'] ?>">Add Health Record for <?= esc($senior['name']) ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="/caregiver/addHealthRecord/<?= $senior['id'] ?>" method="post">
                                <div class="modal-body">
                                    <?= csrf_field() ?>
                                    <div class="mb-3">
                                        <label for="health_condition" class="form-label">Health Condition:</label>
                                        <input type="text" class="form-control" name="health_condition" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description:</label>
                                        <textarea class="form-control" name="description" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="blood_pressure" class="form-label">Blood Pressure:</label>
                                        <input type="text" class="form-control" name="blood_pressure" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="heart_rate" class="form-label">Heart Rate:</label>
                                        <input type="text" class="form-control" name="heart_rate" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="temperature" class="form-label">Temperature:</label>
                                        <input type="text" class="form-control" name="temperature" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add Record</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Add Medication Modal -->
                <div class="modal fade" id="addMedicationModal<?= $senior['id'] ?>" tabindex="-1" aria-labelledby="addMedicationLabel<?= $senior['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addMedicationLabel<?= $senior['id'] ?>">Add Medication for <?= esc($senior['name']) ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="<?= base_url('/caregiver/addMedication/' . $senior['id']) ?>" method="post">
                                <div class="modal-body">
                                    <?= csrf_field() ?>
                                    <div class="mb-3">
                                        <label for="medication_name" class="form-label">Medication Name:</label>
                                        <input type="text" class="form-control" name="medication_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="dosage" class="form-label">Dosage:</label>
                                        <input type="text" class="form-control" name="dosage" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="frequency" class="form-label">Frequency:</label>
                                        <input type="text" class="form-control" name="frequency" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Start Date:</label>
                                        <input type="date" class="form-control" name="start_date" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">End Date (Optional):</label>
                                        <input type="date" class="form-control" name="end_date">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add Medication</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Add Reminder Modal -->
                <div class="modal fade" id="addReminderModal<?= $senior['id'] ?>" tabindex="-1" aria-labelledby="addReminderLabel<?= $senior['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addReminderLabel<?= $senior['id'] ?>">Add Reminder for <?= esc($senior['name']) ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="<?= base_url('/caregiver/addReminder/' . $senior['id']) ?>" method="post">
                                <div class="modal-body">
                                    <?= csrf_field() ?>
                                    <div class="mb-3">
                                        <label for="reminder_text" class="form-label">Reminder Type:</label>
                                        <select name="type" id="type" class="form-control" required>
                                            <option value="Appointments">Appointmens</option>
                                            <option value="Medication">Medication</option>
                                            <option value="Tips">Tips</option>
                                         </select>
                                    </div>
                                    <div class="mb-3">
                                            <label for="message" class="form-label">Message:</label>
                                            <textarea class="form-control" name="message" required></textarea>
                                        </div>
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Reminder Date:</label>
                                        <input type="datetime-local" class="form-control" name="date" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add Reminder</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>


        