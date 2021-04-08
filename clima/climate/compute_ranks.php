<?php

error_reporting(E_ALL ^ E_NOTICE); 

function avg($a){
    $a = array_filter($a);
    $average = array_sum($a)/count($a);
    return $average;
}

function csv_to_array($filename='', $delimiter, $head)
{
    if(!file_exists($filename) || !is_readable($filename))
        return FALSE;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
        {
            $data[] = array_combine($head, $row);
        }
        fclose($handle);
    }
    return $data;
}


$header_ranks = ["year","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
$header_climate = ["id","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

$states = ["A01"=>"Northern Greece","A02"=>"West Greece & Ionian Islands","A03"=>"Thessaly","A04"=>"Central Greece","A05"=>"Peloponnisos","A06"=>"Crete","A07"=>"Dodecanese & Aegean Islands"];

$A01_data = csv_to_array("ranks/A01.txt"," ",$header_ranks);
$A02_data = csv_to_array("ranks/A02.txt"," ",$header_ranks);
$A03_data = csv_to_array("ranks/A03.txt"," ",$header_ranks);
$A04_data = csv_to_array("ranks/A04.txt"," ",$header_ranks);
$A05_data = csv_to_array("ranks/A05.txt"," ",$header_ranks);
$A06_data = csv_to_array("ranks/A06.txt"," ",$header_ranks);
$A07_data = csv_to_array("ranks/A07.txt"," ",$header_ranks);

$current_data = csv_to_array("ranks/Tmax_area_data_2021.txt",";",$header_climate);

$fixed_array_ncl = ["A06","A01","A04","A05","A02","A07","A03"];

$months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

$date_now = date("m");
$year_now = date("Y");

if($date_now!="01"){
    $months_range = array_slice($months, 0, $date_now-1);
    $months_range_res = array_slice($months, $date_now-1, 11);
}else{
    $months_range = $months;
}



$current_data_A01 = $current_data[array_search("A01", array_column($current_data, 'id'))];
unset($current_data_A01["id"]);
$current_data_A02 = $current_data[array_search("A02", array_column($current_data, 'id'))];
unset($current_data_A02["id"]);
$current_data_A03 = $current_data[array_search("A03", array_column($current_data, 'id'))];
unset($current_data_A03["id"]);
$current_data_A04 = $current_data[array_search("A04", array_column($current_data, 'id'))];
unset($current_data_A04["id"]);
$current_data_A05 = $current_data[array_search("A05", array_column($current_data, 'id'))];
unset($current_data_A05["id"]);
$current_data_A06 = $current_data[array_search("A06", array_column($current_data, 'id'))];
unset($current_data_A06["id"]);
$current_data_A07 = $current_data[array_search("A07", array_column($current_data, 'id'))];
unset($current_data_A07["id"]);


for($i=0;$i<=sizeof($A01_data)-1;$i++){
    $years[$i]=$A01_data[$i]["year"];
    for($j=0;$j<=sizeof($months)-1;$j++){
        $sorted_A01[$months[$j]][$A01_data[$i]["year"]] = $A01_data[$i][$months[$j]];
        asort($sorted_A01[$months[$j]]);       
    }
}

print_r($sorted_A01["Jan"]);

for($i=0;$i<=sizeof($A02_data)-1;$i++){
    for($j=0;$j<=sizeof($months)-1;$j++){
        $sorted_A02[$months[$j]][$A02_data[$i]["year"]] = $A02_data[$i][$months[$j]];
        asort($sorted_A02[$months[$j]]);
    }
}

for($i=0;$i<=sizeof($A03_data)-1;$i++){
    for($j=0;$j<=sizeof($months)-1;$j++){
        $sorted_A03[$months[$j]][$A03_data[$i]["year"]] = $A03_data[$i][$months[$j]];
        asort($sorted_A03[$months[$j]]);
    }
}

for($i=0;$i<=sizeof($A04_data)-1;$i++){
    for($j=0;$j<=sizeof($months)-1;$j++){
        $sorted_A04[$months[$j]][$A04_data[$i]["year"]] = $A04_data[$i][$months[$j]];
        asort($sorted_A04[$months[$j]]);
    }
}

for($i=0;$i<=sizeof($A05_data)-1;$i++){
    for($j=0;$j<=sizeof($months)-1;$j++){
        $sorted_A05[$months[$j]][$A05_data[$i]["year"]] = $A05_data[$i][$months[$j]];
        asort($sorted_A05[$months[$j]]);
    }
}

for($i=0;$i<=sizeof($A06_data)-1;$i++){
    for($j=0;$j<=sizeof($months)-1;$j++){
        $sorted_A06[$months[$j]][$A06_data[$i]["year"]] = $A06_data[$i][$months[$j]];
        asort($sorted_A06[$months[$j]]);
    }
}

for($i=0;$i<=sizeof($A07_data)-1;$i++){
    for($j=0;$j<=sizeof($months)-1;$j++){
        $sorted_A07[$months[$j]][$A07_data[$i]["year"]] = $A07_data[$i][$months[$j]];
        asort($sorted_A07[$months[$j]]);
    }
}



for($i=0;$i<=sizeof($months)-1;$i++){
    $ranks_A01[$months[$i]] = array_keys($sorted_A01[$months[$i]]);
    arsort($ranks_A01[$months[$i]]);
    $ranks_A02[$months[$i]] = array_keys($sorted_A02[$months[$i]]);
    arsort($ranks_A02[$months[$i]]);
    $ranks_A03[$months[$i]] = array_keys($sorted_A03[$months[$i]]);
    arsort($ranks_A03[$months[$i]]);
    $ranks_A04[$months[$i]] = array_keys($sorted_A04[$months[$i]]);
    arsort($ranks_A04[$months[$i]]);
    $ranks_A05[$months[$i]] = array_keys($sorted_A05[$months[$i]]);
    arsort($ranks_A05[$months[$i]]);
    $ranks_A06[$months[$i]] = array_keys($sorted_A06[$months[$i]]);
    arsort($ranks_A06[$months[$i]]);
    $ranks_A07[$months[$i]] = array_keys($sorted_A07[$months[$i]]);
    arsort($ranks_A07[$months[$i]]);
}

for($i=0;$i<=sizeof($months_range_res)-1;$i++){
    $ranks_A01[$months_range_res[$i]]["9998"]=$year_now;
    unset($ranks_A01[$months_range_res[$i]][11]);
    $ranks_A02[$months_range_res[$i]]["9998"]=$year_now;
    unset($ranks_A02[$months_range_res[$i]][11]);
    $ranks_A03[$months_range_res[$i]]["9998"]=$year_now;
    unset($ranks_A03[$months_range_res[$i]][11]);
    $ranks_A04[$months_range_res[$i]]["9998"]=$year_now;
    unset($ranks_A04[$months_range_res[$i]][11]);
    $ranks_A05[$months_range_res[$i]]["9998"]=$year_now;
    unset($ranks_A05[$months_range_res[$i]][11]);
    $ranks_A06[$months_range_res[$i]]["9998"]=$year_now;
    unset($ranks_A06[$months_range_res[$i]][11]);
    $ranks_A07[$months_range_res[$i]]["9998"]=$year_now;
    unset($ranks_A07[$months_range_res[$i]][11]);

}

for($i=0;$i<=sizeof($months)-1;$i++){
    arsort($ranks_A01[$months[$i]]);
    arsort($ranks_A02[$months[$i]]);
    arsort($ranks_A03[$months[$i]]);
    arsort($ranks_A04[$months[$i]]);
    arsort($ranks_A05[$months[$i]]);
    arsort($ranks_A06[$months[$i]]);
    arsort($ranks_A07[$months[$i]]);
}





for($i=0;$i<=sizeof($years)-1;$i++){
    for($j=0;$j<=sizeof($months)-1;$j++){
        $ranks_A01_to_file[$i] = $years[$i]."   ".(array_keys($ranks_A01["Jan"])[$i]+1)."   ".(array_keys($ranks_A01["Feb"])[$i]+1)."   ".(array_keys($ranks_A01["Mar"])[$i]+1)."   ".(array_keys($ranks_A01["Apr"])[$i]+1)."   ".(array_keys($ranks_A01["May"])[$i]+1)."   ".(array_keys($ranks_A01["Jun"])[$i]+1)."   ".(array_keys($ranks_A01["Jul"])[$i]+1)."   ".(array_keys($ranks_A01["Aug"])[$i]+1)."   ".(array_keys($ranks_A01["Sep"])[$i]+1)."   ".(array_keys($ranks_A01["Oct"])[$i]+1)."   ".(array_keys($ranks_A01["Nov"])[$i]+1)."   ".(array_keys($ranks_A01["Dec"])[$i]+1);
        $ranks_A02_to_file[$i] = $years[$i]."   ".(array_keys($ranks_A02["Jan"])[$i]+1)."   ".(array_keys($ranks_A02["Feb"])[$i]+1)."   ".(array_keys($ranks_A02["Mar"])[$i]+1)."   ".(array_keys($ranks_A02["Apr"])[$i]+1)."   ".(array_keys($ranks_A02["May"])[$i]+1)."   ".(array_keys($ranks_A02["Jun"])[$i]+1)."   ".(array_keys($ranks_A02["Jul"])[$i]+1)."   ".(array_keys($ranks_A02["Aug"])[$i]+1)."   ".(array_keys($ranks_A02["Sep"])[$i]+1)."   ".(array_keys($ranks_A02["Oct"])[$i]+1)."   ".(array_keys($ranks_A02["Nov"])[$i]+1)."   ".(array_keys($ranks_A02["Dec"])[$i]+1);            
        $ranks_A03_to_file[$i] = $years[$i]."   ".(array_keys($ranks_A03["Jan"])[$i]+1)."   ".(array_keys($ranks_A03["Feb"])[$i]+1)."   ".(array_keys($ranks_A03["Mar"])[$i]+1)."   ".(array_keys($ranks_A03["Apr"])[$i]+1)."   ".(array_keys($ranks_A03["May"])[$i]+1)."   ".(array_keys($ranks_A03["Jun"])[$i]+1)."   ".(array_keys($ranks_A03["Jul"])[$i]+1)."   ".(array_keys($ranks_A03["Aug"])[$i]+1)."   ".(array_keys($ranks_A03["Sep"])[$i]+1)."   ".(array_keys($ranks_A03["Oct"])[$i]+1)."   ".(array_keys($ranks_A03["Nov"])[$i]+1)."   ".(array_keys($ranks_A03["Dec"])[$i]+1);            
        $ranks_A04_to_file[$i] = $years[$i]."   ".(array_keys($ranks_A04["Jan"])[$i]+1)."   ".(array_keys($ranks_A04["Feb"])[$i]+1)."   ".(array_keys($ranks_A04["Mar"])[$i]+1)."   ".(array_keys($ranks_A04["Apr"])[$i]+1)."   ".(array_keys($ranks_A04["May"])[$i]+1)."   ".(array_keys($ranks_A04["Jun"])[$i]+1)."   ".(array_keys($ranks_A04["Jul"])[$i]+1)."   ".(array_keys($ranks_A04["Aug"])[$i]+1)."   ".(array_keys($ranks_A04["Sep"])[$i]+1)."   ".(array_keys($ranks_A04["Oct"])[$i]+1)."   ".(array_keys($ranks_A04["Nov"])[$i]+1)."   ".(array_keys($ranks_A04["Dec"])[$i]+1);            
        $ranks_A05_to_file[$i] = $years[$i]."   ".(array_keys($ranks_A05["Jan"])[$i]+1)."   ".(array_keys($ranks_A05["Feb"])[$i]+1)."   ".(array_keys($ranks_A05["Mar"])[$i]+1)."   ".(array_keys($ranks_A05["Apr"])[$i]+1)."   ".(array_keys($ranks_A05["May"])[$i]+1)."   ".(array_keys($ranks_A05["Jun"])[$i]+1)."   ".(array_keys($ranks_A05["Jul"])[$i]+1)."   ".(array_keys($ranks_A05["Aug"])[$i]+1)."   ".(array_keys($ranks_A05["Sep"])[$i]+1)."   ".(array_keys($ranks_A05["Oct"])[$i]+1)."   ".(array_keys($ranks_A05["Nov"])[$i]+1)."   ".(array_keys($ranks_A05["Dec"])[$i]+1);            
        $ranks_A06_to_file[$i] = $years[$i]."   ".(array_keys($ranks_A06["Jan"])[$i]+1)."   ".(array_keys($ranks_A06["Feb"])[$i]+1)."   ".(array_keys($ranks_A06["Mar"])[$i]+1)."   ".(array_keys($ranks_A06["Apr"])[$i]+1)."   ".(array_keys($ranks_A06["May"])[$i]+1)."   ".(array_keys($ranks_A06["Jun"])[$i]+1)."   ".(array_keys($ranks_A06["Jul"])[$i]+1)."   ".(array_keys($ranks_A06["Aug"])[$i]+1)."   ".(array_keys($ranks_A06["Sep"])[$i]+1)."   ".(array_keys($ranks_A06["Oct"])[$i]+1)."   ".(array_keys($ranks_A06["Nov"])[$i]+1)."   ".(array_keys($ranks_A06["Dec"])[$i]+1);  
        $ranks_A07_to_file[$i] = $years[$i]."   ".(array_keys($ranks_A07["Jan"])[$i]+1)."   ".(array_keys($ranks_A07["Feb"])[$i]+1)."   ".(array_keys($ranks_A07["Mar"])[$i]+1)."   ".(array_keys($ranks_A07["Apr"])[$i]+1)."   ".(array_keys($ranks_A07["May"])[$i]+1)."   ".(array_keys($ranks_A07["Jun"])[$i]+1)."   ".(array_keys($ranks_A07["Jul"])[$i]+1)."   ".(array_keys($ranks_A07["Aug"])[$i]+1)."   ".(array_keys($ranks_A07["Sep"])[$i]+1)."   ".(array_keys($ranks_A07["Oct"])[$i]+1)."   ".(array_keys($ranks_A07["Nov"])[$i]+1)."   ".(array_keys($ranks_A07["Dec"])[$i]+1);                                  
    }
}

#for($i=0;$i<=sizeof($years)-1;$i++){
#    for($j=0;$j<=sizeof($months)-1;$j++){
#        $ranks_A01_to_file_table_year[$i] = (array_keys($sorted_A01_d["Jan"])[$i])."   ".(array_keys($sorted_A01_d["Feb"])[$i])."   ".(array_keys($sorted_A01_d["Mar"])[$i])."   ".(array_keys($sorted_A01_d["Apr"])[$i])."   ".(array_keys($sorted_A01_d["May"])[$i])."   ".(array_keys($sorted_A01_d["Jun"])[$i])."   ".(array_keys($sorted_A01_d["Jul"])[$i])."   ".(array_keys($sorted_A01_d["Aug"])[$i])."   ".(array_keys($sorted_A01_d["Sep"])[$i])."   ".(array_keys($sorted_A01_d["Oct"])[$i])."   ".(array_keys($sorted_A01_d["Nov"])[$i])."   ".(array_keys($sorted_A01_d["Dec"])[$i]);
#        $ranks_A01_to_file_table_val[$i] = (array_values($sorted_A01_d["Jan"])[$i])."   ".(array_values($sorted_A01_d["Feb"])[$i])."   ".(array_values($sorted_A01_d["Mar"])[$i])."   ".(array_values($sorted_A01_d["Apr"])[$i])."   ".(array_values($sorted_A01_d["May"])[$i])."   ".(array_values($sorted_A01_d["Jun"])[$i])."   ".(array_values($sorted_A01_d["Jul"])[$i])."   ".(array_values($sorted_A01_d["Aug"])[$i])."   ".(array_values($sorted_A01_d["Sep"])[$i])."   ".(array_values($sorted_A01_d["Oct"])[$i])."   ".(array_values($sorted_A01_d["Nov"])[$i])."   ".(array_values($sorted_A01_d["Dec"])[$i]);
#    }
#}

#print_r($ranks_A01_to_fileb);


file_put_contents('ranks/output_data/ranks_A01.txt', implode(PHP_EOL, $ranks_A01_to_file));
file_put_contents('ranks/output_data/ranks_A02.txt', implode(PHP_EOL, $ranks_A02_to_file));
file_put_contents('ranks/output_data/ranks_A03.txt', implode(PHP_EOL, $ranks_A03_to_file));
file_put_contents('ranks/output_data/ranks_A04.txt', implode(PHP_EOL, $ranks_A04_to_file));
file_put_contents('ranks/output_data/ranks_A05.txt', implode(PHP_EOL, $ranks_A05_to_file));
file_put_contents('ranks/output_data/ranks_A06.txt', implode(PHP_EOL, $ranks_A06_to_file));
file_put_contents('ranks/output_data/ranks_A07.txt', implode(PHP_EOL, $ranks_A07_to_file));

#file_put_contents('ranks/output_data/ranks_A01_years.txt', implode(PHP_EOL, $ranks_A01_to_file_table_year));
#file_put_contents('ranks/output_data/ranks_A07_val.txt', implode(PHP_EOL, $ranks_A01_to_file_table_val));


#compute data files for Rankings


?>

