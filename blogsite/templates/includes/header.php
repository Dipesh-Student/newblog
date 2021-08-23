<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php
            if (isset($result['pagetitle'])) {
                echo $result['pagetitle'];
            } else {
                echo "website.com";
            }
            ?> </title>

    <!--BOOTSTRAP CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

    <!-- load jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- load custom css -->
    <link rel="stylesheet" href="resources/css/style.css">
    <link rel="stylesheet" href="resources/css/search.css">
</head>

<body>
    <header>
        <nav class="navbar fixed-top">
            <!-- Navbar content -->
            <div class="row" style="width: 100%;">
                <div class="col-left">
                    <h5><a href="./">Home</a></h5>
                </div>
                <div class="col-mid">
                    <form action="index.php?action=search" method="post" style="display: flex;justify-content: center;align-items: center;">
                        <input type="text" name="search" id="search" placeholder="Search" style="width: 80%;">
                        <input type="submit" value="Search" style="width: 20%;">
                    </form>
                </div>
                <div class="col-right">
                    menu
                </div>
            </div>
        </nav>
    </header>