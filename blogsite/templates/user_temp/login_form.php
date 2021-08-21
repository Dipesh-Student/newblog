<?php include(TEMPLATE_PATH . "/includes/header.php"); ?>
<div class="container">
    <div class="login_form">
        <form action="index.php?action=login" method="post">
            <input type="hidden" name="login" value="true" />

            <div>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Username/Email-id" required>
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" name="upassword" id="upassword" placeholder="Password" required>
            </div>

            <div>
                <input type="submit" name="login" value="Login">
            </div>

        </form>
    </div>
</div>

<?php include(TEMPLATE_PATH . "/includes/footer.php"); ?>