<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2020/2/14
 * Time: 21:42
 */

namespace App\Http\Service;

use App\Exceptions\ErrorException;
use Elasticsearch\ClientBuilder;

class SearchService {
    protected $client = null;
    public function __construct() {
        $this->client = ClientBuilder::create()->setHosts(['47.102.205.111:9200/'])->build();
    }

    public function searchArticle($keyword){
        $param = [
            'index' => 'community',
            'type' => 'article',
            'body' => [
                'query' => [
                    'multi_match' => [
                        'query' => $keyword,
                        'fields' => ['title', 'content', 'tag', 'username']
                    ]
                ]
            ],
        ];
        $response = $this->client->search($param);
        $article_ids = [];
        foreach ($response['hits']['hits'] as $article){
            $article_ids[] = $article['_source']['id'];
        }

        return $article_ids;
    }

    public function addArticle($data){
        $param = [
            'index' => 'community',
            'type' => 'article',
            'body' => [
                'id' => $data->article_id,
                'username' => $data->username,
                'title' => $data->title,
                'content' => $data->content,
                'tag' => $data->tag,
            ],
        ];
        try{
            $response = $this->client->index($param);
        }catch (\Exception $exception){
            throw new ErrorException([
                'msg' => $exception->getMessage()
            ]);
        }

        var_dump($response);
    }

    public function createArticleIndex(){
        $param = [
            'index' => 'community',
            'body' => [
                'settings' => [
                    'number_of_shards' => 5,
                    'number_of_replicas' => 1
                ],
                'mappings' => [
                    'article' => [
                        '_source' => [
                            'enabled' => true
                        ],
                        'properties' => [
                            'username' => [
                                'type' => 'string',
                            ],
                            'title' => [
                                'type' => 'string',
                            ],
                            'content' => [
                                'type' => 'string',
                            ],
                            'tag' => [
                                'type' => 'string',
                            ],
                            'id' => [
                                'type' => 'integer',
                            ],
                        ]
                    ]
                ]
            ]
        ];
        $response = $this->client->indices()->create($param);
    }
}