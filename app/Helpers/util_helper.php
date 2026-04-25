<?php

function checkMandatory($fields, $data)
{
    $missing = [];
    foreach ($fields as $val) {
        if (!isset($data[$val]) || $data[$val] == "") {
            $missing[] = $val;
        }
    }
    if (count($missing) != 0) {        
        return "Missing Mandatory Fields '" . implode(',', $missing) . "'";
    }
    return false;
}

function getOrderBy($data, $order_data) {
        if (count($order_data) == 0 || !isset($order_data[$data['sort_name']]) || !isset($data['sort_value']) || $data['sort_value'] == 0) {
            return '';
        }
        return " {$order_data[$data['sort_name']]} " . ((isset($data['sort_value']) && $data['sort_value'] == 2 ) ? "DESC" : "ASC");
    }

function dataTablePagination($builder, $data,$pk,$select = "*", $excel = false,$order_by_arr=[])
{


    if ($excel) {
        $builder->select($select);
        return  $builder->get()->getResultArray();
    }

    $response = [];
    $start = $data['start'];
    $searchValue = $data['search']['value'];
     $order = $data['order']??'';
    $columns = $data['columns'];
    $draw = $data['draw'];
    $length = $data['length'];
    // Total records
    
   

    // Filtered records
    if (!empty($searchValue)) {
        foreach ($order_by_arr as $k=> $column) {
            $builder->orLike($column, $searchValue);           
        }
    }

//     echo $builder->getCompiledSelect();//use before execute
//       exit;
    $filterBuilder = clone $builder;
    // $builder->countAllResults(false);
    $filterBuilder->select("count($pk) as count_pp");
    $filter_count = $filterBuilder->get()->getRowArray();
    $totalFiltered = $filter_count['count_pp'];
 

   
    $newBuilder = clone $builder;
    
     // Order the table
    $ff=[];
     if (!empty($order)) {
         foreach ($order as $sort) {
             $columnIndex = $sort['column'];
             if(empty($order_by_arr[$columnIndex])){
                 continue;
             }
             $columnName = $order_by_arr[$columnIndex]??'';
             $dir = $sort['dir'];
             if ($columns[$columnIndex]['orderable'] === 'true') {
//                 $ff[]=[
//                     '$columnName'=>$columnName,
//                     '$dir' => $dir
//                 ];
                 $builder->orderBy($columnName, $dir);
             }
         }
     }
    

    // Pagination
    if ($length != -1) {
        $builder->limit($length, $start);
    }

  

    $builder->select($select);
//      echo $builder->getCompiledSelect();//use before execute
//       exit;
    
    $result_data = $builder->get()->getResultArray();

    $pk_ids = "";
    if(isset($data['pk_id'])){       
        $pk_ids = $newBuilder->select($data['pk_id'])->get()->getResultArray();
        $pk_Key = array_key_first($pk_ids[0] ?? []);
        if($pk_Key ){
            $pk_ids =  array_column($pk_ids,  $pk_Key);
        }    
    }


    
    // Response format
    $response = [
        'draw' => $draw,
        'recordsFiltered' =>$totalFiltered ,
        'data' => $result_data,
        'pk_ids' =>$pk_ids,
        'order'=>$order ,
        'ff'=>$ff
    ];
    return $response;
}

function getGraphData($data)
{
    $response = [];
    $list = [];
    // get label Data
    $response['label']  = array_values(array_unique(array_map(fn($item) => $item['label'], $data)));

    foreach ($data as $data) {
        $list[$data['id']]['data'][] = $data['val'];
        $list[$data['id']]['label'] = $data['title'];
    }
     
    $response['datasets'] =  array_values($list);
    return $response;
}


function whereCondition($param, $data) {
    $wherecon = [];
    foreach ($param as $para) {
        $_para = explode(".", $para);
        $_para = (count($_para) == 1) ? $para : $_para[1];
        if (isset($data[$_para]) && is_array($data[$_para]) && count($data[$_para]) == 0) {
            continue;
        }
        if (isset($data[$_para]) && $data[$_para] != "") {
            $wherecon [] = (is_array($data[$_para])) ? " {$para} IN (" . implode(',', $data[$_para]) . ") " : " {$para} = {$data[$_para]} ";
        }
    }
    return ($wherecon) ? " AND " . implode(" AND", $wherecon) : "";
}

function whereFreeFilterCondition($param, $data) {
    $wherecon = [];
    foreach ($param as $para) {
        $_para = explode(".", $para);
        $_para = (count($_para) == 1) ? $para : $_para[1];
        if (isset($data['free_search']) && $data['free_search'] != "") {
            $wherecon [] = " $para LIKE TRIM('%" . trim($data['free_search']) . "%') ";
        }
    }
    return ($wherecon) ? " AND (" . implode(" OR", $wherecon) . ")" : "";
}


function slugify($text) {
    // Convert to lowercase
    $text = strtolower($text);
    // Replace non-letter/digit characters with hyphens
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    // Trim hyphens
    $text = trim($text, '-');
    return $text;
}
 