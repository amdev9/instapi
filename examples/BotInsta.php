
<?php
 

require '/Users/alex/dev/instagram/instapi/examples/RegisterTool.php';
require '/Users/alex/dev/instagram/instapi/src/ios.php';
require_once '/Users/alex/dev/instagram/redis/predis/autoload.php';


// FOR MULTITHREADING 
class Connect extends Worker {
    public function getConnection() {
        Predis\Autoloader::register();
        if (!self::$link) {
          self::$link = new Predis\Client(array(
          "scheme" => "tcp",
          "host" => "127.0.0.1",
          "port" => 6379));
        }     
        return self::$link;
    }
    /**
    * Note that the link is stored statically, which for pthreads, means thread local
    **/
    protected static $link;
}
$pool = new Pool(1, "Connect", []);
for ($i = 0; $i < 1; $i++) {
   // $pool->submit (new registerTool());  // fix to ios and add username pass and email
  $pool->submit (new InstaOS()); 
}


$pool->shutdown();



