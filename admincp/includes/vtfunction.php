<?php

function paging($total_rows,$max_rows,$cur_page){

    $max_pages=ceil($total_rows/$max_rows);
    $start=$cur_page-5; if($start<1)$start=1;
    $end=$cur_page+5;	if($end>$max_pages)$end=$max_pages;

    $paging='
	<form action="" method="post" name="frmpaging" id="frmpaging">
	<input type="hidden" name="txtCurnpage" id="txtCurnpage" value="1" />';
    $paging.='<ul>';
    if($cur_page >1) {
        $paging.='<li><a href="javascript:gotopage(1)"> << </a></li>';
        $paging.='<li><a href="javascript:gotopage('.($cur_page-1).')"> < </a></li>';
    }
       
    if($max_pages>1){
        for($i=$start;$i<=$end;$i++)
        {
            if($i!=$cur_page)
                $paging.="<li><a href=\"javascript:gotopage($i)\"> $i </a></li>";
            else
                $paging.="<li class=\"cur_page\"><a href=\"#\" > $i </a></li>";
        }
    }
    if($cur_page < $max_pages) {
        $paging.='<li><a href="javascript:gotopage('.($cur_page+1).')"> > </a></li>';
        $paging.='<li><a href="javascript:gotopage('.($max_pages).')"> >> </a></li>';   
    }
        
    $paging.='</ul></form>';
    echo $paging;
}

function un_unicode($str){
    $marTViet=array('(',')',' ','   ');

    $marKoDau=array('<','>','','');

    $str = str_replace($marTViet, $marKoDau, $str);
    return $str;
}

?>

