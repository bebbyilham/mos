<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Terapi extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Pasien_model');
        $this->load->model('Edukasi_model');
        $this->load->model('Pernyataantarget_model');
        $this->load->model('Terapi_model');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['content'] = '';
        $page = 'pernyataantarget/index';

        echo modules::run('template/loadview', $data, $page);
    }

    public function terapiMusik()
    {
        $data['title'] = 'Terapi Musik';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['content'] = '';
        $page = 'terapi/terapi_musik';
        echo modules::run('template/loadview', $data, $page);
    }


    public function fetchSingleUser()
    {
        $output = array();
        $data = $this->Edukasi_model->fetch_single_user($_POST['id']);

        foreach ($data as $row) {
            $output['nama_akun'] = $row->nama;
            $output['nama_pegawai'] = $row->nama;
            $output['username'] = $row->username;
            $output['id_user'] = $row->id_user;
            $output['role_id'] = $row->role_id;
            $output['nama_akun'] = $row->nama;;
        }
        echo json_encode($output);
    }

    public function simpanAksesTerapi()
    {
        $data = array(
            'id_terapi'          => $_POST['id'],
            'id_user'                       => $_POST['id_user'],
            'id_pasien'                     => $_POST['id_pasien'],
            'status'                        => 'aktif',
        );

        $this->Terapi_model->simpan_akses_terapi($data);
        echo json_encode($data);
    }

    public function tabellistterapi()
    {
        $fetch_data = $this->Terapi_model->make_datatables_list_terapi();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = '<a href="#" class="fa fa-pen-square fa-lg ml-2 mr-2 text-primary akses_terapi" link="' . $row->link . '" id="' . $row->id . '" title="akses"></a>';
            $sub_array[] = '<span id="' . $row->id . '">' . $row->keterangan . "</span><br>" . strtoupper("$row->jenis");
            $sub_array[] = substr($row->keterangan, 0, 100);

            $sub_array[] = '<span href="#" class="status badge badge-primary" title="Diunggah" >' . $row->created_at . '</span><br>' . '<span href="#" class="status badge badge-info" title="Diperbarui" >' . $row->updated_at . '</span>';
            // $sub_array[] = '<a href="#" class="fas fa-question-circle fa-lg ml-2 mr-2 text-primary pertanyaan" id="' . $row->id . '" data-toggle="modal" data-target="#staticBackdrop" title="Pertanyaan"></a>';


            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Terapi_model->get_all_data_list_terapi(),
            "recordsFiltered"     => $this->Terapi_model->get_filtered_data_list_terapi(),
            "data"                => $data
        );
        echo json_encode($output);
    }
}
