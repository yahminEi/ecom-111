<?php
require_once 'dbconnect.php';
session_start();

try {
    $sql = "select * from category";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll(); // multiple rows return
} catch (PDOException $e) {
    echo $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['val'] == 'delete') {
    try {
        $id = $_GET['id'];
        $sql = "delete from product where id=?";
        $stmt = $conn->prepare($sql);
        $staus = $stmt->execute([$id]);

        if ($staus) {
            header("Location:viewInfo.php?show=products");
        }
    } catch (PDOException $e) {
        echo '' . $e->getMessage() . '';
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['val'] == 'edit') {
    $id = $_GET['id'];
    try {
        $sql = "select p.id, p.product_name,
      p.cost, p.price,
      p.description, p.image_path,
      c.cat_name as category,
      p.id catid, p.quantity
        from product p, category c where p.category = c.id and p.id=?";  // return single row corresponding this id

        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        $product = $stmt->fetch();
    } catch (PDOException $e) {
        echo '' . $e->getMessage() . '';
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnUpdate'])) {
    $id = $_POST['id'];
    $productName = $_POST['pname'];
    $price = $_POST['price'];
    $cost = $_POST['cost'];
    $description = $_POST['desc'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];
    $image = $_FILES['pimg'];
    $filePath = "productImages/" . $image['name'];
    if (move_uploaded_file($image['tmp_name'], $filePath)) {
        try {
            $sql = "update product set product_name=?, cost=?, price=?, description=?,
            category=?, quantity=?, image_path=? where id=?";
            $stmt = $conn->prepare($sql);
            $status = $stmt->execute([
                $productName,
                $cost,
                $price,
                $description,
                $category,
                $quantity,
                $filePath,
                $id
            ]);
            if ($status) {
                $_SESSION['message'] = "Update Successful on id $id";
                header("Location:viewInfo.php?show=products");
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <!-- cdn link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php require_once("navigation.php"); ?>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10">
                <h4 class="text-center">Edit Product</h4>
                <form action="editProduct.php" class="form" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 py-3">

                            <div class="mb-3">
                                <label for="id">Product ID</label>
                                <input type="text" name="id" readonly value="<?php echo $product['id']; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="pname" class="form-label">Product Name </label>
                                <input id="pname" type="text" class="form-control" name="pname"
                                    value="<?php if (isset($product)) {
                                                echo $product['product_name'];
                                            } ?>">
                            </div>
                            <div class="mb-3">
                                <label for="cost" class="form-label">Product Cost</label>
                                <input id="cost" type="number" class="form-control" name="cost"
                                    value="<?php if (isset($product)) {
                                                echo $product['cost'];
                                            } ?>">
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Product Price</label>
                                <input id="price" type="number" class="form-control" name="price"
                                    value="<?php if (isset($product)) {
                                                echo $product['price'];
                                            } ?>">
                            </div>
                            <div class="mb-3">
                                <label for="cat">You selected <?php if (isset($product)) {
                                                                    echo "$product[category]";
                                                                } ?></label>
                                <select name="category" id="cat" class="form-select">
                                    <?php
                                    if (isset($categories)) {
                                        foreach ($categories as $category) {
                                            echo "<option value='$category[id]'>$category[cat_name]</option>";
                                        }
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 py-3">
                            <div class="mb-3">
                                <label for="desc" class="form-label">Description</label>
                                <textarea name="desc" id="desc"
                                    placeholder="<?php if (isset($product)) {
                                                        echo $product['description'];
                                                    } ?>">

                                </textarea>
                            </div>

                            <div class="mb-3">
                                <lable for="quantity" class="form-label">Quantity</lable>
                                <input type="number" class="form-control" name="quantity" id="quantity"
                                    value="<?php if (isset($product)) {
                                                echo $product['quantity'];
                                            } ?>">
                            </div>

                            <div class="mb-3">
                                <div class="d-flex me-3">
                                    <p>Previous image</p>
                                    <img src="<?php echo $product['image_path']; ?>" style="width:20%;height:20%">
                                </div>
                                <label for="pimg" class="form-label">Choose Product Image</label>
                                <input type="file" class="form-control" name="pimg" id="pimg">
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-outline-primary" name="btnUpdate">Update</button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>