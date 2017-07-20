<?php
use PHPUnit\Framework\TestCase;
require_once  'lib/_includes/fbsdk/src/Facebook/autoload.php';

class fbTest extends TestCase
{


    public function testFbConfig()
    {
 
        
        require 'fbConfig.php';
        
        $this->assertNotEmpty($app_id);
        $this->assertNotEmpty($app_sec);
        
        $this->assertEquals($g_v,'v2.7');
        
    }

   public function testCallbackUrl(){

        require 'fbConfig.php';
        $this->assertEquals($callBack,'https://bhautikng143.herokuapp.com/fb-callback.php');  
    }

   

}

?>
