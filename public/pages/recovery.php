</div>
<div id='content'>
    <div class='container'>
        <div class='row'>
            <h1 class='title wow fadeIn'>Проблемы со входом?</h1>
            <form method="post">
                <input type='hidden' name='token' value='35873'/>
                <div class='col-xs-12'>
                    <div class='col-xs-4 col-xs-offset-4'>
                        <label for='inp-nickname'  class='labler yellowShadowText'>Ваш ник</label>
                        <input id='inp-nickname'  class='allInp' name='login' type='text' required><i class="fa fa-id-card-o" aria-hidden="true"></i>
                        <label for='inp-password' class='labler yellowShadowText'>Ваш E-mail</label>
                        <input id='inp-mail' class='allInp' name='mail' type='text' required><i class="fa fa-envelope-open" aria-hidden="true"></i>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-xs-10 col-xs-offset-1 textcenter padd30'>
                        <div class='col-xs-4 changer'>
                            <label for='inp-code' class='labler yellowShadowText'>Выбор сервера</label>
                        </div>
                        <?php
                        foreach ($func->servers as $key=>$value){
                            echo "<div class='col-xs-4 changer'><label for='rad-".strtolower($key)."'><i class='".strtolower($key)." left'></i>
                                        </i>
                                        <p class='name'>".$key."</p></label>
                                    <input id='rad-".strtolower($key)."' name='server' type='radio' value='".$key."'>
                                </div>";
                        }
                        ?>
                    </div>
                </div>
                <center><button name="recovery" type="sumbit" class='doButton'><i class="fa fa-arrow-right" aria-hidden="true"></i> Выслать инструкцию на E-Mail</button></center>
        </div>
        </form>
    </div>
</div>
<script>
    $('.absoluter').addClass('dispblck');
    $('.absoluter .nice').addClass('animated fadeInUp');
    setTimeout(function() {
        $('.absoluter .nice').removeClass('fadeInUp');
        $('.absoluter .nice').addClass('fadeOutUp');
        setTimeout(function() {
            $('.absoluter').removeClass('dispblck');
            $('.absoluter .nice').removeClass('animated fadeOutUp');
        }, 1000);
    }, 3000);

    $('.absoluterone').addClass('dispblck');
    $('.absoluterone .bad').addClass('animated fadeInUp');
    setTimeout(function() {
        $('.absoluterone .bad').removeClass('fadeInUp');
        $('.absoluterone .bad').addClass('fadeOutUp');
        setTimeout(function() {
            $('.absoluterone').removeClass('dispblck');
            $('.absoluterone .bad').removeClass('animated fadeOutUp');
        }, 1000);
    }, 3000);
</script>