<h2><?php echo $this->package; ?></h2>
<ul id="package">
<?php if ($this->package->releases->count() > 0) { ?>
    <li>
        <a href="<?php echo $this->index; ?>?package=<?php echo $this->package; ?>&amp;downloads">
            Download
        </a>
    </li>
    <li>
        <a href="<?php echo $this->index; ?>?package=<?php echo $this->package; ?>&amp;rss">
            RSS Feed
        </a>
    </li>
<?php if ($this->package->docs_uri != '') { ?>
    <li>
        <a href="<?php echo $this->package->docs_uri; ?>">
            Documentation
        </a>
    </li>
<?php }
    if ($this->package->bugs_uri != '') { ?>
    <li>
        <a href="<?php echo $this->package->bugs_uri; ?>">
            Bugs
        </a>
    </li>
<?php }
    if ($this->package->cvs_uri != '') { ?>
    <li>
        <a href="<?php echo $this->package->cvs_uri; ?>">
            Source Control
        </a>
    </li>
<?php }
} ?>
</ul>

<?php
    if (isset($this->show_downloads) && $this->show_downloads) {
        include "package/downloads.php";
    } else {
?>
    <h3>Summary</h3>
    <p><?php echo nl2br($this->package->summary); ?></p>
    
    <h3>License</h3>
    <p>
<?php if (isset($this->package->licenseuri)) { ?>
        <a href="<?php echo $this->package->licenseuri; ?>"><?php echo $this->package->license; ?></a>
<?php } else { ?>
        <?php echo $this->package->license; ?>
<?php } ?>
    
    <h3>Current Release</h3>
    <ul>
<?php if ($this->package->releases->count() == 0) { ?>
        <li>No releases have been made yet</li>
<?php } else {
        $this->package->releases->filter('latest');
        $this->package->releases->reverse();
        foreach ($this->package->releases as $release) {
            $release_uri = sprintf(
                'http://%s/get/%s-%s.tgz',
                (string)$release->channel,
                (string)$release->package,
                (string)$release->version
            );
    ?>
    
        <li>
            <a href="<?php echo $release_uri; ?>"><?php echo $release->version; ?></a>
            (<?php echo $release->state; ?>) was released on <?php echo $release->releasedate, "\n"; ?>
        </li>
<?php } ?>
<?php } ?>
    </ul>
    
<?php if ($this->package->summary != $this->package->description) { ?>
    <h3>Description</h3>
    <p><?php echo nl2br($this->package->description); ?></p>
<?php } ?>
    
<?php if ($this->package->maintainers->count() > 0) { ?>
    <h3>Maintainers</h3>
    <ul>
<?php foreach ($this->package->maintainers as $dev) { ?>
        <li>
            <a href="<?php echo $this->index; ?>?user=<?php echo $dev->handle; ?>">
                <?php echo ($dev->handle->name != '' ? $dev->handle->name : $dev->handle), "\n"; ?>
            </a> (<?php echo ucfirst($dev->role); ?>)
        </li>
<?php } ?>
    </ul>
<?php } ?>
    
<?php if($this->package->parentPackage !== false) { ?>
    <h3>Parent Package</h3>
    <p>
        <a href="<?php echo $this->index; ?>?package=<?php echo $this->package->parentPackage; ?>">
            <?php echo $this->package->parentPackage, "\n"; ?>
        </a>
    </p>
<?php } ?>
    
<?php if ($this->package->has_children) { ?>
    <h3>Sub-Packages</h3>
    <ul>
    <?php foreach ($this->package->childPackages as $child) { ?>
        <li>
            <a href="<?php echo $this->index; ?>?package=<?php echo $child; ?>">
                <?php echo $child, "\n"; ?>
            </a>
        </li>
<?php } ?>
    </ul>
<?php } ?>
<?php } ?>