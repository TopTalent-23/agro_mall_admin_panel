<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />

    <title>switch case statement</title>


</head>
<body>
    <form action="switch_case.php" method="get" accept-charset="utf-8">
        Enter your age <input type="number" name="age" />
        <input type="submit" />
    </form>





    <?php


    switch ($_GET["age"]) {
        case ($_GET["age"] < 18):
            echo "your age is " . $_GET["age"] . "  you are not able for voting";
            break;
        case ($_GET["age"] > 18):
            echo "your age is  " . $_GET["age"] . "  you are able for voting";
            break;
        default :
            echo 'please enter your age';
            break;

        
    }


    ?>
</body>
</html>