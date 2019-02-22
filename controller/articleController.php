<?php 

include "model/Article.php";
include "model/pager.php";

class ArticleController {

    public function index(){
        $article = new Article();
        $slide = $article->getSlide();
        $menu = $article->getMenu();

        return array('slide'=>$slide, 'menu'=>$menu);
    } 

    function category()
    {
        $id = $_GET['id'];
        $article = new Article;

        $menuArticle = $article->getArticleById($id);
        $alias = $article->getAliasCategory($id);


        ////pagination
        ///có tham số page thì lấy không có thì mặc định bằng 1;
        $currentPage = (isset($_GET['page']))?$_GET['page']:1;
        $pagination = new pagination(count($menuArticle), $currentPage, 4, 4);
        $paginationHTML = $pagination->showPagination();
        $limit = $pagination->_nItemOnPage;
        $location = ($currentPage-1)*$limit;
        $menuArticle = $article->getArticleById($id, $location, $limit);

        $menu = $article->getMenu();
        $title = $article->getTitleById($id);
        return array('menuArticle'=>$menuArticle, 'menu'=>$menu, 'title'=>$title, 'pagination'=>$paginationHTML, 'alias'=>$alias);
    }

    function detailArticle(){
        $id = $_GET['id'];
        $alias = $_GET['category'];
        $article = new Article();
        $detailArticle = $article->getDetailArticle($id);
        $comment = $article->getComment($id);
        $relatedNews = $article->getRelatedNews($alias);
        $getHotNews = $article->getHotNews();
        return array('detailArticle'=>$detailArticle, 'comment'=>$comment, 'relatedNews'=>$relatedNews, 'getHotNews'=>$getHotNews);
    }

    function comment($id_user, $id_article, $content){
        $article = new Article();
        $comment = $article->addComment($id_user, $id_article, $content);
        header('location:'.$_SERVER['HTTP_REFERER']);
    }

    function searching($key){
        $article = new Article();
        $result = $article->search($key);
        return $result;
    }

}

?>