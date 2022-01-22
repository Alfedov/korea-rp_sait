</div>
<div id='content'>
    <div class='container donatesHeight'>
        <div class='row'>
            <i class='smileGirl'></i>
        </div></div>
    <div class='container'>
        <div class='row'>
            <h1 class='title wow fadeIn'>Донат</h1>
            <div class='col-xs-12'>
                <div class='col-xs-3'>
                    <ul class="donateList">
                        <li><a href="http://forum.grand-rp.su/threads/gde-uznat-nomer-akkaunta.147/"><i class="fa fa-circle" aria-hidden="true"></i> Где узнать номер аккаунта</a></li>
                        <li><a href="http://forum.grand-rp.su/threads/akcii.148/"><i class="fa fa-circle" aria-hidden="true"></i> Акции</a></li>
                        <li><a href="http://forum.grand-rp.su/threads/chto-mozhno-priobresti.170/"><i class="fa fa-circle" aria-hidden="true"></i> Что можно приобрести</a></li>
                    </ul>
                </div>
            </div>
            <!--
            <div class='col-xs-9'>
                <div class='darkBlock'>
                    <h3 class='blockTitle wow fadeIn'>При пополнении ( Система отключена на время X2 )</h3>
                    <div class='row'>
                    <div class='col-xs-6'>
                        <p>на сумму <span class='fontnumb'>100 <sup>руб.</sup></span>, получаете <span class='fontnumb'>150 <sup>руб.</sup></span></p>
                        <p>на сумму <span class='fontnumb'>200 <sup>руб.</sup></span>, получаете <span class='fontnumb'>350 <sup>руб.</sup></span></p>
                    </div>
                    <div class='col-xs-6'>
                        <p>на сумму <span class='fontnumb'>400 <sup>руб.</sup></span>, получаете <span class='fontnumb'>550 <sup>руб.</sup></span></p>
                        <p>на сумму <span class='fontnumb'>600 <sup>руб.</sup></span>, получаете <span class='fontnumb'>950 <sup>руб.</sup></span></p>
                    </div>
                    </div>
                </div>
            </div>
                -->
        </div>
        <div class='row'>
            <form method="post">
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
        <div class='row'>
            <div class='col-xs-12'>
                <div class='col-xs-4 col-xs-offset-4'>
                    <label for='inp-akknumber' class='labler yellowShadowText'>Введите номер аккаунта</label>
                    <input id='inp-nickname' name="donat_id" class='allInp' type='text' required=""><i class="fa fa-user-circle" aria-hidden="true"></i>
                    <label for='inp-sum' class='labler yellowShadowText'>Сумма</label>
                    <input id='inp-password' name="donat_value" class='allInp' type='text' required=""><i class="fa fa-money" aria-hidden="true"></i> </div>
            </div>
        </div>
    </div>

    <div class='container'>
        <div class='row'><button name="donate" class='doButton'><i class="fa fa-arrow-right" aria-hidden="true"></i> <br>далее</button></div>
        </form>

    </div>
</div>
<script>
    $('input, .doButton').hover(function(){
        $('.smileGirl').toggleClass('hover');
    })
</script>
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