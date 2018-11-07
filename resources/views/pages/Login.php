<div class="container" style="min-height: 100vh">
    <div>
        <form method="post" action="<?php echo \Qui\lib\Routes::$routes['login'] ?>" id="loginForm">

            <label>Email*</label>
            <input type="email" name="email" class="form-control" placeholder="Enter your email" required minlength="3"/>

            <br/>

            <label>Password*</label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password" required minlength="1"/>

            <br/>

            <p>* = required</p>

            <br/>

            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
</div>


<script src="js/login.js"></script>