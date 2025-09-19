<?php
require_once "../admin/dbconnect.php";
session_start();
function isStrong($pwd)
{
    if(strlen($pwd)>=8)
    {
        return true;
    }
    else
        return false;
}

if (isset($_POST['signUp']))
{
    $fullName = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    if(isStrong($password))
    { $sql = "insert into users (user_id, full_name, email, password) values (?,?,?,?)";
      $stmt = $conn->prepare($sql);
      $hash = password_hash($password, PASSWORD_BCRYPT);
     $status = $stmt->execute([null, $fullName, $email, $hash]);
      if($status)
      { //where to redirect
        header("Location:clogin.php");

      }

    }
    else{
        $errMsg = "Create password 8 characters at least";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>


</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php require_once "cnavigation.php"; ?>
        </div>
        <div class="row" style="background-color: rgba(137, 218, 134, 0.5);">
            <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
                <img src="../admin/productImages/shopping1.jpg" class="img-fluid mb-3 mt-3"  style="max-width: 350px; height: auto;" alt="Shopping">
                <h2>Happy Shopping!!!</h2>
            </div>
            <div class="col-md-6 d-flex flex-column align-items-center justify-content-center py-3">
                <p class="text-center">Create your free account here</p>
                <form action="signup.php" class="form card bg bg-light p-4 border border-1 rounded shadow w-55" method="post">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text" class="form-control form-control-sm" name="fullname" id="fullname">
                    </div>
                    <div class="mb-3 ">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control form-control-sm" name="email" id="email">
                    </div>
                    <div class="mb-3">
                        <?php if(isset($errMsg))
                            {echo "<p class='alert alert-danger'>$errMsg</p>";}
                            ?>
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control form-control-sm" name="password" id="password">
                    </div>

                    <div class="mb-3">
                        <button type="submit" name="signUp" class="btn btn-outline-success">Sign Up</button>
                    </div>


                </form>
            </div>


        </div>


</body>

</html>