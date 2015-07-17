<?php
require("includes/Kob/Wizard.php");
class BasicTest extends PHPUnit_Framework_TestCase
{
    public function testClasses()
    {
        $wizard = new Kob\Wizard();
        $this->assertInstanceOf('Kob\Wizard', $wizard);

        // The wizard must load, read, and control the sheet process
        $this->assertClassHasAttribute('my_sheet', 'Kob\Wizard');
        $this->assertClassHasAttribute('my_step', 'Kob\Wizard');
        $sheet = $wizard->get_sheet();
        $this->assertInstanceOf('Kob\Sheet', $sheet);
        
        $script = $sheet->load("/home/filipo/projetos/kob-wizard/admin/sheets/simple_wizard.json");
        $this->assertClassHasAttribute('my_obj', 'Kob\Sheet');
        $this->assertInstanceOf('stdClass', $script);

        $wizard->set_sheet($sheet);
        $wizard->run();

        // The sheet must prepare and create posts  
        $this->assertClassHasAttribute('my_post', 'Kob\Sheet');
        $post = $sheet->get_post(); 
        $this->assertInstanceOf('Kob\Post', $post);

        $this->assertClassHasAttribute('my_template', 'Kob\Sheet');
        $template = $sheet->get_template(); 
        $this->assertInstanceOf('Kob\Template', $template);

    }
}
?>
