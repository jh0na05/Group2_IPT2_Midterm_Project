<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'index.php') ? '' : 'collapsed'; ?>" href="index.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'users.php') ? '' : 'collapsed'; ?>" href="users.php">
                <i class="bi bi-people"></i>
                <span>Users</span>
            </a>
        </li><!-- End Users Nav -->

        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'settings.php') ? '' : 'collapsed'; ?>" href="settings.php">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
        </li><!-- End Settings Nav -->

        <!-- Genre List Section -->
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#genreMenu" role="button" aria-expanded="false">
                <i class="bi bi-film"></i>
                <span>Genres</span>
                <i class="bi bi-chevron-down"></i>
            </a>
            <ul id="genreMenu" class="collapse list-unstyled">
                <li><a class="nav-link" href="genre.php?genre=action">Action</a></li>
                <li><a class="nav-link" href="genre.php?genre=romance">Romance</a></li>
                <li><a class="nav-link" href="genre.php?genre=horror">Horror</a></li>
                <li><a class="nav-link" href="genre.php?genre=comedy">Comedy</a></li>
                <li><a class="nav-link" href="genre.php?genre=fantasy">Fantasy</a></li>
                <li><a class="nav-link" href="genre.php?genre=animation">Animation</a></li>
            </ul>
        </li><!-- End Genre List -->

    </ul>
</aside><!-- End Sidebar -->
