<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
  <div class="container">
    <a class="navbar-brand" href="index.php">Ecom</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Features</a>
        </li>
        <?php
          if(isset($_SESSION['auth']))
          {
            // Kiểm tra nếu là admin thì hiển thị nút Dashboard
            if($_SESSION['role_as'] == 1)
            {
              ?>
              <li class="nav-item">
                <a class="nav-link" href="../phpecom/admin/category.php">Dashboard</a>
              </li>
              <?php
            }
            ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?= $_SESSION['auth_user']['name']; ?>
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
              </ul>
            </li>
            <?php
          }
          else
          {
            ?>
              <li class="nav-item">
                <a class="nav-link" href="register.php">Register</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="login.php">Log In</a>
              </li>
            <?php
          }
        ?>
      </ul>
    </div>
  </div>
</nav>
