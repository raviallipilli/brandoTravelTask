<?php
class Journey extends CI_Model
{
    function saverecords($startDate,$startTime)
    {
        $query="insert into journey (date,startTime) values ('".$startDate."','".$startTime."')";
        $this->db->query($query);
    }
}