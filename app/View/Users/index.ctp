<?php

    echo $this->Session->flash();
    echo $this->Html->link("logout",array("controller" => "users","action" => "logout"));

?>