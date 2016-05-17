<?php 
    defined('C5_EXECUTE') or die(_("Access Denied.")); 
	$ih = Loader::helper("image");
	$nav = Loader::helper("navigation");
    if(count($items)<1){ ?>
        <div class="well"><?=t('You have not entered any slides')?></div>
    <?php } else { ?>
        
    <script type="text/javascript">
    $(function(){
        function sliderBackground<?=$bID?>(){
            //if window is greater than the first breakpoint
            if($("body").width() > <?=$breakpoint2?>){
                //if it's bigger than the first, it might be bigger than the second.
                if($("body").width() > <?=$breakpoint3?>){
                    $(".swiper-slide").each(function(){
                        var bg = $(this).attr("data-large-background");
                        $(this).css("background-image", "url('"+bg+"')");
                    });
                } else {
                    $(".swiper-slide").each(function(){
                        var bg = $(this).attr("data-medium-background");
                        $(this).css("background-image", "url('"+bg+"')");
                    });
                }
            } else{
                $(".swiper-slide").each(function(){
                    var bg = $(this).attr("data-small-background");
                    $(this).css("background-image", "url('"+bg+"')");
                });
            }
        }
        var swiper<?=$bID?> = $('.swiper-container').swiper({
            autoplay: <?=$duration?>000,
            speed: <?=$speed?>,
            mode:'horizontal',
            loop: true,
            <?php if($pagination=="yes"){?>
            pagination: '#swiper-pagination-<?=$bID?>',
            paginationClickable: true,
            <?php } ?>
            onFirstInit: function(swiper){
                sliderBackground<?=$bID?>();   
            }
        });       
        window.onresize = function(event) {    
            sliderBackground<?=$bID?>();        
        };
        $("#btn-slide-next-<?=$bID?>").click(function(){
            swiper<?=$bID?>.swipeNext();    
        });
        $("#btn-slide-prev-<?=$bID?>").click(function(){
            swiper<?=$bID?>.swipePrev();    
        });
    });
    </script>
    <style>
        #vivid-simple-slider-<?=$bID?>, #vivid-simple-slider-<?=$bID?> .swiper-slide { position: relative; width: 100%; height: <?=$breakpoint1height?>px; }
        #vivid-simple-slider-<?=$bID?> .swiper-wrapper {  }
            #vivid-simple-slider-<?=$bID?> .swiper-slide { position: relative; text-align: center; background-position: center top; }   
        @media only screen and (min-width:<?=$breakpoint2?>px){
            #vivid-simple-slider-<?=$bID?>, #vivid-simple-slider-<?=$bID?> .swiper-slider  { height: <?=$breakpoint2height?>px; }
        }
        @media only screen and (min-width:<?=$breakpoint3?>px){
            #vivid-simple-slider-<?=$bID?>, #vivid-simple-slider-<?=$bID?> .swiper-slider  { height: <?=$breakpoint3height?>px; }
        }
            .vivid-simple-slider .text-container { padding: 20px; }
                .vivid-simple-slider .slide-title { color: #fff; text-shadow: 0 0 10px rgba(0,0,0,0.4); font-size: 34px; }
                .vivid-simple-slider .slide-desc { color: #fff;  text-shadow: 0 0 10px rgba(0,0,0,0.4); font-size: 18px; }
                .vivid-simple-slider .slide-btn { margin-top: 20px; }
            @media only screen and (min-width:<?=$breakpoint2?>px){
            .vivid-simple-slider .text-container { padding: 50px 20px; }
                .vivid-simple-slider .slide-title { font-size: 50px; }
                .vivid-simple-slider .slide-desc { font-size: 24px; }    
            }
            @media only screen and (min-width:<?=$breakpoint3?>px){
            .vivid-simple-slider .text-container { padding: 100px 15% 0; }
                .vivid-simple-slider .slide-title { font-size: 50px; }
                .vivid-simple-slider .slide-desc { font-size: 24px; } 
                .vivid-simple-slider .slide-btn { margin-top: 50px; }   
            }
    
        .btn-slide-prev, .btn-slide-next { display: none; position: absolute; top: 35%; cursor: pointer; opacity: .6; }
        .btn-slide-prev:hover, .btn-slide-next:hover { opacity: 1; }       
        .btn-slide-prev { font-size: 80px; left: 20px; }
        .btn-slide-next { font-size: 80px; right: 20px; }
        .swiper-pagination { position: absolute; bottom: 20px; right: 20px; }
            .swiper-pagination-switch { display: inline-block; width: 15px; height: 15px; background: rgba(255,255,255,0.6); border-radius: 50%; margin-left: 8px; cursor: pointer; }
            .swiper-pagination-switch.swiper-active-switch { background: #fff; }
        @media only screen and (min-width:<?=$breakpoint2?>px){
           .btn-slide-prev, .btn-slide-next { display: block; }    
        }
    </style>
    <div class="swiper-container vivid-simple-slider" id="vivid-simple-slider-<?=$bID?>">
        
        <div class="swiper-wrapper">
            <?php
        	foreach($items as $item){ 
        		if($item['pageID']){
        			//if set, grab the page object.
        			$page = Page::getByID($item['pageID']);
                    if(is_object($page)){
            			$pageName = $page->getCollectionName();
            			$theLink = $nav->getLinkToCollection($page);
                    }
        		}
        		if($item['fID']){
        			//if set, grab the file object
        			$fileObj = File::getByID($item['fID']);
                    if(is_object($fileObj) && $fileObj->getApprovedVersion()){
            			//set thumbs
            			$crop = true;
            			$small = $ih->getThumbnail($fileObj,$breakpoint1width,$breakpoint1height,$crop);
                        $medium = $ih->getThumbnail($fileObj,$breakpoint2width,$breakpoint2height,$crop);
                        $large = $ih->getThumbnail($fileObj,$breakpoint3width,$breakpoint3height,$crop);
        		 
            ?>
            <div class="swiper-slide" data-small-background="<?=$small->src?>" data-medium-background="<?=$medium->src?>" data-large-background="<?=$large->src?>">
                
                <div class="text-container">
                    
                    <?php if($item['title']){?>
                    <div class="slide-title"><?=$item['title']?></div>
                    <?php } ?>
                    <?php if($item['slidedesc']){?>
                    <div class="slide-desc"><?=$item['slidedesc']?></div>
                    <?php } ?>
                    <?php if($item['btnText']){?>
                    <a class="btn btn-default slide-btn" href="<?=$theLink?>"><?=$item['btnText']?></a>
                    <?php } ?>
                    
                </div>
                
            </div><!-- .swiper-slide -->
            <?php   }//if is object
                }//if fID
            }//each 
            ?>
        </div><!-- .swiper-wrapper -->  
        
        <?php if($arrows=="yes"){?>
        <div class="btn-slide-prev" id="btn-slide-prev-<?=$bID?>"><img src="<?=$blockURL?>/img/arrow-left.png"></div>
        <div class="btn-slide-next" id="btn-slide-next-<?=$bID?>"><img src="<?=$blockURL?>/img/arrow-right.png"></div>
        <?php } ?>
        
        <?php if($pagination=="yes"){?>
        <div class="swiper-pagination" id="swiper-pagination-<?=$bID?>"></div>
        <?php } ?>
    
    </div><!-- .swiper-container -->
    
<?php }//else - show slides ?>