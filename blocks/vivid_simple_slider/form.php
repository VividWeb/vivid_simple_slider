<?php
defined('C5_EXECUTE') or die("Access Denied.");
// LOAD FOR PAGE SELECTOR
$pageSelector = Loader::helper('form/page_selector');

// LOAD FOR FILE SELECTOR
$fp = FilePermissions::getGlobal();
$tp = new TaskPermission(); ?>
<style type="text/css">
.select-image { display: block; padding: 15px; cursor: pointer; background: #dedede; border: 1px solid #cdcdcd; color: #333; vertical-align: center; }
.select-image i { margin-right: 15px; }
.select-image img { max-width: 100%; }
</style>

<style type="text/css">
	.panel-heading { cursor: move; }
    .panel-body { display: none; }
</style>

<p>
<?php print Loader::helper('concrete/ui')->tabs(array(
    array('pane-items', t('Slides'), true),
    array('pane-settings', t('Slider Settings')),
    array('pane-responsive', t('Sizing'))
));?>
</p>

<div class="ccm-tab-content" id="ccm-tab-content-pane-items">
    
    <div class="items-container">
        
        <!-- DYNAMIC ITEMS WILL GET LOADED INTO HERE -->
        
    </div>  
    
    <span class="btn btn-success btn-add-item"><?php echo t('Add Item') ?></span> 

</div>

<div class="ccm-tab-content" id="ccm-tab-content-pane-settings">

    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">                    
                <?php echo $form->label('arrows', t('Arrows?')); ?> 
                <?php echo $form->select('arrows', array('no'=>t('No'),'yes'=>t('Yes')), $arrows); ?>             
            </div>   
        </div>
        <div class="col-xs-6">
            <div class="form-group">                    
                <?php echo $form->label('pagination', t('Pagination?')); ?> 
                <?php echo $form->select('pagination', array('no'=>t('No'),'yes'=>t('Yes')), $pagination); ?>             
            </div> 
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">                    
                <?php echo $form->label('speed', t('Speed:')); ?> 
                <div class="input-group">
                    <?php echo $form->text('speed',$speed?$speed:'250'); ?> 
                    <div class="input-group-addon">ms</div> 
                </div>           
            </div>    
        </div>
        <div class="col-xs-6">
            <div class="form-group">                    
                <?php echo $form->label('duration', t('Duration:')); ?> 
                <div class="input-group">
                    <?php echo $form->text('duration',$duration?$duration:'5'); ?> 
                    <div class="input-group-addon">s</div> 
                </div>           
            </div> 
        </div>
    </div>           
        
</div>

<div class="ccm-tab-content" id="ccm-tab-content-pane-responsive">    
    <fieldset>
        <legend><?=t('Image Sizes')?></legend>
        <div class="row">
            <div class="col-xs-6">
                <div class="form-group">                    
                    <?php echo $form->label('breakpoint1width', t('Image Width:')); ?> 
                    <div class="input-group">
                        <?php echo $form->text('breakpoint1width',$breakpoint1width?$breakpoint1width:'768');?>
                        <div class="input-group-addon">px</div>
                    </div>           
                </div>
            </div>
            <div class="col-xs-6">
                <div class="form-group">                    
                    <?php echo $form->label('breakpoint1height', t('Image Height:')); ?> 
                    <div class="input-group">
                        <?php echo $form->text('breakpoint1height',$breakpoint1height?$breakpoint1height:'400');?>
                        <div class="input-group-addon">px</div>
                    </div>           
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <div class="form-group">                    
                    <?php echo $form->label('breakpoint2', t('Min-Width')); ?> 
                    <div class="input-group">
                        <?php echo $form->text('breakpoint2',$breakpoint2?$breakpoint2:'768');?>
                        <div class="input-group-addon">px</div>
                    </div>           
                </div>   
            </div>
            <div class="col-xs-4">
                <div class="form-group">                    
                    <?php echo $form->label('breakpoint2width', t('Image Width:')); ?> 
                    <div class="input-group">
                        <?php echo $form->text('breakpoint2width',$breakpoint2width?$breakpoint2width:'1024');?>
                        <div class="input-group-addon">px</div>
                    </div>           
                </div>
            </div>
            <div class="col-xs-4">
                <div class="form-group">                    
                    <?php echo $form->label('breakpoint2height', t('Image Height:')); ?> 
                    <div class="input-group">
                        <?php echo $form->text('breakpoint2height',$breakpoint2height?$breakpoint2height:'400');?>
                        <div class="input-group-addon">px</div>
                    </div>           
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <div class="form-group">                    
                    <?php echo $form->label('breakpoint3', t('Min-Width')); ?> 
                    <div class="input-group">
                        <?php echo $form->text('breakpoint3',$breakpoint3?$breakpoint3:'1024');?>
                        <div class="input-group-addon">px</div>
                    </div>           
                </div>   
            </div>
            <div class="col-xs-4">
                <div class="form-group">                    
                    <?php echo $form->label('breakpoint3width', t('Image Width:')); ?> 
                    <div class="input-group">
                        <?php echo $form->text('breakpoint3width',$breakpoint3width?$breakpoint3width:'1400');?>
                        <div class="input-group-addon">px</div>
                    </div>           
                </div>
            </div>
            <div class="col-xs-4">
                <div class="form-group">                    
                    <?php echo $form->label('breakpoint3height', t('Image Height:')); ?> 
                    <div class="input-group">
                        <?php echo $form->text('breakpoint3height',$breakpoint3height?$breakpoint3height:'500');?>
                        <div class="input-group-addon">px</div>
                    </div>           
                </div>
            </div>
        </div>
    </fieldset>
    
</div>


<!-- THE TEMPLATE WE'LL USE FOR EACH ITEM -->
<script type="text/template" id="item-template">
    <div class="item panel panel-default" data-order="<%=sort%>">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-6">
                    <h5><i class="fa fa-arrows drag-handle"></i>
                    <?=t('Slide')?> <%=parseInt(sort)+1%></h5>
                </div>
                <div class="col-xs-6 text-right">
                    <a href="javascript:editItem(<%=sort%>);" class="btn btn-edit-item btn-default"><?=t('Edit')?></a>
                    <a href="javascript:deleteItem(<%=sort%>)" class="btn btn-delete-item btn-danger"><?=t('Delete')?></a>
                </div>
            </div>
        </div>
        <div class="panel-body form-horizontal">
            <!-- IMAGE SELECTOR --->
            <div class="form-group">
                <label class="col-xs-3 control-label"><?php echo t('Select Image') ?></label>
                <div class="col-xs-9">
                    <a href="javascript:chooseImage(<%=sort%>);" class="select-image" id="select-image-<%=sort%>">
                        <% if (thumb.length > 0) { %>
                            <img src="<%= thumb %>" />
                        <% } else { %>
                            <i class="fa fa-picture-o"></i>
                            <?=t('Choose Image')?>
                        <% } %>
                    </a>
                    <input type="hidden" name="<?php echo $view->field('fID')?>[]" class="image-fID" value="<%=fID%>" />
                </div>
            </div>
            <input class="item-sort" type="hidden" name="<?php echo $view->field('sort')?>[]" value="<%=sort%>"/>
            
            <div class="form-group">
                <label class="col-xs-3 control-label" for="title<%=sort%>"><?=t('Title:')?></label>
                <div class="col-xs-9">
                	<input class="form-control" type="text" name="title[]" id="title<%=sort%>" value="<%=title%>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 control-label" for="slidedesc<%=sort%>"><?=t('Caption:')?></label>
                <div class="col-xs-9">
                    <input class="form-control" type="text" name="slidedesc[]" id="slidedesc<%=sort%>" value="<%=slidedesc%>">
                </div>
            </div>            
            
            
            <!-- PAGE SELECTOR --->
            <div class="form-group">
                <label class="col-xs-3 control-label"><?=t('Select a Page')?></label>
                <div class="col-xs-9" id="select-page-<%=sort%>">
					<?php $this->inc('elements/page_selector.php');?>
				</div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 control-label" for="btnText<%=sort%>"><?=t('Button Text:')?></label>
                <div class="col-xs-9">
                    <input class="form-control" type="text" name="btnText[]" id="btnText<%=sort%>" value="<%=btnText%>">
                </div>
            </div>
            
        </div>
    </div><!-- .item -->
</script>


<script type="text/javascript">

//Edit Button
var editItem = function(i){
	$(".item[data-order='"+i+"']").find(".panel-body").toggle();
};
//Delete Button
var deleteItem = function(i) {
    var confirmDelete = confirm('<?php echo t('Are you sure?') ?>');
    if(confirmDelete == true) {
        $(".item[data-order='"+i+"']").remove();
        indexItems();
    }
};
//Choose Image
var chooseImage = function(i){
	var imgShell = $('#select-image-'+i);
    ConcreteFileManager.launchDialog(function (data) {
        ConcreteFileManager.getFileDetails(data.fID, function(r) {
            jQuery.fn.dialog.hideLoader();
            var file = r.files[0];
            imgShell.html(file.resultsThumbnailImg);
            imgShell.next('.image-fID').val(file.fID)
        });
    });
};

//Index our Items
function indexItems(){
    $('.items-container .item').each(function(i) {
        $(this).find('.item-sort').val(i);
        $(this).attr("data-order",i);
    });
};

$(function(){
    
    //DEFINE VARS
    
        
        //Define container and items
        var itemsContainer = $('.items-container');
        var itemTemplate = _.template($('#item-template').html());
    
    //BASIC FUNCTIONS
    
        //Make items sortable. If we re-sort them, re-index them.
        $(".items-container").sortable({
            handle: ".panel-heading",
            update: function(){
                indexItems();
            }
        });
    
    //LOAD UP OUR ITEMS
        
        //for each Item, apply the template.
        <?php 
        if($items) {
            foreach ($items as $item) { 
        ?>
        itemsContainer.append(itemTemplate({
            //define variables to pass to the template.
            title: '<?php echo addslashes($item['title']) ?>',
            slidedesc: '<?php echo addslashes($item['slidedesc']) ?>',
            btnText: '<?php echo addslashes($item['btnText']) ?>',
            
            //IMAGE SELECTOR
            fID: '<?php echo $item['fID'] ?>',
            <?php if($item['fID']) { ?>
            thumb: '<?php echo File::getByID($item['fID'])->getThumbnailURL('file_manager_listing');?>',
            <?php } else { ?>
            thumb: '',
			<?php } ?>
			
			//PAGE SELECTOR
			<?php if($item['pageID']){
				$page = Page::getByID($item['pageID']);
				$pageName = $page->getCollectionName();
			}
			?>
			pageID: '<?=$item['pageID']?>',
			pageName: '<?=$pageName?>',
			
            sort: '<?=$item['sort'] ?>'
        }));
        <?php 
            }
        }
        ?>    
        
        //Init Index
        indexItems();
        
    //CREATE NEW ITEM
        
        $('.btn-add-item').click(function(){
            
            //Use the template to create a new item.
            var temp = $(".items-container .item").length;
            temp = (temp);
            itemsContainer.append(itemTemplate({
                //vars to pass to the template
                title: '',
                slidedesc: '',
                
                btnText: '',
                
                //IMAGE SELECTOR
                fID: '',
                thumb: '',
                
                //PAGE SELECTOR
                pageID: '',
                pageName: '',
                
                sort: temp
            }));
            
            var thisModal = $(this).closest('.ui-dialog-content');
            var newItem = $('.items-container .item').last();
            thisModal.scrollTop(newItem.offset().top);
            
            
            //Init Index
            indexItems();
        });    

});
</script>