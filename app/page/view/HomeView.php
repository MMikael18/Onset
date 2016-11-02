<?php require_once __DIR__.'/includes/head.php'; ?>
<header>
    <div class="row">
        <div class="col-sm-6 offset-md-3">
            <a href="/login/LoginOut">Log out</a>
            <?php App::UserControll("header/action/id"); ?>
        </div>
    </div>        
</header>
<article>
    <div class="container-fluid">
    
    <div class="row">
        <div class="col-sm-12">
            LIST
        </div>
    </div>
    
</article>
<footer>
    <?php App::UserControll("jaska"); ?>
</footer>
<?php require_once __DIR__.'/includes/footer.php'; ?>