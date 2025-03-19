<?php
session_start();
include('partials\header.php');
include('partials\sidebar.php');
include('database\database.php');
include('database\create.php');
include('database\update.php');
include('database\delete.php');
include('database\login.php');
include('database\login_process.php');
include('database\register.php');

$status = '';
if (isset($_SESSION['status'])) {
    $status = $_SESSION['status'];
    unset($_SESSION['status']);
}
//FOR PAGANATION
// Set the number of records per page
$records_per_page = 10;

// Get the current page from the query parameter, default to 1 if not set
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($current_page - 1) * $records_per_page;

// Modify the SQL query to fetch only the records for the current page
$sql = "SELECT * FROM movie_list LIMIT $records_per_page OFFSET $offset";
$movie_list = $conn->query($sql);

// Get the total number of records
$total_records_sql = "SELECT COUNT(*) AS total FROM movie_list";
$total_records_result = $conn->query($total_records_sql);
$total_records = $total_records_result->fetch_assoc()['total'];

// Calculate the total number of pages
$total_pages = ceil($total_records / $records_per_page);
?>

<main id="main" class="main">
<!-- ALERT -->
<?php if ($status == "created"): ?>
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center p-3 shadow-sm rounded" role="alert" style="border-left: 5px solid #28a745;">
    <i class="bi bi-check-circle-fill me-2 text-success fs-4"></i>
    <strong>Movie added successfully!</strong>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

<?php elseif ($status == "updated"): ?>
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center p-3 shadow-sm rounded" role="alert" style="border-left: 5px solid #28a745;">
    <i class="bi bi-pencil-square me-2 text-success fs-4"></i>
    <strong>Movie updated successfully!</strong>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

<?php elseif ($status == "error"): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>There was an error adding the movie!</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php elseif ($status == "deleted"): ?>
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center p-3 shadow-sm rounded" 
     role="alert" style="border-left: 5px solid #dc3545;">
    <i class="bi bi-trash3-fill me-2 text-danger fs-4"></i>
    <strong>Movie deleted successfully!</strong>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

<?php endif; ?>
<!-- END ALERT -->

<!-- PAGE TITLE -->
<div class="pagetitle">
  <h1>Movie Management System</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item">Tables</li>
      <li class="breadcrumb-item active">General</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div>
              <h5 class="card-title">MOVIES</h5>
            </div>
            <div>
              <button class="btn btn-primary btn-sm mt-4 mx-3" data-bs-toggle="modal" data-bs-target="#addMovie">Add Movie</button>
            </div>

          </div>

          <!-- Default Table -->
          <table class="table">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Movie Title</th>
                <th scope="col">Release Date</th>
                <th scope="col">Genre</th>
                <th scope="col">Director</th>
                <th scope="col" class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($movie_list->num_rows > 0): ?>
                <?php while ($row = $movie_list->fetch_assoc()): ?>
                  <tr>
                    <th scope="row"><?php echo $row['id']; ?></th>
                    <td><?php echo $row['movie_title']; ?></td>
                    <td><?php echo $row['release_date']; ?></td>
                    <td><?php echo $row['genre']; ?></td>
                    <td><?php echo $row['director']; ?></td>
                    <td class="d-flex justify-content-center">
<!-- Edit Button -->
<button class="btn btn-success btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#editInfo<?php echo $row['id']; ?>">Update</button>

<!-- Edit Modal -->
<style>
    /* Modal Background */
    #editInfo<?php echo $row['id']; ?> .modal-content {
        background: #f8f9fa;
        border-radius: 12px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
    }

    /* Header Styling */
    #editInfo<?php echo $row['id']; ?> .modal-header {
        background-color: #007bff;
        color: white;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    /* Close Button */
    #editInfo<?php echo $row['id']; ?> .btn-close {
        filter: invert(1);
    }

    /* Form Labels */
    #editInfo<?php echo $row['id']; ?> .form-label {
        font-weight: bold;
        color: #343a40;
    }

    /* Input Fields */
    #editInfo<?php echo $row['id']; ?> .form-control {
        border-radius: 8px;
    }

    /* Select Dropdown */
    #editInfo<?php echo $row['id']; ?> .form-select {
        border-radius: 8px;
    }

    /* Submit Button */
    #editInfo<?php echo $row['id']; ?> .btn-primary {
        width: 100%;
        background: #007bff;
        border: none;
        transition: 0.3s;
        font-weight: bold;
    }

    #editInfo<?php echo $row['id']; ?> .btn-primary:hover {
        background: #0056b3;
    }
</style>
                      
<div class="modal fade" id="editInfo<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editInfoLabel" aria-hidden="true">
        
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title">Edit Movie</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                <form action="database/update.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

<!-- Movie Name -->
        <div class="mb-3">
          <label class="form-label">Movie Name</label>
              <input type="text" class="form-control" name="movie_title" value="<?php echo $row['movie_title']; ?>" required>
                </div>

<!-- Genre -->
  <div class="mb-3">
    <label class="form-label">Genre</label>
      <select class="form-select" name="genre" required>
          <option value="Action" <?php if ($row['genre'] == 'Action') echo 'selected'; ?>>Action</option>
          <option value="Romance" <?php if ($row['genre'] == 'Romance') echo 'selected'; ?>>Romance</option>
          <option value="Horror" <?php if ($row['genre'] == 'Horror') echo 'selected'; ?>>Horror</option>
          <option value="Comedy" <?php if ($row['genre'] == 'Comedy') echo 'selected'; ?>>Comedy</option>
      </select>
  </div>

<!-- Total -->
<div class="mb-3">
    <label class="form-label" for="release_date">Release Date</label>
    <input type="date" class="form-control" name="release_date" id="release_date" 
        value="<?php echo isset($row['release_date']) ? htmlspecialchars($row['release_date']) : ''; ?>" required>
</div>

<!-- Director -->
<div class="mb-3">
    <label class="form-label" for="director">Director</label>
    <input type="text" class="form-control" name="director" id="director" 
        value="<?php echo isset($row['director']) ? htmlspecialchars($row['director'], ENT_QUOTES, 'UTF-8') : ''; ?>" required>
</div>


      <button type="submit" class="btn btn-primary">Update Movie</button>
      </form>
      </div>
      </div>
      </div>
      </div>


<!-- View Button -->
<button class="btn btn-primary btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#viewInfo<?php echo $row['id']; ?>">View</button>

  <!-- View Modal -->
  <style>
    /* Modal Background */
    #viewInfo<?php echo $row['id']; ?> .modal-content {
        background: #f8f9fa;
        border-radius: 12px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    /* Header Styling */
    #viewInfo<?php echo $row['id']; ?> .modal-header {
        background-color: #28a745;
        color: white;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    /* Close Button */
    #viewInfo<?php echo $row['id']; ?> .btn-close {
        filter: invert(1);
    }

    /* Modal Body */
    #viewInfo<?php echo $row['id']; ?> .modal-body {
        padding: 20px;
        font-size: 16px;
    }

    /* Movie Details Styling */
    #viewInfo<?php echo $row['id']; ?> .modal-body p {
        background: #ffffff;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        margin-bottom: 10px;
    }

    #viewInfo<?php echo $row['id']; ?> strong {
        color: #333;
    }
</style>

<div class="modal fade" id="viewInfo<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewInfoLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Movie Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p><strong>Movie Title:</strong> <?php echo $row['movie_title']; ?></p>
            <p><strong>Release Date:</strong> <?php echo $row['release_date']; ?></p>
            <p><strong>Genre:</strong> <?php echo $row['genre']; ?></p>
            <p><strong>Director:</strong> <?php echo $row['director']; ?></p>
        </div>
      </div>
    </div>
</div>

<!-- Delete Button -->
<button class="btn btn-danger btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#deleteInfo<?php echo $row['id']; ?>">Delete</button>

<!-- Delete Modal -->
<style>
    /* Modal Background */
    #deleteInfo<?php echo $row['id']; ?> .modal-content {
        background: #fff3f3;
        border-radius: 12px;
        box-shadow: 0px 4px 12px rgba(255, 0, 0, 0.3);
        border: 2px solid #dc3545;
    }

    /* Header Styling */
    #deleteInfo<?php echo $row['id']; ?> .modal-header {
        background-color: #dc3545;
        color: white;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    /* Close Button */
    #deleteInfo<?php echo $row['id']; ?> .btn-close {
        filter: invert(1);
    }

    /* Modal Body */
    #deleteInfo<?php echo $row['id']; ?> .modal-body {
        font-size: 18px;
        text-align: center;
        font-weight: bold;
        color: #a30000;
    }

    /* Strong Text */
    #deleteInfo<?php echo $row['id']; ?> strong {
        color: #721c24;
    }

    /* Footer Buttons */
    #deleteInfo<?php echo $row['id']; ?> .modal-footer {
        display: flex;
        justify-content: center;
    }

    /* Delete Button */
    #deleteInfo<?php echo $row['id']; ?> .btn-danger {
        background: #c82333;
        border-color: #bd2130;
        transition: 0.3s;
    }

    #deleteInfo<?php echo $row['id']; ?> .btn-danger:hover {
        background: #a71d2a;
        border-color: #921224;
    }

    /* Cancel Button */
    #deleteInfo<?php echo $row['id']; ?> .btn-secondary {
        background: #6c757d;
        transition: 0.3s;
    }

    #deleteInfo<?php echo $row['id']; ?> .btn-secondary:hover {
        background: #5a6268;
    }
</style>

  <div class="modal fade" id="deleteInfo<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteInfoLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
          <div class="modal-body">Are you sure you want to delete <strong><?php echo $row['movie_title']; ?></strong>?</div>
      <div class="modal-footer">
          <form action="database/delete.php" method="GET">
          <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
          <button type="submit" class="btn btn-danger">Yes, Delete</button>
          </form>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
  </div>
  </td>
  </tr>
  <?php endwhile; ?>
  <?php endif; ?>
  </tbody>
  </table>

<!-- ADDING MOVIE Modal  -->
<style>
    /* Modal Background */
    #addMovie .modal-content {
        background: linear-gradient(135deg, #ffffff, #f8f9fa);
        border-radius: 12px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    /* Header Styling */
    #addMovie .modal-header {
        background-color: #007bff;
        color: white;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    /* Close Button */
    #addMovie .btn-close {
        filter: invert(1);
    }

    /* Form Inputs */
    #addMovie .form-control, 
    #addMovie .form-select {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 10px;
    }

    /* Form Labels */
    #addMovie .form-label {
        font-weight: bold;
        color: #495057;
    }

    /* Footer Buttons */
    #addMovie .modal-footer {
        border-top: none;
    }

    #addMovie .btn-primary {
        background-color: #007bff;
        border-radius: 8px;
        padding: 8px 16px;
    }

    #addMovie .btn-secondary {
        border-radius: 8px;
        padding: 8px 16px;
    }
</style>

<div class="modal fade" id="addMovie" tabindex="-1" aria-labelledby="addMovieLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addMovieLabel">Add Movie</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="database/create.php" method="POST">
          <!-- Movie Title -->
          <div class="mb-3">
            <label class="form-label">Movie Title</label>
            <input type="text" class="form-control" name="movie_title" required>
          </div>

          <!-- Genre -->
          <div class="mb-3">
            <label class="form-label">Genre</label>
            <select class="form-select" name="genre" required>
              <option value="Action">Action</option>
              <option value="Romance">Romance</option>
              <option value="Horror">Horror</option>
              <option value="Comedy">Comedy</option>
            </select>
          </div>

          <!-- Total -->
          <div class="mb-3">
            <label class="form-label" for="release_date">Release Date</label>
            <input type="date" class="form-control" name="release_date" id="release_date" required>
          </div>

          <!-- Director -->
          <div class="mb-3">
            <label class="form-label" for="director">Director</label>
            <input type="text" class="form-control" name="director" id="director" 
            value="<?php echo isset($row['director']) ? htmlspecialchars($row['director']) : ''; ?>" required>
          </div>


          <button type="submit" class="btn btn-primary">Add Movie</button>
          
        </form>
      </div>
    </div>
  </div>
</div>

          <!-- End OF Table Modal and alert -->

          <!-- Pagination -->
          <div class="mx-4">
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item <?php if ($current_page <= 1) echo 'disabled'; ?>">
                  <a class="page-link" href="?page=<?php echo $current_page - 1; ?>">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                  <li class="page-item <?php if ($i == $current_page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                  </li>
                <?php endfor; ?>
                <li class="page-item <?php if ($current_page >= $total_pages) echo 'disabled'; ?>">
                  <a class="page-link" href="?page=<?php echo $current_page + 1; ?>">Next</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</main><!-- End #main -->

<?php
include('partials\footer.php');
?>