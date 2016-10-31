<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Summary
 *
 * @author WEB
 */
class Summary extends BaseModel{
    
    public function getStackFlowRanges($gradePoints, $sets){
        foreach($sets as $keys => $values){
            $gradePoints->__setUnits($values->units);
            $sql    = 'SELECT * FROM Results WHERE matric="'.
                    $values->matric.'" AND course="'.$values->code.'"';
            $query  = new \Phalcon\Mvc\Model\Query($sql, $this->getDI());
            $result = $query->execute()->toArray();
            $score  = (int) $result['exam'] + (int) $result['ca'];
            $gradePoints->__gradeParser($score, $values->units, $values->code);
        }
        return $gradePoints;
    }
}
