<?php
include 'connect.php'; 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    if (isset($_POST['id']) && $_POST['id'] !== '') {
        $id = $_POST['id'];
        $sql = "UPDATE itm SET name='$name', price='$price', stock='$stock' WHERE itm_id='$id'";
    } else {
        $sql = "INSERT INTO itm (name, price, stock) VALUES ('$name', '$price', '$stock')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Item successfully saved!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM itm WHERE itm_id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Item successfully deleted!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM itm WHERE itm_id='$id'");
    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
        $itemId = $item['itm_id'];
        $itemName = $item['name'];
        $itemPrice = $item['price'];
        $itemStock = $item['stock'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        form input[type="text"], form input[type="submit"] {
            padding: 10px;
            margin: 5px;
            width: 80%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        form input[type="submit"] {
            width: 50%;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        form input[type="submit"]:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .actions a {
            color: #2196F3;
            text-decoration: none;
            margin: 0 5px;
        }
        .actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Page</h1>
        <form method="POST" action="admin.php">
            <input type="hidden" name="id" id="itemId" value="<?php echo isset($itemId) ? $itemId : ''; ?>">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" value="<?php echo isset($itemName) ? $itemName : ''; ?>"><br>
            <label for="price">Price:</label><br>
            <input type="text" id="price" name="price" value="<?php echo isset($itemPrice) ? $itemPrice : ''; ?>"><br>
            <label for="stock">Stock:</label><br>
            <input type="text" id="stock" name="stock" value="<?php echo isset($itemStock) ? $itemStock : ''; ?>"><br><br>
            <input type="submit" value="Save Item">
        </form>

        <h2>Item List</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
            <?php
            $result = $conn->query("SELECT * FROM itm");
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td>" . $row['stock'] . "</td>";
                    echo "<td class='actions'>";
                    echo "<a href='admin.php?edit=" . $row['itm_id'] . "'>Edit</a> | ";
                    echo "<a href='admin.php?delete=" . $row['itm_id'] . "'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No items found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
