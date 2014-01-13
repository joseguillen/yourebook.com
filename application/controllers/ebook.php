<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ebook extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$data['records'] = $this->ebook_model->get_all_titles();
		$this->load->view('titles_view', $data);
	}
	
	public function show_characters()
	{
		$title_id = $this->input->post('ebook_title');
		
		$data['records'] = $this->ebook_model->get_characters($title_id);
		$data['title_id'] = $title_id;
		$this->load->view('characters_view', $data);
	}
	
	public function create_ebook()
	{
		$characters = $this->ebook_model->get_characters( $this->input->post('title_id') );
		
		$string = read_file('./includes/'.$this->input->post('title_id').'.txt');
				
		foreach($characters as $character)
		{
			$field = $this->input->post( 'character_'.str_replace(' ', '', $character->name) );
			
			if( $field != '' )
			{
				$pattern = $character->name;
				$replace = $field;
				$string = str_replace($pattern, $replace , $string);
			}
		}
		
		$data['filename'] = rand();
		$data['response'] = $string;
		
		//echo $this->generate_pdf($data);
		
		//if ( write_file('./includes/'.$data['filename'].'.html', $string))
		
		if( $this->generate_pdf($data) == true )
		{		    
		    $this->load->view('response_view', $data);
		}
		else
		{
			unset($data['filename']);
		    $data['response'] = 'Sorry.. something went wrong!';
		    $this->load->view('response_view', $data);
		}
	
	}

	public function generate_pdf($data)
	{
		$this->load->library('fpdf');
	

		$this->fpdf->pdf = new Fpdf();
		$this->fpdf->AddPage();
		$this->fpdf->SetFont('Arial', '', 12);
		$m = $data['response'];
		$this->fpdf->MultiCell(0, 8, $m);
		
		$this->fpdf->Output('includes/'.$data['filename'].'.pdf', 'F');
		return true;

		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/ebook.php */