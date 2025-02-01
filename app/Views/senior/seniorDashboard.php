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

    

</div>
<?= $this->endSection() ?>