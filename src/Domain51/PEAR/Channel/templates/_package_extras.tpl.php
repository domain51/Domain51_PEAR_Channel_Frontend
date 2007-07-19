<?php
    if (!empty($this->docs_uri)) { ?>
    <li><a href="<?php echo $this->docs_uri; ?>">Documentation</a></li>
<?php
    }
    
    if (!empty($this->bugs_uri)) { ?>
    <li><a href="<?php echo $this->bugs_uri; ?>">Bugs</a></li>
<?php
    }
    
    if (!empty($this->source_control_uri)) { ?>
<li><a href="<?php echo $this->source_control_uri; ?>">Source Control</a></li>
<?php } ?>