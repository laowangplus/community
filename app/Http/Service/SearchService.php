<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2020/2/14
 * Time: 21:42
 */

namespace App\Http\Service;

use Elasticsearch\ClientBuilder;

class SearchService {
    protected $client = null;
    public function __construct() {
        $this->client = ClientBuilder::create()->setHosts(['47.102.205.111:9200/'])->build();
    }

    public function searchArticle($keyword){
    }

    public function addArticle($data){

    }

    public function createArticleIndex(){

    }
}