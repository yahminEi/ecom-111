<?php
if (!isset($_SESSION)) {
    session_start();
}

if(isset($_SESSION['product'])) {
    $product = $_SESSION['product'];
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php require_once "navigation.php" ?>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10">
                <form action="" class="form">
                    <div class="row">

                        <div class="col-md-6 py-3">
                            <div class="mb-3">
                                <label for="pname" class="form-label">Product Name</label>
                                <input id="pname" type="text" class="form-control" name="pname"
                                    value="<?php if (isset($product)) {
                                                echo $product['product_name'];
                                            }
                                            ?>">
                            </div>

                            <div class="mb-3">
                                <label for="cost" class="form-label">Product Cost</label>
                                <input id="cost" type="number" class="form-control" name="cost"
                                    value="<?php if (isset($product)) {
                                                echo $product['cost'];
                                            }
                                            ?>">
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Product Price</label>
                                <input id="price" type="number" class="form-control" name="price"
                                    value="<?php if (isset($product)) {
                                                echo $product['price'];
                                            }
                                            ?>">
                            </div>

                        </div>
                        <div class="col-md-6 py-3">

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>