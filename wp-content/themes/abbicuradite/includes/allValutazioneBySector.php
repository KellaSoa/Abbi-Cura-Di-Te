<?php
function allValutazioneBySector($sectors,$sectorCurrentUser,$valueGet,$post_id){
    $sectorTest = [];
    if( $sectors ):
        foreach( $sectors as $sector ):
            $sectorTest[] = $sector->ID;
        endforeach;
    endif;
    //$sectorTest = (sizeof($sectorTest) == 0) ? $valueGet['arrayAllSector'] : $sectorTest;
    $has_sector = false;
    foreach ($sectorCurrentUser as $s)
    {
        if (in_array($s, $sectorTest))
            $has_sector = true;
        if($has_sector) break;
    }
    return array('has_sector' => $has_sector, 'postId'=>$post_id);

}