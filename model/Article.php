<?php 

include "model/database.php";

class Article extends database {

    function getSlide(){
        $sql = "SELECT * FROM slide";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    function getMenu(){
        $sql = "SELECT tl.*, GROUP_CONCAT(Distinct lt.id, ':', lt.Ten, ':', lt.TenKhongDau) AS LoaiTin, tt.id as idTin, tt.TieuDe as TieuDeTin, tt.Hinh as HinhTin, tt.TomTat as TomTatTin, tt.TieuDeKhongDau as TieuDeKhongDauTin FROM theloai tl INNER JOIN loaitin lt ON lt.idTheLoai = tl.id INNER JOIN tintuc tt ON tt.idLoaiTin = lt.id GROUP BY tl.id";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    function getArticleById($id, $location=-1, $limit=-1){
        $sql = "SELECT * FROM tintuc WHERE idLoaiTin = $id";

        if($location>-1 && $limit>1){
            $sql.= " limit $location,$limit";
        }

        $this->setQuery($sql);
        return $this->loadAllRows(array($id));
    }

    function getTitleById($id){
        $sql = "SELECT Ten FROM loaitin where id = $id";
        $this->setQuery($sql);
        return $this->loadRow(array($id));
    }

    function getDetailArticle($id)
    {
        $sql = "SELECT * FROM tintuc WHERE id = $id";
        $this->setQuery($sql);
        return $this->loadRow(array($id));
    }

    function getComment($id){
        $sql = "SELECT cmt.*, users.name as name FROM comment cmt inner join users on cmt.idUser = users.id where idTinTuc = $id";
        $this->setQuery($sql);
        return $this->loadAllRows(array($id));
    }

    function getRelatedNews($alias){
        $sql = "SELECT tt.*, lt.TenKhongDau as tenkhongdau from tintuc tt inner join loaitin lt on tt.idLoaiTin = lt.id where lt.TenKhongDau = '$alias' order by RAND() LIMIT 5";
        $this->setQuery($sql);
        return $this->loadAllRows(array($alias));
    }

    function getAliasCategory($id_cat){
        $sql = "SELECT TenKhongDau from loaitin where id = $id_cat";
        $this->setQuery($sql);
        return $this->loadRow(array($id_cat));
    }

    function getHotNews(){
        $sql = "SELECT tt.*, lt.TenKhongDau as tenkhongdau from tintuc tt inner join loaitin lt on tt.idLoaiTin = lt.id where tt.NoiBat = 1 order by RAND() LIMIT 5";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    function addComment($id_user, $id_article, $content){
        $sql = "INSERT INTO comment(idUser, idTinTuc, NoiDung) values(?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute(array($id_user, $id_article, $content));
    }

    function search($key){
        $sql = "SELECT * from tintuc tt inner join loaitin lt on tt.idLoaiTin = lt.id where tt.TieuDe like '%$key%' or tt.TomTat like '%$key%'";
        $this->setQuery($sql);
        return $this->loadAllRows(array($key));
    }
}

?>    