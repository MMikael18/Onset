<?php 
require_once APP.'/includes/head.php'; 
require_once  APP.'/includes/header.php'; 
?>
<article>
    <div class="login-box">
        <form action="/Login/<?php echo $view->get('action'); ?>" method="post">
            <h2><?php echo $view->get('title'); ?></h2>
            <div class="form-group">
                <label for="inputEmail" class="sr-only">Email address</label>
                <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
                <small class="form-control-feedback"></small>
            </div>
            <div class="form-group">
                <label for="inputEmailre" class="sr-only">Re-enter Email address</label>
                <input name="emailre" type="email" id="inputEmailre" class="form-control" data-reenter="#inputEmail" placeholder="Re-enter Email address" required="" autofocus="">
                <small class="form-control-feedback"></small>
            </div>
            <hr>
            <div class="form-group">
                <label for="inputPassword" class="sr-only">Password</label>
                <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required="">
                <small class="form-control-feedback"></small>
            </div>
            <div class="form-group">
                <label for="inputPasswordre" class="sr-only">Re-enter Password</label>
                <input name="passwordre" type="password" id="inputPasswordre" class="form-control" data-reenter="#inputPassword" placeholder="Re-enter Password" required="">
                <small class="form-control-feedback"></small>
            </div>
            <hr>            
            <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo $view->get('title'); ?></button>
        </form>
        <script>
        $( document ).ready(function() {
            // Pre validation for better user experiense
            $('[type="email"]').bind('blur',function(){
                var value = $(this).val();
                if(isEmail(value)){
                    addMessageSuccess.call(this,"");
                }else{
                    addMessageDanger.call(this,"Not an email.");
                }
            });

            $('[type="password"]').bind('blur',function(){
                var pass = $(this).val();
                if(pass.length < 8){
                    addMessageDanger.call(this,"Password is to short. It has to be a leas 8 character long.");
                    return;
                }
                var score = scorePassword(pass);
                if (score > 100){
                    addMessageSuccess.call(this,"Password is strong");
                }else if (score > 60){
                    addMessageWarning.call(this,"Password is good but...");
                }else{
                    addMessageDanger.call(this,"Password is weak");
                }
            });

            $('[data-reenter]').bind('blur',function(){
                var value1 = $(this);
                var value2 =  $(this).attr("data-reenter");
                var message = $(this).attr("placeholder") + ". The requested value is wrong.";
                if(isSame(value1,value2)){
                    addMessageSuccess.call(this,"");
                }else{
                    addMessageDanger.call(this,message);
                }
            });

            $('[type="submit"]').bind('click',function(){
                var form = $(this).parent("form");
                if(form.find(".form-control-danger").length){
                    return false;
                }
                return true;
            });

            function addMessageSuccess(message){
                messageUndo.call(this);                
                $(this).parent(".form-group").addClass("has-success");
                $(this).addClass("form-control-success");
                $(this).next().text(message);  
            }

            function addMessageWarning(message){
                messageUndo.call(this); 
                $(this).parent(".form-group").addClass("has-warning");
                $(this).addClass("form-control-warning");
                $(this).next().text(message);
            }

            function addMessageDanger(message){
                messageUndo.call(this); 
                $(this).parent(".form-group").addClass("has-danger");
                $(this).addClass("form-control-danger");
                $(this).next().text(message);
            }

            function messageUndo(){
                $(this).parent(".form-group").removeClass("has-success").removeClass("has-danger").removeClass("has-warning");
                $(this).removeClass("form-control-success").removeClass("form-control-danger").removeClass("form-control-warning");
            }

            function isEmail(emailAddress){
                var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
                return pattern.test(emailAddress);
            }

            function isSame(id1,id2){
                if($(id1).val().length == 0 || $(id2).val().length == 0){
                    return false;
                }else
                if ($(id1).val() != $(id2).val()) {
                    return false;
                }
                return true;
            }

            function scorePassword(pass) {
                var score = 0;
                if (!pass)
                    return score;
                // award every unique letter until 5 repetitions
                var letters = new Object();
                for (var i=0; i<pass.length; i++) {
                    letters[pass[i]] = (letters[pass[i]] || 0) + 1;
                    score += 5.0 / letters[pass[i]];
                }
                // bonus points for mixing it up
                var variations = {
                    digits: /\d/.test(pass),
                    lower: /[a-z]/.test(pass),
                    upper: /[A-Z]/.test(pass),
                    nonWords: /\W/.test(pass),
                }
                variationCount = 0;
                for (var check in variations) {
                    variationCount += (variations[check] == true) ? 1 : 0;
                }
                score += (variationCount - 1) * 10;
                return parseInt(score);
            }

        });
        </script>
    </div>
</article>
<?php require_once  APP.'/includes/footer.php'; ?>