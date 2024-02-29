<?php
if (isset($_SESSION['logedin']) && $_SESSION['logedin'] == true) {
    $logedin=true;
}
else {
    $logedin=false;
}
echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Grow More</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">';
        if ($logedin) {
            echo '<a class="nav-link active" aria-current="page" href="home.php">Home</a>
            <a class="nav-link active" aria-current="page" href="new_client.php">New client</a>
            <a class="nav-link active" aria-current="page" href="our_clients.php">Our clients</a>
            <a class="nav-link active" aria-current="page" href="logout.php">logout</a>
            ';
        }
        if (!$logedin) {
            echo '<a class="nav-link active" aria-current="page" href="home.php">Home</a>
          <a class="nav-link active" aria-current="page" href="login.php">login</a>';
        }
         
          
       echo   '</li>
       
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>';
?>