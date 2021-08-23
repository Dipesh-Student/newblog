<?php

/**
 * class post to handle post/blog data
 */
class post
{

    //properties

    /**
     * @var string user passed value for post's _title
     */
    public $title = null;

    /**
     * @var string show content's briefing or highlight 
     */
    public $summary = null;

    /**
     * @var string user passed value for post's _content
     */
    public $content;


    //constructor 
    public function __construct($data = array())
    {
        /**
         * get variable values from array if exist's
         */
        if (isset($data['title']))
            $this->title = $data['title'];

        if (isset($data['content']))
            $this->content = $data['content'];

        if (isset($data['summary']))
            $this->summary = $data['summary'];
        else
            $this->summary = implode(" ", array_slice(explode(" ", $data['content']), 0, 10));
    }


    public function show_post()
    {
        $title = $this->title;
        $content = $this->content;
        $summary = $this->summary;
        $result = array("title" => $title, "content" => $content, "summary" => $summary);
        return $result;
    }
    
    /**
     * function to return array of data for @param int id blogid 
     */
    public static function get_post_byid($post_id)
    {
        try {
            $conn = new PDO("mysql:host=localhost;dbname=cms", "root", "");
            $sql = "SELECT * FROM articles WHERE id=:id;";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $post_id, PDO::PARAM_STR);
            $stmt->execute();
            $resultCount = $stmt->rowCount();

            if ($resultCount === 0) {
                $resultset = array("error" => "No post's found");
                return $resultset;
            } else {
                $resultset = $stmt->fetch();
                return $resultset;
            }
        } catch (PDOException $e) {
            $resultset = array("error" => "PDO Error" . $e->getMessage());
            return $resultset;
        }
    }
}
$t = "lion";
$c = "The lion (Panthera leo) is a large felid of the genus Panthera native to Africa and India. It has a muscular, deep-chested body, short, rounded head, round ears, and a hairy tuft at the end of its tail. It is sexually dimorphic; adult male lions are larger than females and have a prominent mane. It is a social species, forming groups called prides. A lion's pride consists of a few adult males, related females, and cubs. Groups of female lions usually hunt together, preying mostly on large ungulates. The lion is an apex and keystone predator; although some lions scavenge when opportunities occur and have been known to hunt humans, the species typically does not.";
$data = array("title" => $t, "content" => $c);
$post = new post($data);
$result = $post->show_post();
$title = $result['title'];
//echo $title;

//print_r(post::get_post_byid(1));
