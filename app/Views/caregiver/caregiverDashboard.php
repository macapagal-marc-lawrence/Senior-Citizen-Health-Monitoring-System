<style>
/* Importing Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Open+Sans:wght@400;600&display=swap');

/* General Layout and Text */
body {
    font-family: 'Roboto', sans-serif;  /* Default font */
}

.header-text {
    font-size: 26px;
    font-weight: 500;  /* Slightly heavier font weight */
    color: #2d3e50;
    margin-bottom: 20px;
}

/* Table Styling */
.table {
    margin-top: 20px;
    width: 100%;
    border-collapse: collapse;
    font-family: 'Open Sans', sans-serif; /* For table content */
}

.table th, .table td {
    padding: 12px;
    text-align: left;
    font-size: 15px;  /* Slightly larger font for better readability */
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f9f9f9;
}

.table-bordered th, .table-bordered td {
    border: 1px solid #ddd;
}

/* Row Hover Effect */
.table-row-hover:hover {
    background-color: #f1f1f1;
    cursor: pointer;
}

/* Header Styling for the Table */
thead.thead-light th {
    background-color: #e9f7f9;
    color: #007b8c;
    font-weight: bold;
}

/* Button Styles */
.btn {
    font-size: 15px;  /* Slightly larger font size */
    padding: 8px 12px;
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s, transform 0.2s;
}

.btn:hover {
    transform: scale(1.05);
}

/* Edit and Delete Buttons */
.btn-warning,
.btn-danger {
    font-size: 15px;
    padding: 8px 18px;
    width: 120px;
    text-align: center;
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s, transform 0.2s;
}

/* Default Button Hover Effects */
.btn-warning:hover,
.btn-danger:hover {
    transform: scale(1.05);
}

/* Modal Styles */
.modal-content {
    border-radius: 10px;
}

.modal-header {
    background-color: #e9f7f9;
    border-bottom: 1px solid #ddd;
}

.modal-footer {
    background-color: #f8f9fa;
}

/* Form Input Fields */
.form-label {
    font-weight: bold;
    margin-bottom: 5px;
    font-family: 'Open Sans', sans-serif;
}

.form-control {
    margin-bottom: 15px;
    font-family: 'Open Sans', sans-serif;
}

/* Navbar and Header */
.navbar {
    background-color: var(--primary-color);
}

.navbar-brand {
    color: #fff;
}

.navbar-light .navbar-nav .nav-link {
    color: #ffffff;
}

.navbar-light .navbar-nav .nav-link:hover {
    color: #ffcc00;
}

/* Logout Button */
.btn-danger {
    background-color: #ff4747;
    color: white;
}

.btn-danger:hover {
    background-color: #e43e3e;
}



/* Footer */
footer {
    background-color: #2d3e50;
    color: white;
    padding: 10px;
    text-align: center;
    margin-top: 30px;
}
</style>


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

        