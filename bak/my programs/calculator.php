<html>
<body>

    <form action="calculator.php" method="get">
        First num: <input type="number" name="I"><br>
        Second num: <input type="number" name="II"><br>
        <input type="submit" name="btn">
    </form>
    <?php
    if ($_GET["I"] > 0 && $_GET["II"] > 0) {
        echo 'Addition of ( ' . $_GET["I"] . ' ) and ( ' . $_GET["II"] . ' ) =  ';
        echo $_GET["I"]+$_GET["II"];
        echo ('<br>');
        echo 'Substraction of ( ' . $_GET["I"] . ' ) and ( ' . $_GET["II"] . ' ) =  ';
        echo $_GET["I"]-$_GET["II"];
        echo ('<br>');
        echo 'Multiplication of ( ' . $_GET["I"] . ' ) and ( ' . $_GET["II"] . ' ) =  ';
        echo $_GET["I"]*$_GET["II"];
        echo ('<br>');
        echo 'Division of ( ' . $_GET["I"] . ' ) and ( ' . $_GET["II"] . ' ) =  ';
        echo $_GET["I"]/$_GET["II"];
        echo ('<br>');
        echo 'Modulo of ( ' . $_GET["I"] . ' ) and ( ' . $_GET["II"] . ' ) = ';
        echo $_GET["I"]%$_GET["II"];
        echo ('<br>');
    }
    elseif (empty($_GET["I"]) && empty($_GET["II"])) {
        echo("Please enter a number");
    }
    elseif(empty($_GET["I"]) || empty($_GET["II"])) {
        echo("चुतीया है क्या  ????? ...");
    }
    

    ?>
</body>
</html>