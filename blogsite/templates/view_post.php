<?php include("includes/header.php"); ?>

<div class="container">
    <div class="row">
        <div class="leftcolumn">
            <?php //print_r($r);
            foreach ($r['data'] as $key => $value) {
                $author = $value['username'];
                $title = $value['title'];
                $content = $value['content'];
                $date = $value['publicationDate'];
            }
            ?>
            <div class="card">
                <h2><?= htmlspecialchars($title); ?></h2>
                <h5><?= $date . " by " .htmlspecialchars($author); ?></h5>
                <div class="fakeimg" style="height:200px;">Image</div>
                <p><?= htmlspecialchars($content); ?></p>
                <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
            </div>

        </div>
        <div class="rightcolumn">
            <div class="card">
                <h2>About Me</h2>
                <div class="fakeimg" style="height:100px;">Image</div>
                <p>Some text about me in culpa qui officia deserunt mollit anim..</p>
            </div>
            <div class="card">
                <h3>Popular Post</h3>
                <div class="fakeimg">Image</div><br>
                <div class="fakeimg">Image</div><br>
                <div class="fakeimg">Image</div>
            </div>
            <div class="card">
                <h3>Follow Me</h3>
                <p>Some text..</p>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>