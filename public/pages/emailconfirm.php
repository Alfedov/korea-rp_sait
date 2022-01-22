</div>
<div id='content'>
    <div class='container'>
        <div class='row'>
            <h1 class='title wow fadeIn'>Новая почта: <?php echo $_SESSION['temp_mail'];?></h1>
            <form method="post">
                <center><button type="sumbit" name="change" class='doButton'><i class="fa fa-arrow-right" aria-hidden="true"></i> Изменить</button></center>
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
<script src="/assets/js/changerServer.js"></script>