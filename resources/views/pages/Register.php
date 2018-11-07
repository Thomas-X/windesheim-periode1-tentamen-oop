<div class="container" style="min-height: 100vh">
    <div>
        <form method="post" action="<?php echo \Qui\lib\Routes::$routes['onRegister'] ?>" id="registerForm">

            <label>First name*</label>
            <input type="text" name="fname"  class="form-control" id="fname" placeholder="Enter your firstname" required/>

            <br/>

            <label>Last name*</label>
            <input type="text" name="lname"  class="form-control" id="lname" placeholder="Enter your lastname" required/>

            <br/>

            <label>Email*</label>
            <input type="email" name="email"  class="form-control" id="email" placeholder="Enter your email" required/>

            <br/>

            <label>Password*</label>
            <input type="password" name="password"  class="form-control" id="password" placeholder="Enter your password" required/>

            <br/>

            <p>* = required</p>

            <br/>

            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
</div>


<script src="js/register.js"></script>