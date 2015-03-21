<?php $this->load->view('admincp_convention/layout/header'); ?>



<table width="1020" border="0" cellspacing="0" cellpadding="0" align="center" style="min-height:300px;"> 

  <tr>

  	<td>

    	<div class="dotted_line">

			<span class="span8">
		        <h1>Form <small>Manage Form</small></h1>
			</span>
		 <div class="span5 offset sub_link" align="right">

            	<?php

                $form_attributes = array('class' => 'formA', 'id' => 'myform','style'=>'margin:0px;', 'method'=>'post');

                echo form_open(base_url() . 'admincp_convention/form/view', $form_attributes);

				?>

				<div class="control-group <?php if(form_error('keywords')){ echo "error";}?>">

					<div class="controls">

						<?php /*?><span class="span4">


                        <select name="mm_type" class="input-large" style="margin:0;">

                        <option value="0" <?php  ?> >All members</option>

                        </select>

                        </span><?php */?>

                        <span class="span4">

                        <input style="margin-top:10px;" class="input-xlarge" type="text" id="search" name="search" placeholder="Search member by name or email" value="<?php echo $this->session->userdata('search'); ?>">

                        </span>

                        <span class="span2">

                        <input type="submit" value="<?php echo $this->lang->line('btn_submit');?>" class="btn" />

                        </span>

					</div>
                    <div >
                    		

                        <a href="<?php echo base_url('admincp_convention/form/form_export_to_excel/');?>" id="exportexcel" style="width:100px;float:right;" class="dropdown-toggle" >Export to excel</a>

                        

                      
                    </div>

				</div>
				

                

           

		</div>

        <hr>

<table border="0" cellspacing="2" cellpadding="2" width="100%" class="table table-hover">

    <thead>

        <tr>

        	<th scope="col" width="20">#</th>
            <th scope="col">Name</th>
          	<th scope="col">Email </th>
            <th scope="col"><?php echo $this->lang->line('text_created_by');?></th>
            <th scope="col"><?php echo $this->lang->line('text_created_date');?></th>
            <th scope="col"><?php echo $this->lang->line('text_modified_by');?></th>
            <th scope="col"><?php echo $this->lang->line('text_modified_date');?></th>
            <th scope="col">Action</th>

        </tr>

    </thead>

    <tfoot>

    	<tr>

        	<td colspan="7"></td>

        </tr>

    </tfoot>

    <?php

		if ($query)
		{
			$i=0;
			foreach ($query as $row)
		    {
			   	$i++;
				$chapter = $this->dbform->get_chapter_from_mm_id($row->mm_id);
	?>

    <tr>
		<td><?php echo $i; ?></td>
        <td><?php echo $chapter->mm_username; ?></td>
        <td><?php echo $chapter->mm_email; ?></td>
        <td><?php echo $row->fm_created_by; ?></td>
        <td><?php echo $row->fm_created_date; ?></td>
        <td><?php echo $row->fm_modified_by; ?></td>
        <td><?php echo $row->fm_modified_date; ?></td>
        <td><a href="<?php echo base_url(); ?>admincp_convention/form/edit/<?php echo $row->fm_id; ?>" title="<?php echo $this->lang->line('misc_edit');?>"><i class="icon-edit"></i></a>
        <a href="<?php echo base_url();?>admincp_convention/form/delete/<?php echo $row->fm_id; ?>" title='<?php echo $this->lang->line('misc_delete');?>' onclick="javascript: return del();"><i class="icon-minus-sign"></i></a></td>
    </tr>
	<?php
   }
}
else
{
	echo "<tr><td colspan='5'>".$this->lang->line('text_no_result')."</td></tr>";
}
?>
</table>
<?php echo $this->pagination->create_links(); ?>
</div>
</td></tr></table>
<link href="<?php echo base_url(); ?>css/email.css" rel="stylesheet" type="text/css">
<?php $this->load->view('admincp_convention/layout/footer'); ?>