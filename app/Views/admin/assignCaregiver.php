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
    
</style>