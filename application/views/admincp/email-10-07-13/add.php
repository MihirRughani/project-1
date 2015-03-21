<?php $this->load->view('admincp/layout/header'); ?>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
<div class="space10px"></div>

<table width="1020" border="0" cellspacing="0" cellpadding="0" align="center" style="min-height:300px;"> 
  <tr>
  	<td>
    	<div class="dotted_line">
		        <h1><?php echo $this->lang->line('text_email');?> <small><?php echo $this->lang->line('btn_text_add_email');?></small></h1>
		</div>
        <hr>
	
            <?php
                $form_attributes = array('class' => 'formA', 'id' => 'myform');
                echo form_open('', $form_attributes);
            ?>

             <div class="control-group <?php if(form_error('subject')){ echo "error";}?>">
            	<label class="control-label" for="inputError"><?php echo $this->lang->line('text_subject');?></label>
                <div class="controls">
                    <input class="input-xxlarge" type="text" id="subject" name="subject" value="<?php echo set_value('subject'); ?>">
                    <span class="help-inline"><?php echo form_error('subject'); ?></span>
                </div>
            </div>
            <div class="control-group <?php if(form_error('email_template_name')){ echo "error";}?>">
            	<label class="control-label" for="inputError">Select Template</label>
                <div class="controls">
                <select class="input-medium" name="email_template_name" id="email_template_name">
                <option value="">Please Select</option>
                <?php
					$get_template = $this->dbadminheader->get_template();
					
					foreach($get_template as $get_template_row)
					{

						?>
                        <option  value="<?php echo $get_template_row->template_id; ?>"><?php echo $get_template_row->template_title; ?></option>
                        <?php
					}
				?>
                </select>
                <span class="help-inline"><?php echo form_error('email_template_name'); ?></span>
                </div>
            </div>
             
                 <div class="control-group <?php if(form_error('html')){ echo "error";}?>">
                    <label class="control-label" for="inputError"><?php echo $this->lang->line('text_message');?></label>
                    <div class="controls">
                        <textarea style="width:70%; min-height:150px;" name="html" id="html"><?php echo set_value('html'); ?></textarea>
                        <span class="help-inline"><?php echo form_error('html'); ?></span>
                    </div>
                </div>
                <div name='get_temp_ch'  id='get_temp_ch'>
                <div class="space10px"></div>   
                     <div class="row">
                        <div  class="span11">
                      <label class="control-label">Select Chapter</label>
                        <table><tr>
                        <?php
							$chapter = $this->dbadminheader->get_chapters();
                            $i = 0;
                            foreach($chapter as $chapter_row)
                            {
                                if($i%6==0)
                                {
                                    ?>
                                    </tr><tr>
                                    <?php
                                }
                                ?>
                                <td>
                                
                                    <span class="span3">
                                        <label class="checkbox">
                                            <input disabled="disabled" onclick='check_all_ch(this.value)' type="checkbox" id="chapter[]"   name="chapter[]" value="<?php echo $chapter_row->ch_id; ?>" />  <?php echo $chapter_row->ch_name; ?>
                                            <input  id='ch_<?php echo $chapter_row->ch_id; ?>' size="20"  type='hidden' name='ch_<?php echo $chapter_row->ch_id; ?>' value='yes'/>
                                        </label>
                                    </span>
                                </td>
                                <?php
                            	$i++;
                            }
                        ?>
                         </tr></table>
                    </div>
                    </div>
                <div class="space10px"></div>   
                 <div class="row" >
                <div class="span11" id='used_data'>
                <label style="display:none">Select All User To Send Mail&nbsp;<input style="margin-top:0px" type="checkbox" id="check_all_user"  name="check_all_user" value="yes" onclick="check_all(this.value)" /></label>
                
                <table><tr>
                <?php
                    /*$user_details = $this->dbadminheader->user_details();
                    $i = 0;
                    foreach($user_details as $user_details_row)
                    {
                        if($i%6==0)
                        {
                            ?>
                            </tr><tr>
                            <?php
                        }
                        ?>
                        <td>
                            <span class="span3">
                                <label class="checkbox">
                                    <input onclick='check_all_ch_member(this.value)' disabled="disabled"  type="checkbox"  name="user_details[]" value="<?php echo $user_details_row->mm_id; ?>" />  <?php echo $user_details_row->mm_username; ?>
                                </label>
                            </span>
                        </td>
                        <?php
                    $i++;
                    }*/
                ?>
                </tr></table>
                </div>
                </div>
            </div>
           
            
            <div class="control-group <?php if(form_error('queued')){ echo "error";}?>">
            	<label class="control-label" for="inputError"><?php echo $this->lang->line('page_status');?></label>
                <div class="controls">
                    <select name="queued" style="width:150px;">
						<option <?php if(set_value('queued') == 0) { echo 'selected="selected"'; } ?> value="0">Save and Close</option>
                        <option <?php if(set_value('queued') == 1) { echo 'selected="selected"'; } ?> value="1">Save and Send</option>
                    </select>
                    <span class="help-inline"><?php echo form_error('queued'); ?></span>
                </div>
            </div>
           
            <input type="submit" value="<?php echo $this->lang->line('btn_submit');?>" class="btn" />
            
		</form>

</td></tr></table>


<script>

function check_all(status)
{
	var checkbox = document.getElementsByName('user_details[]');
	var ln = checkbox.length;
	if(status=='yes')
	{
		for (var i = 0, l = ln; i < l; i++) {
			//alert(checkbox[i].disabled);
			if (checkbox[i].disabled==false)
			{
			checkbox[i].checked = true;			  	
			}
			else
			{
			checkbox[i].checked = false;			  		
			//checkbox[i].disabled==false
			}
		}
		document.getElementById("check_all_user").value = "no";
		document.getElementById("check_all_user").checked=true;
	}
	else
	{
		for (var i = 0, l = ln; i < l; i++) {			
			if (checkbox[i].disabled==false)
			{
			checkbox[i].checked = false;			  	
			}
			else
			{
			checkbox[i].checked = false;			  		
			//checkbox[i].disabled==false
			}
		}
		document.getElementById("check_all_user").value = "yes";
		document.getElementById("check_all_user").checked=false;
	}
}
function check_all_ch(id)
{
	
	if(document.getElementById('ch_'+id).value=='yes')
	{
	/*$.ajax({
	  url: BASE_URI+'admincp/email/get_chapter_user/'+id,
	  success: function(data) {
		var str=data.split("|");*/
		$('#used_data'+id).hide(200);
		/*}
	});*/
	document.getElementById('ch_'+id).value = "no";	
	}
	else
	{
		/*$.ajax({
	  url: BASE_URI+'admincp/email/get_chapter_user/'+id+'_not',
	  success: function(data) {
		var str=data.split("|");*/
		$('#used_data'+id).show(200);
		  /*}
	});*/
	document.getElementById('ch_'+id).value = "yes";	
	}
}
$('#email_template_name').change(function() {
	
	$.ajax({
	  url: BASE_URI+'admincp/email/get_template_chapter/'+$('#email_template_name').val(),
	  success: function(data) {
		 
		var str=data.split("|");
		$('#get_temp_ch').html(str[0]);
		
		$('.nicEdit-main').html(str[2]);
		$('#html').html(str[2]);
		//$('#arr_ch').val(str[3]);
		if(str[1]=='0')
		{
		$("#check_all_user").attr("disabled", true);
		}
		
	  }
	});
});

</script>
<?php $this->load->view('admincp/layout/footer'); ?>