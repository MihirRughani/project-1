<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chapter extends CI_Controller {

function __construct()
	{
		parent::__construct();
		
		$this->load->model('dbchapter');
		$this->load->model('dbheader');
	}
	
	public function _remap($method, $params = array())
	{
		if($this->uri->segment(2))
		{
			$this->view($method);
		}
		elseif(!$this->uri->segment(2))
		{
			$this->view_all();
		}
		elseif($this->uri->segment(3))
		{
			$this->details();
		}
	}
	
	function view($chapter_seo)
	{
		$data['chapter'] = $this->dbchapter->chapter($chapter_seo);
		
		$data['news'] = $this->dbchapter->latesr_news($data['chapter']->ch_id,2);
		
		$data['events'] = $this->dbchapter->latesr_events($data['chapter']->ch_id,2);
		
		$data['media'] = $this->dbchapter->latesr_media($data['chapter']->ch_id,5);
		
		$data['title'] = $data['chapter']->ch_name;
		$data['sub_title'] = 'Chapter';
		$data['description'] = "";
		$data['keywords'] = "";
		$this->load->view('chapter',$data);
	}
	
	function view_all()
	{		
			$num_rec = count($this->dbchapter->count_all_chapters());
		
			$this->load->library('pagination');
			
			$config['base_url'] = base_url().'chapters/page/';
			$config['total_rows'] = $num_rec;
			$config['per_page'] = 50;
			$config['uri_segment'] = 3;
			$config['num_links'] = 4;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = '<div align="center" class="pagination"><ul>';
			$config['full_tag_close'] = '</ul></div>';
			
			$config['first_link'] = 'First';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close']  = '</li>';
			
			$config['last_link'] = 'Last';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			
			$config['next_link'] = 'Next';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			
			$config['prev_link'] = 'Prev';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close']  = '</li>';
			
			$config['cur_tag_open'] = '<li class="active"><a>';
			$config['cur_tag_close'] = '</a></li>';
			
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
	
			if ($this->uri->segment(3) == "")
			{
				$segment  = 0;
			}
			else
			{
				if(is_numeric($this->uri->segment(3)))
				{
					$segment = ($this->uri->segment(3)-1)*$config['per_page'];
				}
				else
				{
					$segment  = 0;
				}
				
			}
			
			$data['query'] = $this->dbchapter->get_all_all_chapters($segment,$config['per_page']);
			
			$this->pagination->initialize($config);
			
			$data['title'] = 'Chapters';
			$data['sub_title'] = 'All Chapters';
			$data['description'] = "";
			$data['keywords'] = "";
			$this->load->view('chapters',$data);
		
	}
	
}