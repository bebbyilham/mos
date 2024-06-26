<?php

class Admin_model extends CI_Model
{
    // ------------------------------------------------------------- ROLE
    var $order_column = array(null, 'role', null);

    public function make_query()
    {
        $this->db->select('*');
        $this->db->from('user_role');

        if (isset($_POST["search"]["value"])) {
            $this->db->like('role', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'DESC');
        }
    }

    public function make_datatables()
    {
        $this->make_query();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data()
    {
        $this->db->select("*");
        $this->db->from('user_role');
        return $this->db->count_all_results();
    }




    public function tambah_role($data)
    {
        $this->db->insert('user_role', $data);
    }

    public function edit_role($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('user_role', $data);
    }

    public function delete_role($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_role');
    }

    public function fetch_single_role($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('user_role');
        return $query->result();
    }
    // ------------------------------------------------------------- END ROLE







    // ------------------------------------------------------------- MENU
    var $order_column2 = array(null, 'menu', 'icon', null);

    public function make_query_menu()
    {
        $this->db->select('*');
        $this->db->from('user_menu');

        if (isset($_POST["search"]["value"])) {
            $this->db->like('menu', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column2[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'ASC');
        }
    }

    public function make_datatables_menu()
    {
        $this->make_query_menu();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_menu()
    {
        $this->make_query_menu();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_menu()
    {
        $this->db->select("*");
        $this->db->from('user_menu');
        return $this->db->count_all_results();
    }




    public function tambah_menu($data)
    {
        $this->db->insert('user_menu', $data);
    }

    public function edit_menu($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('user_menu', $data);
    }

    public function delete_menu($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_menu');
    }

    public function fetch_single_menu($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('user_menu');
        return $query->result();
    }
    // ------------------------------------------------------------- END MENU





    // ------------------------------------------------------------- SUBMENU
    var $order_column3 = array(null, 'deskripsi', 'title', 'url', 'icon', 'is_active', null);

    public function make_query_submenu()
    {
        $this->db->select('
            user_sub_menu.id,
            user_sub_menu.title,
            user_sub_menu.url,
            user_sub_menu.icon,
            user_sub_menu.is_active,
            user_menu.menu,
            user_menu.deskripsi
            ');
        $this->db->from('user_sub_menu');
        $this->db->join('user_menu', 'user_menu.id = user_sub_menu.menu_id');

        if (isset($_POST["search"]["value"])) {
            $this->db->like('title', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column3[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('user_sub_menu.id', 'DESC');
        }
    }

    public function make_datatables_submenu()
    {
        $this->make_query_submenu();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_submenu()
    {
        $this->make_query_submenu();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_submenu()
    {
        $this->db->select("*");
        $this->db->from('user_sub_menu');
        return $this->db->count_all_results();
    }




    public function tambah_submenu($data)
    {
        $this->db->insert('user_sub_menu', $data);
    }

    public function edit_submenu($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('user_sub_menu', $data);
    }

    public function delete_submenu($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_sub_menu');
    }

    public function fetch_single_submenu($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('user_sub_menu');
        return $query->result();
    }
    // ------------------------------------------------------------- END SUBMENU












    // ------------------------------------------------------------- REFERENSI
    // PENGENAL 
    var $order_column4 = array(null, 'pengenal', 'status_pengenal', null);

    public function make_query_pengenal()
    {
        $this->db->select('*');
        $this->db->from('referensi_pengenal');

        if (isset($_POST["search"]["value"])) {
            $this->db->like('pengenal', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column4[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('referensi_pengenal.id_pengenal', 'DESC');
        }
    }

    public function make_datatables_pengenal()
    {
        $this->make_query_pengenal();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_pengenal()
    {
        $this->make_query_pengenal();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_pengenal()
    {
        $this->db->select("*");
        $this->db->from('referensi_pengenal');
        return $this->db->count_all_results();
    }

    public function tambah_pengenal($data)
    {
        $this->db->insert('referensi_pengenal', $data);
    }

    public function edit_pengenal($id, $data)
    {
        $this->db->where('id_pengenal', $id);
        $this->db->update('referensi_pengenal', $data);
    }

    public function delete_pengenal($id)
    {
        $this->db->where('id_pengenal', $id);
        $this->db->delete('referensi_pengenal');
    }

    public function fetch_single_pengenal($id)
    {
        $this->db->where('id_pengenal', $id);
        $query = $this->db->get('referensi_pengenal');
        return $query->result();
    }





    // AGAMA 
    var $order_column5 = array(null, 'ket_agama', 'status_agama', null);

    public function make_query_agama()
    {
        $this->db->select('*');
        $this->db->from('referensi_agama');

        if (isset($_POST["search"]["value"])) {
            $this->db->like('ket_agama', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column5[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('referensi_agama.id_agama', 'ASC');
        }
    }

    public function make_datatables_agama()
    {
        $this->make_query_agama();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_agama()
    {
        $this->make_query_agama();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_agama()
    {
        $this->db->select("*");
        $this->db->from('referensi_agama');
        return $this->db->count_all_results();
    }

    public function tambah_agama($data)
    {
        $this->db->insert('referensi_agama', $data);
    }

    public function edit_agama($id, $data)
    {
        $this->db->where('id_agama', $id);
        $this->db->update('referensi_agama', $data);
    }

    public function delete_agama($id)
    {
        $this->db->where('id_agama', $id);
        $this->db->delete('referensi_agama');
    }

    public function fetch_single_agama($id)
    {
        $this->db->where('id_agama', $id);
        $query = $this->db->get('referensi_agama');
        return $query->result();
    }





    // WARGA NEGARA 
    var $order_column6 = array(null, 'ket_warganegara', 'status_warganegara', null);

    public function make_query_warganegara()
    {
        $this->db->select('*');
        $this->db->from('referensi_warganegara');

        if (isset($_POST["search"]["value"])) {
            $this->db->like('ket_warganegara', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column6[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('referensi_warganegara.id_warganegara', 'ASC');
        }
    }

    public function make_datatables_warganegara()
    {
        $this->make_query_warganegara();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_warganegara()
    {
        $this->make_query_warganegara();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_warganegara()
    {
        $this->db->select("*");
        $this->db->from('referensi_warganegara');
        return $this->db->count_all_results();
    }

    public function tambah_warganegara($data)
    {
        $this->db->insert('referensi_warganegara', $data);
    }

    public function edit_warganegara($id, $data)
    {
        $this->db->where('id_warganegara', $id);
        $this->db->update('referensi_warganegara', $data);
    }

    public function delete_warganegara($id)
    {
        $this->db->where('id_warganegara', $id);
        $this->db->delete('referensi_warganegara');
    }

    public function fetch_single_warganegara($id)
    {
        $this->db->where('id_warganegara', $id);
        $query = $this->db->get('referensi_warganegara');
        return $query->result();
    }



    // SUKU BANGSA 
    var $order_column7 = array(null, 'ket_sukubangsa', 'status_sukubangsa', null);

    public function make_query_sukubangsa()
    {
        $this->db->select('*');
        $this->db->from('referensi_sukubangsa');

        if (isset($_POST["search"]["value"])) {
            $this->db->like('ket_sukubangsa', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column7[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('referensi_sukubangsa.id_sukubangsa', 'DESC');
        }
    }

    public function make_datatables_sukubangsa()
    {
        $this->make_query_sukubangsa();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_sukubangsa()
    {
        $this->make_query_sukubangsa();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_sukubangsa()
    {
        $this->db->select("*");
        $this->db->from('referensi_sukubangsa');
        return $this->db->count_all_results();
    }

    public function tambah_sukubangsa($data)
    {
        $this->db->insert('referensi_sukubangsa', $data);
    }

    public function edit_sukubangsa($id, $data)
    {
        $this->db->where('id_sukubangsa', $id);
        $this->db->update('referensi_sukubangsa', $data);
    }

    public function delete_sukubangsa($id)
    {
        $this->db->where('id_sukubangsa', $id);
        $this->db->delete('referensi_sukubangsa');
    }

    public function fetch_single_sukubangsa($id)
    {
        $this->db->where('id_sukubangsa', $id);
        $query = $this->db->get('referensi_sukubangsa');
        return $query->result();
    }



    // STATUS NIKAH 
    var $order_column8 = array(null, 'ket_statusnikah', 'status_statusnikah', null);

    public function make_query_statusnikah()
    {
        $this->db->select('*');
        $this->db->from('referensi_statusnikah');

        if (isset($_POST["search"]["value"])) {
            $this->db->like('ket_statusnikah', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column8[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('referensi_statusnikah.id_statusnikah', 'DESC');
        }
    }

    public function make_datatables_statusnikah()
    {
        $this->make_query_statusnikah();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_statusnikah()
    {
        $this->make_query_statusnikah();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_statusnikah()
    {
        $this->db->select("*");
        $this->db->from('referensi_statusnikah');
        return $this->db->count_all_results();
    }

    public function tambah_statusnikah($data)
    {
        $this->db->insert('referensi_statusnikah', $data);
    }

    public function edit_statusnikah($id, $data)
    {
        $this->db->where('id_statusnikah', $id);
        $this->db->update('referensi_statusnikah', $data);
    }

    public function delete_statusnikah($id)
    {
        $this->db->where('id_statusnikah', $id);
        $this->db->delete('referensi_statusnikah');
    }

    public function fetch_single_statusnikah($id)
    {
        $this->db->where('id_statusnikah', $id);
        $query = $this->db->get('referensi_statusnikah');
        return $query->result();
    }



    // PENDIDIKAN
    var $order_column9 = array(null, 'ket_pendidikan', 'status_pendidikan', null);

    public function make_query_pendidikan()
    {
        $this->db->select('*');
        $this->db->from('referensi_pendidikan');

        if (isset($_POST["search"]["value"])) {
            $this->db->like('ket_pendidikan', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column9[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('referensi_pendidikan.id_pendidikan', 'DESC');
        }
    }

    public function make_datatables_pendidikan()
    {
        $this->make_query_pendidikan();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_pendidikan()
    {
        $this->make_query_pendidikan();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_pendidikan()
    {
        $this->db->select("*");
        $this->db->from('referensi_pendidikan');
        return $this->db->count_all_results();
    }

    public function tambah_pendidikan($data)
    {
        $this->db->insert('referensi_pendidikan', $data);
    }

    public function edit_pendidikan($id, $data)
    {
        $this->db->where('id_pendidikan', $id);
        $this->db->update('referensi_pendidikan', $data);
    }

    public function delete_pendidikan($id)
    {
        $this->db->where('id_pendidikan', $id);
        $this->db->delete('referensi_pendidikan');
    }

    public function fetch_single_pendidikan($id)
    {
        $this->db->where('id_pendidikan', $id);
        $query = $this->db->get('referensi_pendidikan');
        return $query->result();
    }



    // PEKERJAAN
    var $order_column10 = array(null, 'ket_pekerjaan', 'status_pekerjaan', null);

    public function make_query_pekerjaan()
    {
        $this->db->select('*');
        $this->db->from('referensi_pekerjaan');

        if (isset($_POST["search"]["value"])) {
            $this->db->like('ket_pekerjaan', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column10[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('referensi_pekerjaan.id_pekerjaan', 'DESC');
        }
    }

    public function make_datatables_pekerjaan()
    {
        $this->make_query_pekerjaan();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_pekerjaan()
    {
        $this->make_query_pekerjaan();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_pekerjaan()
    {
        $this->db->select("*");
        $this->db->from('referensi_pekerjaan');
        return $this->db->count_all_results();
    }

    public function tambah_pekerjaan($data)
    {
        $this->db->insert('referensi_pekerjaan', $data);
    }

    public function edit_pekerjaan($id, $data)
    {
        $this->db->where('id_pekerjaan', $id);
        $this->db->update('referensi_pekerjaan', $data);
    }

    public function delete_pekerjaan($id)
    {
        $this->db->where('id_pekerjaan', $id);
        $this->db->delete('referensi_pekerjaan');
    }

    public function fetch_single_pekerjaan($id)
    {
        $this->db->where('id_pekerjaan', $id);
        $query = $this->db->get('referensi_pekerjaan');
        return $query->result();
    }



    // HUBUNGAN
    var $order_column11 = array(null, 'ket_hubungan', 'status_hubungan', null);

    public function make_query_hubungan()
    {
        $this->db->select('*');
        $this->db->from('referensi_hubungan');

        if (isset($_POST["search"]["value"])) {
            $this->db->like('ket_hubungan', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column11[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('referensi_hubungan.id_hubungan', 'DESC');
        }
    }

    public function make_datatables_hubungan()
    {
        $this->make_query_hubungan();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_hubungan()
    {
        $this->make_query_hubungan();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_hubungan()
    {
        $this->db->select("*");
        $this->db->from('referensi_hubungan');
        return $this->db->count_all_results();
    }

    public function tambah_hubungan($data)
    {
        $this->db->insert('referensi_hubungan', $data);
    }

    public function edit_hubungan($id, $data)
    {
        $this->db->where('id_hubungan', $id);
        $this->db->update('referensi_hubungan', $data);
    }

    public function delete_hubungan($id)
    {
        $this->db->where('id_hubungan', $id);
        $this->db->delete('referensi_hubungan');
    }

    public function fetch_single_hubungan($id)
    {
        $this->db->where('id_hubungan', $id);
        $query = $this->db->get('referensi_hubungan');
        return $query->result();
    }

    // PROFESI
    var $order_column13 = array(null, 'ket_profesi', 'status_profesi', null);

    public function make_query_profesi()
    {
        $this->db->select('*');
        $this->db->from('referensi_profesi');

        if (isset($_POST["search"]["value"])) {
            $this->db->like('ket_profesi', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column13[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_profesi', 'DESC');
        }
    }

    public function make_datatables_profesi()
    {
        $this->make_query_profesi();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_profesi()
    {
        $this->make_query_profesi();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_profesi()
    {
        $this->db->select("*");
        $this->db->from('referensi_profesi');
        return $this->db->count_all_results();
    }

    public function tambah_profesi($data)
    {
        $this->db->insert('referensi_profesi', $data);
    }

    public function edit_profesi($id, $data)
    {
        $this->db->where('id_profesi', $id);
        $this->db->update('referensi_profesi', $data);
    }

    public function fetch_single_profesi($id)
    {
        $this->db->where('id_profesi', $id);
        $query = $this->db->get('referensi_profesi');
        return $query->result();
    }


    // WISMA
    var $order_column14 = array(null, 'nama_wisma', 'status_wisma', null);

    public function make_query_wisma()
    {
        $this->db->select('*');
        $this->db->from('referensi_wisma');

        if (isset($_POST["search"]["value"])) {
            $this->db->like('nama_wisma', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column14[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_wisma', 'DESC');
        }
    }

    public function make_datatables_wisma()
    {
        $this->make_query_wisma();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_wisma()
    {
        $this->make_query_wisma();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_wisma()
    {
        $this->db->select("*");
        $this->db->from('referensi_wisma');
        return $this->db->count_all_results();
    }

    public function tambah_wisma($data)
    {
        $this->db->insert('referensi_wisma', $data);
    }

    public function edit_wisma($id, $data)
    {
        $this->db->where('id_wisma', $id);
        $this->db->update('referensi_wisma', $data);
    }

    public function fetch_single_wisma($id)
    {
        $this->db->where('id_wisma', $id);
        $query = $this->db->get('referensi_wisma');
        return $query->result();
    }

    // KELAS RAWATAN
    var $order_column15 = array(null, 'nama_kelas', 'status_kelas', null);

    public function make_query_kelas()
    {
        $this->db->select('*');
        $this->db->from('referensi_kelas');

        if (isset($_POST["search"]["value"])) {
            $this->db->like('nama_kelas', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column15[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_kelas', 'DESC');
        }
    }

    public function make_datatables_kelas()
    {
        $this->make_query_kelas();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_kelas()
    {
        $this->make_query_kelas();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_kelas()
    {
        $this->db->select("*");
        $this->db->from('referensi_kelas');
        return $this->db->count_all_results();
    }

    public function tambah_kelas($data)
    {
        $this->db->insert('referensi_kelas', $data);
    }

    public function edit_kelas($id, $data)
    {
        $this->db->where('id_kelas', $id);
        $this->db->update('referensi_kelas', $data);
    }

    public function fetch_single_kelas($id)
    {
        $this->db->where('id_kelas', $id);
        $query = $this->db->get('referensi_kelas');
        return $query->result();
    }


    // PENJAMIN
    var $order_column16 = array(null, 'nama_penjamin', 'kode_penjamin', 'status_penjamin', null);

    public function make_query_penjamin()
    {
        $this->db->select('*');
        $this->db->from('referensi_penjamin');

        if (isset($_POST["search"]["value"])) {
            $this->db->like('nama_penjamin', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column16[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_penjamin', 'DESC');
        }
    }

    public function make_datatables_penjamin()
    {
        $this->make_query_penjamin();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_penjamin()
    {
        $this->make_query_penjamin();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_penjamin()
    {
        $this->db->select("*");
        $this->db->from('referensi_penjamin');
        return $this->db->count_all_results();
    }

    public function tambah_penjamin($data)
    {
        $this->db->insert('referensi_penjamin', $data);
    }

    public function edit_penjamin($id, $data)
    {
        $this->db->where('id_penjamin', $id);
        $this->db->update('referensi_penjamin', $data);
    }

    public function fetch_single_penjamin($id)
    {
        $this->db->where('id_penjamin', $id);
        $query = $this->db->get('referensi_penjamin');
        return $query->result();
    }

    // SATUAN LABOR
    var $order_column17 = array(null, 'nama_satuan_labor', 'kode_satuan_labor', 'status_satuan_labor', null);

    public function make_query_satuan_labor()
    {
        $this->db->select('*');
        $this->db->from('referensi_satuan_labor');

        if (isset($_POST["search"]["value"])) {
            $this->db->like('nama_satuan_labor', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column17[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_satuan_labor', 'DESC');
        }
    }

    public function make_datatables_satuan_labor()
    {
        $this->make_query_satuan_labor();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_satuan_labor()
    {
        $this->make_query_satuan_labor();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_satuan_labor()
    {
        $this->db->select("*");
        $this->db->from('referensi_satuan_labor');
        return $this->db->count_all_results();
    }

    public function tambah_satuan_labor($data)
    {
        $this->db->insert('referensi_satuan_labor', $data);
    }

    public function edit_satuan_labor($id, $data)
    {
        $this->db->where('id_satuan_labor', $id);
        $this->db->update('referensi_satuan_labor', $data);
    }

    public function fetch_single_satuan_labor($id)
    {
        $this->db->where('id_satuan_labor', $id);
        $query = $this->db->get('referensi_satuan_labor');
        return $query->result();
    }

    // GRUP TINDAKAN LABOR
    var $order_column18 = array(null, 'nama_kategori_tindakan_labor', 'status_kategori_tindakan_labor', null);

    public function make_query_grup_labor()
    {
        $this->db->select('*');
        $this->db->from('referensi_kategori_tindakan_labor');

        if (isset($_POST["search"]["value"])) {
            $this->db->like('nama_kategori_tindakan_labor', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column18[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_kategori_tindakan_labor', 'DESC');
        }
    }

    public function make_datatables_grup_labor()
    {
        $this->make_query_grup_labor();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_grup_labor()
    {
        $this->make_query_grup_labor();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_grup_labor()
    {
        $this->db->select("*");
        $this->db->from('referensi_kategori_tindakan_labor');
        return $this->db->count_all_results();
    }

    public function tambah_grup_labor($data)
    {
        $this->db->insert('referensi_kategori_tindakan_labor', $data);
    }

    public function edit_grup_labor($id, $data)
    {
        $this->db->where('id_kategori_tindakan_labor', $id);
        $this->db->update('referensi_kategori_tindakan_labor', $data);
    }

    public function fetch_single_grup_labor($id)
    {
        $this->db->where('id_kategori_tindakan_labor', $id);
        $query = $this->db->get('referensi_kategori_tindakan_labor');
        return $query->result();
    }


    // BAHAN RADIOLOGI
    var $order_column19 = array(null, 'nama_bahan_radiologi', 'status_bahan_radiologi', null);

    public function make_query_bahan_radiologi()
    {
        $this->db->select('*');
        $this->db->from('referensi_bahan_radiologi');

        if (isset($_POST["search"]["value"])) {
            $this->db->like('nama_bahan_radiologi', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column19[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_bahan_radiologi', 'DESC');
        }
    }

    public function make_datatables_bahan_radiologi()
    {
        $this->make_query_bahan_radiologi();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_bahan_radiologi()
    {
        $this->make_query_bahan_radiologi();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_bahan_radiologi()
    {
        $this->db->select("*");
        $this->db->from('referensi_bahan_radiologi');
        return $this->db->count_all_results();
    }

    public function tambah_bahan_radiologi($data)
    {
        $this->db->insert('referensi_bahan_radiologi', $data);
    }

    public function edit_bahan_radiologi($id, $data)
    {
        $this->db->where('id_bahan_radiologi', $id);
        $this->db->update('referensi_bahan_radiologi', $data);
    }

    public function fetch_single_bahan_radiologi($id)
    {
        $this->db->where('id_bahan_radiologi', $id);
        $query = $this->db->get('referensi_bahan_radiologi');
        return $query->result();
    }



    // CARA KELUAR
    var $order_column20 = array(null, 'cara_keluar', 'status_cara_keluar', null);

    public function make_query_cara_keluar()
    {
        $this->db->select('*');
        $this->db->from('referensi_cara_keluar');

        if (isset($_POST["search"]["value"])) {
            $this->db->like('cara_keluar', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column20[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_cara_keluar', 'DESC');
        }
    }

    public function make_datatables_cara_keluar()
    {
        $this->make_query_cara_keluar();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_cara_keluar()
    {
        $this->make_query_cara_keluar();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_cara_keluar()
    {
        $this->db->select("*");
        $this->db->from('referensi_cara_keluar');
        return $this->db->count_all_results();
    }

    public function tambah_cara_keluar($data)
    {
        $this->db->insert('referensi_cara_keluar', $data);
    }

    public function edit_cara_keluar($id, $data)
    {
        $this->db->where('id_cara_keluar', $id);
        $this->db->update('referensi_cara_keluar', $data);
    }

    public function fetch_single_cara_keluar($id)
    {
        $this->db->where('id_cara_keluar', $id);
        $query = $this->db->get('referensi_cara_keluar');
        return $query->result();
    }
    // ------------------------------------------------------------- END REFERENSI 


    // ------------------------------------------------------------- TAMBAH PEGAWAI
    var $order_column12 = array(null, 'nama_pegawai', 'profesi', 'status_pegawai', null);

    public function make_query_pegawai()
    {
        $this->db->select('*');
        $this->db->from('pegawai');
        $this->db->join('referensi_profesi', 'referensi_profesi.id_profesi = pegawai.profesi');

        if (isset($_POST["search"]["value"])) {
            $this->db->like('nama_pegawai', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column12[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_pegawai', 'DESC');
        }
    }

    public function make_datatables_pegawai()
    {
        $this->make_query_pegawai();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_pegawai()
    {
        $this->make_query_pegawai();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_pegawai()
    {
        $this->db->select("*");
        $this->db->from('pegawai');
        return $this->db->count_all_results();
    }




    public function tambah_pegawai($data)
    {
        $this->db->insert('pegawai', $data);
    }

    public function tambah_user($data)
    {
        $this->db->insert('user', $data);
    }

    public function edit_pegawai($id, $data)
    {
        $this->db->where('id_pegawai', $id);
        $this->db->update('pegawai', $data);
    }

    public function edit_user($id, $data)
    {
        $this->db->where('id_user', $id);
        $this->db->update('user', $data);
    }

    public function delete_pegawai($id)
    {
        $this->db->where('id_pegawai', $id);
        $this->db->delete('pegawai');
    }

    public function fetch_single_pegawai($id)
    {
        $this->db->where('id_pegawai', $id);
        $query = $this->db->get('pegawai');
        return $query->result();
    }

    public function fetch_single_user($id)
    {
        $this->db->where('pegawai.id_pegawai', $id);
        $this->db->join('user', 'user.pegawai_id = pegawai.id_pegawai', 'LEFT');
        $query = $this->db->get('pegawai');
        return $query->result();
    }
    // ------------------------------------------------------------- END TAMBAH PEGAWAI

    public function simpan_edukasi($data)
    {
        $this->db->insert('konten_edukasi', $data);
    }
    public function simpan_list_konten_edukasi($data)
    {
        $this->db->insert('list_konten_edukasi', $data);
    }
    public function ubah_status_edukasi($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(
            'konten_edukasi',
            $data
        );
    }
    public function hapus_list_konten_edukasi($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('list_konten_edukasi');
    }

    //tabel edukasi
    var $order_columnE = array(null, 'judul', null, 'status', 'created_at', null);
    public function make_query_edukasi()
    {
        // $id_pasien = $_POST['idpasien'];
        $this->db->select('*');
        // $this->db->where('jenis_layanan', 2);
        $this->db->from('konten_edukasi');
        if (($_POST["search"]["value"])) {
            $this->db->like('no_registrasi', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_columnE[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'ASC');
        }
    }


    public function make_datatables_edukasi()
    {
        $this->make_query_edukasi();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_edukasi()
    {
        $this->make_query_edukasi();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_edukasi()
    {
        $this->db->select("*");
        $this->db->from('konten_edukasi');
        return $this->db->count_all_results();
    }
    //end edukasi

    //tabel konten edukasi
    var $order_columnKE = array(null, 'judul', null, 'status', 'created_at', null);
    public function make_query_konten_edukasi()
    {
        $this->db->select('*');
        $this->db->where('id_edukasi', $_POST['id_edukasi']);
        $this->db->from('list_konten_edukasi');
        if (($_POST["search"]["value"])) {
            $this->db->like('keterangan', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_columnKE[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'ASC');
        }
    }


    public function make_datatables_konten_edukasi()
    {
        $this->make_query_konten_edukasi();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_konten_edukasi()
    {
        $this->make_query_konten_edukasi();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_konten_edukasi()
    {
        $this->db->select("*");
        $this->db->from('list_konten_edukasi');
        return $this->db->count_all_results();
    }
    //end edukasi

    public function ubah_status_konten_edukasi($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(
            'list_konten_edukasi',
            $data
        );
    }

    public function simpan_list_konten_edukasi_pertanyaan($data)
    {
        $this->db->insert('pertanyaan_konten_edukasi', $data);
    }
    public function ubah_status_edukasi_pertanyaan($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(
            'pertanyaan_konten_edukasi',
            $data
        );
    }

    //tabel konten edukasi pertanyaan
    var $order_columnKEP = array(null, 'judul', null, 'status', 'created_at', null);
    public function make_query_konten_edukasi_pertanyaan()
    {
        $this->db->select('*');
        $this->db->where('id_list_edukasi', $_POST['id_konten_edukasi']);
        $this->db->from('pertanyaan_konten_edukasi');
        if (($_POST["search"]["value"])) {
            $this->db->like('pertanyaan', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_columnKEP[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'ASC');
        }
    }


    public function make_datatables_konten_edukasi_pertanyaan()
    {
        $this->make_query_konten_edukasi_pertanyaan();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_konten_edukasi_pertanyaan()
    {
        $this->make_query_konten_edukasi_pertanyaan();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_konten_edukasi_pertanyaan()
    {
        $this->db->select("*");
        $this->db->from('pertanyaan_konten_edukasi');
        return $this->db->count_all_results();
    }
    //end edukasi pertanyaan

    // edukasi jawaban
    public function simpan_list_konten_edukasi_jawaban($data)
    {
        $this->db->insert('jawaban_konten_edukasi', $data);
    }
    public function ubah_status_edukasi_jawaban($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(
            'jawaban_konten_edukasi',
            $data
        );
    }

    //tabel konten edukasi jawaban
    var $order_columnKEJ = array(null, 'judul', null, 'status', 'created_at', null);
    public function make_query_konten_edukasi_jawaban()
    {
        $this->db->select('*');
        $this->db->where('id_pertanyaan', $_POST['id_pertanyaan']);
        $this->db->from('jawaban_konten_edukasi');
        if (($_POST["search"]["value"])) {
            $this->db->like('jawaban', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_columnKEJ[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'ASC');
        }
    }


    public function make_datatables_konten_edukasi_jawaban()
    {
        $this->make_query_konten_edukasi_jawaban();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_konten_edukasi_jawaban()
    {
        $this->make_query_konten_edukasi_jawaban();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_konten_edukasi_jawaban()
    {
        $this->db->select("*");
        $this->db->from('jawaban_konten_edukasi');
        return $this->db->count_all_results();
    }
    //end edukasi jawaban

    public function fetch_all_jawaban($id)
    {
        $this->db->where('id_pertanyaan', $id);
        $query = $this->db->get('jawaban_konten_edukasi');
        return $query->result();
    }

    public function simpan_jawaban_betul($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(
            'pertanyaan_konten_edukasi',
            $data
        );
    }

    public function fetch_pertanyaan($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('pertanyaan_konten_edukasi');
        return $query->result();
    }

    public function ubah_status_pertanyaan($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(
            'pertanyaan_konten_edukasi',
            $data
        );
    }

    public function simpan_pernyataantarget($data)
    {
        $this->db->insert('pernyataan_target', $data);
    }

    //tabel pernyataantarget
    var $order_columnPT = array(null, 'judul', null, 'status', 'created_at', null);
    public function make_query_pernyataantarget()
    {
        // $id_pasien = $_POST['idpasien'];
        $this->db->select('*');
        // $this->db->where('jenis_layanan', 2);
        $this->db->from('pernyataan_target');
        if (($_POST["search"]["value"])) {
            $this->db->like('no_registrasi', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_columnPT[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'ASC');
        }
    }


    public function make_datatables_pernyataantarget()
    {
        $this->make_query_pernyataantarget();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_pernyataantarget()
    {
        $this->make_query_pernyataantarget();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_pernyataantarget()
    {
        $this->db->select("*");
        $this->db->from('pernyataan_target');
        return $this->db->count_all_results();
    }
    //end pernyataantarget

    public function simpan_list_target($data)
    {
        $this->db->insert('list_pernyataan_target', $data);
    }

    //tabel lsit target
    var $order_columnLT = array(
        null, 'judul', null, 'status', 'created_at', null
    );
    public function make_query_list_pernyataan_target()
    {
        $this->db->select('*');
        $this->db->where('id_target', $_POST['id_target']);
        $this->db->from('list_pernyataan_target');
        if (($_POST["search"]["value"])) {
            $this->db->like('keterangan', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_columnLT[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'ASC');
        }
    }


    public function make_datatables_list_pernyataan_target()
    {
        $this->make_query_list_pernyataan_target();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_list_pernyataan_target()
    {
        $this->make_query_list_pernyataan_target();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_list_pernyataan_target()
    {
        $this->db->select("*");
        $this->db->from('list_pernyataan_target');
        return $this->db->count_all_results();
    }
    //end edukasi

    public function ubah_status_list_pernyataan_target($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(
            'list_pernyataan_target',
            $data
        );
    }

    public function simpan_pertanyaan_target($data)
    {
        $this->db->insert('pertanyaan_target', $data);
    }
    public function ubah_status_pertanyaan_target($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(
            'pertanyaan_target',
            $data
        );
    }

    //tabel target pertanyaan
    var $order_columnTP = array(null, 'judul', null, 'status', 'created_at', null);
    public function make_query_target_pertanyaan()
    {
        $this->db->select('*');
        $this->db->where('id_list_target', $_POST['id_list_target']);
        $this->db->from('pertanyaan_target');
        if (($_POST["search"]["value"])) {
            $this->db->like('pertanyaan', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_columnTP[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'ASC');
        }
    }


    public function make_datatables_target_pertanyaan()
    {
        $this->make_query_target_pertanyaan();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_target_pertanyaan()
    {
        $this->make_query_target_pertanyaan();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_target_pertanyaan()
    {
        $this->db->select("*");
        $this->db->from('pertanyaan_target');
        return $this->db->count_all_results();
    }
    //end target pertanyaan

    public function ubah_status_target_pertanyaan($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(
            'pertanyaan_target',
            $data
        );
    }

    //tabel pernyataan jawaban
    var $order_columnPJ = array(null, 'judul', null, 'status', 'created_at', null);
    public function make_query_pernyataan_target_jawaban()
    {
        $this->db->select('*');
        $this->db->where('id_pertanyaan', $_POST['id_pertanyaan']);
        $this->db->from('jawaban_pernyataan_target');
        if (($_POST["search"]["value"])) {
            $this->db->like('jawaban', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_columnPJ[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'ASC');
        }
    }


    public function make_datatables_pernyataan_target_jawaban()
    {
        $this->make_query_pernyataan_target_jawaban();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_pernyataan_target_jawaban()
    {
        $this->make_query_pernyataan_target_jawaban();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_pernyataan_target_jawaban()
    {
        $this->db->select("*");
        $this->db->from('jawaban_pernyataan_target');
        return $this->db->count_all_results();
    }
    //end pernyataan jawaban

    // pernyataan jawaban
    public function simpan_list_pernyataan_target_jawaban($data)
    {
        $this->db->insert('jawaban_pernyataan_target', $data);
    }
    public function ubah_status_pernyataan_target_jawaban($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(
            'jawaban_pernyataan_target',
            $data
        );
    }

    public function fetch_all_jawaban_pernyataan($id)
    {
        $this->db->where('id_pertanyaan', $id);
        $query = $this->db->get('jawaban_pernyataan_target');
        return $query->result();
    }

    public function simpan_jawaban_betul_pernyataan($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(
            'pertanyaan_target',
            $data
        );
    }

    public function simpan_self_control($data)
    {
        $this->db->insert('self_control', $data);
    }

    //tabel selfcontrol
    var $order_columnSC = array(null, 'judul', null, 'status', 'created_at', null);
    public function make_query_selfcontrol()
    {
        // $id_pasien = $_POST['idpasien'];
        $this->db->select('*');
        // $this->db->where('jenis_layanan', 2);
        $this->db->from('self_control');
        if (($_POST["search"]["value"])) {
            $this->db->like('deskripsi', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_columnSC[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'ASC');
        }
    }


    public function make_datatables_selfcontrol()
    {
        $this->make_query_selfcontrol();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_selfcontrol()
    {
        $this->make_query_selfcontrol();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_selfcontrol()
    {
        $this->db->select("*");
        $this->db->from('self_control');
        return $this->db->count_all_results();
    }
    //end selfcontrol

    public function simpan_list_selfcontrol($data)
    {
        $this->db->insert('list_selfcontrol', $data);
    }

    //tabel lsit target
    var $order_columnLS = array(
        null, 'judul', null, 'status', 'created_at', null
    );
    public function make_query_list_selfcontrol()
    {
        $this->db->select('*');
        $this->db->where('id_selfcontrol', $_POST['id_metode']);
        $this->db->from('list_selfcontrol');
        if (($_POST["search"]["value"])) {
            $this->db->like('keterangan', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_columnLS[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'ASC');
        }
    }


    public function make_datatables_list_selfcontrol()
    {
        $this->make_query_list_selfcontrol();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_list_selfcontrol()
    {
        $this->make_query_list_selfcontrol();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_list_selfcontrol()
    {
        $this->db->select("*");
        $this->db->from('list_selfcontrol');
        return $this->db->count_all_results();
    }
    //end selfcontrol

    public function ubah_status_list_selfcontrol($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(
            'list_selfcontrol',
            $data
        );
    }

    //tabel selfcontrol pertanyaan
    var $order_columnSP = array(
        null, 'judul', null, 'status', 'created_at', null
    );
    public function make_query_selfcontrol_pertanyaan()
    {
        $this->db->select('*');
        $this->db->where('id_list_selfcontrol', $_POST['id_list_selfcontrol']);
        $this->db->from('pertanyaan_selfcontrol');
        if (($_POST["search"]["value"])) {
            $this->db->like('pertanyaan', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_columnSP[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'ASC');
        }
    }


    public function make_datatables_selfcontrol_pertanyaan()
    {
        $this->make_query_selfcontrol_pertanyaan();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_selfcontrol_pertanyaan()
    {
        $this->make_query_selfcontrol_pertanyaan();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_selfcontrol_pertanyaan()
    {
        $this->db->select("*");
        $this->db->from('pertanyaan_selfcontrol');
        return $this->db->count_all_results();
    }
    //end target pertanyaan

    public function ubah_status_selfcontrol_pertanyaan($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(
            'pertanyaan_selfcontrol',
            $data
        );
    }

    public function simpan_pertanyaan_selfcontrol($data)
    {
        $this->db->insert('pertanyaan_selfcontrol', $data);
    }
    public function ubah_status_pertanyaan_selfcontrol($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(
            'pertanyaan_selfcontrol',
            $data
        );
    }

    //tabel selfcontrol jawaban
    var $order_columnSJ = array(null, 'judul', null, 'status', 'created_at', null);
    public function make_query_self_control_jawaban()
    {
        $this->db->select('*');
        $this->db->where('id_pertanyaan', $_POST['id_pertanyaan']);
        $this->db->from('jawaban_self_control');
        if (($_POST["search"]["value"])) {
            $this->db->like('jawaban', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_columnSJ[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'ASC');
        }
    }


    public function make_datatables_self_control_jawaban()
    {
        $this->make_query_self_control_jawaban();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_self_control_jawaban()
    {
        $this->make_query_self_control_jawaban();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_self_control_jawaban()
    {
        $this->db->select("*");
        $this->db->from('jawaban_self_control');
        return $this->db->count_all_results();
    }
    //end selfcontrol jawaban

    // selfcontrol jawaban
    public function simpan_list_self_control_jawaban($data)
    {
        $this->db->insert('jawaban_self_control', $data);
    }
    public function ubah_status_self_control_jawaban($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(
            'jawaban_self_control',
            $data
        );
    }

    public function fetch_all_jawaban_self_control($id)
    {
        $this->db->where('id_pertanyaan', $id);
        $query = $this->db->get('jawaban_self_control');
        return $query->result();
    }

    public function simpan_jawaban_betul_self_control($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(
            'pertanyaan_selfcontrol',
            $data
        );
    }

    var $order_columnT = array(
        null, 'judul', null, 'status', 'created_at', null
    );
    public function make_query_list_terapi()
    {
        $this->db->select('*');
        // $this->db->where('id_terapi', $_POST['id_metode']);
        $this->db->from('list_terapi');
        if (($_POST["search"]["value"])) {
            $this->db->like('keterangan', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_columnT[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'ASC');
        }
    }


    public function make_datatables_list_terapi()
    {
        $this->make_query_list_terapi();

        if (
            $_POST["length"] != -1
        ) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_list_terapi()
    {
        $this->make_query_list_terapi();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_list_terapi()
    {
        $this->db->select("*");
        $this->db->from('list_terapi');
        return $this->db->count_all_results();
    }
    //end terapi

    public function simpan_list_terapi($data)
    {
        $this->db->insert('list_terapi', $data);
    }

    public function ubah_status_list_terapi(
        $data,
        $id
    ) {
        $this->db->where('id', $id);
        $this->db->update(
            'list_terapi',
            $data
        );
    }

    //tabel kuesioner
    var $order_columnSCK = array(
        null, 'judul', null, 'status', 'created_at', null
    );
    public function make_query_kuesioner()
    {
        // $id_pasien = $_POST['idpasien'];
        $this->db->select('*');
        // $this->db->where('jenis_layanan', 2);
        $this->db->from('kuesioner');
        if (($_POST["search"]["value"])) {
            $this->db->like('deskripsi', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_columnSCK[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'ASC');
        }
    }


    public function make_datatables_kuesioner()
    {
        $this->make_query_kuesioner();

        if (
            $_POST["length"] != -1
        ) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_kuesioner()
    {
        $this->make_query_kuesioner();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_kuesioner()
    {
        $this->db->select("*");
        $this->db->from('kuesioner');
        return $this->db->count_all_results();
    }
    //end kuesioner
    public function simpan_kuesioner($data)
    {
        $this->db->insert('kuesioner', $data);
    }

    public function simpan_list_kuesioner($data)
    {
        $this->db->insert('list_kuesioner', $data);
    }

    //tabel lsit target
    var $order_columnLSK = array(
        null, 'judul', null, 'status', 'created_at', null
    );
    public function make_query_list_kuesioner()
    {
        $this->db->select('*');
        $this->db->where(
            'id_kuesioner',
            $_POST['id_kuesioner']
        );
        $this->db->from('list_kuesioner');
        if (($_POST["search"]["value"])) {
            $this->db->like('keterangan', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_columnLSK[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'ASC');
        }
    }


    public function make_datatables_list_kuesioner()
    {
        $this->make_query_list_kuesioner();

        if (
            $_POST["length"] != -1
        ) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_list_kuesioner()
    {
        $this->make_query_list_kuesioner();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_list_kuesioner()
    {
        $this->db->select("*");
        $this->db->from('list_kuesioner');
        return $this->db->count_all_results();
    }
    //end kuesioner

    public function ubah_status_list_kuesioner(
        $data,
        $id
    ) {
        $this->db->where('id', $id);
        $this->db->update(
            'list_kuesioner',
            $data
        );
    }

    //tabel kuesioner pertanyaan
    var $order_columnSPK = array(
        null, 'judul', null, 'status', 'created_at', null
    );
    public function make_query_kuesioner_pertanyaan()
    {
        $this->db->select('*');
        $this->db->where(
            'id_list_kuesioner',
            $_POST['id_list_kuesioner']
        );
        $this->db->from('pertanyaan_kuesioner');
        if (($_POST["search"]["value"])) {
            $this->db->like('pertanyaan', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_columnSPK[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'ASC');
        }
    }


    public function make_datatables_kuesioner_pertanyaan()
    {
        $this->make_query_kuesioner_pertanyaan();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_kuesioner_pertanyaan()
    {
        $this->make_query_kuesioner_pertanyaan();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_kuesioner_pertanyaan()
    {
        $this->db->select("*");
        $this->db->from('pertanyaan_kuesioner');
        return $this->db->count_all_results();
    }
    //end target pertanyaan

    public function ubah_status_kuesioner_pertanyaan($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(
            'pertanyaan_kuesioner',
            $data
        );
    }

    public function simpan_pertanyaan_kuesioner($data)
    {
        $this->db->insert('pertanyaan_kuesioner', $data);
    }
    public function ubah_status_pertanyaan_kuesioner($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(
            'pertanyaan_kuesioner',
            $data
        );
    }

    //tabel kuesioner jawaban
    var $order_columnSJK = array(
        null, 'judul', null, 'status', 'created_at', null
    );
    public function make_query_kuesioner_jawaban()
    {
        $this->db->select('*');
        $this->db->where('id_pertanyaan', $_POST['id_pertanyaan']);
        $this->db->from('jawaban_kuesioner');
        if (($_POST["search"]["value"])) {
            $this->db->like('jawaban', $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_columnSJK[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'ASC');
        }
    }


    public function make_datatables_kuesioner_jawaban()
    {
        $this->make_query_kuesioner_jawaban();

        if (
            $_POST["length"] != -1
        ) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_kuesioner_jawaban()
    {
        $this->make_query_kuesioner_jawaban();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data_kuesioner_jawaban()
    {
        $this->db->select("*");
        $this->db->from('jawaban_kuesioner');
        return $this->db->count_all_results();
    }
    //end kuesioner jawaban

    // kuesioner jawaban
    public function simpan_list_kuesioner_jawaban($data)
    {
        $this->db->insert('jawaban_kuesioner', $data);
    }
    public function ubah_status_kuesioner_jawaban($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(
            'jawaban_kuesioner',
            $data
        );
    }
}
