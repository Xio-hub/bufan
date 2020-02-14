<?php

namespace App\Org;

class Page
{
    protected $next_page_url    = null;
    protected $prev_page_url    = null;
    protected $total            = 0; //总共多少條數據
    protected $url              = '';
    protected $queryString      = '';
    protected $currentOffset    = 0;
    protected $queryStringArr   = [];
    protected $pageSize;

    public function __construct($total, $pageSize)
    {
        $this->total = $total;
        $this->queryString = \Request::getQueryString();
        $this->url = env('APIGATEWAY_PATH'). '/' . \Request::path();
        if ($this->queryString) {
            $this->queryStringArr = explode('&', $this->queryString);
        }
		$this->currentOffset= \Request::query('offset');
        $this->pageSize = $pageSize;
        $this->setNext();
        $this->setPrev();
    }

    public function setNext()
    {
        $next_page_index = $this->currentOffset + $this->pageSize;
        if ($next_page_index < $this->total && $this->total!=0) {
            $this->setOffset($next_page_index);
            $this->next_page_url = $this->url . '?' . implode('&', $this->queryStringArr);
        }
    }

    protected function setOffset($offset)
    {
        foreach ($this->queryStringArr as $key => $value) {
            if (strchr($value, 'offset')) { 
                unset($this->queryStringArr[$key]);
                break;
            }
        }
        $this->queryStringArr[] = 'offset=' . $offset;
    }

    public function setPrev()
    {
        if ($this->currentOffset >= $this->pageSize && $this->total!=0) {
            $this->setOffset($this->currentOffset - $this->pageSize);
            $this->prev_page_url = $this->url . '?' . implode('&', $this->queryStringArr);
        }
    }

    public function getNext()
    {
        return $this->next_page_url;
    }

    public function getPrev()
    {
        return $this->prev_page_url;
    }

    public function setQueryStringArr($queryString)
    {
        $this->queryString = $queryString;
        $this->queryStringArr = explode('&', $this->queryString);
    }
}
