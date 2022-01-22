</div>
<div id="content">
    <div class="container">
        <div class="row">
            <h1 class="title wow fadeIn" style="visibility: visible; animation-name: fadeIn;">Дом <?php echo $func->getHouseClass($house[$tableconf['TABLE_HOUSE_CLASS']], true); ?> класса, номер <?php echo $house[$tableconf['TABLE_HOUSE_ID']]; ?></h1>
            <center><img src="/assets/img/home.png"></center><br><br>
            <div class="darkBlock wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="col-xs-4">
                            <p><small>Государственная цена</small></p>
                            <p><span class="fontnumb"><span class="spincrement"><?php echo $house[$tableconf['TABLE_HOUSE_COST']]; ?><i class="dollar">$</i></span></span></p>
                        </div>
                        <div class="col-xs-4">
                            <p><small>Оплаченные дни</small></p>
                            <p><?php echo $house[$tableconf['TABLE_HOUSE_DAYS']];?></p>
                        </div>
                        <div class="col-xs-4">
                            <p><small>Дверной замок</small></p>
                            <p><i class="fa fa-<?php echo ($house[$tableconf['TABLE_HOUSE_LOCK']] == 1) ? "lock" : "unlock" ;?>"></i></p>
                        </div>
                        <center><h3 class="blockTitle wow fadeIn" style="visibility: visible; animation-name: fadeIn;">Предметы в сейфе</h3></center>
                        <div class="col-xs-4">
                            <p><small>Деньги</small></p>
                            <p><span class="fontnumb"><?php echo $house[$tableconf['TABLE_HOUSE_CASH']]; ?>$</span></p>
                        </div>
                        <div class="col-xs-4">
                            <p><small>Наркотики</small></p>
                            <p><span class="fontnumb"><?php echo $house[$tableconf['TABLE_HOUSE_DRUGS']];?> г.</span></p>
                        </div>
                        <div class="col-xs-4">
                            <p><small>Продукты</small></p>
                            <p><span class="fontnumb">0</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="darkBlock wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">
                    <div class="row">
                        <div class="col-md-9">Условия оплаты дома:<br>
                            - Дом не выставлен на продажу в государство.
                            <br>- При оффлайн оплате дома, цена увеличивается на X2.
                            <br>- Оффлайн оплата доступна на 10 дней, при условии, что остаток 10 дней либо меньше.
                        </div>
                        <div class="col-md-3">
                            - Эконом класс: 3.000$
                            <br>- Средний класс: 6.000$
                            <br>- Высший класс: 10.000$
                            <br>- Элитный класс: 20.000$
                        </div>
                    </div>
                </div></div>
            <form method="post"><input type="hidden" name="token" value="12687"><center><button type="sumbit" name="house" class="doButton"><i class="fa fa-money" aria-hidden="true"></i> Оплатить оффлайн</button></center></form>
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