<?php

global $g_config;
HTML_BEGIN();
HEADER_BEGIN();
LINK_CSS($g_config['base_url'] . 'css/default.css');
HEADER_END();
BODY_BEGIN();

print ('az okoska metódust hívtuk meg a defult_controllerben a megtalált név: ' . $this->parameters['name']);

BODY_END();
HTML_END();

