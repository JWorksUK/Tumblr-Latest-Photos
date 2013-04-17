<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Tumblr Latest Photos Class
 */

class Tumblr_Latest_Photos
{
    private $base_hostname;

    const cache = "tumblr-latest-photos.cache";

    protected $api_key = "yLj2mBXMpwUFNBcnSZohkTL1IDIcdmdHnNXsFspn26qTneyZwF";

    /**
     * Constructors object depending on tumblr base name
     *
     * @param string $base_hostname tumblr base name
     */
    function __construct( $base_hostname )
    {
        $this->base_hostname = $base_hostname;
    }
    
    // -------------------------------------------------------------------------

    /**
     * The generate method takes an array of tweets and build the markup
     * 
     * @access  public
     * @param   int     $limit
     * @return  array
     */
    public function generate( $limit = 10 )
    {

        // Limiting the number of shown tweets
        $photos = array_slice($this->get(),0,$limit);
        $data=array();

        foreach($photos as $p){
            $item = new stdClass;

            $item->id = $p->id;
            $item->blog_name = $p->blog_name;
            $item->post_url = $p->post_url;
            $item->short_url = $p->short_url;
            $item->date = self::relativeTime($p->date);
            $item->caption = $p->caption;
            $item->photo = $p->photos[0];

            $data[] = $item;
        }

        return $data;
    }

    // -------------------------------------------------------------------------

    /**
     * The get method returns an array of photo post objects
     * 
     * @access  public
     * @return  array
     */
    public function get()
    {
        $cache = dirname(__FILE__).'/'.self::cache;

        $photos = array();

        if(file_exists($cache) && time() - filemtime($cache) < 60*30 && filesize( $cache )!==0){
            // Use the cache if it exists and is less than three hours old
            $data = unserialize(file_get_contents($cache));
        }
        else{
            // Otherwise rebuild it
            $data = json_decode($this->fetch_feed());
            file_put_contents($cache,serialize($data));
        }

        if ( isset( $data->meta->status ) && $data->meta->status == 200 ) :
            $photos = $data->response->posts;
        endif;

        if(!$photos){
            $photos = array();
        }

        return $photos;
    }

    // -------------------------------------------------------------------------
    
    /**
     * @access  private
     * @param   int     $int
     * @return  string  json encoded strong
     */
    private function fetch_feed($limit = 10)
    {
        $url = "http://api.tumblr.com/v2/blog/{$this->base_hostname}.tumblr.com/posts/photo?api_key={$this->api_key}&limit={$item}&filter=text";

        return file_get_contents($url);
    }

    // -------------------------------------------------------------------------
    
    /**
     * @access  private
     * @param   string  $mysql_date_time    date format 'Y-m-d H:i:s'
     * @return  string
     */
    private static function relativeTime($time)
    {

        $divisions  = array(1,60,60,24,7,4.34,12);
        $names      = array('second','minute','hour','day','week','month','year');
        $time       = time() - strtotime($time);

        $name = "";

        if($time < 10){
            return "just now";
        }

        for($i=0; $i<count($divisions); $i++){
            if($time < $divisions[$i]) break;

            $time = $time/$divisions[$i];
            $name = $names[$i];
        }

        $time = round($time);

        if($time != 1){
            $name.= 's';
        }

        return "$time $name ago";
    }
}
