<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanreminder extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Pasien_model');
        $this->load->model('Edukasi_model');
        $this->load->model('Pernyataantarget_model');
        $this->load->model('Terapi_model');
        $this->load->model('Pesanreminder_model');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['content'] = '';
        $page = 'pesanreminder/index';

        echo modules::run('template/loadview', $data, $page);
    }

    public function pesan()
    {
        $data['title'] = 'Pesan (Chat)';
        $data['user'] = $this->db->join('user_role', 'user_role.id = user.role_id')->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['content'] = '';
        $page = 'pesanreminder/pesan';
        echo modules::run('template/loadview', $data, $page);
        // echo modules::run('template/loadview', $data, $page);
    }

    public function tabelkontakPetugas()
    {
        $fetch_data = $this->Pesanreminder_model->make_datatables_kontak_petugas();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = "<b>" . $row->gelar_depan . ' ' . $row->nama_pegawai . ' ' . $row->gelar_belakang . "</b>";
            $sub_array[] = "<b>" . $row->hp_pegawai . "</b>";
            $sub_array[] = '<a href="#" class="fas fa-comment-medical fa-lg ml-2 mr-2 text-primary hubungi" kontak="' . $row->hp_pegawai . '" title="Chat"></a>';



            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Pesanreminder_model->get_all_data_kontak_petugas(),
            "recordsFiltered"     => $this->Pesanreminder_model->get_filtered_data_kontak_petugas(),
            "data"                => $data
        );
        echo json_encode($output);
    }
}
