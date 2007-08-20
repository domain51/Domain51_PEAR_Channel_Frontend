<?php
// @todo display error when no packages are available
?>
<h3>Downloads</h3>

<dl>
<?php
    foreach ($this->package->releases as $release) {
?>
    <di>
        <dt>Version <?php echo $release->version; ?></dt>
        <dd>
            <dl>
                <dt>Links</dt>
                <dd>
                    <ul>
                        <li><a href="<?php
                            // @todo add support for protocols other than http
                            // @todo add support for other base directories for getting files
                            printf("http://%s/get/%s-%s.tgz",
                                   (string)$release->channel,
                                   (string)$release->package,
                                   (string)$release->version
                                  );
                            ?>">Download</a></li>
                    </ul>
                </dd>
                <dt>Release Date</dt>
                <dd><?php echo date('F jS, Y', strtotime((string)$release->releasedate)); ?></dd>
                
                <dt>Release State</dt>
                <dd><?php echo $release->state; ?></dd>
                
                <dt>Changelog</dt>
                <dd><?php echo $release->changelog; ?></dd>
                
                <dt>Dependencies</dt>
                <dd>
                    <ul>
<?php foreach ($release->dependencies as $dependency) { ?>
                        <li><?php echo (string)$dependency; ?></li>
<?php } ?>
                    </ul>
                </dd>
            </dl>
        </dd>
    </di>


<?php
    }
?>