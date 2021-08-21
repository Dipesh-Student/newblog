<?php include(TEMPLATE_PATH . "/includes/header.php"); ?>
<div class="container">
    <div class="register_form">
        <form action="index.php?action=register" method="post">
            <input type="hidden" name="register" value="true" />

            <div>
                <label for="email">Username</label>
                <input type="text" name="email" id="email" placeholder="Email-id" required>
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" name="upassword" id="upassword" placeholder="Password" required>
            </div>
            <div>
                <label for="password">Confirm Password</label>
                <input type="password" name="cpassword" id="cpassword" placeholder="Password" required>
            </div>

            <div>
                <input type="submit" name="register" value="Signup">
            </div>

        </form>
    </div>
</div>

<?php include(TEMPLATE_PATH . "/includes/footer.php"); ?>