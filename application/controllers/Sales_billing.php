<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
class Sales_billing extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model('sales_billing_model'); 
    $this->load->model('user_model');
    $this->load->helper(array('form'));
    $this->load->library('form_validation');

  }

  public function index() {
    if ($this->session->logged_in) {
      $session_data = $this->session->userdata();
      $data['username'] = $session_data['username'];
      //$data['sales_billing'] = $this->sales_billing_model->get_salesbilling();
      $this->load->view('acumatica/sales_billing_view');
    }
  }

  public function cari(){
    $data['page_title'] = 'Sales Billing Result';
    if ($this->session->logged_in){
      $session_data = $this->session->userdata();
      $data['username'] = $session_data['username'];

      $data['user_status'] = $this->user_model->get_user_status($data);

      $this->load->view('templates/header', $data);
      $this->load->view('templates/menu');

      $data['sales_billing'] = $this->sales_billing_model->get_salesbilling();
      if (is_array($data['sales_billing'])) {
        $this->load->view('acumatica/sales_billing_result_view', $data);
      }
      else {
        $this->load->view('acumatica/sales_billing_no_result_view', $data);
      }
    }
    $this->load->view('templates/footer');
  }

  //fungsi rilis ini dipisah part karena ngambil variabel dari URL yang dipisah oleh "/"
  public function rilis($part1, $part2, $part3, $part4){
    if ($this->session->logged_in) {
      $session_data = $this->session->userdata();
      $data['username'] = $session_data['username'];
    }
    $this->load->view('templates/header', $data);
    $this->load->view('templates/menu');
    $refnbr = $part1.'/'.$part2.'/'.$part3.'/'.$part4;
    //echo 'apa sih'.$refnbr;
    $data['sales_billing'] = $this->sales_billing_model->release_salesbilling($refnbr);
    $this->load->view('acumatica/sales_billing_result_view', $data);

    $this->load->view('templates/footer');
  }
}
