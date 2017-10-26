<?php
if(file_exists($this->ComponentPathTemplate)) {
    require $this->ComponentPathTemplate;
} else {
    echo "error Template '".$this->componentTemplateSubfolder."' not found";
}
