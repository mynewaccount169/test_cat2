<?php
include 'functions.php';

$cat = new Catalog;
 $categories = $cat->get_cat();
 $categories_tree =  $cat->map_tree($categories);
 $categories_menu =  $cat->categories_to_string($categories_tree);

/*
if( isset($_GET['product']) ){
    $product_id = (int)$_GET['product'];
    // массив данных продукта
    $get_one_product = $cat->get_one_product($product_id);
    // получаем ID категории
    $id = $get_one_product['parent'];
}else{
    $id = (int)$_GET['category'];
}*/

// хлебные крошки
// return true (array not empty) || return false


// ID дочерних категорий
//$ids = $cat->cats_id($categories, $id);
//$ids = !$ids ? $id : rtrim($ids, ",");

/*=========Пагинация==========*/

// кол-во товаров на страницу
//$perpage = 16;

// общее кол-во товаров
//$count_goods = $cat->count_goods($ids);

// необходимое кол-во страниц
//$count_pages = ceil($count_goods / $perpage);
// минимум 1 страница
//if( !$count_pages ) $count_pages = 1;

// получение текущей страницы
//if( isset($_GET['page']) ){
	//$page = (int)$_GET['page'];
	//if( $page < 1 ) $page = 1;
//}else{
//	$page = 1;
//}

// если запрошенная страница больше максимума
//if( $page > $count_pages ) $page = $count_pages;

// начальная позиция для запроса
//$start_pos = ($page - 1) * $perpage;

//$pagination = $cat->pagination($page, $count_pages);

/*=========Пагинация==========*/

//$get_id = $_GET['category'];
//$get_catById = $cat->get_catById($get_id);

//$products = $cat->get_products($ids, $start_pos, $perpage);