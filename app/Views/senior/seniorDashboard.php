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
    

</div>
<?= $this->endSection() ?>