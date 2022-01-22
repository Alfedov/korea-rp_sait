<!--LOLKEK-->
<div class="col-md-6 textright">
    <div class="serverblock wow flipInX wait-1" style="visibility: visible; animation-name: flipInX;"> <i class="<?php echo strtolower($key); ?> left"></i>
        <p class="name"><?php echo $key; ?> <small><?php echo $func->servers[$key]["ONLINE"]?> / <?php echo $func->servers[$key]["MAXPLAYERS"]?></small></p>
        <div class="ip"><?php echo $func->servers[$key]["IP"]?>:<?php echo $func->servers[$key]["PORT"]?></div>
        <p class="onof green">Online</p>
    </div>
</div>