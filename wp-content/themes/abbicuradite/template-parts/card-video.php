<?php
$video =  $args['video'];
$view_taxonomy =  $args['view_taxonomy'];
?>

<div class="col-lg-4 mb-3 d-flex align-items-stretch">
    <div class="card">
        <!--add video-->

        <div class="card-body ">
            <?php echo $video['link_video_youtube']?>
            <h4 class="text-uppercase"><?php echo $video['titolo_video_youtube']?></h4>
            <?php if(!empty($video['caption_video_youtube'])):?>
            <div class="pb-3"><?php echo $video['caption_video_youtube']?></div>
            <?php endif;?>
        </div>
        <?php if(!empty($video['area_di_rischio_video_youtube']) && $view_taxonomy):?>
        <div class="card-footer px-0">
            <a class="areaRischio " href="<?php echo site_url('/area-rischio/'. strtolower($video['area_di_rischio_video_youtube']->slug)); ?>"><span class="areaRischio menu-<?php echo strtolower($video['area_di_rischio_video_youtube']->name); ?>"> > <?php if(strtolower($video['area_di_rischio_video_youtube']->name) == 'sbas') echo substr($video['area_di_rischio_video_youtube']->name, 5); else echo substr($video['area_di_rischio_video_youtube']->name, 4); ?></span></a><br>
        </div>
        <?php endif;?>
    </div>
</div>