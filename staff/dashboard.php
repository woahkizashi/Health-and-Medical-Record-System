<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include "../includes/header.php" ?>
    <!-- content container -->
    <div style="display: flex; justify-content: center; align-items: center;">
<!-- sidebar -->
    <div style="border: solid black; height: 70vh; width: 50vh; margin: 0 0 0 20px;">
        <ul style="display: flex; justify-content: center; align-items: center; flex-direction: column; padding-top: 10px">
                <li style="border: solid black; height: 50px; width: 90%; list-style-type: none; display: flex; justify-content: center; align-items: center; font-size: 20px; margin: 2px">
                    Active
                </li>
                <li style="border: solid black; height: 50px; width: 90%; list-style-type: none; display: flex; justify-content: center; align-items: center; font-size: 20px; margin: 2px">
                    Finished
                </li>
        </ul>
    </div>
    <!-- Main Section -->
     <div id="contentBox" style="width: 100%; height: 70vh; border: solid black; margin: 0 10px 0 10px"></div>
    </div>
    
    
    <script src="../assets/js/script.js"></script>
</body>
</html>