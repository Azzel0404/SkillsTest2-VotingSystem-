<?php 
include 'db.php';

    $edit_mode = false;
    $edit_position;

    if(isset($_POST['add'])){
        $posName = $_POST['posName'];
        $numOfPositions = $_POST['numOfPositions'];
        $posStat = $_POST['posStat'];
        $conn->query("INSERT INTO Positions (posName,numOfPositions,posStat) 
        VALUES ('$posName','$numOfPositions','$posStat')");
    }

    if(isset($_GET['edit'])){
        $edit_mode = true;
        $edit_id = $_GET['edit'];
        $result = $conn->query("SELECT * FROM Positions where posID = $edit_id");
        $edit_position = $result -> fetch_assoc();
    }

    if(isset($_POST['edit1'])){
        $id = $_POST['id'];
        $posName = $_POST['posName'];
        $numOfPositions = $_POST['numOfPositions'];
        $posStat = $_POST['posStat'];
        $conn->query("UPDATE Positions SET posName = '$posName', 
        numOfPositions='$numOfPositions', posStat='$posStat' WHERE posID = '$id'");
    }

    if(isset($_GET['deactivate'])){
        $id = $_GET['deactivate'];
        $conn->query("UPDATE Positions SET posStat = 'closed' WHERE posID = '$id'");
    }

    $positions = $conn->query("SELECT * FROM Positions");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Positions</title>
</head>
<body>
    <h1>Positions Management</h1><br><br>
    <?php if($edit_mode && $edit_position): ?>
    <form method = "post">
        <input type="hidden" name = "id" value="<?=$edit_position['posID']?>" required>
        Position Name: <input type="text" name = "posName" value ="<?= $edit_position['posName']?>" required><br>
        Number Of Positions:<input type="number" name = "numOfPositions" value = "<?= $edit_position['numOfPositions']?>" required><br>
        Positions Status:
            <select name ="posStat">
                <option value = "open" <?=$edit_position['posStat'] == 'open' ? 'selected' : '' ?>>Open</option>
                <option value = "closed" <?= $edit_position['posStat'] == 'closed' ? 'selected' : '' ?>>Closed</option>
            </select><br>
            <button type="submit" name="edit1">Edit Position</button>
            <button><a href="Positions.php">Back</a></button>
    </form>
    <?php else: ?>
    <form method="post">
        <input type="hidden" name="id" value="">
        Position Name:<input type="text" name="posName" required></input><br>
        Number Of Positions:<input type="number" name="numOfPositions" required></input><br>
        Position Status:
        <select name="posStat">
            <option value="open">Open</option>
            <option value="closed">Close</option>
        </select>
        <button type="submit" name="add">Add Position</button><br>
    </form>
    <?php endif; ?>

    <button><a href="index.html">Back</a></button>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Position Name</th>
            <th>Number Of Positions</th>
            <th>Position Status</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $positions->fetch_assoc()): ?>
        <tr>
            <td><?= $row['posID'] ?></td>
            <td><?= $row['posName'] ?></td>
            <td><?= $row['numOfPositions'] ?></td>
            <td><?= $row['posStat']?></td>
            <td>
                <a href="?edit=<?= $row['posID'] ?>">Edit</a>
                <?php if ($row['posStat'] == 'open'): ?>
                    <a href="?deactivate=<?= $row['posID'] ?>">Deactivate</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>