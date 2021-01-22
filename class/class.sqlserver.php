<?php
require_once "class.base.php";
class SQLServer extends Base {
    private $conn = null;
    public function __construct() {
        $this->settable = false;
        $this->data = array('insert_id' => null, 'affected_rows' => null, 'last_error' => array());
		$serverName = "10.22.10.22";
              $data = array(
			 	                    "Database"=>"HIS",
									"UID"=>"admin",
									"PWD"=>"123",
							        "CharacterSet" => "UTF-8",
							);
        $conn = sqlsrv_connect($serverName, $data);
        sqlsrv_configure("WarningsReturnAsErrors", 0);
        if ($this->errors()) {
            echo '<pre>Error connecting to the base date! Details: ';
            var_dump($this->last_error);
            die;
        }

        $this->conn = $conn;

    }
    public function __destruct() {
        if (!is_null($this->conn)) {
            @sqlsrv_close($this->conn);

        }
    }
    private function errors() {
        if (($erros = sqlsrv_errors()) != null) {
           $_erros = array();
		   if(isset($_GET["debug"])){
			 print_r($erros);
		   }
            foreach ($erros as $_erro) {
                // Delete the error handling codes 5701 and 5703, as these
                // Information messages are sent during the connection, not errors
                if (!in_array($_erro['code'], array(5701, 5703)))
                    $_erros[] = $_erro;
            }
            $this->data['last_error'] = $_erros;
			//print_r($_erros);
            if (count($_erros) > 0)
                return true;
        }
    }
	/*$store_name="{call store_name(?, ?)}"
	// store_name name stored proc
	//(?, ?) number input/output parameter
	//$params = array(
                $n1,
				$n2,
               		);
	return $query
	*/

	   public function select_store( $store_name, $params ) {
        $query = sqlsrv_query($this->conn, $store_name, $params, array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
        if ($this->errors()) {
            return;
        }
        return $query;
		//sqlsrv_close($this->conn);
    }
	//chinh sua

	  public function query( $store_name, $params ) {

        $query = sqlsrv_query($this->conn, $store_name, $params);
        if ($this->errors()) {
			print_r($this->errors());
            return;
        }
        return $query;
		//sqlsrv_close($this->conn);
    }

	 public function begin_tran() {

			   if ( sqlsrv_begin_transaction( $this->conn ) === false )
		{
			 //echo "Could not begin transaction.\n";
			// die( print_r( sqlsrv_errors(), true ));
		}

    }
	 public function commit() {

		sqlsrv_commit( $this->conn );

    }

	 public function rollback() {

		sqlsrv_rollback( $this->conn );

    }



    public static function escape_string($str) {
        return str_replace("'", "''", $str);
    }
}

class SQLServerResult extends Base {

    /**
     * Index of the current result set
     * @var int
     */
    private $Currentindex = 0;
    /**
     * lines do result set
     * @var mixed[]
     */
    private $lines;

    /**
     * Fill in the fields of the class based on the results of the query
     *
     * @param resource $result O result a query of SQLSRV
     */
    public function __construct($result) {
        $this->settable = false; // disables change in pseudo-class members
        // populates the fields of the class based on the results
        $this->data = array(
            'num_rows' => sqlsrv_num_rows($result),
            'num_fields' => sqlsrv_num_fields($result),
            'has_rows' => sqlsrv_has_rows($result)
        );

        $this->fetch($result); // fills the array of results
    }

    /**
     * Cycles through all lines of the result and store in vector
     *
     * @ param resource $ result The result of a query of SQLSRV
     */
    private function fetch($result) {
        $lines =& $this->lines;

        $lines = array();
        while ($r = sqlsrv_fetch_array($result)) {
            $lines[] = $r;
        }

        sqlsrv_free_stmt($result); //frees the memory resource, since we will not need it again travels
    }

    /**
     * Returns an array containing all the results of the query, with fields shaped object
     *
     * @return stdClass [] An array with the results of the query in the form of object
     */
    public function get_as_object() {
        $lines = $this->lines;
        foreach ($lines as $i => $linha) {
            $lines[$i] = (object) $linha;
        }

        return $lines;
    }

    /**
     * Returns an array containing all the results of the query, with fields shaped array
     *
     * @ return mixed [] [] An array with the results of the query in the form of array
     */
    public function get_as_array() {
        return $this->lines;
    }

    /**
      * Simulates the operation of the function sqlsrv_fetch_array (), traversing the
      * Result set row by row. Returns the current line in the form of associative array.
      *
      * @ Return mixed The current row or false if there are no more records
      */
    public function fetch_array() {
        if ($this->Currentindex < $this->data['num_rows']) {
            $result = $this->lines[$this->Currentindex];
            $this->Currentindex++;

            return $result;
        } else {
            return false;
        }
    }

      /**
      * Simulates the operation of the function sqlsrv_fetch_array (), traversing the
      * Result set row by row. Returns the current line shaped of object.
      *
      * @ Return mixed The current row or false if there are no more records
      */
    public function fetch_object() {
        $row = $this->fetch_array();
        return $row ? (object) $row : false;
    }

    /**
      * Gets a row set and returns as associative array. Simulates the operation
      * The FETCH ABSOLUTE.
      *
      * @ Param int $ index The row to be selected
      * @ Return mixed An array with the fields of the row if it exists or null if the line is not set
      */
    public function get_row_as_array($index) {
        if ($index > 0 && $index < $this->data['num_rows']) {
            return $this->lines[$index];
        } else {
            return null;
        }
    }

      /**
      * Gets a row set and returns an object. Simulates the operation
      * The FETCH ABSOLUTE.
      *
      * @ Param int $ index The row to be selected
      * @ Return mixed An object with the fields of the row if it exists or null if the line is not set
      */
    public function get_row_as_object($index) {
        return (object) $this->get_row_as_array($index);
    }

      /**
      * Position the pointer inside the class (used in fetch_array ()) Given at the index.
      *
      * @ Param int $ index The new index pointer.
      * @ Return mixed False if the index is outside the bounds of the result set, otherwise the old position.
      */
    public function seek($index) {
        if ($index >= 0 && $index < $this->data['num_rows']) {
            $indexold = $this->Currentindex;
            $this->Currentindex = $index;

            return $indexold;
        } else {
            return false;
        }
    }

    /**
     * Position the pointer inside the class (used in fetch_array ()) in the first record.
      *
      * @ Return mixed The even seek ()
      */
    public function first() {
        return $this->seek(0);
    }

    /**
      * Position the pointer inside the class (used in fetch_array ()) on the last record.
      *
      * @ Return mixed The even seek ()
      */
    public function last() {
        return $this->seek($this->data['num_rows'] - 1);
    }

    /**
      * Returns the value of a field in the table, passing the row index and column index
      *
      * @ Param int $ row The row index set
      * @ Param int $ col The column index set
      * @ Return mixed The value of the field if it exists, null otherwise.
      */
    public function get_field($row, $col) {
        if ($row >= 0 && $row < $this->data['num_rows'] && $col >= 0 && $col < $this->data['num_fields']) {
            return $this->lines[$row][$col];
        } else {
            return null;
        }
    }

}

