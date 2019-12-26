<?php include 'catalog.php'; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Каталог</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/graphite.css">

    <script src="js/jquery-1.9.0.min.js"></script>

    <script src="js/bootstrap.js"></script>
</head>
<body>
<?php
/*
class ip extends Db{
    public function __construct()
    {
        $this->db = new Db;
    }


    public function	select_ip(){

        $params = [
            'ip' => $_SERVER['REMOTE_ADDR'],


        ];
         $query = $this->db->query("SELECT * FROM remote_ip WHERE ip=:ip",$params);
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
         $data = $row['ip'];
    }
    return $data;
}


    public function	add_ip(){

        $params1 = [
            'ip' => $_SERVER['REMOTE_ADDR'],
            'date' => time(),

        ];
        $params2 = [
            'date' => time(),
            'ip_from_base' => $this->select_ip(),
        ];
        if($this->select_ip()!=$_SERVER['REMOTE_ADDR']){
            return $query = $this->db->query("INSERT INTO remote_ip (ip,date_visit)  VALUES (:ip,:date)",$params1);

        }
        if($this->select_ip()==$_SERVER['REMOTE_ADDR']){
           return $query = $this->db->query("UPDATE remote_ip SET date_visit=:date WHERE ip=:ip_from_base",$params2);

        }
    }
}
$ip = new ip;
$ip->add_ip();
 $ip->select_ip();
*/
 ?>

<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">ТОВАР</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body px-4">
                <div class="table-responsive" id="employee_details">
                    <table class="table table-bordered">
                        <tr>
                            <td width="10%" align="right"><b>наименование</b></td>
                            <td width="90%"><span id="title"></span></td>
                        </tr>
                        <tr>
                            <td width="10%" align="right"><b>цена</b></td>
                            <td width="90%"><span id="price"></span>грн</td>
                        </tr>
                        <tr>
                            <td width="10%" align="right"><b>дата</b></td>
                            <td width="90%"><span id="date"></span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="sidebar">
        <div class="vertmenu">
            <ul class="accordion" id="accordion">
                <?php echo $categories_menu ?>
            </ul>
        </div>
    </div>
    <div class="breadcrumbs123">
    </div>

    <div class="cat_content">
    </div>
    <select id="sort_by" style="float: right;">
        <option value="" disabled selected>выберите</option>
        <option value="sort-asc" id="sort-asc">наименьшая цена</option>
        <option value="sort-new" id="sort-new">новинки</option>
        <option value="sort-Alfavit" id="sort-Alfavit">по алфавиту</option>
    </select>
    <br />

    <div style="float: right;" class="content">
    </div>
</div>
<script>
    var path = "<?=PATH?>";
</script>
<script src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/jquery.cookie.js"></script>
<script src="js/scripts.js"></script>
<script>

</script>
</body>
</html>