<?php

class Dbverification extends CI_Model {



    function getQueuedEmail()

    {

	 	$sql="SELECT * FROM verification 

where email_send!=3 AND queued=1 AND email_template_status=1 AND stop_mail=0  ORDER BY uid ASC";

		return $query = $this->db->query($sql);

    }

    function getFirstQueuedMailing(){

  $sql="SELECT * FROM verification 

where email_send!=3 AND queued=1 AND email_template_status=1 AND stop_mail=0 ORDER BY uid ASC";

		$query = $this->db->query($sql);

		return $query->result();

	}    



    function getBatchEmailSubscribers($emailID)

    {

		$sql="SELECT a.uid,b.mm_id,a.email_send,
		
		c.mm_fname,
		c.mm_mother_maiden_name,
		
		c.mm_father_name,
		c.mm_hometown,
		
		c.mm_original_surname,
		c.mm_username,
			
		c.mm_lname,
		c.mm_password,
		
		c.mm_email,
		c.mm_address,
		
		c.mm_cphone,
		c.mm_state_id,
		
		c.mm_hphone,
		c.mm_city_id,
		
		c.mm_birth_month,
		c.mm_birth_year,		
		c.mm_gender,
		
		c.occupation_id,
		
		c.edu_qualification,
		c.univercity_college_name,
		
		c.mm_photo,
		c.mm_life_id,
		
		c.mm_disp_dir,
		c.mm_disp_birth,
		
		c.mm_seq,
		c.mm_family_id,
		c.mm_relationship
		
		FROM verification a 

INNER JOIN  verification_template_to_member b ON a.uid=b.email_template_id

INNER JOIN member_master c ON b.mm_id=c.mm_id

where   a.uid='".$emailID."' AND a.email_send!=3 AND  a.queued=1 AND a.email_template_status=1 AND a.stop_mail=0 AND b.mail_send_status=0 ORDER BY a.uid ASC";

      	$query = $this->db->query($sql);

		return $query->result();

   }

    

    function countEmailSubscribers($emailID)

    {

		$sql="SELECT a.email_send,c.mm_seq,c.mm_username,c.mm_email FROM verification a 

INNER JOIN  verification_template_to_member b ON a.uid=b.email_template_id

INNER JOIN member_master c ON b.mm_id=c.mm_id 

where  a.uid='".$emailID."' AND a.email_send!=3 AND a.queued=1 AND a.email_template_status=1 AND a.stop_mail=0 AND b.mail_send_status=0";

		$query = $this->db->query($sql);

        return $query->num_rows();

    }

        

    function updateEmailStartNum($emailID, $quant, $totalSubscribers)

    {

		//echo $emailID;

		$quant1=$quant;

		//echo $totalSubscribers;

		//exit;

        $this->db->where('uid', $emailID);

        //$this->db->set('startNum', $quant, FALSE);

		 $this->db->set('startNum', 'startNum+1', FALSE);

        $this->db->update('verification'); 	

        

        if($totalSubscribers == $quant1)

        {

            $currentTime = date("Y-m-d H:i:s");

            $this->db->where('uid', $emailID);

            //$this->db->set('startNum', '0', FALSE);

            $this->db->set('queued', '0', FALSE);

			$this->db->set('email_send', '3', FALSE);

			$this->db->set('email_template_status', '0', FALSE);

            $this->db->set('sent', $currentTime);

            $this->db->update('verification');

        }

		

		

    }

	function email_template_to_member($email_template_id)

	{

		$sql="SELECT b.mm_seq,b.mm_username,b.mm_email FROM verification_template_to_member a 

INNER JOIN member_master b ON a.mm_id=b.mm_id

WHERE a.email_template_id='".$email_template_id."'";

		$query = $this->db->query($sql);

		return $query->result();

	}

	function get_template()

	{

		$sql="select * from template where template_status = '1'";

		$query = $this->db->query($sql);

		return $query->result();

	}

	function edit($data,$id)

	{

		$this->db->where("uid", $id);

		if($this->db->update('verification', $data))

		{

			return true;

		}

		else

		{

			return false;

		}

	}

	function mail_send_status($data,$id,$emailID)

	{

		

		$sql="update  verification_template_to_member set mail_send_status=1

WHERE mm_id = '".$id."' AND email_template_id = '".$emailID."'";

		

		$query = $this->db->query($sql);

		if($query)

		{

			return true;

		}

		else

		{

			return false;

		}

	}

	function get_relationship($user_id)

	{

		$sql="SELECT * FROM member_master WHERE mm_family_id ='".$user_id."' ORDER by mm_id DESC";

		$query = $this->db->query($sql);

		return $query->result();

	}

	function get_relationship_sub($family_id,$user_id)

	{

		$sql="SELECT * FROM member_master WHERE mm_id ='".$family_id."' OR mm_family_id ='".$family_id."' AND mm_id !='".$user_id."' AND mm_family_id !='0' ORDER by mm_id DESC";

		$query = $this->db->query($sql);

		return $query->result();

	}
	function states()

	{

		$sql="SELECT * FROM states ORDER BY state_name ASC";

        $query = $this->db->query($sql);

		return $query->result();

	}
	function cities($state_id)

	{

		$sql="SELECT * FROM city WHERE state_id = '".$state_id."' ORDER BY city_name ASC";

        $query = $this->db->query($sql);

		return $query->result();

	}

	//////////////update_pradip_20140107//////
	
	function chk_status($info)

	{

		$sql="SELECT * FROM mail_status WHERE mail_info = '".$info."'";

        	$query = $this->db->query($sql);

		return $query->num_rows();

	}
	
	function insert($data)

	{

		if($this->db->insert('mail_status', $data))

		{

			return true;

		}

		else

		{

			return false;

		}

	}
	
	function delete($info)

	{

		$this->db->delete('mail_status', array('mail_info' => $info));

		return true;	

	}

	//////////////////////update_pradip_20140107 end//////////////////

}



?> 