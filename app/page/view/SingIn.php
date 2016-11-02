<?php 
    require_once __DIR__.'/includes/head.php';
?>
<header>        
</header>
<article>
    <div class="login-box">
        <form action="/Login/<?php echo $view->get('action'); ?>"  method="post">
            <h2><?php echo $view->get('title'); ?></h2>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
            <label for="inputPassword" class="sr-only">Password</label>
            <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required="">
            <hr>
            <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo $view->get('title'); ?></button>
        </form>
        Create a Onset account. <a href="/Login/startSingUp">Sing up now!</a>
    </div>
</article>
<footer>
</footer>
<?php 
    require_once __DIR__.'/includes/footer.php';
?>