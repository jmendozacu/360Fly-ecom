<?php include("template/header.php"); ?>


<div class="body-wrapper">
    <?php include("modules/banner.php"); ?>

    <div class="z-product-camera">
        <div class="container wrapper-width">
            <form>
                <div class="product-essential">
                    <div class="col-xs-12 col-sm-8 col-md-8">
                        <h1 class="z-product-name mobile">360fly 4K <br />VIDEO CAMERA</h1>

                        <?php include_once("modules/product-images.php"); ?>
                    </div>

                    <div class="col-xs-12 col-sm-4 col-md-4 product-main">
                        <?php include_once("modules/product-info.php"); ?>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- Product Camera -->

    <?php
        include("modules/videos.php");
        include("modules/last-action.php");
        include("modules/press.php");
        include("modules/tabs.php");
        include("modules/tabs/testimonials.php");
        include("modules/tabs/tech-specs.php");
        include("modules/tabs/apps.php");
        include("modules/box.php");
        include("modules/promo.php");
        include("modules/accessories.php");
    ?>

</div>




<script type="text/javascript" src="assets/js/vm-events.js"></script>
<?php include("template/footer.php"); ?>
