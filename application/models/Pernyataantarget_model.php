 <?php
    class Pernyataantarget_model extends CI_Model
    {
        public function simpan_akses_taget($data)
        {
            $this->db->insert('akses_target', $data);
        }

        public function fetch_all_targets()
        {
            $query = $this->db->get('pernyataan_target');
            return $query->result();
        }

        //tabel akses target
        var $order_columnKE = array(null, 'judul', null, 'status', 'created_at', null);
        public function make_query_akses_target()
        {
            $this->db->select('
            akses_target.id,
            akses_target.status,
            akses_target.created_at,
            akses_target.updated_at,
            pernyataan_target.target
            ');
            $this->db->where('id_user', $_POST['id_user']);
            $this->db->from('akses_target');
            $this->db->join('pernyataan_target', 'pernyataan_target.id = akses_target.id_pernyataan_target', 'LEFT');
            if (($_POST["search"]["value"])) {
                $this->db->like('target', $_POST["search"]["value"]);
            }

            if (isset($_POST["order"])) {
                $this->db->order_by($this->order_columnKE[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } else {
                $this->db->order_by('akses_target.id', 'ASC');
            }
        }


        public function make_datatables_akses_target()
        {
            $this->make_query_akses_target();

            if ($_POST["length"] != -1) {
                $this->db->limit($_POST['length'], $_POST['start']);
            }
            $query = $this->db->get();
            return $query->result();
        }

        public function get_filtered_data_akses_target()
        {
            $this->make_query_akses_target();
            $query = $this->db->get();

            return $query->num_rows();
        }

        public function get_all_data_akses_target()
        {
            $this->db->select("*");
            $this->db->from('akses_target');
            return $this->db->count_all_results();
        }
        //end target

        public function ubah_status_akses_target($data, $id)
        {
            $this->db->where('id', $id);
            $this->db->update('akses_target', $data);
        }
    }
    ?>