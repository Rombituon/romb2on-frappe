<?php
namespace Romb2on\Frappe;
use Illuminate\Support\Facades\Http;

class Doctype {
    private $frappe;

    private $options = [
        'doctype' => null,
        'options' => [],
    ];

    public function __construct($frappe)
    {
        $this->frappe = $frappe;
    }

    public function getDoc($docTypeName,$docName)
    {
        $query = http_build_query([
            'fields' =>'["*"]' ,
        ],encoding_type:PHP_QUERY_RFC3986);

        $response = Http::withHeaders($this->frappe->headers)
                    ->get($this->frappe->url."/api/resource/".$docTypeName."/".$docName."?".$query);

        return json_decode($response);
    }

    public function getAll($docTypeName, $options = [])
    {
        $query = http_build_query(array_merge([
            'fields' =>'["*"]' ,
        ],$options),encoding_type:PHP_QUERY_RFC3986);

        // dd($query);
        // urlencode('["*"]')
        $response = Http::withHeaders($this->frappe->headers)
                    ->get($this->frappe->url."/api/resource/".$docTypeName."?".$query);
                    
        return json_decode($response);
    }

    public function create($docTypeName,$data=[])
    {
        $response = Http::withHeaders($this->frappe->headers)
                    ->post($this->frappe->url."/api/resource/".$docTypeName,$data);
        return json_decode($response);
    }

    public function update($docTypeName,$docName,$data=[])
    {
        $response = Http::withHeaders($this->frappe->headers)
                    ->put($this->frappe->url."/api/resource/".$docTypeName."/".$docName,$data);
        return json_decode($response);
    }

    public function delete($docTypeName,$docName)
    {
        $response = Http::withHeaders($this->frappe->headers)
                    ->delete($this->frappe->url."/api/resource/".$docTypeName."/".$docName);
        return json_decode($response);
    }
    

    public function mount($docTypeName)
    {
        $this->options['doctype'] = $docTypeName;

        return $this;
    }

    public function filters($options=[])
    {
        $this->options['options'] = array_merge($this->options['options'],[
            'filters' => $options
        ]);

        return $this;
    }

    public function fields($options=[])
    {
        $this->options['options'] = array_merge($this->options['options'],[
            'fields' => $options
        ]);

        return $this;
    }

    public function orderBy($options=['name desc'])
    {
        $this->options['options'] = array_merge($this->options['options'],[
            'order_by'=>$options
        ]);
        return $this;
    }

    public function paginate($page=1,$limit=10)
    {
        if($page <= 0) {
            throw new \Exception('Page must be greater than 0');
        }

        $page = $page - 1;

        $this->options['options'] = array_merge($this->options['options'], [
            'limit_start' => $page,
            'limit_page_length' => $limit,
        ]);

        // dd(http_build_query($opt));

       return $this;
    }

    public function get()
    {
        $data = $this->getAll(
            $this->options['doctype'], 
            $this->options['options']
        );

        return $data;
    }
}