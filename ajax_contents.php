<?php
require 'catalog.php';
class Contents extends Db
{
    public function __construct()
    {
        $this->db = new Db;
    }
    public function get_products()
    {
        $cat = new Catalog;
        $id = $_POST['arg'];
        $categories = $cat->get_cat();
        $ids = $cat->cats_id($categories, $id);
        $ids = !$ids ? $id : rtrim($ids, ",");


        $arr = [
            'default'=> 'title',
            'sort-new'=> 'date',
            'sort-asc'=> 'price',
            'sort-Alfavit'=> 'title',
        ];
        $arr2= [
            'default'=> 'ASC',
            'sort-new'=> 'DESC',
            'sort-asc'=> 'ASC',
            'sort-Alfavit'=> 'ASC',
        ];
        $param = $_POST['sort_by'];
        if(!$param){
            $param = 'default';
        }

        if ($ids) {
            $query = $this->db->query("SELECT * FROM products WHERE parent IN($ids) ORDER BY ".$arr[$param]." ".$arr2[$param]." LIMIT 20");
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $id = $row['id'];
                $username = trim($row['title']);
                $name = $row['price'];
                $parent = $row['parent'];
                $date = $row['date'];
                $return_arr[] = array(
                    "id" => $id,
                    "title" => $username,
                    "price" => $name,
                    "parent" => $parent,
                    "date" =>  date('d-m-Y H:i', $date)
                );

            }
            if($this->count_goods($ids) >=1) {
              //  echo 1;
                return $return_arr;
            }else{
                $return_arr = array('answer' => 'no',
                    'info' => 'товаров нет');
            //    echo 2;
                return $return_arr;
            }
        } else {
            $query = $this->db->query("SELECT * FROM products ORDER BY ".$arr[$param]." ASC LIMIT 20");

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $id = $row['id'];
                $username = trim($row['title']);
                $name = $row['price'];
                $parent = $row['parent'];
                $date = $row['date'];
                $return_arr[] = array(
                    "id" => $id,
                    "title" => $username,
                    "price" => $name,
                    "parent" => $parent,
                    "date" =>  date('d-m-Y H:i', $date)

                );

            }
         //   echo 3;
            return $return_arr;
        }

    }
    public  function count_goods($ids)
    {
        $params = [
            'ids' =>$ids,
        ];
        if (!$ids) {
            $query = $this->db->column("SELECT COUNT(*) FROM products");
        } else {
            $query = $this->db->column("SELECT COUNT(*) FROM products WHERE parent IN($ids)",$params);
        }

        return $query;
    }
    public function count_cats($id){
        $params = [
            'id' =>   $id,
        ];
        return $this->db->column("SELECT COUNT(*) FROM categories WHERE parent=:id", $params);
    }
    public  function get_catById()
    {
        $id = $_POST['arg'];
        $params = [
            'id' =>    $id,
        ];
        if ($id AND $this->count_cats($id)>=1) {
            $query = $this->db->query("SELECT * FROM categories WHERE parent=:id AND parent!=0", $params);

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                $id = $row['id'];
                $username = $row['title'];

                $parent = $row['parent'];
                $return_arr[] = array(
                    "id_cat" => $id,
                    "title_cat" => $username,
                    "parent" => $parent
                );
                //  $products[] = $row;
            }
          //  echo 4;
          return  $return_arr;
        } else {

            $return_arr = array(
                'answer' => 'no',
                'info' => 'в этой категории ничего нет'
            );
          //  echo 5;
           return $return_arr;


        }
    }
    public   function breadcrumbs($array, $id)
    {
        if (!$id) return false;
        $count = count($array);
        $breadcrumbs_array = array();
        for ($i = 0; $i < $count; $i++) {
            if ($array[$id]) {
                $breadcrumbs_array[$array[$id]['id']] = $array[$id]['title'];
                $id = $array[$id]['parent'];
            } else break;
        }
        return array_reverse($breadcrumbs_array, true);
    }

    public function get_content(){
        $cat2 = new Catalog;
        $categories = $cat2->get_cat();
        $id = $_POST['arg'];
        $breadcrumbs_array = $this->breadcrumbs($categories, $id);


        $result[] = $this->get_catById();
        $result[] =  $this->get_products();
        $result[] = $breadcrumbs_array;

       // $result = array_merge(...[$cat, $prod]);
        return  json_encode($result);
    }




}
$prod = new Contents;

echo  $prod->get_content();
