<?php include("includes/header.php"); ?>

<div class="container">

</div>
<div class="row">
    <div class="col-left">
        <h3>project.com</h3>
        <div class="features">
            <ul>
                <li><a href="#">Bookmark</a></li>
                <li><a href="#">Bookmark</a></li>
                <li><a href="#">Bookmark</a></li>
            </ul>
        </div>
    </div>
    <div class="col-mid">
        <h3>Feed</h3>
        <div class="feed_container">
            <?php
            if (isset($_SESSION['username']) && isset($_SESSION['isloggedin'])) {
                //if user is logged in
            ?>
                <div class="blog-form">
                    <form action="index.php?action=post" method="post">
                        <input class="form-control" type="text" name="btitle" id="btitle" placeholder="Title" required autofocus>
                        <textarea class="form-control" name="bcontent" id="bcontent" rows="4" placeholder="Content" required></textarea>
                        <input class="btn btn-primary" name="makepost" type="submit" value="Post">
                    </form>
                    <div class="error-msg">
                        <?php
                        if (isset($result['error'])) {
                            echo $result['error'];
                        }
                        ?>
                    </div>
                </div>
            <?php
            } else {
                //show login button
            ?>
                <div class="signup-div">
                    <a href="index.php?action=login">Login</a>
                    <a href="index.php?action=register">Register</a>
                </div>
            <?php
            }
            ?>


            <?php
            foreach ($r['data'] as $res => $val) {
                $title = $val['title'];
                $summary = $val['summary'];
                $date = $val['publicationDate'];
                $post_id = $val['id'];
            ?>
                <div class="card text-white bg-dark mb-3">
                    <div class="card-header"><?= htmlspecialchars($title); ?></div>
                    <div class="card-body">
                        <p class="card-text"><?= htmlspecialchars($summary) ?></p>
                    </div>
                    <div class="card-footer" style="display: flex; justify-content: space-around;">
                        <label for="date"><?php if (isset($_SESSION['isloggedin']) === true) {
                                                echo basic_fun::elapsed_time($date, $_SESSION['username']);
                                            } else {
                                                echo $date;
                                            }
                                            ?></label>
                        <a href="index.php?action=view_post&pid=<?= trim($post_id); ?>" style="text-decoration: none;">View</a>
                        <button class="post_del" onclick="post_del('<?= $post_id; ?>','<?= $_SESSION['username']; ?>');">Delete</button>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <div class="col-right">
        <h3>Top-trends</h3>
    </div>
</div>

<!-- <script src="main.js"></script> -->
<?php include("includes/footer.php"); ?>