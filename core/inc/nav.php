<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">Members Area</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php if ($account_type === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href='add-user.php'>Add User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href='table-view.php'>View Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href='iplogs.php'>Login Attempts</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <form action="logout.php" method="post" class="form-inline">
                        <button class="btn btn-outline-light" type="submit">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
