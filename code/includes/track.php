<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of track
 *
 * @author Luis
 */
class track
{
    private $trackId;
    //private $boardId;
    private $title;
    private $description;
    
    public function createTrack($trackArray)
    {
        $this->title = $trackArray['title'];
        $this->desc = $trackArray['desc'];
        $sqlObj = new DataBase();
        $query = "INSERT INTO  `db_tackster`.`track` (
                    `id` ,
                    `title` ,
                    `description`
                )
                VALUES (
                    NULL ,  '$this->title',  '$this->description'
                );";
        $sqlObj->destroy();        
    }
    
    
    
    //put your code here
}

?>
