<?php

error_reporting(E_ALL ^ E_NOTICE); 


function write_empty($val){  
    if(empty($val)){
        return "9999";
    }else{
        return bcdiv($val,1,1);
    }
}

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

$header_current = ["id","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","name"];
$header_climate = ["name","id","area","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","lat","lon"];

$states = ["A01"=>"Northern Greece","A02"=>"West Greece & Ionian Islands","A03"=>"Thessaly","A04"=>"Central Greece","A05"=>"Peloponnisos","A06"=>"Crete","A07"=>"Dodecanese & Aegean Islands"];

$climate_data = csv_to_array("climate_2010_2019.csv",";",$header_climate);
$current_data = csv_to_array("clima_month_Tmax_current_m.txt","	",$header_current);
$fixed_array_ncl = ["A04","A02","A03","A06","A07","A05","A01"];

$months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

$date_now = date("m");
$year_now = date("Y");

if($date_now!="01"){
    $months_range = array_slice($months, 0, $date_now-1);
    $months_range_res = array_slice($months, $date_now-1, 11);
}else{
    $months_range = $months;
}

#---------compute Month_data_climateAVG(2010-2019) from fixed .csv file (climate_2010_2019.csv)
#---------compute Current_data_climateAVG(current month) from .txt file (clima_month_Tmax_current.txt)
#---------if station has missing values, compute avg climate without this stations for each area
for($i=0;$i<sizeof($climate_data);$i++){
    $names[$i] = $climate_data[$i]["name"];
    $areas[$i] = $climate_data[$i]["area"];
    $areas_station[$i] = $climate_data[$i]["area"];
    $ids[$i] = $climate_data[$i]["id"];
    $lats[$i] = $climate_data[$i]["lat"];
    $lons[$i] = $climate_data[$i]["lon"];
    for($j=0;$j<sizeof($months);$j++){        
        if($climate_data[$i]["area"]=="A01" && $current_data[$i][$months[$j]]!=9999){
            $Month_data_climate["A01"][$months[$j]][$i] = $climate_data[$i][$months[$j]];
            $Current_data_climate["A01"][$months[$j]][$i] = $current_data[$i][$months[$j]];
        }else if($climate_data[$i]["area"]=="A02" && $current_data[$i][$months[$j]]!=9999){
            $Month_data_climate["A02"][$months[$j]][$i] = $climate_data[$i][$months[$j]];
            $Current_data_climate["A02"][$months[$j]][$i] = $current_data[$i][$months[$j]];
        }else if($climate_data[$i]["area"]=="A03" && $current_data[$i][$months[$j]]!=9999){
            $Month_data_climate["A03"][$months[$j]][$i] = $climate_data[$i][$months[$j]];
            $Current_data_climate["A03"][$months[$j]][$i] = $current_data[$i][$months[$j]];
        }else if($climate_data[$i]["area"]=="A04" && $current_data[$i][$months[$j]]!=9999){
            $Month_data_climate["A04"][$months[$j]][$i] = $climate_data[$i][$months[$j]];
            $Current_data_climate["A04"][$months[$j]][$i] = $current_data[$i][$months[$j]];
        }else if($climate_data[$i]["area"]=="A05" && $current_data[$i][$months[$j]]!=9999){
            $Month_data_climate["A05"][$months[$j]][$i] = $climate_data[$i][$months[$j]];
            $Current_data_climate["A05"][$months[$j]][$i] = $current_data[$i][$months[$j]];
        }else if($climate_data[$i]["area"]=="A06" && $current_data[$i][$months[$j]]!=9999){
            $Month_data_climate["A06"][$months[$j]][$i] = $climate_data[$i][$months[$j]];
            $Current_data_climate["A06"][$months[$j]][$i] = $current_data[$i][$months[$j]];
        }else if($climate_data[$i]["area"]=="A07" && $current_data[$i][$months[$j]]!=9999){
            $Month_data_climate["A07"][$months[$j]][$i] = $climate_data[$i][$months[$j]];
            $Current_data_climate["A07"][$months[$j]][$i] = $current_data[$i][$months[$j]];
        }
    }
}

#---------Compute deviation for areas (A01, A02, A03, A04, A05, A06, A07)

for($i=0;$i<sizeof($climate_data);$i++){
    for($j=0;$j<sizeof($months_range);$j++){
        if($climate_data[$i]["area"]=="A01"){
            $sd_areas["A01"][$months[$j]] = (avg($Current_data_climate["A01"][$months[$j]]) - avg($Month_data_climate["A01"][$months[$j]]));
            $area_values["A01"]["year"]=$year_now;
            $area_values["A01"][$months[$j]] = bcdiv(avg($Current_data_climate["A01"][$months[$j]]),1,1);
        }else if($climate_data[$i]["area"]=="A02"){
            $sd_areas["A02"][$months[$j]] = (avg($Current_data_climate["A02"][$months[$j]]) - avg($Month_data_climate["A02"][$months[$j]]));
            $area_values["A02"]["year"]=$year_now;
            $area_values["A02"][$months[$j]] = bcdiv(avg($Current_data_climate["A02"][$months[$j]]),1,1); 	
        }else if($climate_data[$i]["area"]=="A03"){
            $sd_areas["A03"][$months[$j]] = (avg($Current_data_climate["A03"][$months[$j]]) - avg($Month_data_climate["A03"][$months[$j]]));
            $area_values["A03"]["year"]=$year_now;
            $area_values["A03"][$months[$j]] = bcdiv(avg($Current_data_climate["A03"][$months[$j]]),1,1); 	
        }else if($climate_data[$i]["area"]=="A04"){
            $sd_areas["A04"][$months[$j]] = (avg($Current_data_climate["A04"][$months[$j]]) - avg($Month_data_climate["A04"][$months[$j]]));
            $area_values["A04"]["year"]=$year_now;
            $area_values["A04"][$months[$j]] = bcdiv(avg($Current_data_climate["A04"][$months[$j]]),1,1); 	
        }else if($climate_data[$i]["area"]=="A05"){
            $sd_areas["A05"][$months[$j]] = (avg($Current_data_climate["A05"][$months[$j]]) - avg($Month_data_climate["A05"][$months[$j]]));
            $area_values["A05"]["year"]=$year_now;
            $area_values["A05"][$months[$j]] = bcdiv(avg($Current_data_climate["A05"][$months[$j]]),1,1); 	
        }else if($climate_data[$i]["area"]=="A06"){
            $sd_areas["A06"][$months[$j]] = (avg($Current_data_climate["A06"][$months[$j]]) - avg($Month_data_climate["A06"][$months[$j]]));
            $area_values["A06"]["year"]=$year_now;
            $area_values["A06"][$months[$j]] = bcdiv(avg($Current_data_climate["A06"][$months[$j]]),1,1); 	
        }else if($climate_data[$i]["area"]=="A07"){
            $sd_areas["A07"][$months[$j]] = (avg($Current_data_climate["A07"][$months[$j]]) - avg($Month_data_climate["A07"][$months[$j]]));
            $area_values["A07"]["year"]=$year_now;
            $area_values["A07"][$months[$j]] = bcdiv(avg($Current_data_climate["A07"][$months[$j]]),1,1); 	
        }
    }
}
#print_r($area_values["A07"]);

#---------Compute deviation for every station-every month, when value 9999 => no data, yet
for($i=0;$i<sizeof($climate_data);$i++){
    for($j=0;$j<sizeof($months);$j++){
        if($current_data[$i][$months[$j]]!=9999){
            $sd_stations[$current_data[$i]["name"]][$months[$j]] = $current_data[$i][$months[$j]] - $climate_data[$i][$months[$j]];
        }else{
            $sd_stations[$current_data[$i]["name"]][$months[$j]] = 9999;
        }
    }
}

#---------Make array to write deviation for areas .txt
for($i=0;$i<sizeof($sd_areas);$i++){
    for($j=0;$j<sizeof($months);$j++){
        $d_Tmax_areas_data[$i] = array_keys($sd_areas)[$i]."   ".$states[array_keys($sd_areas)[$i]]."   ".write_empty($sd_areas[array_keys($sd_areas)[$i]][$months[0]])."   ".write_empty($sd_areas[$areas[$i]][$months[1]])."   ".write_empty($sd_areas[$areas[$i]][$months[2]])."   ".write_empty($sd_areas[$areas[$i]][$months[3]])."   ".write_empty($sd_areas[$areas[$i]][$months[4]])."   ".write_empty($sd_areas[$areas[$i]][$months[5]])."   ".write_empty($sd_areas[$areas[$i]][$months[6]])."   ".write_empty($sd_areas[$areas[$i]][$months[7]])."   ".write_empty($sd_areas[$areas[$i]][$months[8]])."   ".write_empty($sd_areas[$areas[$i]][$months[9]])."   ".write_empty($sd_areas[$areas[$i]][$months[10]])."   ".write_empty($sd_areas[$areas[$i]][$months[11]]);
    }        
}


#---------Make array to write deviation for areas the previous month. This file is readed from NCL code to plot choropleth maps.
for($i=0;$i<sizeof($sd_areas);$i++){
    for($j=0;$j<sizeof($months_range);$j++){
        $all_sd_areas_data_previous_month[$i] = $fixed_array_ncl[$i].";".$states[$fixed_array_ncl[$i]].";".round($sd_areas[$fixed_array_ncl[$i]][$months[$j]],1).";".sizeof($Current_data_climate[$fixed_array_ncl[$i]][$months[$j]]);
    }        
}

#---------Make array to write deviation for stations .txt

for($i=0;$i<sizeof($sd_stations);$i++){
    for($j=0;$j<sizeof($months);$j++){    
        $d_Tmax_stations_data[$ids[$i]] = $areas_station[$i]."   ".$ids[$i]."   ".$lats[$i]."   ".$lons[$i]."   ".$names[$i]."   ".$states[$areas[$i]]."   ".round($sd_stations[$names[$i]][$months[0]],1)."   ".round($sd_stations[$names[$i]][$months[1]],1)."   ".round($sd_stations[$names[$i]][$months[2]],1)."   ".round($sd_stations[$names[$i]][$months[3]],1)."   ".round($sd_stations[$names[$i]][$months[4]],1)."   ".round($sd_stations[$names[$i]][$months[5]],1)."   ".round($sd_stations[$names[$i]][$months[6]],1)."   ".round($sd_stations[$names[$i]][$months[7]],1)."   ".round($sd_stations[$names[$i]][$months[8]],1)."   ".round($sd_stations[$names[$i]][$months[9]],1)."   ".round($sd_stations[$names[$i]][$months[10]],1)."   ".round($sd_stations[$names[$i]][$months[11]],1);
    }        
}

#---------Make array to write deviation for stations, previous month for archive .txt

for($i=0;$i<sizeof($sd_stations);$i++){
    for($j=0;$j<sizeof($months_range);$j++){    
        $d_Tmax_stations_month[$ids[$i]] = $areas_station[$i]."   ".$ids[$i]."   ".$lats[$i]."   ".$lons[$i]."   ".$names[$i]."   ".$states[$areas[$i]]."   ".round($sd_stations[$names[$i]][$months[$j]],1);
    }        
}

#---------Make array to write deviation for areas the last month for archive .txt
for($i=0;$i<sizeof($sd_areas);$i++){
    for($j=0;$j<sizeof($months_range);$j++){
        $d_Tmax_areas_month[$i] = array_keys($sd_areas)[$i]."   ".$states[array_keys($sd_areas)[$i]]."   ".round($sd_areas[array_keys($sd_areas)[$i]][$months[$j]],1);
    }        
}



#---------Make array to write values for areas .txt
for($i=0;$i<sizeof($area_values);$i++){
    for($j=0;$j<sizeof($months);$j++){
        $area_Tmax_values[$i] = array_keys($area_values)[$i].";".write_empty($area_values[array_keys($area_values)[$i]][$months[0]]).";".write_empty($area_values[$areas[$i]][$months[1]]).";".write_empty($area_values[$areas[$i]][$months[2]]).";".write_empty($area_values[$areas[$i]][$months[3]]).";".write_empty($area_values[$areas[$i]][$months[4]]).";".write_empty($area_values[$areas[$i]][$months[5]]).";".write_empty($area_values[$areas[$i]][$months[6]]).";".write_empty($area_values[$areas[$i]][$months[7]]).";".write_empty($area_values[$areas[$i]][$months[8]]).";".write_empty($area_values[$areas[$i]][$months[9]]).";".write_empty($area_values[$areas[$i]][$months[10]]).";".write_empty($area_values[$areas[$i]][$months[11]]);
    }        
}


sort($d_Tmax_stations_data);
sort($d_Tmax_stations_month);


#-----------export data .txt files


#print_r($area_values);

file_put_contents('output_data/d_Tmax_stations_data.txt', implode(PHP_EOL, $d_Tmax_stations_data));
file_put_contents('ranks/Tmax_area_data_'.date('Y').'.txt', implode(PHP_EOL, $area_Tmax_values));
file_put_contents('output_data/d_Tmax_areas_data.txt', implode(PHP_EOL, $d_Tmax_areas_data));
file_put_contents('C:/Users/norton/Desktop/NCL/regions/'.date('m-y', strtotime('last month')).'.txt', implode(PHP_EOL, $all_sd_areas_data_previous_month));
file_put_contents('output_data/d_Tmax_stations_'.date('m-y', strtotime('last month')).'.txt', implode(PHP_EOL, $d_Tmax_stations_month));
file_put_contents('output_data/d_Tmax_areas_'.date('m-y', strtotime('last month')).'.txt', implode(PHP_EOL, $d_Tmax_areas_month));


#compute files for ranking

$header_ranks = ["year","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];



$previous_data_A01 = csv_to_array("ranks/rank_data/A01.txt"," ",$header_ranks);
$previous_data_A02 = csv_to_array("ranks/rank_data/A02.txt"," ",$header_ranks);
$previous_data_A03 = csv_to_array("ranks/rank_data/A03.txt"," ",$header_ranks);
$previous_data_A04 = csv_to_array("ranks/rank_data/A04.txt"," ",$header_ranks);
$previous_data_A05 = csv_to_array("ranks/rank_data/A05.txt"," ",$header_ranks);
$previous_data_A06 = csv_to_array("ranks/rank_data/A06.txt"," ",$header_ranks);
$previous_data_A07 = csv_to_array("ranks/rank_data/A07.txt"," ",$header_ranks);


for($i=0;$i<=sizeof($months_range_res)-1;$i++){
    if($date_now!="01"){
        $area_values["A01"][$months_range_res[$i]] = "9999"; 
        $area_values["A02"][$months_range_res[$i]] = "9999"; 
        $area_values["A03"][$months_range_res[$i]] = "9999"; 
        $area_values["A04"][$months_range_res[$i]] = "9999"; 
        $area_values["A05"][$months_range_res[$i]] = "9999"; 
        $area_values["A06"][$months_range_res[$i]] = "9999"; 
        $area_values["A07"][$months_range_res[$i]] = "9999"; 
    }
}

array_unshift($previous_data_A01, $area_values["A01"]);
array_unshift($previous_data_A02, $area_values["A02"]);
array_unshift($previous_data_A03, $area_values["A03"]);
array_unshift($previous_data_A04, $area_values["A04"]);
array_unshift($previous_data_A05, $area_values["A05"]);
array_unshift($previous_data_A06, $area_values["A06"]);
array_unshift($previous_data_A07, $area_values["A07"]);



for($i=0;$i<sizeof($previous_data_A01);$i++){
    $area_A01_for_rank[$i] = $previous_data_A01[$i]["year"]." ".write_empty($previous_data_A01[array_keys($previous_data_A01)[$i]][$months[0]])." ".write_empty($previous_data_A01[array_keys($previous_data_A01)[$i]][$months[1]])." ".write_empty($previous_data_A01[array_keys($previous_data_A01)[$i]][$months[2]])." ".write_empty($previous_data_A01[array_keys($previous_data_A01)[$i]][$months[3]])." ".write_empty($previous_data_A01[array_keys($previous_data_A01)[$i]][$months[4]])." ".write_empty($previous_data_A01[array_keys($previous_data_A01)[$i]][$months[5]])." ".write_empty($previous_data_A01[array_keys($previous_data_A01)[$i]][$months[6]])." ".write_empty($previous_data_A01[array_keys($previous_data_A01)[$i]][$months[7]])." ".write_empty($previous_data_A01[array_keys($previous_data_A01)[$i]][$months[8]])." ".write_empty($previous_data_A01[array_keys($previous_data_A01)[$i]][$months[9]])." ".write_empty($previous_data_A01[array_keys($previous_data_A01)[$i]][$months[10]])." ".write_empty($previous_data_A01[array_keys($previous_data_A01)[$i]][$months[11]]);
    $area_A02_for_rank[$i] = $previous_data_A02[$i]["year"]." ".write_empty($previous_data_A02[array_keys($previous_data_A02)[$i]][$months[0]])." ".write_empty($previous_data_A02[array_keys($previous_data_A02)[$i]][$months[1]])." ".write_empty($previous_data_A02[array_keys($previous_data_A02)[$i]][$months[2]])." ".write_empty($previous_data_A02[array_keys($previous_data_A02)[$i]][$months[3]])." ".write_empty($previous_data_A02[array_keys($previous_data_A02)[$i]][$months[4]])." ".write_empty($previous_data_A02[array_keys($previous_data_A02)[$i]][$months[5]])." ".write_empty($previous_data_A02[array_keys($previous_data_A02)[$i]][$months[6]])." ".write_empty($previous_data_A02[array_keys($previous_data_A02)[$i]][$months[7]])." ".write_empty($previous_data_A02[array_keys($previous_data_A02)[$i]][$months[8]])." ".write_empty($previous_data_A02[array_keys($previous_data_A02)[$i]][$months[9]])." ".write_empty($previous_data_A02[array_keys($previous_data_A02)[$i]][$months[10]])." ".write_empty($previous_data_A02[array_keys($previous_data_A02)[$i]][$months[11]]);
    $area_A03_for_rank[$i] = $previous_data_A03[$i]["year"]." ".write_empty($previous_data_A03[array_keys($previous_data_A03)[$i]][$months[0]])." ".write_empty($previous_data_A03[array_keys($previous_data_A03)[$i]][$months[1]])." ".write_empty($previous_data_A03[array_keys($previous_data_A03)[$i]][$months[2]])." ".write_empty($previous_data_A03[array_keys($previous_data_A03)[$i]][$months[3]])." ".write_empty($previous_data_A03[array_keys($previous_data_A03)[$i]][$months[4]])." ".write_empty($previous_data_A03[array_keys($previous_data_A03)[$i]][$months[5]])." ".write_empty($previous_data_A03[array_keys($previous_data_A03)[$i]][$months[6]])." ".write_empty($previous_data_A03[array_keys($previous_data_A03)[$i]][$months[7]])." ".write_empty($previous_data_A03[array_keys($previous_data_A03)[$i]][$months[8]])." ".write_empty($previous_data_A03[array_keys($previous_data_A03)[$i]][$months[9]])." ".write_empty($previous_data_A03[array_keys($previous_data_A03)[$i]][$months[10]])." ".write_empty($previous_data_A03[array_keys($previous_data_A03)[$i]][$months[11]]);
    $area_A04_for_rank[$i] = $previous_data_A04[$i]["year"]." ".write_empty($previous_data_A04[array_keys($previous_data_A04)[$i]][$months[0]])." ".write_empty($previous_data_A04[array_keys($previous_data_A04)[$i]][$months[1]])." ".write_empty($previous_data_A04[array_keys($previous_data_A04)[$i]][$months[2]])." ".write_empty($previous_data_A04[array_keys($previous_data_A04)[$i]][$months[3]])." ".write_empty($previous_data_A04[array_keys($previous_data_A04)[$i]][$months[4]])." ".write_empty($previous_data_A04[array_keys($previous_data_A04)[$i]][$months[5]])." ".write_empty($previous_data_A04[array_keys($previous_data_A04)[$i]][$months[6]])." ".write_empty($previous_data_A04[array_keys($previous_data_A04)[$i]][$months[7]])." ".write_empty($previous_data_A04[array_keys($previous_data_A04)[$i]][$months[8]])." ".write_empty($previous_data_A04[array_keys($previous_data_A04)[$i]][$months[9]])." ".write_empty($previous_data_A04[array_keys($previous_data_A04)[$i]][$months[10]])." ".write_empty($previous_data_A04[array_keys($previous_data_A04)[$i]][$months[11]]);
    $area_A05_for_rank[$i] = $previous_data_A05[$i]["year"]." ".write_empty($previous_data_A05[array_keys($previous_data_A05)[$i]][$months[0]])." ".write_empty($previous_data_A05[array_keys($previous_data_A05)[$i]][$months[1]])." ".write_empty($previous_data_A05[array_keys($previous_data_A05)[$i]][$months[2]])." ".write_empty($previous_data_A05[array_keys($previous_data_A05)[$i]][$months[3]])." ".write_empty($previous_data_A05[array_keys($previous_data_A05)[$i]][$months[4]])." ".write_empty($previous_data_A05[array_keys($previous_data_A05)[$i]][$months[5]])." ".write_empty($previous_data_A05[array_keys($previous_data_A05)[$i]][$months[6]])." ".write_empty($previous_data_A05[array_keys($previous_data_A05)[$i]][$months[7]])." ".write_empty($previous_data_A05[array_keys($previous_data_A05)[$i]][$months[8]])." ".write_empty($previous_data_A05[array_keys($previous_data_A05)[$i]][$months[9]])." ".write_empty($previous_data_A05[array_keys($previous_data_A05)[$i]][$months[10]])." ".write_empty($previous_data_A05[array_keys($previous_data_A05)[$i]][$months[11]]);
    $area_A06_for_rank[$i] = $previous_data_A06[$i]["year"]." ".write_empty($previous_data_A06[array_keys($previous_data_A06)[$i]][$months[0]])." ".write_empty($previous_data_A06[array_keys($previous_data_A06)[$i]][$months[1]])." ".write_empty($previous_data_A06[array_keys($previous_data_A06)[$i]][$months[2]])." ".write_empty($previous_data_A06[array_keys($previous_data_A06)[$i]][$months[3]])." ".write_empty($previous_data_A06[array_keys($previous_data_A06)[$i]][$months[4]])." ".write_empty($previous_data_A06[array_keys($previous_data_A06)[$i]][$months[5]])." ".write_empty($previous_data_A06[array_keys($previous_data_A06)[$i]][$months[6]])." ".write_empty($previous_data_A06[array_keys($previous_data_A06)[$i]][$months[7]])." ".write_empty($previous_data_A06[array_keys($previous_data_A06)[$i]][$months[8]])." ".write_empty($previous_data_A06[array_keys($previous_data_A06)[$i]][$months[9]])." ".write_empty($previous_data_A06[array_keys($previous_data_A06)[$i]][$months[10]])." ".write_empty($previous_data_A06[array_keys($previous_data_A06)[$i]][$months[11]]);
    $area_A07_for_rank[$i] = $previous_data_A07[$i]["year"]." ".write_empty($previous_data_A07[array_keys($previous_data_A07)[$i]][$months[0]])." ".write_empty($previous_data_A07[array_keys($previous_data_A07)[$i]][$months[1]])." ".write_empty($previous_data_A07[array_keys($previous_data_A07)[$i]][$months[2]])." ".write_empty($previous_data_A07[array_keys($previous_data_A07)[$i]][$months[3]])." ".write_empty($previous_data_A07[array_keys($previous_data_A07)[$i]][$months[4]])." ".write_empty($previous_data_A07[array_keys($previous_data_A07)[$i]][$months[5]])." ".write_empty($previous_data_A07[array_keys($previous_data_A07)[$i]][$months[6]])." ".write_empty($previous_data_A07[array_keys($previous_data_A07)[$i]][$months[7]])." ".write_empty($previous_data_A07[array_keys($previous_data_A07)[$i]][$months[8]])." ".write_empty($previous_data_A07[array_keys($previous_data_A07)[$i]][$months[9]])." ".write_empty($previous_data_A07[array_keys($previous_data_A07)[$i]][$months[10]])." ".write_empty($previous_data_A07[array_keys($previous_data_A07)[$i]][$months[11]]);

}        

file_put_contents('ranks/A01.txt', implode(PHP_EOL, $area_A01_for_rank));
file_put_contents('ranks/A02.txt', implode(PHP_EOL, $area_A02_for_rank));
file_put_contents('ranks/A03.txt', implode(PHP_EOL, $area_A03_for_rank));
file_put_contents('ranks/A04.txt', implode(PHP_EOL, $area_A04_for_rank));
file_put_contents('ranks/A05.txt', implode(PHP_EOL, $area_A05_for_rank));
file_put_contents('ranks/A06.txt', implode(PHP_EOL, $area_A06_for_rank));
file_put_contents('ranks/A07.txt', implode(PHP_EOL, $area_A07_for_rank));

$area = $_GET["area"];
$month_reg = $_GET["month"];


for($i=0;$i<sizeof($previous_data_A02);$i++){
    for($j=0;$j<sizeof($months);$j++){
        if($previous_data_A02[$i][$months[$j]]!="9999"){
            $a2[$months[$j]][$previous_data_A02[$i]["year"]] = $previous_data_A02[$i][$months[$j]];
        }
    }
}

    



if($area=="A01"){
    sort($previous_data_A01);
    echo json_encode($previous_data_A01);
}else if($area=="A02"){
    sort($previous_data_A02);
    echo json_encode($previous_data_A02);
}else if($area=="A03"){
    sort($previous_data_A03);
    echo json_encode($previous_data_A03);
}else if($area=="A04"){
    sort($previous_data_A04);
    echo json_encode($previous_data_A04);
}else if($area=="A05"){
    sort($previous_data_A05);
    echo json_encode($previous_data_A05);
}else if($area=="A06"){
    sort($previous_data_A06);
    echo json_encode($previous_data_A06);
}else if($area=="A07"){
    sort($previous_data_A07);
    echo json_encode($previous_data_A07);
}

?>