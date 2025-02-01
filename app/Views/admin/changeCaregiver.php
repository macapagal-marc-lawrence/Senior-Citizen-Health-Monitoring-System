<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

<style>
    .container {
        margin-top: 5%;
    }

    .card {
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .card h2 {
        color: #2d3748;
        font-weight: bold;
    }

    .form-group label {
        color: #4a5568;
        font-weight: 500;
    }

    .form-control {
        border-radius: 6px;
        border: 1px solid #cbd5e0;
        padding: 0.75rem;
        transition: box-shadow 0.2s, border-color 0.2s;
    }

    .form-control:focus {
        box-shadow: 0 0 5px rgba(66, 153, 225, 0.3);
        border-color: #63b3ed;
    }

    .btn-success {
        background-color: #48bb78;
        border-color: #48bb78;
        color: #fff;
        transition: background-color 0.3s, transform 0.3s;
    }
    .btn-success:hover {
        background-color: #38a169;
        transform: scale(1.05);
    }

    .btn-primary {
        background-color: #4299e1;
        border-color: #4299e1;
        color: #fff;
        transition: background-color 0.3s, transform 0.3s;
    }
    .btn-primary:hover {
        background-color: #3182ce;
        transform: scale(1.05);
    }

    .icon {
        margin-right: 8px;
        color: #4a5568;
    }

    /* Flash Message Styling */
    .alert {
        transition: opacity 0.5s ease;
    }

    .alert.hide {
        opacity: 0;
        visibility: hidden;
    }
</style>


<div class="container">
    <div class="card shadow-lg">
        <h2 class="text-center mb-4"><i class="bi bi-people-fill icon"></i>Change Caregiver for <?= esc($senior['name']) ?></h2>

        <!-- Flash Message -->
        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger" id="flashMessage">
            <?= session()->getFlashdata('error') ?>
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

        <form action="/admin/saveCaregiverChange/<?= $senior['id'] ?>" method="post">
            <?= csrf_field() ?>

            <input type="hidden" name="senior_id" value="<?= esc($senior['id']) ?>">

            <div class="form-group mb-3">
                <label for="current_caregiver"><i class="bi bi-person-heart icon"></i>Current Caregiver:</label>
                <input type="text" class="form-control" id="current_caregiver" value="<?= esc($currentCaregiver['name'] ?? 'None Assigned') ?>" disabled>
            </div>

            <div class="form-group mb-3">
                <label for="caregiver_id"><i class="bi bi-person-heart icon"></i>Select New Caregiver:</label>
                <select name="caregiver_id" id="caregiver_id" class="form-control" required>
                    <option value="">Select a caregiver</option>
                    <?php foreach ($caregivers as $caregiver): ?>
                        <option value="<?= esc($caregiver['id']) ?>" <?= isset($currentCaregiver) && $currentCaregiver['caregiver_id'] == $caregiver['id'] ? 'selected' : '' ?>>
                            <?= esc($caregiver['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle-fill icon"></i>Save Changes
                </button>
                <a href="<?= site_url('/admin/adminDashboard') ?>" class="btn btn-primary">
                    <i class="bi bi-arrow-left-circle icon"></i>Back to Dashboard
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
