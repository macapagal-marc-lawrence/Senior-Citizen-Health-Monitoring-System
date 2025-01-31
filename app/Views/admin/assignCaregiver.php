<?= $this->extend('layouts/frontend') ?>

<?= $this->section('section')?>

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
        transform: translate(-3px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);;
    }

    .card h2 {
        color:  #2d3748;
        font-weight: bold;
    }

    .form-group label {
        color: #4a5568;
        font-weight: 500;
    }
</style>