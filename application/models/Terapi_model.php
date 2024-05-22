 <?php
    class Terapi_model extends CI_Model
    {
        public function simpan_akses_selfcontrol($data)
        {
            $this->db->insert('akses_selfcontrol', $data);
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

        public function simpan_akses_terapi($data)
        {
            $this->db->insert('akses_terapi', $data);
        }

        public function fetch_single_konten($id)
        {
            $this->db->where('list_terapi.id', $id);
            // $this->db->join('list_konten_edukasi', 'list_konten_edukasi.id_edukasi = konten_edukasi.id', 'LEFT');
            $query = $this->db->get('list_terapi');
            return $query->result();
        }
    }
    ?>