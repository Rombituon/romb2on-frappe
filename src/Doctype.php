<?php
namespace Romb2on\Frappe;
use Illuminate\Support\Facades\Http;
use stdClass;

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

    public function getAll($docTypeName, $options = [], $childFields=[])
    {
        $query = http_build_query(array_merge([
            'fields' =>'["*"]' ,
        ],$options),encoding_type:PHP_QUERY_RFC3986);

        // dd($query);
        // urlencode('["*"]')
        $response = Http::withHeaders($this->frappe->headers)
                    ->get($this->frappe->url."/api/resource/".$docTypeName."?".$query);

        if(count($childFields) == 0) {
            $response = json_decode($response);
            return $response;
        }


        $obj = json_decode($response);
        // dd($obj);

        $responseObj = [];

        foreach ($childFields as $childObj) {
            
            foreach ($obj->data as $data) {
                $mapped_key = explode('.', $childObj['mapped_key'])[1];
                // $yes=$data->{$mapped_key}=="22noorazilahawang93@gmail.com";
                // dd($yes);
                if(property_exists($data,$mapped_key))
                {
                    $dt = $childObj['doctype'];
                    $df = $childObj['key'];
                    $dn = $data->{$mapped_key}; 
                    $filters = $childObj['filters'];

                    

                    $responseObj[] = $this->getAll($dt,[
                        'filters'=>$filters
                    ]);
          
                }

               
            }

            

            
            
        }
                    
        return $responseObj;
    }

    public function create($docTypeName,$data=[])
    {
        $cls = new stdClass();
        $response = Http::withHeaders($this->frappe->headers)
                        ->post($this->frappe->url."/api/resource/".$docTypeName,$data);

        $resObj = json_decode($response);

        if(property_exists($resObj,'exc'))
        {
            $cls->data = $resObj;
            $cls->status = false;
        }
        else
        {
            $cls->data = json_decode($response);
            $cls->status = true;
        }

        return $cls;
        
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