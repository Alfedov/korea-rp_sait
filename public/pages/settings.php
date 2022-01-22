</div>
<div id='content'>
    <div class='container'>
        <div class='row'>
            <h1 class='title wow fadeIn'>Настройки безопасности</h1>
            <h3 class='blockTitle wow fadeIn'>Информация</h3>
            <div class='darkBlock wow fadeInRight'>
                <div class='row'>
                    <div class='col-xs-12'>
                        <div class='col-xs-4'>
                            <p><small>Google Authenticator</small></p>
                            <p><span class='fontnumb'><span class='spincrement'><?php echo empty($user->player[$tableconf['TABLE_GASECRET']]) ? "Отсутствует" : "Установлен"; ?></span></span></p>
                        </div>
                        <div class='col-xs-4'>
                            <p><small>Привязка по IP</small></p>
                            <p><span class='fontnumb'><span class='spincrement'>Отсутствует</span></span></p>
                        </div>
                        <div class='col-xs-4'>
                            <p><small>Последний вход</small></p>
                            <?php

                            $last = $user->conn->query("SELECT * FROM `log_auth` WHERE `name` = '".$user->player[$tableconf['TABLE_NAME']]."' ORDER BY `date` DESC LIMIT 1")->fetch_assoc();

                            ?>
                            <p><span class='fontnumb'><span class='spincrement'><?php echo date('Y-n-j H:i:s',$last['date']);?></span></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <h3 class='blockTitle wow fadeIn'>Смена пароля</h3>
            <div class='col-md-12'>

                <div class='darkBlock wow fadeInRight'>
                    <div class='row'>
                        - Новый пароль должен иметь не менее 4 и не более 16 символов!<br>
                        <form method="post">
                            <div class='col-md-6'>

                                <label for='inp-nickname'  class='labler yellowShadowText'>Старый пароль</label>
                                <input id='inp-nickname'  class='allInp' name='lastpass' type='password' required><i class="fa fa-exchange" aria-hidden="true"></i>
                            </div>
                            <div class='col-md-6'>
                                <label for='inp-nickname'  class='labler yellowShadowText'>Новый пароль</label>
                                <input id='inp-nickname'  class='allInp' name='newpass' type='password' required><i class="fa fa-key" aria-hidden="true"></i>
                            </div>
                            <center><button type="sumbit" name="setpass" class='doButton'><i class="fa fa-check" aria-hidden="true"></i> Изменить</button></center>
                    </div>
                    </forM>

                </div>
            </div><br>
            <h3 class='blockTitle wow fadeIn'>Смена Email</h3>
            <div class='col-md-12'>
                <div class='darkBlock wow fadeInRight'>
                    <div class='row'>
                        - При изменении Email, вам будет отправлено письмо на старый ящик, что бы продолжить смену!<br>
                        <form method="post">
                            <div class='col-md-6'>

                                <label for='inp-nickname'  class='labler yellowShadowText'>Старый Email</label>
                                <input id='inp-nickname'  class='allInp' name='lastemail' type='email' required><i class="fa fa-envelope-open-o" aria-hidden="true"></i>
                            </div>
                            <div class='col-md-6'>
                                <label for='inp-nickname'  class='labler yellowShadowText'>Новый Email</label>
                                <input id='inp-nickname'  class='allInp' name='newemail' type='email' required><i class="fa fa-envelope-open" aria-hidden="true"></i>
                            </div>
                            <center><button type="sumbit" name="setemail" class='doButton'><i class="fa fa-check" aria-hidden="true"></i> Изменить</button></center>
                    </div>
                    </forM>

                </div>
            </div>
        </div>
        <h1 class='title wow fadeIn'><p class='needInfo right'>Последние 20 авторизаций в Личный Кабинет</h1>
        <div class='col-xs-12'>
            <div class='darkBlock wow fadeInRight'>
                <ul class='mainList'>
                    <li class='th_'>
                        <div class='col-xs-6'>
                            Дата
                        </div>
                        <div class='col-xs-3'>
                            IP
                        </div>
                        <div class='col-xs-3'>
                            Браузер
                        </div>
                    </li>

                    <?php

                    $log = $user->getUserLog();

                    foreach($log as $key):?>

                        <li class='tr_'>
                            <div class='col-xs-6'>
                                <?php echo $func->getTime($key['date']);?>
                            </div>
                            <div class='col-xs-3'>
                                <span class='fontnumb'><?php echo $key['ip'];?></span>
                            </div>
                            <div class='col-xs-3'>
                                <?php echo $key['browser'];?>
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