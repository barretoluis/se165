<?php
class DataBase
{
	private $mysqli;
        private $result;
        private $returnSet = array();
	public function __construct($h = "localhost", $u = "tackster", 
                                    $p = "4tackster2use", $n = "db_tackster")
	{
                 $this->mysqli = mysqli_connect($h, $u, $p, $n);
                 if(!$this->mysqli)
                 {
                     echo "Unable to connect".mysqli_error($this->mysqli);
                 }
                 else
                 {
                    // echo "Connected to DB server";
                 }
                 
	}
	public function destroy()
	{
		$this->mysqli->close();
	}
	public function DoQuery($query)
	{
		//$result = $mysqli->query($query);
                $this->result = mysqli_query($this->mysqli, $query);
                if (!$this->result)
                {
                    echo "Couldn not run Query ($query)".mysqli_error($this->mysqli)."\n";
                }
                return mysqli_insert_id($this->mysqli);
                

	}

        public function GetData()
	{
            
            
                while($val = mysqli_fetch_assoc($this->result))
                {
                    //$returnSet[] = $val;
                    array_push($this->returnSet, $val);
                }
                    return $this->returnSet;
	}
        public function getNumberOfRecords()
        {
            return mysqli_num_rows($this->result);
        }
        
}
?>