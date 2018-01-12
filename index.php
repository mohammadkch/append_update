    function appendUpdate($table_name, $table_name_import, $primarys_array, $fields_array, $step )
    {
        $all_fields = implode(',',$primarys_array).','.implode(',',$fields_array);
        $all_fields_array = explode(',',$all_fields);

        $query = $this->db->query("

			SELECT
				count(*) AS total_rows
			FROM
				$table_name_import
			WHERE
				1

		");

        if ($query->num_rows() == 1)
        {
            $result_array = $query->result_array();
            $total_rows = $result_array[0]['total_rows'];
        }
        else
        {
            return false ;
        }


        for ($i=0;$i<$total_rows;$i+=$step)
        {
            $values_array = array();

            $query = $this->db->query("

				SELECT
					$all_fields
				FROM
					$table_name_import
				WHERE
					1
				LIMIT $i,
				 $step
			");

            if ($query->num_rows()<1)
                break;

            $result_rowset = $query->result_array();
            $rowset_values_array = array();

            foreach ($result_rowset as $result_row)
            {
                $single_row_values_array = array();

                foreach ($all_fields_array as $field)
                {
                    if ($result_row[$field] == NULL)
                        $single_row_values_array[]=" NULL ";
                    else
                        $single_row_values_array[]="'".$result_row[$field]."'";
                }
                $rowset_values_array[] = '('.implode(',',$single_row_values_array).')';
            }

            $rowset_values_string = implode(',',$rowset_values_array);

            $update_array = array();

            foreach ($fields_array as $field)
            {
                $update_array[] = $field.' = VALUES ('.$field.')';
            }

            $update_string = implode(',', $update_array );

            $insert_query = $this->db->query("

				INSERT INTO $table_name (
					$all_fields
				)
				VALUES
					$rowset_values_string
				ON DUPLICATE KEY UPDATE
					$update_string
			");

            $insert_result = $query->result();
        }

        return $insert_result ;
    }
