<?php

    require_once('Ripcord/ripcord.php');
    class myTest {
        public function Foo() {
            return 'Bar';
        }
    }
    $test = new MyTest();
    $server = ripcord::server( $test );
    $server->run();


?>