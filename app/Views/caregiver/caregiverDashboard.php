

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


        