</div>
<div id="content">
    <div class="container">
        <div class="row">
            <h1 class="title wow fadeIn" style="visibility: visible; animation-name: fadeIn;"><p class="needInfo right">Общее количество сотрудников: <span class="fontnumb"><?php echo count($leader);?></span></p></h1>
            <div class="col-xs-12">
                <div class="darkBlock wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">
                    <ul class="mainList">
                        <li class="th_">
                            <div class="col-xs-6">
                                Сотрудник
                            </div>
                            <div class="col-xs-3">
                                Ранг
                            </div>
                            <div class="col-xs-3">
                                Активность
                            </div>
                        </li>

                        <?php
                        foreach($leader as $key):
                        ?>
                            <li class="tr_">
                                <form method="post">
                                    <input type="hidden" name="uninvite" value="<?php echo $key[$tableconf['TABLE_NAME']];?>">
                                    <button class="delSost"><i class="fa fa-male" aria-hidden="true"></i> <i class="fa fa-window-close" aria-hidden="true"></i></button>
                                </form>
                                <div class="col-xs-6">
                                    <?php echo $key[$tableconf['TABLE_NAME']]; if($key[$tableconf['TABLE_NAME']] == $user->player[$tableconf['TABLE_NAME']]) echo " (Это Вы)";?>
                                </div>
                                <div class="col-xs-3">
                                    <span class="fontnumb"><?php echo $key[$tableconf['TABLE_RANG']];?></span>
                                </div>
                                <div class="col-xs-3">
                                    Был в сети <span class="fontnumb"><?php echo date('Y-n-j H:i:s',$key[$tableconf['TABLE_ONLINE']]);?></span>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
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