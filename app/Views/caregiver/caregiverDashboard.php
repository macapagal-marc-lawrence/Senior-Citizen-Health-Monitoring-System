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

        