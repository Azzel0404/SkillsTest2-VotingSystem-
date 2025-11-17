<?php 
include 'db.php';

$edit_mode = false;
$edit_position;

    if(isset($_POST['add'])){
        $posName = $_POST['posName'];
        $numOfPositions = $_POST['numOfPosition'];
        $posStat = $_POST['posStat'];
        $conn->query("INSERT INTO Positions (posName,numOfPosition,posStat) 
        VALUES ('$posName','$numOfPositions','$posStat')");
    }

    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
        $edit_mode = true;
        $result = $conn->query("SELECT * FROM Positions WHERE posID = '$id'");
        $edit_position = $result->fetch_assoc();
    }

    if(isset($_POST['edit1'])){
        $id = $_POST['id'];
        $posName = $_POST['posName'];
        $numOfPositions = $_POST['numOfPosition'];
        $posStat = $_POST['posStat'];
        $conn->query("UPDATE Positions SET posName = '$posName', numOfPosition = '$numOfPositions'
        ,posStat = '$posStat' WHERE posID = '$id'");
    }

    if(isset($_GET['deactivate'])){
        $id = $_GET['deactivate'];
        $conn->query("UPDATE Positions SET posStat = 'closed' WHERE posID = '$id'");
    }

    $Positions = $conn->query("SELECT * FROM Positions");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Positions Management</title>
</head>
<body>
    <h1>Positions Management</h1><br>
    <?php if($edit_mode && $edit_position): ?>
        <form method="post">
            <input type="hidden" name="id" value="<?=$edit_position['posID']?>" required><br>
            Position Name:<input type="text" name="posName" value="<?= $edit_position['posName'] ?>" required><br>
            Number Of Position: <input type="number" name="numOfPosition" value="<?= $edit_position['numOfPosition'] ?>" required><br>
            Postat:
                <select name="posStat">
                    <option value="open" <?= $edit_position['posStat'] == 'open' ? 'selected' : ''?>>Open</option>
                    <option value="closed" <?= $edit_position['posStat'] =='closed' ? 'selected' : ''?>>Closed</option>
                </select>
                <button type="submit" name="edit1">Edit Position</button>
                <button a href="Positions.php">Back</button>
        </form>
    <?php else: ?>
        <form method="post">
            <input type="hidden" name="id" value="" required><br>
            Position Name: <input type="text" name="posName" required><br>
            Number Of Position: <input type="number" name="numOfPosition" required><br>
            Position Status:
            <select name="posStat">
                <option value="open">Open</option>
                <option value="closed">Closed</option>
            </select>
            <button type="submit" name="add">Add Position</button>
        </form>
    <?php endif; ?>

    <button><a href = "index.php">Back</a></button>

     <table border="1">
        <tr>
            <th>ID</th>
            <th>Position Name</th>
            <th>Number Of Positions</th>
            <th>Position Status</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $Positions->fetch_assoc()): ?>
        <tr>
            <td><?= $row['posID'] ?></td>
            <td><?= $row['posName'] ?></td>
            <td><?= $row['numOfPosition'] ?></td>
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