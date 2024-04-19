<?php

function drawHeader($title = 'Default Title'){ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" type="text/css" href="../styles/register.css">
</head>
<body>
    <header>
        <h1><a href="../pages/index.php">TEMPLATE NAME</a></h1>
    </header>
    <main>
<?php }

function drawFooter() { ?>
    </main>
    <footer>
        LTW Buy & Sell &copy; 2024
    </footer>
</body>
</html>
<?php }
?>
