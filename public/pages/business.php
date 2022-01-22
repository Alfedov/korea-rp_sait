</div>
<div id="content">
    <div class="container">
        <div class="row">
            <h1 class="title wow fadeIn" style="visibility: visible; animation-name: fadeIn;">Бизнес:  <?php echo $biz[$tableconf['TABLE_BIZ_NAME']]; ?></h1>
            <center><img src="/assets/img/flats.png"></center><br><br>
            <div class="darkBlock wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="col-xs-4">
                            <p><small>Государственная цена</small></p>
                            <p><span class="fontnumb"><span class="spincrement"><?php echo $biz[$tableconf['TABLE_BIZ_COST']];?><i class="dollar">$</i></span></span></p>
                        </div>
                        <div class="col-xs-4">
                            <p><small>Оплаченные дни</small></p>
                            <p><?php echo $biz[$tableconf['TABLE_BIZ_DAYS']];?></p>
                        </div>
                        <div class="col-xs-4">
                            <p><small>Вход в бизнес</small></p>
                            <p><i class="fa fa-<?php echo ($biz[$tableconf['TABLE_BIZ_LOCK']] == 1) ? "lock" : "unlock" ;?>"></i></p>
                        </div>
                        <center><h3 class="blockTitle wow fadeIn" style="visibility: visible; animation-name: fadeIn;">Информация бизнеса</h3></center>
                        <div class="col-xs-3">
                            <p><small>Цена за вход</small></p>
                            <p><span class="fontnumb"><?php echo $biz[$tableconf['TABLE_BIZ_ENTER_COST']];?>$</span></p>
                        </div>
                        <div class="col-xs-3">
                            <p><small>Цена за продукты</small></p>
                            <p><span class="fontnumb"><?php echo $biz[$tableconf['TABLE_BIZ_PRICEPROD']];?>$</span></p>
                        </div>
                        <div class="col-xs-3">
                            <p><small>Банковский счёт бизнеса</small></p>
                            <p><span class="fontnumb"><?php echo $biz[$tableconf['TABLE_BIZ_CASH']];?>$</span></p>
                        </div>
                        <div class="col-xs-3">
                            <p><small>В магазине / На складе</small></p>
                            <p><span class="fontnumb">0/20000 прод.</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="darkBlock wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">
                    <div class="row">
                        <div class="col-md-7">Условия оплаты Бизнеса:<br>
                            - Бизнес не выставлен на продажу в государство.
                            <br>- При оффлайн оплате, цена увеличивается на X2.
                            <br>- Оффлайн оплата доступна на 10 дней, при условии, что остаток 10 дней либо меньше.
                        </div>
                        <div class="col-md-5">Цены оплаты на 10 дней:<br>
                            Бар: 34.000$ - Риелт.: 80.000$ - 24x7: 70.000$<br>
                            ГАЗ: 110.000$ - CL BELL: 44.000$ - Ферма: 240.000$<br>
                            BINKO: 102.000$ - СТО: 300.000$ - АЗС: 140.000$<br>
                            Магазин мебели: 160.000$ - Автосалон: 300.000$
                        </div>
                    </div>
                </div></div>
            <form method="post"><input type="hidden" name="token" value="55121"><center><button type="sumbit" name="biz" class="doButton"><i class="fa fa-money" aria-hidden="true"></i> Оплатить оффлайн</button></center></form>
        </div>
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