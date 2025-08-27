<?php
if (!isset($_SESSION)) {

    session_start();
}
require_once "dbconnect.php";

if (isset($_GET['show']) && $_GET['show'] == "categories") {
    try {

        $sql = "select * from category";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo "" . $e->getMessage() . "";
    }
} else if (isset($_GET['show']) && $_GET['show'] == "products") {
    echo "after insert products";
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php require_once "navigation.php"; ?>
        </div>

        <div class="row">
            <div class="col-md-2 mx-auto py-5">
                <div class="card">
                    <a href="insertCategory.php" class="btn btn-outline-primary rounded mb-2">
                        Insert Category</a>
                    <a href="insertProduct.php" class="btn btn-outline-primary rounded mb-2">
                        Insert Product
                    </a>
                </div>


            </div>
            <div class="col-md-10 mx-auto py-5">
                <?php
                if (isset($_SESSION['message'])) {
                    echo "<p class ='alert alert-success'>$_SESSION[message]</p>";
                }

                ?>
                <table class="table table-striped">

                    <?php
                    if (isset($categories)) {
                        foreach ($categories as $category) {
                            echo "<tr>
                                 <td>$category[id]</td>
                                 <td>$category[cat_name]</td>
                                 <td>$category[description]</td>
                                 
                              </tr>";
                        } //for each end

                    } // if end

                    ?>


                </table>

            </div>
        </div>
    </div>
</body>

</html>