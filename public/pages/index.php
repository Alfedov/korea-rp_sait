<!DOCTYPE html>
<html lang="ru-RU">
<head>
	<meta charset="UTF-8">
    <title><?php echo $title; ?></title>
	<meta charset="Grand RP">
    <?php if(!empty($description)): ?><meta name="description" content="<?php echo $description; ?>" /> <?php endif; ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="assets\img\favicon.png">
	<link rel="apple-touch-icon" href="assets\img\favicon_apple.png">
    <?php
    if(!empty($styles)) {
        foreach ($styles as $style) {
            echo '<link rel="stylesheet" type="text/css" href="'.$style.'" />
            ';
        }
    }
    ?>
    <?php
    if(!empty($scripts)) {
        foreach($scripts as $script) {
            echo "<script type='text/javascript' src='" . $script . "'></script>
            ";
        }
    }
    ?>
	<script>
		wow = new WOW({
			boxClass: 'wow', // default
			animateClass: 'animated', // default
			offset: 0, // default
			mobile: true, // default
			live: true // default
		})
		wow.init();
	</script>
	</head><body class='<?php echo $bodyclass; ?>'>
    <?php if(!empty($_SESSION['success'])): ?>
    <div class="absoluter">
        <div class="alert nice">
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-xs-3"> <i class="fa fa-window-close-o" aria-hidden="true"></i> </div>
                    <div class="col-xs-9">
                        <p><?php echo $_SESSION['success']['title']; ?></p>
                        <p><small><?php echo $_SESSION['success']['message']; ?></small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>
    <?php if(!empty($_SESSION['error'])): ?>
    <div class="absoluterone">
        <div class="alert bad">
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-xs-3"> <i class="fa fa-window-close-o" aria-hidden="true"></i> </div>
                    <div class="col-xs-9">
                        <p><?php echo $_SESSION['error']['title']; ?></p>
                        <p><small><?php echo $_SESSION['error']['message']; ?></small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <? endif; ?>
    <div id='header'>
        <div class='container'>

            <div class='row'>
                <div class='topline'>
                    <div class='col-xs-12'>
                        <div class='col-md-2'>
                            <a href='/'><img class='logo wow fadeIn' src='https://forum.korea-rp.ru/data/assets/logo/footer-brand-logo.png'></a>
                        </div>
                        <div class='col-md-7'>
                            <ul class='mainMenu wow fadeInLeft wait-1'>
                                <li><a href='/donate'><img src='/assets/img/donate.png'> Донат<?php echo $tableconf['X2_DONATE'] ? '<span class="x2 yellowShadowText">x2</span>' : ''?></a></li>
                                <li>
                                    <a href='http://forum.grand-rp.su/'><img src='/assets/img/forum.png'> Форум</a>
                                </li>
                            </ul>
                        </div>
                        <div class='col-md-3'>
                            <?php
                            if($ucp && $user->isAuthorized()):?>
                            <div class="userBar wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">
                                <div class="level"><?php echo $user->player[$tableconf['TABLE_LEVEL']]; ?></div>
                                <div class="avatar minimize"> <img src="/assets/img/ava.png"> </div>
                                <p><?php echo $user->player[$tableconf['TABLE_NAME']]; ?><span class="exit"></span></p>
                                <div class="money"><i class="fa fa-money yellowShadowText" aria-hidden="true"></i> <?php echo $user->player[$tableconf['TABLE_DONATE']]; ?> <sup>руб.</sup></div>
                            </div>
                            <?php else: ?>
                            <a href='/account/' class='login yellowShadow right animated wow fadeInRight wait-2'>Личный кабинет</a></div>
                            <?php endif;?>
                    </div>
                </div>
            </div>

	<?php require_once $page; ?>
    <!-- ВК
    <script type="text/javascript" src="//vk.com/js/api/openapi.js?142"></script>
    <div id="vk_community_messages"></div>
    <script type="text/javascript">
    VK.Widgets.CommunityMessages("vk_community_messages", 111339891, {tooltipButtonText: "Есть вопрос ?"});
    </script>-->
    <div id='footer'>
        <div class='container'>
            <div class='row'>
                <div class='col-xs-12 wow fadeIn wait-1'>
                    <div class='col-md-6'>
                        <p><span>Социальные ссылки</span></p>
                        <p><a href='https://vk.com/officialkorearp'><i class="fa fa-vk" aria-hidden="true"></i> Сообщество Вконтакте</a></p>
                    </div>
                    <div class='col-md-6 textright'>
                        <p><span>Техническая поддержка</span></p>
                        <p><a href='https://vk.com/alfedovdev'><i class="fa fa-users" aria-hidden="true"></i> Разработчик сайта</a></p>
                    </div>
                </div>
            </div>
            <p>
            <center><small>Korea Roleplay © 2022</small></center>
            </p>
        </div>
    </div>
	<a href="#" class="go-top"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></a>

    <?php
    if(!empty($footscripts)) {
        foreach($footscripts as $script) {
            echo "<script type='text/javascript' src='" . $script . "'></script>
    ";
        }
    }
    ?>

	<script>
		$(document).ready(function () {
			$('#online').viewportChecker({
				callbackFunction: function () {
					$('.spincrement').spincrement({
						duration: 4000,
						thousandSeparator:' ',
					});
				}
			});
		});
	</script>
	<script>
	function initparticles() {
   bubbles();
}
function bubbles() {
   $.each($(".particletext.bubbles"), function(){
      var bubblecount = ($(this).width()/50)*10;
      for(var i = 0; i <= bubblecount; i++) {
         var size = ($.rnd(40,80)/10);
         $(this).append('<span class="particle" style="top:' + $.rnd(20,80) + '%; left:' + $.rnd(0,95) + '%;width:' + size + 'px; height:' + size + 'px;animation-delay: ' + ($.rnd(0,30)/10) + 's;"></span>');
      }
   });
}

jQuery.rnd = function(m,n) {
      m = parseInt(m);
      n = parseInt(n);
      return Math.floor( Math.random() * (n - m + 1) ) + m;
}

initparticles();
	</script>
    </div></body>

</html>
<?php unset($_SESSION['success']);?>
<?php unset($_SESSION['error']);?>