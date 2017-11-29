<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_hapity
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$formData = $this->formData;

  $key = (count($formData) && isset($formData[0]->key)) ? $formData[0]->key : "";
 $enable = (count($formData) && isset($formData[0]->published)) ? $formData[0]->published : 0;  

 $show_ED = ($key == "") ? "display:none" : false;

 $yes = ((int)$enable) ?  "checked='checked'" : "";
 $no = (!(int)$enable) ?  "checked='checked'" : "";

?>

<div class="alert hide" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Message</strong><br>
  <span class="msg"></span>
</div>


<form action="index.php?option=com_hapity&task=hapitysave.getform" method="post" id="adminForm" name="adminForm">  
  <fieldset class="uploadform">
  <legend>Key setting</legend>
  <div class="control-group">
  <div class="control-label">
  <label for="install_directory" class="control-label">Hapity Key</label>
  </div>
  <div class="controls">
  <input class="span5 input_box" type="text" id="hapity_key" name="hapity_key" placeholder="Enter Hapity Key here" value="<?php echo $key ?>" >
 
 <?php if(!$key || $key == ""){ ?>
  <button type="button" id="hapity_aturize" data-loading-text="cheking..." class="btn btn-primary " autocomplete="off">Authenticate Key</button>
  <?php }else{  ?>

  <button type="button" id="remove_key" data-loading-text="Removing" class="btn btn-danger" autocomplete="off">Remove Key</button>
  <?php }  ?>
  </div>
  </div>


  <div class="control-group show_ED"  style="<?php echo $show_ED; ?>">
  <div class="control-label">
  <label for="install_directory" class="control-label">Enabled</label>
  </div>
  <div class="controls btn-group ">
  <label for="jform_sendEmail1" class="">
 <input id="jform_sendEmail1"  <?php echo $yes ?>  name="enable_key" value="1" type="radio">
 Yes</label>
 <label for="jform_sendEmail0" class="">
 <input id="jform_sendEmail0" <?php echo $no ?> name="enable_key" value="0" type="radio">
  No</label>
  </div>
  </div>





  <div class="form-actions show_ED" style="<?php echo $show_ED; ?>">

  <input class="btn btn-primary" name="submit" type="submit" value="Save">
  </div>

  </fieldset>
	
</form>




<script type="text/javascript">
	

	jQuery(document).on("keyup","#hapity_key2",function(){
		var val = jQuery(this).val();
		if(val != ""){
          jQuery("#hapity_aturize").show();
		}else{
         jQuery("#hapity_aturize").hide();
		}
	})


		jQuery(document).on("click","#hapity_aturize",function(){
		var val = jQuery("#hapity_key").val();
		if(val != ""){
             var $btn = jQuery(this).button('loading')
            var baseUrl = '<?php echo JUri::base() ?>';
			jQuery.ajax({
                url:baseUrl+"index.php?option=com_hapity&task=hapitysave.validateKey",
                type:"post",
                dataType:"json",
                data:{"hapity_key":val},
                success : function(data){

                	if(typeof data.status != "undefined" && data.status == "ok" && data.msg == 1){
                		$btn.button('reset').removeClass().addClass("btn btn-danger").text("Remove Key").attr("id","remove_key");
                     jQuery(".alert").removeClass().addClass("alert alert-success alert-dismissible").find(".msg").text("Key authorized successfully");
                     jQuery(".show_ED").show();

                	}else{

                		$btn.button('reset');
                     jQuery(".alert").removeClass().addClass("alert alert-danger alert-dismissible").find(".msg").text("Key entered is worng.Please enter correct key and try again");

                	}

                  window.location.reload();


                     
                }
			});
          
		}else{


                     jQuery(".alert").removeClass().addClass("alert alert-danger alert-dismissible").find(".msg").text("Please Enter key!");
         
		}
	})




	jQuery(document).on("keyup","#hapity_key2",function(){
		var val = jQuery(this).val();
		if(val != ""){
          jQuery("#hapity_aturize").show();
		}else{
         jQuery("#hapity_aturize").hide();
		}
	})


		jQuery(document).on("click","#remove_key",function(){
	
		
             var $btn = jQuery(this).button('loading')
            var baseUrl = '<?php echo JUri::base() ?>';
			jQuery.ajax({
                url:baseUrl+"index.php?option=com_hapity&task=hapitysave.removeKey",
                type:"post",
                
                
                success : function(data){

                  jQuery("#hapity_key").val("");
                  jQuery(".show_ED").hide();

                	
                		$btn.button('reset').removeClass().addClass("btn btn-success").text("Authenticate Key").attr("id","hapity_aturize");
                     jQuery(".alert").removeClass().addClass("alert alert-success alert-dismissible").find(".msg").text("Key Removed successfully");



                     
                }
			});
          
		
	})




</script>
