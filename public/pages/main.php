<?php $number = rand(1,3)?>
<div class='say say-1 wow fadeIn wait-3' style='<?php echo ($number == 1) ? "display:block;" : ""?>'> <img src='assets\img\top1.png'>
    <p><span>Выбери</span>
        <br>любую сферу
        <br><small>заработка!</small></p>
</div>
<div class='say say-1 say-2 wow fadeIn wait-3' style='<?php echo ($number == 2) ? "display:block;" : ""?>'> <img src='assets\img\top2.png'>
    <p><span>Управляй</span>
        <br>будущим
        <br><small>своей роли!</small></p>
</div>
<div class='say say-1 say-3 wow fadeIn wait-3' style='<?php echo ($number == 3) ? "display:block;" : ""?>'> <img src='assets\img\top3.png'>
    <p><span>Индивидуальное</span>
        <br>будущее
        <br><small>каждого игрока!</small></p>
</div>
</div>
<div id='online'>
    <div class='container'>
        <div class='row'>
            <p class='onlineTitle wow flipInX'>Сейчас нас
                <br><span class='fontnumb fsize40 spincrement'><?php echo $func->online; ?></span></p>
            <div class='col-xs-12'>
                <?php if($need): ?>
                    <div class="grid-4 info">
                        <?php
                        foreach($func->servers as $key=>$value) {
                            include PUBLIC_DIR . "/servers.php";
                        }
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
