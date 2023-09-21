<?php
function AllTestBySector($sectors,$sectorCurrentUser,$valueGet){
    $sectorTest = [];
    if( $sectors ):
        foreach( $sectors as $sector ):
            $sectorTest[] = $sector->ID;
            $SectorsParentId = wp_get_post_parent_id($sector->ID);
        endforeach;
    endif;
    $sectorTest = (sizeof($sectorTest) == 0) ? $valueGet['arrayAllSector'] : $sectorTest;
    $has_sector = false;
    foreach ($sectorCurrentUser as $s)
    {
        if (in_array($s, $sectorTest)) $has_sector = true;
        if($has_sector) break;
    }
    return array('has_sector' => $has_sector);
}