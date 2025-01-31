<?= $this->extend('layouts/frontend.php') ?>

<?= $this->section('content') ?>

<style>
     .sidebar {
        width: 70px;
        background: rgba(233, 244, 248, 0.9);
        color: #2d3748;
        transition: width 0.3s;
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        overflow: hidden;
        border-right: 1px solid #cbd5e0;
        z-index: 100;
     }
     .sidebar:hover {
        width: 220px;
    }
    .sidebar .nav-link {
        font-size: 1rem;
        color: #4a5568;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        border-radius: 6px;
        margin: 5px 0;
        transition: background-color 0.3s, color 0.3s;
    }
    .sidebar .nav-link:hover {
        color: #2b6cb0;
        background-color: rgba(66, 153, 225, 0.15);
    }
    .sidebar .nav-link.active {
        background-color: rgba(66, 153, 225, 0.2);
        color: #2c5282;
        font-weight: bold;
    }
    .sidebar .nav-link i {
        font-size: 1.2rem;
        margin-right: 10px;
        transition: transform 0.3s;
    }
    .sidebar:hover .nav-link i {
        transform: scale(1.1);
    }
</style>