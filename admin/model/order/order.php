<?php
class ModelOrderOrder extends Model {

	public function delete_order($order_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_image WHERE order_id = '" . (int)$order_id . "'");
	}

	public function get_list_order($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "order_image";

		$implode = array();

		if (!empty($data['filter_name'])) {
			$implode[] = "name like '%".$data['filter_name']."%'";
		}

		if (!empty($data['filter_telephone'])) {
			$implode[] = "telephone like '%".$data['filter_telephone']."%'";
		}

		if($implode)
		{
			$sql .= " where " . implode(" and ", $implode);
		}

		$sort_data = array(
			'name',
			'address',
			'telephone',
			'date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY date_added";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
	public function get_total_order($data = array()) {
		$sql = "SELECT count(*) as total FROM " . DB_PREFIX . "order_image";

		$implode = array();

		if (!empty($data['filter_name'])) {
			$implode[] = "name like '%".$data['filter_name']."%'";
		}

		if (!empty($data['filter_telephone'])) {
			$implode[] = "telephone like '%".$data['filter_telephone']."%'";
		}

		if($implode)
		{
			$sql .= " where " . implode(" and ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
}